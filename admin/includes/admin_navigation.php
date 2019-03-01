<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
   <!-- Brand and toggle get grouped for better mobile display -->
   <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Ant's CMS Admin</a>
   </div>
   <!-- Top Menu Items -->
   <ul class="nav navbar-right top-nav">
      <!-- OLD CODE WITHOUT AJAX<li><a href =""><strong>Users Online: <?php echo users_online(); ?></strong></a></li> -->
      <li><a href =""><strong>Users Online: <span class="usersonline"> </span></strong></a></li>
      <li><a href ="../index.php"><strong>Homepage</strong></a></li>
      <?php  
         $query = "SELECT * FROM users WHERE '{$_SESSION ['username']}' = username ";
         $select_user_image_query = mysqli_query($connection, $query);
         $row = mysqli_fetch_assoc($select_user_image_query);
         $user_image = $row['user_image'];
                   
                    ?>
      <li class="dropdown">
         <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <!-- <i class="fa fa-user"></i>  -->
            <?php echo "<img width='30' img height='30' align='center' class='img-responsive img-circle' src='../images/$user_image' alt='user_image'" ?>  
            <?php echo $_SESSION ['user_firstname']?>  
            <?php echo $_SESSION ['user_lastname'] ?> 
            <b class="caret"></b>
         </a>
         <ul class="dropdown-menu">
            <li>
               <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
            </li>
            <li class="divider"></li>
            <li>
               <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
            </li>
         </ul>
      </li>
   </ul>
   <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
   <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav side-nav">
      <li>
         <a href="../admin/index.php"><i class="fa fa-fw fa-dashboard"></i>Dashboard</a>
      </li>
      <li>
         <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown">
         <i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
         <ul id="posts_dropdown" class="collapse">
            <li><a href='posts.php'>View All Posts</a></li>
            <li><a href='posts.php?source=add_post'>Add Post</a></li>
         </ul>
      </li>
      <li>
         <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
      </li>
      <li class="">
         <a href="./comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
      </li>
      <li>
         <?php // call admin function to show users nav or not
            if (is_admin( $_SESSION ['username']) || !is_admin( $_SESSION ['username'])){ //waste of code but easy fix to display for all users
                echo " <a href='javascript:;' data-toggle='collapse' data-target='#demo'><i class='fa fa-fw fa-arrows-v'></i> Users <i class='fa fa-fw fa-caret-down'></i></a>
                    <ul id='demo' class='collapse'>
                <li>
                    <a href='users.php'>View All Users</a>
                </li>
                <li>";
            
                if (is_admin( $_SESSION ['username'])){ //only show if admin
                  echo"  <a href='users.php?source=add_user'>Add New Users</a>
                </li>
                </ul>
                </li>
                <li>
                <a href='profile.php'><i class='fa fa-fw fa-dashboard'></i> Profile</a>
                </li>
                </ul>";
                }
            }
            ?>
   </div>
   <!-- /.navbar-collapse -->
</nav>
<!--
   <ol class="breadcrumb">
       <li>
           <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
       </li>
       <li class="active">
           <i class="fa fa-file"></i> Blank Page
       </li>
   </ol>
   -->