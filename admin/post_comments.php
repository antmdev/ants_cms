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
                  Post Comments
                  <small><i style="color:slategrey"><?php echo $_SESSION ['username'] ?></i></small>
               </h1>
               <div class="table-responsive">
                  <table class="table table-striped table-hover">
                     <thead>
                        <tr>
                           <th>Id</th>
                           <th>Author</th>
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
                           $query = "SELECT * FROM comments WHERE comment_post_id =" . mysqli_real_escape_string($connection, $_GET['id']) . " ";
                           
                           
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
                           
                                                           echo "<td>$comment_id</td>";
                                                           echo "<td>$comment_author</td>";
                                                           echo "<td>$comment_content</td>";
                                                           echo "<td>$comment_email</td>";
                           
                           //Add a function for the query to look up category ID and dynamically display it in view all posts
                           
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
                           //need to send a get request for approve then a second get request to get the id so the header refresh below can catch it
                           
                                               echo "<td><a href ='post_comments.php?approve=$comment_id&id=" . $_GET['id'] . " ' >Approve</a></td>";
                                               echo "<td><a href ='post_comments.php?unapprove=$comment_id&id=" . $_GET['id'] . " ' >Unapprove</a></td>";
                                               echo "<td><a href ='post_comments.php?delete=$comment_id&id=" . $_GET['id'] . " ' >Delete</a></td>";
                                               echo "</tr>";
                                                       }
                                                       ?>
                     </tbody>
                  </table>
               </div>
               <?php
                  if(isset($_GET['approve'])) {
                  
                      $the_comment_id = escape($_GET['approve']);
                      $query = "UPDATE `comments` SET `comment_status` = 'approved' WHERE `comments`.`comment_id` = {$the_comment_id}";
                      // $query = "UPDATE comments SET comment_status = 'approve' WHERE comment_id = {$the_comment_id}";
                      $approve_comment_query = mysqli_query($connection, $query);
                      header("location: post_comments.php?id=" . $_GET['id'] . " ");
                      //Need to pull in the GET request again because we cant find it on this page as its sent from view_all_posts.php.
                  }
                  
                  if(isset($_GET['unapprove'])) {
                  
                      $the_comment_id = escape($_GET['unapprove']);
                      $query = "UPDATE `comments` SET `comment_status` = 'unapproved' WHERE `comments`.`comment_id` = {$the_comment_id}";
                      $unapprove_comment_query = mysqli_query($connection, $query);
                      header("location: post_comments.php?id=" . $_GET['id'] . " ");
                  }
                  
                  ?>
               <?php
                  if(isset($_GET['delete'])) {
                  
                      $the_comment_id = escape($_GET['delete']);
                      $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
                      $delete_query = mysqli_query($connection, $query);
                      //ADD THIS REFRESH BELOW THE QUERY TO REFRESH THE PAGE
                      header("location: post_comments.php?id=" . $_GET['id'] . " ");
                  }
                  
                  ?>
            </div>
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /#page-wrapper -->
</div>
<?php include "includes/admin_footer.php"; ?>