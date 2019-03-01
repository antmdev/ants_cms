<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<?php
   if(isset($_POST['liked'])){
   
       $post_id = $_POST['post_id'];
       $user_id = $_POST['user_id'];
   
   
       // die();
   
   
       //1) SELECT POST
       $query = "SELECT * FROM posts WHERE post_id =$post_id";
       $postResult = mysqli_query($connection, $query);
       $post = mysqli_fetch_array($postResult);
       $likes = $post['likes'];
   
       // if(mysqli_num_rows($postResult) >=1 ) {
       //     echo $post_id;
       // }
      
      
       //2) UPDATE POST WITH LIKES
       mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id=$post_id");
        //now evey tike we click on the like button we update the 'likes' with the like varibale +1
   
       //3) CREATE LIKES FOR A POST
       //user_id and post_id is grabbed from the AJAX code at the bottom of the page
       mysqli_query($connection, "INSERT INTO likes (user_id, post_id) VALUES($user_id, $post_id) ");
   
       exit();
   }
   //UNLIKING PHP
   
   if(isset($_POST['unliked'])){
       
       //TEST
       // echo "UNLIKED";
   
       $post_id = $_POST['post_id'];
       $user_id = $_POST['user_id'];
   
       //1 FETCHING THE RIGHT POST
   
       $query = "SELECT * FROM posts WHERE post_id =$post_id";
       $postResult = mysqli_query($connection, $query);
       $post = mysqli_fetch_array($postResult);
       $likes = $post['likes'];
   
       //2 DELETE LIKES
   
       mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");
   
       // 3 UPDATE WITH DECREMENT LIKES
       mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id=$post_id");
       
       exit();
    
   }
   
   ?>
<!-- Page Content -->
<div class="container">
<div class="row">
   <!-- Blog Entries Column -->
   <div class="col-md-8">
      <?php
         //This is looping through the entire post below and assigning the ID to the relevant
         
         if(isset($_GET['p_id'])){
         
         $the_post_id = $_GET['p_id'];
         
         //            OLD POST COUNTER // ADING BACK IN BECAUSE ITS BROKEN BUT WORKS WITH THE BELOW
         //            Setting the post view counts up, every time the post view is called with a P_id and the p_id matches it adds one.
         
         $view_query = "UPDATE posts SET post_views_count = post_views_count +1 WHERE post_id = $the_post_id";
         $send_query = mysqli_query($connection, $view_query);
         
         if(!$send_query){
             die("QUERY FAILED");
         }
         
         if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ) {
         
             $query = "SELECT * FROM posts WHERE post_id = $the_post_id " ; //query to see everything as i'm admin
         
         } else {
             
             $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published' " ;
         
         } 
         
         $select_all_posts_query = mysqli_query($connection,$query);
         
         if(mysqli_num_rows($select_all_posts_query) < 1) {
         
             echo "<h1 class='text-center'> No posts available </h1>";
             
         } else {
         
         while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
         $post_id = $row['post_id'];
         $post_title = $row['post_title'];
         $post_user = $row['post_user'];
         $post_date = $row['post_date'];
         $post_image = $row['post_image'];
         $post_content = $row['post_content'];
         $post_status = $row['post_status'];
         $post_tags = $row['post_tags'];
         
         
         ?>
      <h1 class="page-header">
         <?php echo $post_title ?>
         <!-- Need to add functionality to not just print out tags, but print them out with seperate links and so each one goes to any post with that tag -->
         <small><a href="#"> <?php echo $post_tags; ?></small></a>
      </h1>
      <!-- First Blog Post -->
      <h2>
      </h2>
      <p class="lead">
         by <a href="/cms/author_posts.php?author=<?php echo $post_user ?>&p_id=<?php echo $post_id;?>"><?php echo $post_user ?></a>
      </p>
      <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
      <hr>
      <img class="img-responsive" src="<?php echo imagePlaceholder($post_image);?>" alt="">
      <hr>
      <p><?php echo $post_content?></p>
      <!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON --><!-- CREATING THE LIKE BUTTON -->
      <?php 
         if(isLoggedIn()){ ?>
      <div class="row">
         <p class="pull-right"><a 
            class="<?php echo userLikedThisPost($the_post_id) ? ' unlike' : ' like'; ?>" 
            href=""><span class="glyphicon glyphicon-thumbs-up" 
            data-toggle="tooltip"
            data-placement="top"
            title="<?php echo userLikedThisPost($the_post_id) ? ' I liked this before' : ' Want to like it?'; ?>"
            ></span>
            <?php echo userLikedThisPost($the_post_id) ? ' unlike' : ' like'; ?>
            </a>
         </p>
      </div>
      <?php } else { ?>
      <div class="row">
         <p class="pull-right login-to-post">You need to <a href="/cms/login.php">Login</a> to like  </p>
      </div>
      <?php } ?>
      <div class="row">
         <p class="pull-right likes">Like <?php getPostlikes($the_post_id); ?></p>
      </div>
      <div class="clearfix">
      </div>
      <?php } ?>
      <?php
         //getting errors when comment is too LONG! FIXED with real_escape_string
         
         if(isset($_POST['create_comment'])) {
         
             $the_post_id = $_GET['p_id'];
             $comment_author = $_POST['comment_author'];
             $comment_email = $_POST['comment_email'];
         //                $comment_author = escape($_POST['comment_content']);
             $comment_content = mysqli_real_escape_string($connection, $_POST['comment_content']);
         
             if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
         
                 $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
         
                 $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved' , now())";
         
                 $create_comment_query = mysqli_query($connection, $query);
         
                 if(!$create_comment_query) {
         
                     die('QUERY FAILED' . msqli_error($connection));
                 }
         
                 //UPDATE comment count in MYSQL
         
                 $query = "UPDATE posts SET post_comment_count =  post_comment_count + 1  ";
                 $query .= "WHERE post_id =  $the_post_id  ";
                 $update_comment_count  = mysqli_query($connection, $query);
         
         
             } else {
                 echo "<script>alert('Fields cannot be empty');</script>";
                 // echo '<script type="text/javascript">alert("hello!");</script>';
         
             }
         }
         ?>
      <!-- Comments Form -->
      <div class="well">
         <h4>Leave a Comment:</h4>
         <form action="" method="post" role="form">
            <div class="form-group">
               <label for="comment_author">Author</label>
               <input type="text" class="form-control" name="comment_author">
            </div>
            <div class="form-group">
               <label for="email">Email</label>
               <input type="email" class="form-control" name="comment_email">
            </div>
            <div class="form-group">
               <label for="comment">Your Comment</label>
               <textarea class="form-control" name="comment_content" rows="3"></textarea>
            </div>
            <!-- the name here is what triggers the _POST super global!!!! -->
            <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
         </form>
      </div>
      <hr>
      <!-- Posted Comments -->
      <?php 
         $query = "SELECT * FROM users ";
         
         $select_comments = mysqli_query($connection, $query);
         
         while ($row = mysqli_fetch_array($select_comments)) {
             $user_id =  $row['user_id'];
             $username =  $row['username'];
             $user_email =  $row['user_email']; 
             $user_image=  $row['user_image'];
         
          }
         
         $query = "SELECT user_email FROM users ";
         
         $select_users_query = mysqli_query($connection, $query);
         
         // $new_array = array();
         
         while ($row = mysqli_fetch_row($select_users_query)) {
         
             $new_array[] = $row; // Inside while loop
             
         //  $user_email     = $row['user_email'];
         // $user_image     = $row['user_image'];
         }
         
         // THIS HAS FOUND AN EMAIL ADDRESS!!!!
         
         // foreach($new_array as $new_arr) {
            
         //     if (in_array('antmilner@hotmail.com', $new_arr)) {
         //         // return true;
         //         echo "Found";
         //     }
         // }
         // ^^^^^^^THIS HAS FOUND AN EMAIL ADDRESS^^^^^^^^!!!!
         
         // echo $sidemenu['mname']."<br />";
         // echo $new_array[]->user_email ;
         // foreach($new_array as $new_new_array);{
          // print_r($new_new_array);
         //  var_dump($new_array);
         
         //  $imploded = implode(" , ",$new_array);
         //  echo $imploded;
         
         ?>
      <!-- <pre> -->
      <?php
         // print_r($new_array);
         // ?>
      <!-- </pre> -->
      <?php // ADDING THE COMMENTS TO THE POST
         // if(var_dump(isset($new_array['user_email']))){
         //     echo "YES user_email is there";
         // }   else {
             
         // }         // TRUE
         
         
         
         // if(array_key_exists('antmilner84@hotmail.com', $new_array)) {
         
         //     echo "IT is THERE";
         // }else {
         //     echo "NOT there bro";
         // }
         
         
         
         
         $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
         $query .= "AND comment_status = 'approved' ";
         $query .= "ORDER BY comment_id DESC ";
         $select_comment_query = mysqli_query($connection, $query);//send info
         if(!$select_comment_query) {
         
         die('QUERY FAILED' . msqli_error ($connection));
         
         }
         
         while ($row = mysqli_fetch_array($select_comment_query)) { //run loop for info
         
         $comment_date = $row['comment_date'];
         $comment_content = $row['comment_content'];
         $comment_author = $row['comment_author'];
         $comment_email = $row['comment_email'];
         
         
         ?>
      <?php
         // echo $comment_email;
         // echo "<br>";
         // echo $user_email;
         // echo "<br>";
         // if($comment_email == $user_email){
         // echo  "IT MATCHES";
         // } else {
         //     echo "NO MATCH";
         // }
         
         foreach($new_array as $new_arr) {
         
         if (in_array($comment_email, $new_arr)) {
         
         // $email_is_in_db = $comment_email;
         
         
         print_r($new_arr);
         
         // echo "Found it brother";
         // echo $comment_email;
         }
         }
         ?>
      <!-- Comment -->
      <div class="media">
         <a class="pull-left" href="#">
         <img class="media-object" width='64' img height='64' align='center' class='img-responsive img-square'>
         </a>
         <div class="media-body">
            <h4 class="media-heading"><?php echo $comment_author; ?>
               <small><?php echo $comment_date; ?></small>
            </h4>
            <?php echo $comment_content; ?>
         </div>
      </div>
      <?php  } } }  else {
         header("location: index.php");
         
         }
         ?>
   </div>
   <!-- Blog Sidebar Widgets Column -->
   <?php include "includes/sidebar.php"; ?>
</div>
<!-- /.row -->
<hr>
<?php include "includes/footer.php"; ?>
<script>
   $(document).ready(function(){ //check page loaded (JQUERY)
   
   $("[data-toggle='tooltip']").tooltip();
   
   
       var  post_id = <?php echo $the_post_id; ?>
       
       //grab the post id for JS variable
   
       var user_id = <?php echo loggedInUserId(); ?>
   
       //LIKING
   
   
   $('.like').click(function(){ //find the class for like and register click
   
       console.log('it works'); //log to console
   
   
      // AJAX is a web developmemnt technique to send and recive data without refreshing
      //JQUERY has some AJAX function built in to easily make requests
   
       $.ajax({   
           //to use AJAZ - which is built into JQUERY
           //Perform an asynchronous HTTP (Ajax) request.
           //takes 1 parameter url (string) then (settings)
   
           url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
           //checking a $_POST event has been sent to this page
      
           type: 'post',
   
           data: {
               'liked': 1,
               'post_id': post_id,
               'user_id': user_id
   
           }
   
       });
   });
   
    //UNLIKING
    $('.unlike').click(function(){ 
   
       $.ajax({   
       url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
       type: 'post',
       data: {
           'unliked': 1,
           'post_id': post_id,
           'user_id': user_id
       }
   
       });
   });
   
   });
   
</script>