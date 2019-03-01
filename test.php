<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php session_start() ?>

<?php

echo loggedInUserId();



if(userLikedThisPost()){
  
    echo "user liked it";

} else {

    echo "not liked";
}


?>