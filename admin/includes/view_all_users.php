<?php include ("delete_modal.php"); ?>
<div class="table-responsive">
   <table class="table table-striped table-hover">
      <thead>
         <tr>
            <th>Id</th>
            <th width=15%>Username</th>
            <th width=10%>First Name</th>
            <th width=10%>Last Name</th>
            <th width=20%>Email</th>
            <th width=10%>User Image</th>
            <th width=10%>Role</th>
         </tr>
      </thead>
      <tbody>
         <?php 
            $query = "SELECT * FROM users ORDER BY user_id ASC ";
            $select_comments = mysqli_query($connection, $query);
            
            while ($row = mysqli_fetch_assoc($select_comments)) {
                $user_id =  $row['user_id'];
                $username =  $row['username'];
                $user_password =  $row['user_password'];
                $user_firstname =  $row['user_firstname'];
                $user_lastname =  $row['user_lastname'];
                $user_email =  $row['user_email']; 
                $user_image=  $row['user_image'];
                $user_role =  $row['user_role'];
               
                echo "<tr>";
                
                echo "<td>$user_id</td>";
                echo "<td>$username</td>";
                echo "<td>$user_firstname</td>";
                echo "<td>$user_lastname</td>";
                echo "<td>$user_email</td>";
                echo "<td><img width='60' img height='60' align='center' class='img-responsive img-circle' src='../images/$user_image' alt='user_image'></td>";
                echo "<td>$user_role</td>";
            
                echo "<td><a href ='users.php?change_to_admin={$user_id}'>Admin</a></td>";
                echo "<td><a href ='users.php?change_to_sub={$user_id}'>Subscriber</a></td>";
                echo "<td><a class='btn btn-info' href ='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
                // echo "<td><a href ='users.php?delete={$user_id}'>Delete</a></td>";
                echo "<td><a class='btn btn-danger delete_link' rel='$user_id' href='javascript:void(0)'>Delete</a></td>";
                echo "</tr>"; 
            }
            ?> 
         <script>
            $(document).ready(function(){ 
            
                $(".delete_link").on('click', function(){
            
                //targetting using "this" and the attribute is "rel"
                var id = $(this).attr("rel");
                //concatinating using + below
                var delete_url = "users.php?delete="+ id +" ";
            
                $(".modal_delete_link").attr("href", delete_url);
                $("#myModal").modal('show');
            
            });
            
            });
            
         </script>
      </tbody>
   </table>
</div>
<?php
   if(isset($_GET['change_to_admin'])) {
   
       $the_user_id = escape($_GET['change_to_admin']);
       $query = "UPDATE users SET user_role = 'admin' WHERE user_id = {$the_user_id}";
      // $query = "UPDATE comments SET comment_status = 'approve' WHERE comment_id = {$the_comment_id}";
       $change_to_admin_query = mysqli_query($connection, $query); 
       header("location: users.php");
   }
   
   if(isset($_GET['change_to_sub'])) {
   
       $the_user_id = escape($_GET['change_to_sub']);
       $query = "UPDATE `users` SET `user_role` = 'subscriber' WHERE user_id = {$the_user_id}";
       $change_to_subscriber_query = mysqli_query($connection, $query); 
       header("location:users.php");
   }
   
   ?>          
<?php
   if(isset($_GET['delete'])){
   
       if(isset($_SESSION['user_role'])) {
   
           if($_SESSION['user_role'] == 'admin') {
   
               $the_user_id =mysqli_real_escape_string($connection, $_GET['delete']);
               $query = "DELETE FROM users WHERE user_id = {$the_user_id} ";
               $delete_query = mysqli_query($connection, $query);
               header("location:users.php");
           }
   
       }
   }
   
   ?>