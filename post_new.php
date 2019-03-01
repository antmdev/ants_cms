<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php include "includes/navigation.php"; ?>
<!-- Navigation -->
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
      <!-- <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
         <hr>
         
         <?php   ?>
         
         Blog Comments -->
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
      <?php // ADDING THE COMMENTS TO THE POST
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
         }
         
         // echo $comment_email;
                     
         $newquery = "SELECT * FROM users";
         
         $user_details_query = mysqli_query($connection, $newquery);
         
         while ($row = mysqli_fetch_array($user_details_query)) {
         
             $user_email =  $row['user_email']; 
             $user_image=  $row['user_image'];
         
         
         
         // echo $user_email;
          
         
         ?>
      <!-- Comment -->
      <div class="media">
         <a class="pull-left" href="#">
            <!-- <img class="media-object" src="http://placehold.it/64x64" alt=""> -->
            <img class="media-object" src="http://placehold.it/64x64" alt="">
         </a>
         <div class="media-body">
            <h4 class="media-heading"><?php echo $comment_author; ?>
               <small><?php echo $comment_date; ?></small>
            </h4>
            <?php echo $comment_content; ?>
         </div>
      </div>
      <?php } } } }
         else {
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