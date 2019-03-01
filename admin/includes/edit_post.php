<?php
   if(isset($_GET['p_id'])){
   
   $the_post_id =  escape($_GET['p_id']);
   
   }
   
   $query = "SELECT * FROM posts WHERE post_id = $the_post_id  ";
   $select_posts_by_id = mysqli_query($connection,$query);
   
   while($row = mysqli_fetch_assoc($select_posts_by_id)) {
       $post_id            =  $row['post_id'];
       $post_user          =  $row['post_user'];
       $post_title         =  $row['post_title'];
       $post_category_id   =  $row['post_category_id'];
       $post_status        =  $row['post_status'];
       $post_image         =  $row['post_image'];
       $post_content       =  $row['post_content'];
       $post_tags          =  $row['post_tags'];
       $post_comment_count =  $row['post_comment_count'];
       $post_date          =  $row['post_date'];
       // $post_views_count   =  $row['post_views_count'];
   }
   
   ?>
<?//Detect the form once it has been submitted
   //uses value from the form submit / update post button below ?>
<?php // UPDATE QUERY
   if(isset($_POST['update_post'])) {
   
   // grabbing form post values from below and assigning to a variable 
   //$post_category_id is the new assigned variable name slightly different to post_category
   
   $post_user              =  escape($_POST['post_user']);
   $post_title             =  escape($_POST['post_title']);
   $post_category_id       =  escape($_POST['post_category']);
   $post_status            =  escape($_POST['post_status']);
   $post_image             =  escape($_FILES['image']['name']);
   $post_image_temp        =  escape($_FILES['image']['tmp_name']);
   // $post_content           =  escape($_POST['post_content']);
   //either this escape string or the escapes has fixed the edit post length bug!!
   $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
   
   $post_tags              =  escape($_POST['post_tags']);
   
   move_uploaded_file($post_image_temp, "../images/$post_image");
   
   // make sure the $post_image is not empty, and if it is we go get it from the database. If empty we search database all from post_id. Then run while loop to search through the row to find the result set then pull out the image.
   
       if(empty($post_image)) {
       
       $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
       $select_image = mysqli_query($connection,$query);
           
       while($row = mysqli_fetch_array($select_image)) {
           
          $post_image = $row['post_image'];
       
       }
   }
   
   //This is basically one huge string query concatinated so it's easier to read and better for debugging
   //So this is updating the post - and then update and set the post_title (which is the column in the table) to equal to the post title in the form
   //NEED A WHITE SPACE after SET in QUery
   
   $query  = "UPDATE posts SET ";
   $query .="post_title        =  '{$post_title}', ";
   $query .="post_category_id  =  '{$post_category_id}', ";
   $query .="post_date         =   now(), ";
   $query .="post_user         =  '{$post_user}', " ;
   $query .="post_status       =  '{$post_status}', " ;
   $query .="post_tags         =  '{$post_tags}', " ;
   $query .="post_content      =  '{$post_content}', ";
   $query .="post_image        =  '{$post_image}' ";
   $query .="WHERE post_id     =   $the_post_id ";
   
   //assign connection to new variable    
   $update_post = mysqli_query($connection,$query);
   //    
   confirmQuery($update_post);
   
   // echo "<p>Post Updated: <a href='../post.php?p_id={$the_post_id}>View Post</a> </p>";
   // echo "Post Updated: " . " " . "<a href='../post.php?p_id=$post_id'>View Post </a>";  
   echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
   //header("location:posts.php");
   
   }
   
   ?>
<!-- name attribute is caught by the POST super global-->
<form action=""  method="post" enctype="multipart/form-data">
   <div class="form-group">
      <label for="title"> Post Title </label>
      <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title"> 
   </div>
   <div class="form-group">
      <label for="categories">Categories</label>
      <select name="post_category" id="">
      <?php 
         //This creates a drop down selector which then searches the database for the available categoryies that have been previouslt created. ConfirmQuery function confirms connection to the database.
                 
             $query = "SELECT * FROM categories";
             $select_categories = mysqli_query($connection, $query);
                 
             confirmQuery($select_categories);
                                 
             while($row = mysqli_fetch_assoc($select_categories)) {
             $cat_id = $row['cat_id'];
             $cat_title = $row['cat_title']; 
                 
             if($cat_id == $post_category_id) {
         
                echo "<option selected value ='{$cat_id}'>{$cat_title}</option>"; //adding this to pullin the category as default dispalyed
             } else {
         
                 echo "<option value ='{$cat_id}'>{$cat_title}</option>";
             }
                 
             }
         
         ?>
      </select>      
   </div>
   <div class="form-group">
      <label for="users">User</label>
      <select name="post_user" id="">
      <?php
         echo "<option value ='{$post_user}'>{$post_user}</option>";
         ?>
      <?php
         $query = "SELECT * FROM users";
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
   <!-- <div class="form-group">
      <label for="title"> Post View Counts</label>
      <input value="<?php //echo ; ?>" type=" text" class="form-control" name="post_user">        
      </div> -->
   <!-- <div class="form-group">
      <label for="title"> Post Status </label>
      <input value="<?php //echo $post_status; ?>" type="text" class="form-control" name="post_status">        
      </div> -->
   <div class="form-group">
      <label for="post_status">Post Status</label>
      <select name="post_status" id="">
         <option value="draft" <?php if($post_status == 'draft'){echo "selected";} ?>>Draft</option>
         <option value="published" <?php if($post_status == 'published'){echo "selected";} ?>>Published</option>
      </select>
   </div>
   <div class="form-group">
      <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
      <input  value='image' type="file" name="image">
   </div>
   <div class="form-group">
      <label for="title"> Post Tags </label>
      <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">    
   </div>
   <div class="form-group">
      <label for="title"> Post Content </label>
      <textarea value='text_area' class="form-control" name="post_content" id="body" cols="30" rows="10"><?php echo $post_content; ?></textarea>        
   </div>
   <div class="form-group">
      <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">        
   </div>
</form>