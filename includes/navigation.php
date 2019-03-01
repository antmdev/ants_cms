<?php include ("login_modal.php"); ?>
<?php require_once "admin/functions.php"; ?>
<?php
   if (session_status() == PHP_SESSION_NONE) session_start();
   ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
   <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         </button>
         <!-- <a class="navbar-brand" href="index.php" img src="Grab-logo.png" width="27px">Home</a> -->
         <a class="navbar-brand" href="/cms">
         <img alt="Brand" src="/cms/images/test-logo.png" width="100" height="25">
         </a>
         
         <script>
            $(document).ready(function(){ 
                $(".navbar-brand").on('click', function(){
                $("#myModal").modal('show');
            });
            });
         </script>
      </div>
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
         <ul class="nav navbar-nav navbar-right">
         <!-- ADDING THE SEARCH FUNCTIONALITY TO THE HEADER SEARCH -->
         <ul class="nav navbar-nav navbar-left">
         <?php  
            //add code for login / Logout button on header
            
                if(isset($_SESSION['user_role'])){
                
                echo "<a rel='' href='/cms/includes/logout.php'  class='navbar-brand'  width='27px'>logout</a>";
                    
                } else {
            
                echo "<a rel='' href='javascript:void(0)'  class='navbar-brand'  width='27px'>login</a>";
            
                }
            
                ?>
            <li class='<?php echo $registration_class ?>'>
               <a href="/cms/registration">Registration</a>
            </li>
            <li class='<?php echo $contact_class ?>'>
               <a href="/cms/contact">Contact</a>
            </li>
            <?php if(isLoggedIn()): //SHORTHAND IF STATEMENT SO YOU CAN WRITE HTML EASIER INBETWEEN?> 
            <?php else: ?>
            <li class='<?php echo $contact_class ?>'>
               <a href="/cms/login">Login</a>
            </li>
            <?php endif; ?>
            <?php
               if(isset($_SESSION['user_role'])){
               
               //(nested if statement)
                   if(isset($_GET['p_id'])) {
               
                   $the_post_id = ($_GET['p_id']);
               
               echo "<li><a href ='/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                   }
               
               }
               
               ?>
            <!-- <li>
               <a href="admin/index.php"><strong>Admin Panel</strong></a>
               </li> -->
            <form class="navbar-form navbar-right" action="search.php" method="post">
               <div class="input-group">
                  <input name="search" type="text" class="form-control" placeholder="Search">
               </div>
               <button name="submit" class="btn btn-default" type="submit">Search Blogs</button>
            </form>
         </ul>
         <?php 
            if(isset($_SESSION['user_role'])){
            
            echo "<li><a href='/cms/admin/index.php'><strong>Admin Panel</strong></a></a></li>";
            
            }
            ?>
      </div>
      <!-- /.navbar-collapse -->
   </div>
   <!-- /.container -->
</nav>