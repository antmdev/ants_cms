<?php
   WhatMethodThenLogIn();
   
   ?>
<!-- Blog Sidebar Widgets Column -->
<div class="col-md-4">
   <!--LOGIN FORM  -->                
   <div class="well">
      <?php if(isset($_SESSION['user_role'])): ?>
      <h4 align="center"> Loged in as <?php echo $_SESSION['username'] ?></h4>
      <a href="/cms/includes/logout.php" id="singlebutton" name="singlebutton" class="btn btn-primary btn-sm center-block">Logout</a>
   </div>
   <?php else: ?> 
   <h4>Login</h4>
   <form method="post">
      <div class="form-group">
         <input name="username" type="text" class="form-control" placeholder="Enter Username">
      </div>
      <div class="input-group">
         <input name="password" type="password" class="form-control" placeholder="Enter Password">
         <span class="input-group-btn">
         <button class="btn btn-primary" name="login" type="submit">Login</button>
         </span> 
      </div>
   </form>
   <div class="form-group">
      <br>
      <a href="forgot.php?forgot=<?php echo uniqid(true); //SMASH a funky mess in the URL?> ">Forgot Password</a>
   </div>
</div>
<?php endif; ?>   
<!-- Blog Search Well -->
<!-- Need to add a form to submit the data, leaving action blank means it will be submitted to the same page (not another page).
   - We change input name to search
   - we change button name to submit (to match the PHP search POST) -->
<div class="well">
   <h4>Blog Search</h4>
   <form action="search.php" method="post">
      <div class="input-group">
         <input name="search" type="text" class="form-control">
         <span class="input-group-btn">
         <button name="submit" class="btn btn-default" type="submit">
         <span class="glyphicon glyphicon-search"></span>
         </button>
         </span>
      </div>
   </form>
   <!-- form search form-->
   <!-- /.input-group -->
</div>
<!-- Blog Categories Well -->
<div class="well">
   <?php 
      //   $query = "SELECT * FROM categories LIMIT 4"; limit function to reduce number
          $query = "SELECT * FROM categories ";
          $select_categories_sidebar = mysqli_query($connection, $query);
      
      ?>
   <h4>Blog Categories</h4>
   <div class="row">
      <div class="col-lg-12">
         <ul class="list-unstyled">
            <?php
               while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
               $cat_title =  $row['cat_title'];
               $cat_id =  $row['cat_id'];
               echo"<li><a href='/cms/category/$cat_id'> {$cat_title}</a></li>";
                }
               ?>
         </ul>
      </div>
   </div>
   <!-- /.row -->
</div>
<?php include "includes/widget.php"; ?>
</div>