<?php include "includes/admin_header.php"; ?>
<?php
   //  if (!is_admin( $_SESSION ['username'])){
   //      header ("location: index.php");
   //  } 
   
    ?>
<div id="wrapper">
   <!-- Navigation -->
   <?php include "includes/admin_navigation.php"; ?>
   <div id="page-wrapper">
      <div class="container-fluid">
         <!-- Page Heading -->
         <div class="row">
            <div class="col-lg-12">
               <h1 class="page-header">
                  CMS Users
                  <div class="form-group pull-right">
                     <a href="users.php?source=add_user "><input class="btn btn-primary" type="submit" name="edit_user" value="Add User"></a>       
                  </div>
                  <small><i style="color:slategrey">Username:    <?php echo $_SESSION ['username'] ?></i></small>
               </h1>
               <!-- Table--> 
               <?php 
                  //The Source is checking if the URL is set to add_user, in which czse it will send to add-User, and the same for get_user
                         
                  if(isset($_GET['source'])){
                      
                      $source = $_GET['source'];
                  } else {
                      
                      $source = '';
                  }
                          
                  switch($source) {
                          
                  case 'add_user';
                  include "includes/add_user.php"; 
                  break;
                          
                  case 'edit_user';
                  include "includes/edit_user.php";
                  break;
                          
                  case '200';
                  echo "nice 200";
                  break;
                          
                  default :
                          
                  include "includes/view_all_users.php";
                          
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