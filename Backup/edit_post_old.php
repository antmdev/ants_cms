<?php
if(isset($_GET['p_id'])) {
    
   $the_post_id = $_GET['p_id'];
}

$query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
$select_posts_by_id  = mysqli_query($connection, $query);
   
    while($row = mysqli_fetch_assoc($select_posts_by_id)) {
        $post_id            =  $row['post_id'];
        $post_author        =  $row['post_author'];
        $post_title         =  $row['post_title'];
        $post_category_id   =  $row['post_category_id'];
        $post_status        =  $row['post_status'];
        $post_image         =  $row['post_image'];
        $post_content       =  $row['post_content'];
        $post_tags          =  $row['post_tags'];
        $post_comment_count =  $row['post_comment_count'];
        $post_date          =  $row['post_date'];
        
    }

?>
<?//Detect the form once it has been submitted
//uses value from the form submit / update post button below ?>


<?php // UPDATE QUERY

if(isset($_POST['update_post'])) {

// grabbing form post values from below and assigning to a variable 
//$post_category_id is the new assigned variable name slightly different to post_category
   
    $post_author            =  $_POST['post_author'];
    $post_title             =  $_POST['post_title'];
    $post_category_id       =  $_POST['post_category'];
    $post_status            =  $_POST['post_status'];
    $post_image             =  $_FILES['image']['name'];
    $post_image_temp        =  $_FILES['image']['tmp_name'];
    // $post_image             =  $_FILES['image']['name']);
    // $post_image_temp        =  $_FILES['image']['tmp_name']);
    $post_content           =  $_POST['post_content'];
    $post_tags              =  $_POST['post_tags'];
   
    move_uploaded_file($post_image_temp, "../images/$post_image");
    
// make sure the $post_image is not empty, and if it is we hgo get it from the database. If empty we search database all from post_id. Then run while loop to search through the row to find the result set then pull out the image.
    
    if(empty($post_image)) {
        
        $query = "SELECT all FROM posts WHERE post_id = $the_post_id ";
        $select_image = mysqli_query($connection, $query);
        
        while($row = mysqli_fetch_array ($select_image)) {
     
            $post_image = $row['post_image'];
    }
}

//This is basically one huge string query concatinated so it's easier to read and better for debugging
//So this is updating the post - and then update and set the post_title (which is the column in the table) to equal to the post title in the form
//NEED A WHITE SPACE after SET in QUery
    
    $query = "UPDATE posts SET ";
    $query .="post_title  =  '{$post_title}', ";
    $query .="post_category_id = '{$post_category_id}', ";
    $query .="post_date = now(), ";
    $query .="post_author =  '{$post_author}', " ;
    $query .="post_status =  '{$post_status}', " ;
    $query .="post_tags   =  '{$post_tags}', " ;
    $query .="post_content=  '{$post_content}', ";
    $query .="post_image  =  '{$post_image}' ";
    $query .="WHERE post_id = {$the_post_id} ";
    
//assign connection to new variable    
    $update_post = mysqli_query($connection, $query);
//    
    confirmQuery($update_post);
    
    if(!$update_post) {
        
        die("QURERY FAILED" . mysqli_error($connection));
    }

}

    
?>


<!-- name attribute is caught by the POST super global-->
<form action=""  method="post" enctype="multipart/form-data">
    
    <div class="form-group">
        <label for="title"> Post Title </label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title"> 
   
    </div>  
        
    <div class="form-group">
        
    <select name="post_category" id="">
              
<?php 
//This creates a drop down selector which then searches the database for the available categoryies that have been previouslt created. ConfirmQuery function confirms connection to the database.
        
    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection, $query);
        
    confirmQuery($select_categories);
                        
    while($row = mysqli_fetch_assoc($select_categories)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title']; 
        
    echo "<option value ='$cat_id'>{$cat_title}</option>";
        
    }

?>
                  
    </select>      
    </div>
    <div class="form-group">
        <label for="title"> Post Author</label>
        <input value="<?php echo $post_author; ?>" type="text" class="form-control" name="post_author">        
    </div>
    
    <div class="form-group">
        <label for="title"> Post Status </label>
        <input value="<?php echo $post_status; ?>" type="text" class="form-control" name="post_status">        
    </div>
    
    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
   </div>

    <div class="form-group">
       <label for="post_image">Post Image</label>
       <input type="file" class="form-control" name="post_image">
    </div>


    <div class="form-group">
        <label for="title"> Post Tags </label>
        <input value="<?php echo $post_tags; ?>"type="text" class="form-control" name="post_tags">    
    </div>
    <div class="form-group">
        <label for="title"> Post Content </label>
        <textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?></textarea>        
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">        
    </div>

</form>