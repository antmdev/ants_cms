<?php
   if(isset($_POST['create_user'])) {
   
   
       $user_firstname         =  escape($_POST['user_firstname']);
       $user_lastname          =  escape($_POST['user_lastname']);
       $user_role              =  escape($_POST['user_role']);
       $username               =  escape($_POST['username']);
       $user_email             =  escape($_POST['user_email']);
       $user_password          =  escape($_POST['user_password']);
   //      $post_date =  date ('d-m-y');
       $user_image             =  escape($_FILES ['image']['name']) ;
       $user_image_temp        =  escape($_FILES['image']['tmp_name']);
   
       move_uploaded_file ($user_image_temp, "../images/$user_image");
   
       $user_password = password_hash( $user_password, PASSWORD_BCRYPT, array('cost' => 10) );
   
       $query = "INSERT INTO users (user_firstname, user_lastname, user_role, username, user_email, user_password, user_image)";
   
       $query .= "VALUES ('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$user_password}', '{$user_image}') ";
   
   
       $create_user_query = mysqli_query($connection, $query);
   
       confirmQuery($create_user_query);
       // header("location:users.php");
       echo "<p class='bg-success'>User Created. <a href='users.php'>View Users </a></p>";
   
   }
   ?>
<!-- name attribute is caught by the POST super global-->
<form action=""  method="post" enctype="multipart/form-data">
   <div class="form-group">
      <label for="title"> First Name </label>
      <input type="text" class="form-control" name="user_firstname" placeholder="John" required>
   </div>
   <div class="form-group">
      <label for="title"> Last Name </label>
      <input type="text" class="form-control" name="user_lastname" placeholder="Smith" required>
   </div>
   <div class="form-group">
      <select name="user_role" id="" required>
         <option value="subscriber" >Select Options</option>
         <option value="admin">Admin</option>
         <option value="subscriber">Subscriber</option>
      </select>
   </div>
   <div class="form-group">
      <label for="User Image"> User Image </label>
      <input type="file" name="image">
   </div>
   <div class="form-group">
      <label for="Username"> Username </label>
      <input type="text" class="form-control" name="username" required placeholder="JohnSmith123">
   </div>
   <div class="form-group">
      <label for="Email"> Email </label>
      <input type="Email" class="form-control" name="user_email" placeholder="Email" required>
   </div>
   <div class="form-group">
      <label for="password"> Password </label>
      <input type="Password" class="form-control" name="user_password" pattern=".{5,10}" required title="Password must be between 5 to 10 characters">
   </div>
   <div class="form-group">
      <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
   </div>
</form>