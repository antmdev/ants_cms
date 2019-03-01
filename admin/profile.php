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
                  Profile Page
                  <small><i style="color:slategrey">Username:     <?php echo $_SESSION ['username'] ?></i></small>
               </h1>
               <!-- Form from Edit user -->
               <form action=""  method="post" enctype="multipart/form-data">
                  <?php
                     if (isset($_SESSION['username'])){
                     
                         $session_username = $_SESSION['username'];
                     
                         $query = "SELECT * FROM users WHERE username = '{$session_username}' ";
                     
                         $select_user_profile_query = mysqli_query($connection, $query);
                     
                         while ($row = mysqli_fetch_array($select_user_profile_query)) {
                             $user_id =  $row['user_id'];
                             $username =  $row['username'];
                             $user_password =  $row['user_password'];
                             $user_firstname =  $row['user_firstname'];
                             $user_lastname =  $row['user_lastname'];
                             $user_email =  $row['user_email'];
                     
                             //grabs user image from DB (works)
                             $user_image=  $row['user_image'];
                         }
                     }
                     ?>
                  <?php
                     if(isset($_POST['edit_user'])) {
                     
                         $user_firstname = $_POST ['user_firstname'];
                         $user_lastname = $_POST['user_lastname'];
                         $username = $_POST['username'];
                         $user_email = $_POST['user_email'];
                         $user_password = $_POST['user_password'];
                     
                         $user_image = $_FILES ['image']['name'];
                         $user_image_temp = $_FILES['image']['tmp_name'];
                     
                         move_uploaded_file($user_image_temp, "../images/$user_image");
                     
                     //Collect image from database if empty...
                     
                         if (empty($user_image)) {
                     
                             $query = "SELECT * FROM users WHERE username = '{$session_username}' ";
                     
                             $select_user_image = mysqli_query($connection, $query);
                     
                             while ($row = mysqli_fetch_array($select_user_image)) {
                     
                                 $user_image = $row['user_image'];
                     
                             }
                         }
                     
                         if (!empty($user_password)) {
                     
                             $query_password = "SELECT user_password FROM users WHERE username = '{$session_username}' ";
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
                             $query .= "user_image            =  '{$user_image}', ";
                             $query .= "user_firstname        =  '{$user_firstname}', ";
                             $query .= "user_lastname         =  '{$user_lastname}', ";
                             $query .= "username              =  '{$username}', ";
                             $query .= "user_email            =  '{$user_email}', ";
                             $query .= "user_password         =  '{$hashed_password}' ";
                             $query .= "WHERE username       =  '{$session_username}' ";
                     
                     
                     //assign connection to new variable    
                             $edit_user_from_profile = mysqli_query($connection, $query);
                     
                             confirmQuery($edit_user_from_profile);
                     // header("location: users.php");
                     
                     // needs fixing below
                             echo "<p class='bg-success'>User Updated. <a href='users.php'>View Users </a></p>";
                     
                         }
                     
                     }
                     ?>
                  <div class="form-group">
                     <label for="title"> First Name </label>
                     <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname;?>">
                  </div>
                  <div class="form-group">
                     <label for="title"> Last Name </label>
                     <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname;?>">
                  </div>
                  <!--/ REMOVE SELECTOR FOR ROLE AS PROFILE SHOULDN'T HAVE THAT RIGHT-->
                  <div class="form-group">
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
            </div>
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /#page-wrapper -->
</div>
<?php include "includes/admin_footer.php"; ?>