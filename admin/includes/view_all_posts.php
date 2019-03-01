<?php
   //post count is broken.
   
   // if (!is_admin( $_SESSION ['username'])){
   //     header ("location: index.php");
   // } 
   
   ?>
<?php
   include ("delete_modal.php");
   
   if(isset($_POST['checkBoxArray'])){
   
       //foreach loop are specifically designed to loop through the entire array and it knows when to stop when the array is done. The "as" takes each value of the array and assign it a variable called $checkBoxValue.
   
       foreach($_POST['checkBoxArray'] as $postValueId ){
   
           // echo $checkBoxValue;
           $bulk_options = $_POST['bulk_options'];
   
           switch ($bulk_options) {
   
               case 'published':
   
                   $query  = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
   
                   $update_to_published_status = mysqli_query($connection,$query);
   
                   confirmQuery($update_to_published_status);
   
                   break;
   
               case 'draft':
   
                   $query  = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
   
                   $update_to_draft_status = mysqli_query($connection,$query);
   
                   confirmQuery($update_to_draft_status);
   
                   break;
   
   
               // CLONE CASE
               case 'clone':
   
                   $query  = "SELECT * FROM posts WHERE post_id = {$postValueId} ";
                   $select_post_query = mysqli_query($connection,$query);
   
                   while ($row = mysqli_fetch_assoc($select_post_query)) {
                       $post_title         =  escape($row['post_title']);
                       $post_category_id   =  escape($row['post_category_id']);
                       $post_date          =  escape($row['post_date']);
                       $post_user          =  escape($row['post_user']);
                       $post_status        =  escape($row['post_status']);
                       $post_image         =  escape($row['post_image']);
                       $post_tags          =  escape($row['post_tags']);
                       $post_content       =  escape($row['post_content']);
                       $post_views_count   =  escape($row['post_views_count']);
   
                       if (empty($post_tags)){
                           $post_tags = "No Tags";
                       }
   
   
                   }
   
                   $query = "INSERT INTO posts";
                   $query .= "(post_category_id, post_title, post_user, ";
                   $query .= "post_date, post_image, post_tags, post_status, post_content )";
   
                   $query .= "VALUES ({$post_category_id}, ";
                   $query .= "'{$post_title}', '{$post_user}', ";
                   $query .= "now(), '{$post_image}', " ;
                   $query .= "'{$post_tags}', '{$post_status}', '{$post_content}')";
   
                   $copy_query = mysqli_query($connection,$query);
   
                   if(!$copy_query) {
                       die("Query Failed" . mysqli_error($connection));
                   }
   
                   // confirmQuery($delete_post);
   
                   break;
   
               case 'reset_views_count':
   
                   $query  = "UPDATE posts SET post_views_count = 0 WHERE post_id = {$postValueId} ";
   
                   $reset_views_count = mysqli_query($connection,$query);
   
                   confirmQuery($reset_views_count);
   
                   break;
   
               case 'delete':
   
                   $query  = "DELETE FROM posts WHERE post_id = {$postValueId} ";
   
                   $delete_post = mysqli_query($connection,$query);
   
                   confirmQuery($delete_post);
   
                   $query = "DELETE FROM comments WHERE comment_post_id = {$postValueId}";
                   $delete_comment_query = mysqli_query($connection, $query);
                   confirmQuery($delete_comment_query);
   
                   break;
   
           }
   
       }
   
   }
   
   
   ?>
<form action="" method="post">
   <table class="table table-bordered table-hover">
   <div id="bulkOptionContainer" class="col-xs-4">
      <select class="form-control" name="bulk_options" id="">
         <option value="">Select Options</option>
         <option value="published">Publish</option>
         <option value="draft">Draft</option>
         <option value="delete">Delete</option>
         <option value="clone">Clone</option>
         <option value="reset_views_count">Reset View Count</option>
      </select>
   </div>
   <div class="col-xs-4">
      <input type="submit" name="submit" class="btn btn-success" value="Apply">
      <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
   </div>
   <div class="table-responsive">
   <table class="table table-striped table-hover">
      <thead>
         <tr>
            <th><input id="selectAllBoxes" type="checkbox"></th>
            <th>Id</th>
            <th width="10%">User</th>
            <th width="20%">Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Images</th>
            <th>Tags</th>
            <th width="1%">Comments</th>
            <th>Date</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Post Views</th>
         </tr>
      </thead>
      <tbody>
         <?php 
            // $user = currentUser();
            
            // the below grabs the user and displays only their posts but its been removed.
            // $query = "SELECT * FROM posts  LEFT JOIN categories ON posts.post_category_id WHERE post_user = '$user'  = categories.cat_id ORDER BY posts.post_id DESC";
            
            $query = "SELECT * FROM posts  LEFT JOIN categories ON posts.post_category_id  = categories.cat_id ORDER BY posts.post_id DESC";
            
            $select_posts = mysqli_query($connection, $query);
            
            while($row = mysqli_fetch_assoc($select_posts)) {
                $post_id            =  $row['post_id'];
                $post_user          =  $row['post_user'];
                $post_title         =  $row['post_title'];
                $post_category_id   =  $row['post_category_id'];
                $post_status        =  $row['post_status'];
                $post_image         =  $row['post_image'];
                $post_tags          =  $row['post_tags'];
                $post_comment_count =  $row['post_comment_count'];
                $post_date          =  $row['post_date'];
                $post_views_count   =  $row['post_views_count'];
                $category_title     =  $row['cat_title'];
                $category_id        =  $row['cat_id'];
            
                echo "<tr>";
            
                ?>
         <!--
            We wait for the checkbox to be clicked, then when the form is submitted it will get a name and posted via $_POST
            as an array. BUt we need to assign it a value first -the value we assign is taken form the $post_id
            then we can fill the array with all of the IDs we want to "delete" for example.
            -->
         <td><input class='checkBoxes' id='selectAllBoxes' type='checkbox' name='checkBoxArray[]' value= '<?php echo $post_id; ?>'</td>
         <?php
            echo "<td>$post_id</td>";
            
            
            //create a condition to create if there's something here, and if the user is an author from the comments section we display that, otherwise if its a user from admin we display that.
            
            //                    echo "<td>$post_user</td>";
            
            if(!empty($post_user)){
            
            echo "<td>{$post_user}</td>";
            
            
            } elseif (!empty($post_user)){
            
            echo "<td>{$post_user};</td>";
            
            }
            
            echo "<td>$post_title</td>";
            
            
            echo "<td>{$category_title}</td>";
            
            //  }
            
            echo "<td>$post_status</td>";
            echo "<td><img width='100' class='img-responsive img-rounded' src='../images/$post_image' alt='image'></td>";
            echo "<td>$post_tags</td>";
            
            $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id}";
            $send_comment_query = mysqli_query($connection, $query);
            
            $row = mysqli_fetch_array($send_comment_query);
            
            $comment_id = $row['comment_id'];
            $count_comments = mysqli_num_rows($send_comment_query);
            
            
            echo "<td><div style='text-align: center;'><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";
            
            
            //   old post comment count echo "<td><div style='text-align: center;'>{$post_comment_count}</div></td>";
            echo "<td>$post_date</td>";
            
            
            
            echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View Post</td>";
            //enter parameter which comes after the question mark
            //Ampersan & includes a second parameter which in this case is p_id relating to the post id.  
            echo "<td><a class='btn btn-info' href ='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
            
            //We're coming back to change the GET request for delete to be a POST request because its more secure this way:
            // OLD CODE  echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
            
            //break out PHP  ?>
<form method="post">
<input type="hidden" name="post_id" value="<?php echo $post_id ?>" > 
<?php echo '<td> <input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>'; ?>
</form>
<?php  //bring PHP back
   // echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
   
   
   
   
   
   // echo "<td><a onClick=\"javascript: return confirm('are you sure you want to delete?'); \" href ='posts.php?delete={$post_id}'>Delete</a></td>";
   //adding a reset post count functionality by clicking on the link and sending reset in the get request.(Bottom of page)
   // echo "<td><a href='posts.php?reset={$post_id}'>{$post_views_count}</a></td>";
   echo "<td><div style='text-align: center;'><a href ='posts.php?reset={$post_id}'>{$post_views_count}</a></div></td>";
   // echo  "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";
   // echo "<td>{$post_views_count}<a href='posts.php?reset={$post_id}'>&nbsp;&nbsp;<span class='glyphicon glyphicon-remove-circle'></a></span></td>";
   echo "</tr>";
   
   
   
   } // NEED THIS FOR CAT_ID QUERY
   ?>
<script>
   $(document).ready(function(){ 
   
       $(".delete_link").on('click', function(){
   
       //targetting using "this" and the attribute is "rel"
       var id = $(this).attr("rel");
       //concatinating using + below
       var delete_url = "posts.php?delete="+ id +" ";
   
       $(".modal_delete_link").attr("href", delete_url);
       $("#myModal").modal('show');
   
   });
   
   });
   
</script>
</tbody>
</table>
<?php
   //DELETE posts get request
   
                           
               
   if (is_admin( $_SESSION ['username'])){
   
       if(isset($_POST['delete'])) {
   
           $the_post_id = escape($_POST['post_id']);//no escape because from inside application
           $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
           $delete_query = mysqli_query($connection, $query);
           confirmQuery($delete_query);
   
           $query = "DELETE FROM comments WHERE comment_post_id = {$the_post_id}";
           $delete_comment_query = mysqli_query($connection, $query);
           confirmQuery($delete_comment_query);
       
           //ADD THIS REFRESH BELOW THE QUERY TO REFRESH THE PAGE
           header("location:posts.php");
       }
   }
   //Reset views count
   
   if(isset($_GET['reset'])) {
   
       $the_post_id = escape($_GET['reset']);
       //rather than seting post to zero where post id = post id we're concatinating and using real escape string to clean data.
       $query  = "UPDATE posts SET post_views_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $_GET['reset']) . " "; //escaping the GET request which is the ?reset where posts.php = post_id for $post_views_count.
   
       // $query  = "UPDATE posts SET post_views_count = 0 WHERE post_id = $the_post_id ";
   
       $reset_query = mysqli_query($connection, $query);
   
       confirmQuery($reset_query);
   
       header("location:posts.php");
   
   }
   ?>