<?php include "includes/db.php"; ?>
<?php require_once "admin/functions.php"; ?>
<?php  include "includes/header.php"; ?>
<?php 
   require 'vendor/autoload.php';
   
   $dotenv = new \Dotenv\Dotenv(__DIR__);
   $dotenv->load();
   
   //4.3 BELOW
   $options = array(
       'cluster' => 'eu',
       'useTLS' => true
     );
   
   $pusher = new Pusher\Pusher (getenv('APP_KEY'), getenv('APP_SECRET'), getenv('APP_ID'), $options);
   
   // pusher
   // app_id = "621265"
   // key = "c21f4553edf47bad1778"
   // secret = "4591c632fbfb770f636d"
   // cluster = "eu"
   
   // $pusher = new Pusher\Pusher ('key', 'secret', 'app_id', 'options');
   // //4.1 BELOW
   
   // $options = array(
   //     'cluster' => 'eu',
   //     'encrypted' => true
   // );
   
   if($_SERVER['REQUEST_METHOD'] == "POST") { //to avoid complications we use this technique
   
       $username   = trim($_POST['username']); //clears white space
       $email      = trim($_POST['email']);
       $password   = trim($_POST['password']);
   
       $error = [
           'username' => '',
           'email' => '',
           'password' => '',
       ];
       //username entry errors
       if(strlen($username) <4 ){
           $error['username'] = 'Username needs to be greater than 4 characters';
       }
       if ($username ==""){
           $error['username'] = 'Username cannot be empty';
       }
       if(username_exists($username)){
           $error['username'] = 'Username already exists, please choose another one';
       }
       //email entry errors
       if($email ==""){
           $error['email'] = 'Email cannot be empty';
       }
       if(useremail_exists($email)){
           $error['email'] = 'User email already exists, <a href="index.php"> Please login </a>';
       }
        //password entry errors
        if($password ==""){
           $error['password'] = 'Password cannot be empty';
       }
   
       foreach($error as $key => $value) {
   
           if(empty($value)){
   
               unset($error[$key]); //unset the key of that variable
   
           }
   
       } //foreach
   
       if(empty($error)){ //if the error is empty then register user
   
   
           $data['message'] = $username;
           $pusher->trigger('notification', 'subscriber', $data);
   
   
           register_user($username, $email, $password); //function to register user
   
           //When error for registration is empty we want to trigger an event
           //Pusher       
   
           login_user($username, $password); //function to registe user
       }
   }
   
   
   ?>
<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>
<!-- Page Content -->
<div class="container">
<section id="login">
   <div class="container">
      <div class="row">
         <div class="col-xs-6 col-xs-offset-3">
            <div class="form-wrap">
               <h1>Register</h1>
               <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                  <div class="form-group">
                     <label for="username" class="sr-only">username</label>
                     <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" 
                        autocomplete="on"
                        value="<?php echo isset($username) ? $username : '' ?>">
                     <!-- shorthand IF STATEMENT ^^ ECHO something if set, ? = display it : = else statement if not set -->
                     <p><?php echo isset($error['username']) ? $error['username']  : '' ?> </p>
                     <!-- CALL ERROR STATEMENTS-->
                  </div>
                  <div class="form-group">
                     <label for="email" class="sr-only">Email</label>
                     <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com"
                        autocomplete="on"
                        value="<?php echo isset($email) ? $email : '' ?>">
                     <p><?php echo isset($error['email']) ? $error['email']  : '' ?> </p>
                  </div>
                  <div class="form-group">
                     <label for="password" class="sr-only">Password</label>
                     <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                     <p><?php echo isset($error['password']) ? $error['password']  : '' ?> </p>
                  </div>
                  <input type="submit" name="register" id="btn-login" class="btn btn-info btn-lg btn-block" value="Register">
               </form>
            </div>
         </div>
         <!-- /.col-xs-12 -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container -->
</section>
<hr>
<?php include "includes/footer.php";?>