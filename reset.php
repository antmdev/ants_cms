<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>
<?php 
   if(!isset($_GET['email']) && !isset($_GET['token'])){
   
       redirect('index');
   }
   
   //for testing
   // $email = 'antmilner@hotmail.com'; 
   
   // $token ='ed3fa6d04b4859f07a0a34077852a12575f8d1ef71baf14821b6950e57cbe46e6a15fb4c28ebb15cfc716c17091352688967';
   
   if ($stmt = mysqli_prepare($connection, 'SELECT username, user_email, token FROM users WHERE token=?'))
   
   mysqli_stmt_bind_param($stmt, "s", $token);
   
   mysqli_stmt_execute($stmt);
   
   mysqli_stmt_bind_result($stmt, $username, $user_email, $_GET['token']);
   
   mysqli_stmt_fetch($stmt);
   
   mysqli_stmt_close($stmt);
   
   //echo $username; // confirms that its working.
   
   // if($_GET['token'] !== || $_GET['email'] != $email) {
       
   //     //if token doesnt match token from DB or email doesnt match then redirect
   
   //     redirect('index');
   
   if(isset($_POST['password']) && isset($_POST['confirmPassword'])){
   
       if($_POST['password'] === $_POST['confirmPassword'])
   
       $password = $_POST['password'];
   
       $hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
   
       //setting the token to empty as once we've used it we dont want it anymore
   
       if($stmt = mysqli_prepare($connection, "UPDATE users SET token='', user_password='{$hashedPassword}' WHERE user_email =? ")) {
   
           mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
           mysqli_stmt_execute($stmt);
   
           if(mysqli_stmt_affected_rows($stmt) >= 1) {
   
               redirect('/cms/login.php');
           
                } 
   
           mysqli_stmt_close($stmt);
   
           }
   
   }
   
   ?>
<!-- Page Content -->
<div class="container">
   <div class="container">
      <div class="row">
         <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
               <div class="panel-body">
                  <div class="text-center">
                     <h3><i class="fa fa-lock fa-4x"></i></h3>
                     <h2 class="text-center">Forgot Password?</h2>
                     <p>You can reset your password here.</p>
                     <div class="panel-body">
                        <form id="register-form" role="form" autocomplete="off" class="form" method="post">
                           <div class="form-group">
                              <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                 <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                              </div>
                           </div>
                           <div class="form-group">
                              <div class="input-group">
                                 <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                 <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                              </div>
                           </div>
                           <div class="form-group">
                              <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                           </div>
                           <input type="hidden" class="hide" name="token" id="token" value="">
                        </form>
                     </div>
                     <!-- Body-->
                     <!-- <h2>Please check your email</h2> -->
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- /.container -->