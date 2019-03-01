<?php include ("delete_modal.php"); ?>
<form action="" method="post">
   <table class="table table-bordered table-hover">
   <div id="bulkOptionContainer" class="col-xs-4">
      <select class="form-control" name="bulk_options" id="">
         <option value="">Select Options</option>
         <option value="approve">Approve</option>
         <option value="unapprove">Unapprove</option>
         <?php
            if (is_admin( $_SESSION ['username'])){
            echo "<option value='delete'>Delete</option>";
            echo "<option value='clone'>Clone</option>";
            }
            ?>
      </select>
   </div>
   <div class="col-xs-4">
      <input type="submit" name="submit" class="btn btn-default" value="Apply Changes">
      <p></p>
      <a class="btn btn-success" href="comments.php?source=approveAll">Approve All</a>
   </div>
   <div class="table-responsive">
   <table class="table table-striped table-hover">
      <thead>
         <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>Id</th>
            <th>User</th>
            <th width="40%">Comment</th>
            <th width="auto">Email</th>
            <th width="7%">Status</th>
            <th width="20%">In Response To</th>
            <th width="7%">Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
         </tr>
      </thead>
      <tbody>
         <?php 
            $query = "SELECT * FROM comments ORDER BY comment_id ASC ";
            $select_comments = mysqli_query($connection, $query);
            
            while ($row = mysqli_fetch_assoc($select_comments)) {
                $comment_id =  $row['comment_id'];
                $comment_post_id =  $row['comment_post_id'];
                $comment_author =  $row['comment_author'];
                $comment_content =  $row['comment_content'];
                $comment_email =  $row['comment_email']; 
                $comment_status =  $row['comment_status'];
                $comment_date =  $row['comment_date'];
               
                echo "<tr>";
                ?>
         <td><input class='checkBoxes' id='selectAllBoxes' type='checkbox' name='checkBoxArray[]' value= '<?php echo $comment_id; ?>'</td>
         <?php
            echo "<td>$comment_id</td>";
            echo "<td>$comment_author</td>";
            echo "<td>$comment_content</td>";
            echo "<td>$comment_email</td>";
            
            //Add a function for the query to look up catergory ID and dynamically display it in view all posts
            
            //            $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
            //        
            //            $select_categories_id = mysqli_query($connection, $query);
            //                        
            //            while ($row = mysqli_fetch_assoc($select_categories_id)) {
            //            $cat_id = $row['cat_id'];
            //            $cat_title = $row['cat_title']; 
            //        
            //            echo "<td>{$cat_title}</td>";
            //                
            //            }
            
            
            echo "<td>$comment_status</td>";
            
            $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
            $select_post_id_query = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_assoc($select_post_id_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                echo "<td><a href='../post.php?p_id=$post_id'>$post_title</td>";
                }
            
            
            echo "<td>$comment_date</td>";
            echo "<td><a class='btn btn-success' href ='comments.php?approve=$comment_id'>Approve</a></td>";
            echo "<td><a class='btn btn-info'href ='comments.php?unapprove=$comment_id'>Unapprove</a></td>";
            echo "<td><a class='btn btn-danger' href ='comments.php?delete=$comment_id'>Delete</a></td>";
            
            
            // echo "<td><a class='btn btn-danger' rel='$comment_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
            
            // JAVASCRIPT MODAL BROKEN FOR DELETING POSTS...  
            
            
            echo "</tr>"; 
            }
            ?> 
      </tbody>
   </table>
</form>
<script>
   $(document).ready(function(){ 
   
       $(".delete_link").on('click', function(){
   
       //targetting using "this" and the attribute is "rel"
       var id = $(this).attr("rel");
       //concatinating using + below
       var delete_url = "comments.php?delete="+ id +" ";
   
       $(".modal_delete_link").attr("href", delete_url);
       $("#myModal").modal('show');
   
   });
   
   });
   
</script>
<?php
   if(isset($_GET['approve'])) {
        commentApproval();
        header("location:comments.php");
   }
   
   if(isset($_GET['unapprove'])) {
       commentUnapprove();
       header("location:comments.php");
   }
   
   
       if(isset($_GET['delete'])) {
           if (is_admin( $_SESSION ['username'])){
                deleteComment();
                header("location:comments.php");
           }   
       }
   
   if (is_admin( $_SESSION ['username'])){
       
       if(isset($_GET['delete'])){
       
       $the_comment_id = escape($_GET['delete']);
       
       $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
       $delete_query = mysqli_query($connection, $query);
       header("Location: comments.php");
       
       }
   }
   
   ?>        
<?php
   ?>
<?php
   if(isset($_GET['source'])){
   
       $source = $_GET['source'];
   
   } else {
   
       $source = '';
   }
   
   switch($source) {
   
       case 'approveAll': //WORKS! dont break it!
   
           $query = "UPDATE comments SET comment_status = 'approved'";
           $update_to_approved_status = mysqli_query($connection, $query);
   
           confirmQuery($update_to_approved_status);
           header("location:comments.php");
   
           break;
   }
   
   ?>
<?php // SWITCH statements for bulk options
if(isset($_POST['checkBoxArray'])){
//foreach loop are specifically designed to loop through the entire array and it knows when to stop when the array is done. The "as" takes each value of the array and assign it a variable called $checkBoxValue.
foreach($_POST['checkBoxArray'] as $commentValueId ){
// echo $checkBoxValue;
$bulk_options = $_POST['bulk_options'];
switch ($bulk_options) {
case 'approve': //THIS WORKS
$query = "UPDATE `comments` SET `comment_status` = '{$bulk_options}' WHERE `comments`.`comment_id` = {$commentValueId}";
$update_to_approved_status = mysqli_query($connection,$query);
confirmQuery($update_to_approved_status);
header("location:comments.php");
break;
case 'unapprove': //THIS WORKS
$query = "UPDATE `comments` SET `comment_status` = '{$bulk_options}' WHERE `comments`.`comment_id` = {$commentValueId}";
$update_to_unapproved_status = mysqli_query($connection,$query);
confirmQuery($update_to_unapproved_status);
header("location:comments.php");
break;
case 'delete': //THIS WORKS
//comment_id = '{$bulk_options}'
$query = "DELETE FROM comments WHERE comment_id = {$commentValueId}";
$delete_comment = mysqli_query($connection,$query);
confirmQuery($delete_comment);
header("location:comments.php");
break;
// CLONE CASE
case 'clone':   //In PROGRESS
$query  = "SELECT * FROM posts WHERE post_id = {$postValueId} ";
$select_post_query = mysqli_query($connection,$query);
while ($row = mysqli_fetch_assoc($select_post_query)) {
$post_title         =  $row['post_title'];
$post_category_id   =  $row['post_category_id'];
$post_date          =  $row['post_date'];
$post_author        =  $row['post_author'];
$post_status        =  $row['post_status'];
$post_image         =  $row['post_image'];
$post_tags          =  $row['post_tags'];
$post_content       =  $row['post_content'];
$post_views_count   =  $row['post_views_count'];
}
$query = "INSERT INTO posts";
$query .= "(post_category_id, post_title, post_author, ";
$query .= "post_date, post_image, post_tags, post_status, post_content )";
$query .= "VALUES ({$post_category_id}, ";
$query .= "'{$post_title}', '{$post_author}', ";
$query .= "now(), '{$post_image}', " ;
$query .= "'{$post_tags}', '{$post_status}', '{$post_content}')";
$copy_query = mysqli_query($connection,$query);
if(!$copy_query) {
die("Query Failed" . mysqli_error($connection));
}
// confirmQuery($delete_post);
break;
}
}
}