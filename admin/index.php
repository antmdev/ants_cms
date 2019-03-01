<?php include "includes/admin_header.php"; ?>
<div id="wrapper">
<!-- <?php // if ($connection) echo "conn"; ?> -->
<?php 
   //previous code for users online was here...
   
   ?>
<!-- Navigation -->
<?php include "includes/admin_navigation.php"; ?>
<div id="page-wrapper">
<div class="container-fluid">
<!-- Page Heading -->
<div class="row">
<h1 class="page-header">
   Welcome to the Admin Panel 
   <!-- Echo session username to display in admin panel! -->
   <small><i style="color:slategrey">Username:    <?php echo $_SESSION ['username'] ?></i>
</h1>
<!--  <small><br> User Role: <?php// echo $_SESSION ['user_role'] ?></small> -->
<!-- </h1> -->
<!-- <h1><?php // echo $count_user ?></h1> -->
<div class="row">
   <div class="col-lg-3 col-md-6">
      <div class="panel panel-primary">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-file-text fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                  <!-- CALL FUNCTION FOR COUNT NUMBER -->
                  <div class='huge'><?php echo $post_count = recordCount('posts'); ?></div>
                  <div>Posts</div>
               </div>
            </div>
         </div>
         <a href="posts.php">
            <div class="panel-footer">
               <span class="pull-left">View Posts</span>
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>
   <div class="col-lg-3 col-md-6">
      <div class="panel panel-green">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-comments fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                  <div class='huge'><?php echo $comment_counts = recordCount('comments'); ?></div>
                  <div>Comments</div>
               </div>
            </div>
         </div>
         <a href="comments.php">
            <div class="panel-footer">
               <span class="pull-left">View Comments</span>
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>
   <div class="col-lg-3 col-md-6">
      <div class="panel panel-yellow">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-user fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                  <div class='huge'><?php echo $number_users = recordCount('users'); ?></div>
                  <div> Users</div>
               </div>
            </div>
         </div>
         <a href="users.php">
            <div class="panel-footer">
               <span class="pull-left">View Users</span>
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>
   <div class="col-lg-3 col-md-6">
      <div class="panel panel-red">
         <div class="panel-heading">
            <div class="row">
               <div class="col-xs-3">
                  <i class="fa fa-list fa-5x"></i>
               </div>
               <div class="col-xs-9 text-right">
                  <div class='huge'><?php echo $number_categories = recordCount('categories'); ?></div>
                  <div>Categories</div>
               </div>
            </div>
         </div>
         <a href="categories.php">
            <div class="panel-footer">
               <span class="pull-left">View Categories</span>
               <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
               <div class="clearfix"></div>
            </div>
         </a>
      </div>
   </div>
</div>
<?php //<!-- CALL FUNCTION FOR Admin Graph   -->
   $post_draft_count = checkStatus('posts', 'post_status', 'draft');
   $post_published_count = checkStatus('posts', 'post_status', 'published');
   $unapproved_comment_count = checkStatus('comments', 'comment_status', 'unapproved');
   $subscriber_count = checkUserRole('users', 'user_role', 'subscriber');
   $admin_count = checkUserRole('users', 'user_role', 'admin');
   
   
   ?>
<!-- /.row -->
<div class="row">
   <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      
      function drawChart() {
          var data = google.visualization.arrayToDataTable([
          ['Data', 'Count' ],
      
          <?php
         //create an array for the four sections in the dashboard, this will print the values for the columns
         //We're printing the values as "static" values, because they're text and we're defining them ourselves.
         $element_text = ['All Posts', 'Active Posts', 'Draft Posts', 'Comments', 'Pending Comments', 'Users', 'Subscribers', 'Admins', 'Categories' ];
         
         //create an array for the four sections in the dashboard
         $element_count = [$post_count, $post_published_count, $post_draft_count, $comment_counts, $unapproved_comment_count, $number_users, $subscriber_count, $admin_count, $number_categories];
         
         //create a for-loop to count through all of the possible arrays so we can display them dynamically
         //$i - is the intialiser of the loop which will go through each of the values in the elements text array
         //Then we echo each of the values it will read into a new array
         
         for($i = 0;$i < 9; $i++) {
         
         echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
         
         }
         
         ?>
      
              //First time the loop prints out 4 static values as defined in the for-loop
              //second time the loop goes arond on the $element_count variable it prints out the count as defined 
              //earlier in the page when we dynamically pulled out the counts from the DB
      
              //  ['Posts', 1000,],
      
          ]);
      
          var options = {
          chart: {
              title: '',
              subtitle: '',
          }
          };
      
          var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
      
          chart.draw(data, google.charts.Bar.convertOptions(options));
      }
   </script>
   <div class="table-responsive">
      <table class="table">
         <div id="columnchart_material" style="width: 'auto'; height: 500px; margin:90px;"></div>
      </table>
   </div>
</div>
<!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>
<link rel="stylesheet"
   href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://js.pusher.com/4.3/pusher.min.js"></script>
<!-- /* PUSHER Script for admin */ -->
<script>
   //JQUERY
   // $(document).ready(function(){
   
       Pusher.logToConsole = true;
       
    var pusher = new Pusher('c21f4553edf47bad1778', {
         cluster: 'eu',
         forceTLS: true
       });
     
     
      var channel = pusher.subscribe('notification');
   
       channel.bind('subscriber', function(data) {
   
         toastr.success(JSON.stringify(data.message + " Has Registered!"));
         
       });
   
     
</script>
<!-- }); -->
<script>
//  var notificationChannel =  pusher.subscribe('notifications');
// notificationChannel.bind('new_user', function(notification){
//     var message = notification.message;
//     // alert(JSON.stringify(notification));
//     //This causes a ALERT box to appear.... not required...
//     console.log(message);
//     toastr.success(`${message} just registered`);
//     // toastr.success('Have fun storming the castle!', 'Miracle Max Says')
<script>