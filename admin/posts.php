<?php include "includes/admin_header.php"; ?>
<div id="wrapper">
   <!-- Navigation -->
   <?php include "includes/admin_navigation.php"; ?>
   <div id="page-wrapper">
      <div class="container-fluid">
         <!-- Page Heading -->
         <div class="row">
            <div class="col-lg-12">
               <h1 class="page-header">
                  Blog Posts
                  <!-- <div class="form-group pull-right">
                     <a href="posts.php?source=add_post "><input class="btn btn-primary" type="submit" name="edit_user" value="Add Post"></a>       
                     </div> -->
                  <small><i style="color:slategrey">Username:    <?php echo $_SESSION ['username'] ?></i></small>
               </h1>
               <!-- Table--> 
               <?php 
                  if(isset($_GET['source'])){
                      
                      $source = $_GET['source'];
                  } else {
                      
                      $source = '';
                  }
                          
                  switch($source) {
                          
                  case 'add_post';
                  include "includes/add_posts.php"; 
                  break;
                          
                  case 'edit_post';
                  include "includes/edit_post.php";
                  break;
                          
                  case '200';
                  echo "nice 200";
                  break;
                          
                  default :
                          
                  include "includes/view_all_posts.php";
                          
                  break;
                  
                  }
                          
                  
                          
                  
                  ?>            
            </div>
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /#page-wrapper -->
</div>
<?php include "includes/admin_footer.php"; ?>