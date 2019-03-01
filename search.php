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
         /*this is the SEARCH functionality - we make a post to super global
         - assign it to a variable $search
         - Then check the database "posts" where "post_tags" is LIKE the search request 
         then add the % sign to make it like a variable*/
                             
                          if(isset($_POST['submit'])){
         //               echo $search = $_POST ['search'];
                          $search = $_POST ['search'];
         
         //adding admin privalges to search functionality 
         
                          if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin' ) {
         
                             $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%' "; //query to see everything as i'm admin
             
                             } else {
                             
                                 $query = "SELECT * FROM posts WHERE post_status = 'published' AND post_tags LIKE '%$search%' "; 
                         
                             } 
                              
                          
                          $search_query = mysqli_query($connection, $query);
                              
                              if(!$search_query) {
                                  die("QUERY FAILED" . mysqli_error($connection));
                              }
                              
                              $count = mysqli_num_rows($search_query);
                              if($count == 0){
                                  
                                //  echo "<h1> Sorry, no results for that search</h1>";
                             echo("<h2 style='color:#0565A7;'>Sorry! No results for that search" . "&nbsp;" . "&nbsp;" . "<i class='glyphicon glyphicon-thumbs-down'></i></h2></a>");
                              } 
                              else {
                                  
               while ($row = mysqli_fetch_assoc($search_query)) {
                     $post_title =  $row['post_title'];
                     $post_author =  $row['post_author'];
                     $post_date =  $row['post_date'];
                     $post_image =  $row['post_image'];
                     $post_content =  $row['post_content'];
             
         ?>
      <h1 class="page-header">
         Page Heading
         <small>Secondary Text</small>
      </h1>
      <!-- First Blog Post -->
      <h2>
         <a href="#"><?php echo $post_title ?></a>
      </h2>
      <p class="lead">
         by <a href="index.php"><?php echo $post_author ?></a>
      </p>
      <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
      <hr>
      <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
      <hr>
      <p><?php echo $post_content?></p>
      <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
      <?php } } }?>
   </div>
   <!-- Blog Sidebar Widgets Column -->
   <?php include "includes/sidebar.php"; ?>
</div>
<!-- /.row -->
<hr>
<?php include "includes/footer.php"; ?>