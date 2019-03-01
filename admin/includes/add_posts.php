<?php
   if(isset($_POST['create_post'])) {
   
       $post_title         =  escape($_POST ['title']);
       $post_author        =  escape($_POST['post_user']);
       $post_category_id   =  escape($_POST['post_category']);
       $post_status        =  escape($_POST['post_status']);
   
   //post image takes input from "Post Image" form below. It is then stored in a temporary location on the server using the variable $post_image_temp - we then need to tell it to move it from this temporary location to another location.
   
       $post_image         =  escape($_FILES ['image']['name']);
       $post_image_temp    =  escape($_FILES['image']['tmp_name']);
   
       $post_tags          =  escape($_POST['post_tags']);
       $post_date          =  escape(date ('d-m-y'));
       // $post_content =  $_POST['post_content'];
       $post_content       = mysqli_real_escape_string($connection, $_POST['post_content']);
   
   
   //this is a function to move the uploaded file from the temporary location to a new location in the images folder.  
   
       move_uploaded_file ($post_image_temp, "../images/$post_image");
   
   //run a query to the database
   
       $query = "INSERT INTO posts (post_title, post_user, post_category_id, post_status, post_image, post_tags, post_date, post_content )";
   //find the values from the form and insert them into the table in the database above. We're using single quotes for these variable because they are mostly strings.    
   // now() is a new function that sends the date in a neat format for the database.
       $query .=
           "VALUES ('{$post_title}', '{$post_author}','{$post_category_id}','{$post_status}','{$post_image}','{$post_tags}', now(), '{$post_content}') ";
   
   //send data to database
       $create_post_query = mysqli_query($connection, $query);
   
   //run our function from functions.php to check DB connection.
       confirmQuery($create_post_query);
   
       $the_post_id = mysqli_insert_id($connection);
   
       echo "<p class='bg-success'>Post Added. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
   
       // header("location:posts.php");
   
   }
   
   ?>
<!-- name attribute is caught by the POST super global-->
<form action=""  method="post" enctype="multipart/form-data">
   <div class="form-group">
      <label for="title"> Post Title </label>
      <input type="text" class="form-control" name="title">
   </div>
   <!-- ///////////////////// PASTED from edit posts -->
   <div class="form-group">
      <label for="category"> Category </label>
      <select name="post_category" id="">
      <?php
         //This creates a drop down selector which then searches the database for the available categoryies that have been previouslt created. ConfirmQuery function confirms connection to the database.
         
         $query = "SELECT * FROM categories";
         $select_categories = mysqli_query($connection, $query);
         
         confirmQuery($select_categories);
         
         while($row = mysqli_fetch_assoc($select_categories)) {
             $cat_id = $row['cat_id'];
             $cat_title = $row['cat_title'];
         
             echo "<option value ='{$cat_id}'>{$cat_title}</option>";
         
         }
         
         ?>
      </select>
   </div>
   <div class="form-group">
      <label for="users"> Users </label>
      <select name="post_user" id="">
      <?php
         //This creates a drop down selector which then searches the database for the available categoryies that have been previouslt created. ConfirmQuery function confirms connection to the database.
         
         $query = "SELECT * FROM users ";
         $select_users = mysqli_query($connection, $query);
         
         confirmQuery($select_users);
         
         while($row = mysqli_fetch_assoc($select_users)) {
             $user_id = $row['user_id'];
             $username = $row['username'];
         
             echo "<option value ='{$username}'>{$username}</option>";
         
         }
         
         ?>
      </select>
   </div>
   <!-- ///////////////////// PASTED from edit posts -->
   <!--    <div class="form-group">-->
   <!--        <label for="title"> Post Author</label>-->
   <!--        <input type="text" class="form-control" name="author">-->
   <!--    </div>-->
   <!-- <div class="form-group">
      <label for="title"> Post Status </label>
      <input type="text" class="form-control" name="post_status">        
      </div> -->
   <div class="form-group">
      <label for="post_status">Post Status</label>
      <select name="post_status" id="">
         <option value="draft">Select</option>
         <option value="draft">Draft</option>
         <option value="published">Published</option>
      </select>
   </div>
   <div class="form-group">
      <label for="title"> Post Image </label>
      <input type="file" name="image">
   </div>
   <div class="form-group">
      <label for="title"> Post Tags </label>
      <input type="text" class="form-control" name="post_tags">
   </div>
   <div class="form-group">
      <label for="title"> Post Content </label>
      <textarea class="form-control" name="post_content" id="body" cols="30" rows="10"> 
      </textarea>
   </div>
   <div class="form-group">
      <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
   </div>
</form>