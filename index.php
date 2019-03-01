<?php require_once "includes/db.php"; ?>
<?php require_once "includes/header.php"; ?>
<?php require_once "includes/navigation.php"; ?>
<?php require_once "admin/functions.php"; ?> <!-- USING REQUIRE ONCE BECAUSE PHP COULDNT CALL REDIRECT() FROM FUNCTIONS PHP  TWICE-->
<!-- Navigation -->
<!-- Page Content -->
<div class="container">
<div class="row">
   <!-- Blog Entries Column -->
   <div class="col-md-8">
      <?php //assigning pages for pagination 
         $per_page = 5;
         
         if(isset($_GET['page'])) {
         $page = $_GET['page'];
         
         } else {
         $page=""; //if we first find the get request we assign to empty string to avoid errors.
         }
         
         if ($page == "" || $page == 1){
         
         $page_1 = 0; // if page is empty or equal to 1 we assign to page one.
         
         } else {
         $page_1 = ($page * $per_page) - $per_page; //if we're on page two for example we're doing 2 * 5 = 10 - 5 = 5 so it gives us 5 posts on every page
         }
         
         
         if(isset($_SESSION['username']) && is_admin($_SESSION['username'])){
         // if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
         
         // $post_query_count = "SELECT * FROM posts" ; //query to see everything as i'm admin
         $post_query_count = "SELECT * FROM posts " ;// $page_1, $per_page ";
         
         } else {
         
         // $post_query_count = "SELECT * FROM posts WHERE post_status = 'published' ";
         $post_query_count = "SELECT * FROM posts WHERE post_status = 'published' " ; //LIMIT $page_1, $per_page "";
         
         } 
         //code to find out how many posts there are: 
         
         // $post_query_count = "SELECT * FROM posts WHERE post_status = 'published' "; 
         $find_count = mysqli_query($connection, $post_query_count);
         $count  = mysqli_num_rows($find_count);
         
         if ($count <1) {
         
         echo "<h1 class='text-center'> No posts available </h1>";
         
         
         } else {
         
         $count = ceil($count / $per_page); //ceil rounds functions up. floor rounds down
         
         // echo $count;
         
         
         //DB Query to find in POSTS, select all posts
         //Run a while loop on the DB posts
         // LIMIT always need to go to the end
         
         $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1, $per_page";
         $select_all_posts_query = mysqli_query($connection, $query);
         
         while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
         
         $post_id = $row['post_id'];
         $post_title = $row['post_title'];
         $post_user = $row['post_user'];
         $post_date = $row['post_date'];
         $post_image = $row['post_image'];
         $post_content = substr($row['post_content'],0,400);
         $post_status = $row['post_status'];
         //
         //            
         //            
         //            echo "<h2 class=text-center> Sorry there's no published posts! </h2>";
         //            
         
         //            
         
         ?>    
      <!-- <h1 class="page-header">
         Latest Blog Posts
         <small></small>
         </h1> -->
      <!-- First Blog Post -->
      <!-- remeber we pass the parameter P_id which is the key of the array of the GET super global for the ID's-->
      <!-- When people click on the title of a post, this sends a parameter to the URL and that parameter is gonna be the p_id = the id of the post-->
      <!-- CAN REWRITE BELOW BECAUSE OF REWRITE ENGINE -->             
      <h2><a href="/cms/post/<?php echo $post_id ?>"><?php echo $post_title ?></a></h2>
      <p class="lead">
         <!-- need to send a get request with this using the ?? -->
         by <a href="/cms/author_posts.php?author=<?php echo $post_user ?>&p_id=<?php echo $post_id;?>"><?php echo $post_user ?></a>
      </p>
      <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
      <hr>
      <!-- <a href="post.php?p_id=<?php echo $post_id ?>"> -->
      <a href="post.php?p_id=<?php echo $post_id ?>"> 
      <img class="img-responsive" src="<?php echo imagePlaceholder($post_image);?>" alt=""></a>
      <p><?php echo $post_content?></p>
      <a class="btn btn-primary" href="/cms/post.php?p_id=<?php echo $post_id;?>"> Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
      <hr>
      <?php  }  } ?>
   </div>
   <!-- Blog Sidebar Widgets Column -->
   <?php include "includes/sidebar.php"; ?>
</div>
<!-- /.row -->
<hr>
<nav aria-label="Page navigation example">
   <ul class="pagination">
      <!-- <ul class="pager"> -->
      <!-- <?php
         //CREATING PAGINATION EDWIN CODE
         // whilst i is greater than or equal to count we increment 
         //$Count is no.rows / 5
         
         //assigning the $i as the initialiaser and assiging it to the $count
         
         // for($i = 1; $i <= $count; $i++) {
         
         //         if($i == $page) { // which i sthe get request and therefore active page
         
         //         echo "<li><a class='active_link' href='index.php?page={$i}' style=color:'#FFFFFF'>{$i}</a></li>";
                         
         
         //         } else {
         
         //         echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
         
         //         }
         
         
         // }
         
         ?> -->
      <?php //CREATING PAGINATION STUDENT CODE WITH PREVIOUS / NEXT BUTTON
         if($page != 1 && $page != ""){
         
         $prev_page = $page - 1;
         
         echo "<li><a class='page-link' href='index.php?page={$prev_page}' aria-label='Previous'><span aria-hidden='true'>&laquo;</span>
         <span class='sr-only'></span>      Previous</a></li>";
         
         
         }
         
         for($i = 1; $i <= $count ; $i++){
         
         if($i == $page || ($i == 1 && $page == 1)){
         
         echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
         } else {
         
         echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
         
         }
         
         }
         
         if($page != $count && $page != ""){
         
         $next_page = $page + 1;
         
         // echo "<li><a href='index.php?page={$next_page}'>NEXT</a></li>";
         echo "<li><a class='page-link' href='index.php?page={$next_page}' aria-label='Next'><span aria-hidden='true'>&raquo;</span>
         <span class='sr-only'>  Next</span>      Next</a></li>";
         
         
         }
         
         ?>
   </ul>
</nav>
<?php include "includes/footer.php"; ?>