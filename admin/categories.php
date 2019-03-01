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
            Blog Categories
            <small><i style="color:slategrey">Username:  <?php echo $_SESSION ['username'] ?></i></small>
         </h1>
         <!-- Form for Categories -->
         <div class="col-xs-6">
            <!--  /////////////////////////////////////////////  FORM VALIDATION -->
            <?php insertCategories() ?>
            <!--  ///////////////////////////////////////////// ADD CATEGORY FORM -->
            <!-- (table>thead>tr>th*2) -->
            <form action="" method="post">
               <div class="form-group">
                  <label for="cat-title"> Add Category</label>
                  <input type = "text" class="form-control" name = "cat_title">
               </div>
               <div class="form-group">
                  <input class = "btn btn-primary" type="submit" name="submit" value="Add category">
               </div>
            </form>
            <!--FIND ALL CATEGORIES QUERY -->
            <?php updateCategories(); ?>    
         </div>
         <!-- add category form -->                
         <div class="col-xs-6">
            <table class="table table-bordered table-hover">
               <thead>
                  <tr>
                     <th>ID</th>
                     <th>Category Title</th>
                  </tr>
               </thead>
               <tbody>
                  <tr>
                  </tr>
                  <!--FIND ALL CATEGORIES QUERY -->
                  <?php findAllCategories(); ?>
                  <!-- //DELETE QUERY -->
                  <?php deleteCategories();  ?>
               </tbody>
            </table>
         </div>
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>