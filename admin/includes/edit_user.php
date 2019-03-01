<?php
   if(isset($_GET['edit_user'])) {
   
       $the_user_id = escape($_GET['edit_user']);
   
       $query = "SELECT * FROM users WHERE user_id = $the_user_id ORDER BY user_id ASC ";
   
       $select_users_query = mysqli_query($connection, $query);
   
       while ($row = mysqli_fetch_assoc($select_users_query)) {
           $user_id        = $row['user_id'];
           $username       = $row['username'];
           $user_password  = $row['user_password'];
           $user_firstname = $row['user_firstname'];
           $user_lastname  = $row['user_lastname'];
           $user_email     = $row['user_email'];
           $user_image     = $row['user_image'];
           $user_role      = $row['user_role'];
   
       }
   
       if (isset($_POST['edit_user'])) {
   
           $user_firstname     = escape($_POST ['user_firstname']);
           $user_lastname      = escape($_POST['user_lastname']);
           $user_role          = escape($_POST['user_role']);
           $user_image         = escape($_FILES ['image']['name']);
           $user_image_temp    = escape($_FILES['image']['tmp_name']);
           $username           = escape($_POST['username']);
           $user_email         = escape($_POST['user_email']);
           $user_password      = escape($_POST['user_password']);
   
           move_uploaded_file($user_image_temp, "../images/$user_image");
   
           if (empty($user_image)) {
   
               $query = "SELECT * FROM users WHERE user_id = $the_user_id";
               $select_user_image = mysqli_query($connection, $query);
   
               while ($row = mysqli_fetch_array($select_user_image)) {
   
                   $user_image = $row['user_image'];
   
               }
           }
   
   
           if (!empty($user_password)) {
   
               $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
               $get_user_query = mysqli_query($connection, $query_password);
               confirmQuery($get_user_query);
   
               $row = mysqli_fetch_array($get_user_query);
               $db_user_password = $row['user_password'];
   
               if ($db_user_password != $user_password) {
   
                   $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
   
               } else {
                   $hashed_password = $db_user_password;
               }
   
   
               $query = "UPDATE users SET ";
               $query .= "user_firstname        =  '{$user_firstname}', ";
               $query .= "user_lastname         =  '{$user_lastname}', ";
               $query .= "user_role             =  '{$user_role}', ";
               $query .= "user_image            =  '{$user_image}', ";
               $query .= "username              =  '{$username}', ";
               $query .= "user_email            =  '{$user_email}', ";
               $query .= "user_password         =  '{$hashed_password}' ";//updated with new encrypted password
               $query .= "WHERE user_id         =  '{$the_user_id}' ";
   
   
   //assign connection to new variable
               $edit_user_query = mysqli_query($connection, $query);
   
               confirmQuery($edit_user_query);
   
               echo "<p class='bg-success'>User Updated. <a href='users.php'>View Users </a></p>";
   
           }
   
       }
   
   
   }else {
       header("location:index.php");
   }
   
   ?>
<!-- name attribute is caught by the POST super global-->
<form action=""  method="post" enctype="multipart/form-data">
   <div class="form-group">
      <label for="title"> First Name </label>
      <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname;?>">        
   </div>
   <div class="form-group">
      <label for="title"> Last Name </label>
      <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname;?>">        
   </div>
   <div class="form-group">
      <select name="user_role" id="">
         <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
         <?php 
            //STANDARD CODE
                // if ($user_role == 'admin') {
                //        echo "<option value='subscriber'>subscriber</option>";
                // } else {
                //        echo "<option value='admin'>admin</option>";
                // }
            
            
            //TESTING STUDENT CODE
            //WOrks but doesnt fix bug
            
                    $query = "SELECT DISTINCT user_role FROM users WHERE user_role != '{$user_role}'";
                    $select_role = mysqli_query($connection, $query);
                    confirmQuery($select_role);
                    $number = 0;
                    while($row = mysqli_fetch_array($select_role)){
                        $u_role = $row['user_role'];
                        echo "<option value={$u_role}>{$u_role}</option>";
                        $number++;
                    }
            ?>
      </select>
   </div>
   <div class="form-group">
      <img width="100" src="../images/<?php echo $user_image; ?>" alt="">
      <input  type="file" name="image">
   </div>
   <div class="form-group">
      <label for="title"> Username </label>
      <input type="text" class="form-control" name="username" value="<?php echo $username;?>">      
   </div>
   <div class="form-group">
      <label for="title"> Email </label>
      <input type="Email" class="form-control" name="user_email" value="<?php echo $user_email;?>">     
   </div>
   <div class="form-group">  
      <label for="post_content"> Password </label>
      <input autocomplete="off" type="Password" class="form-control" name="user_password">
   </div>
   <div class="form-group">
      <input class="btn btn-primary" type="submit" name="edit_user" value="Update User">        
   </div>
</form>