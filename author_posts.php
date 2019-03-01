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
                     $the_post_author = $_GET['author'];
                         
                 }
                 
                 
             $query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}' ORDER BY 'post_date' ASC";
                 $select_post_author = mysqli_query($connection, $query);
                         
                 while ($row = mysqli_fetch_assoc($select_post_author)) {
                     
                     $post_id = $row['post_id'];
                     $post_title = $row['post_title'];
                     $post_user = $row['post_user'];
                     $post_date = $row['post_date'];
                     $post_image = $row['post_image'];
                     $post_content = $row['post_content'];
                     $post_status = $row['post_status'];
                     $post_tags = $row['post_tags'];
         
          ?>    
      <!-- First Blog Post -->
      <h2><a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a></h2>
      <small><a href'#'> <?php echo $post_tags ?></small></a>
      </h2>
      <p class="lead"> 
         All posts by <?php echo $post_user ?>
      </p>
      <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
      <hr>
      <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
      <hr>
      <p><?php echo $post_content?></p>
      <hr>
      <!-- <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
         <?php  } ?>
         
                   
         
                    
         
                         <!-- Blog Comments -->
      <!-- Comments Form -->
   </div>
   <!-- Blog Sidebar Widgets Column -->
   <?php include "includes/sidebar.php"; ?>
</div>
<!-- /.row -->
<hr>
<?php include "includes/footer.php"; ?>