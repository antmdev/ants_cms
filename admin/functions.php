<?php
//////////////////////////////////////////////////////////////////////////////////////


////Function to redirect

function redirect($location){
    header("location:" . $location);
    exit;
}

////Function to if it is a method

function ifItIsMethod($method=null){
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
        return true;
    }
    return false;
}

////Function us user logged in
function isLoggedIn(){
    if(isset($_SESSION['user_role'])){
        return true;
    }
    return false;
}

////Function quick QUERY
function query($query){
    global $connection;
    return mysqli_query($connection, $query);
}


////check if user is logged in and redirect

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
    if(isLoggedIn()){
        redirect($redirectLocation);
    }
}

function testFunction(){
    return "TESTING";
}

function loggedInUserIdNew(){
    if(isLoggedIn()){
        $result = query("SELECT * FROM users WHERE username='" . $_SESSION['username'] ."'");
        confirmQuery($result);
        $user = mysqli_fetch_array($result);
        return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
    }
    return false;

}

////Function us user logged in

function loggedInUserId(){

    if(isLoggedIn()){
       
        $result = query("SELECT * FROM users WHERE username='" . $_SESSION['username'] ."'");
        $user  = mysqli_fetch_array($result);
        
        //LONG HAND if / else return result
        if(mysqli_num_rows($result) >=1){
            return $user['user_id'];
        }
    }
    return false;
}

////Function user has like post already

function userLikedThisPost($post_id){

    $result = query("SELECT * FROM likes WHERE user_id=" .loggedInUserId() . " AND post_id={$post_id}");
    // echo $result;
    // shorthand if statement
    confirmQuery($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}
//FUNCTION - get the post likes

function getPostlikes($post_id){

    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    confirmQuery($result);
    echo mysqli_num_rows($result);

}


//FUNCTION - to check logged in then redirect to INDEX

function WhatMethodThenLogIn(){
    if (ifItIsMethod('post')){
        if(isset($_POST['login']))
            if(isset($_POST['username']) && isset($_POST['password'])){
            login_user($_POST['username'], $_POST['password']);
        }else {
            redirect('index');
        }
    }
}

//CONFIMR QUERY EDWIN NO BETTER
// function confirmQuery($result) {  
//     global $connection;
//     if(!$result ) {
//           die("QUERY FAILED ." . mysqli_error($connection));          
//       }
// }
// //confirm connection to database global function ANT

function confirmQuery($result){
global $connection;
        if($result === 0){
           echo "";
        } else {
        if(!$result) {
        die("QUERY FAILED ." . mysqli_error($connection));
        }
    return $result;
    }
}

// insert into categories

function insertCategories() {
    
global $connection;
 
/* setting up some validations on hitting enter */
//getting post super global cat-title and assigning to a variable
                
if(isset($_POST['submit'])) {
$cat_title = $_POST['cat_title'];
 
//if there's an empty string we say it shouldnt be empty
    
    if($cat_title =="" || empty($cat_title)) {
        
        echo "This field should not be empty";
        
    } else {

// if it's not empty we want to send the data to the database.

        $stmt = mysqli_prepare($connection, "INSERT INTO categories (cat_title) VALUES (?) ");

        mysqli_stmt_bind_param($stmt, 's', $cat_title );

        mysqli_stmt_execute($stmt);
        
        if(!$stmt) {
//if it's not succesful connection it will kill the svript
            
            die('QUERY FAILED' . mysqli_error($connection));
        }
    }
}
}

//////////////////////////////////////////////////////////////////////////////////////
function findAllCategories() {
global $connection;    

    $query = "SELECT * FROM categories ";
    $select_categories = mysqli_query($connection, $query);
                        
/* After connecting to the database above - we're now creating a new search to $select_categories. We then echo the data into the table. By repeating the <tr> we stack them vertically in the table to keep them neat.

*/
while ($row = mysqli_fetch_assoc($select_categories)) {
$cat_id =  $row['cat_id'];
$cat_title=  $row['cat_title'];

echo "<tr>";
echo "<td>{$cat_id}</td>"; 
echo "<td>{$cat_title}</td>";
/* DELETE Option - create a link for each item 
question mark ? makes a key in the array the GET super global
it's an associative array and delete is the value */

?>
<form method="post">
<input type="hidden" name="cat_id" value="<?php echo $cat_id ?>" > 
<?php echo '<td><input class="btn btn-danger" type="submit" name="delete" value="Delete"></td>'; ?>
</form>
<?php
// echo "<td><a class='btn btn-danger' href='categories.php?delete={$cat_id}'>Delete</a></td>";
echo "<td><a class='btn btn-info'href='categories.php?edit={$cat_id}'>Edit</a></td>";
echo "</tr>";
}
    
}
    
////////////////////////////////////////////////////////////////////////////////////// 

function deleteCategories() {
global $connection;  
 
// if we see a GET request in GET - check for the delete key set above. 
//if we find it assign it to a new variable $the_cat_id
//it is the same ID but we're just assigning it a different variable name
                        
                           
                        
    if (is_admin( $_SESSION ['username'])){ //stops users deleting when not admin

        if(isset($_POST['delete'])) {
        
        $the_cat_id = escape($_POST['cat_id']); 
        
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
        
        $delete_query = mysqli_query($connection, $query);

// We need to add the below so that when it sends the request it automatcially refreshes the page so it looks like the request is made instantly (otherwise you have to click twice)
//this code means it does another request for the page we're on (i.e refresh)        
        header("location:categories.php");
         
        }
    }
        
}

//////////////////////////////////////////////////////////////////////////////////////
function updateCategories() {
global $connection;  
    
    
 if(isset($_GET['edit']))  {
      $cat_id = $_GET['edit'];
      include "includes/update_categories.php";
}
}


/////////////////////////////////////////////////////////////////////////////////////
function escape($string) {

global $connection;

return mysqli_real_escape_string($connection, trim($string));


}

/////////////////////////////////////////////////////////////////////////////////////
//replacement image

function imagePlaceholder($image=''){

    if(!$image) {

        return "https://via.placeholder.com/600x200";
        // return "images/lawn care image.jpg";


    } else {

        return "/cms/images/" . $image;
    }
}





/////////////////////////////////////////////////////////////////////////////////////


function currentUser(){

        if(isset($_SESSION['username'])){

            return $_SESSION['username'];
        }

        return false;

}

/////////////////////////////////////////////////////////////////////////////////////

function users_online() {
    if(isset($_GET['onlineusers'])) { //from AJAX in scripts.js
global $connection; //only available where "include db.php & functions.php" are included otherwise its not available

if(!$connection){

    session_start();

    include("../includes/db.php");
}
//this will hold id of sessions and will change (create a new session) per browser your using i.e different users
//if you can understand the lgic, its just determining whether a user has been online more or less than 30 seconds
//Then we're inserting that if they're new, and if not new then updating the session
//$users_online_query - basically says if they're not active for 30 seconds then they're offline
$session = session_id(); 
$time = time(); //holds the time 
$time_out_in_seconds = 05; //60 seconds how long we want user to be "marked as offline"
$time_out = $time - $time_out_in_seconds; // give a timeout variable

$query = "SELECT * FROM users_online WHERE session = '$session'";
$send_query = mysqli_query($connection, $query);

//if mysqli_num_rows = none -  that means no rows have been returend from database that contain session ID and therefore a new user has logged in. so we insert a time and session into the table to set for the users
$count = mysqli_num_rows($send_query);

if($count == NULL){ // this means a new user has logged in.
    mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");

} else { //i.e if you already have a user logged in and is not new
    mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
}
$users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
echo $count_user = mysqli_num_rows($users_online_query); //change from return to echo because there's no PHP to catch it
  
} //GET request isset()
} //Function close
users_online()

/////////////////////////////////////////////////////////////////////////////////////
//Function to replace post / comment / view count etc. in admin

?>
<?php
function recordCount($table){
            global $connection; 
            $query = "SELECT * FROM " . $table;
            $select_all_posts = mysqli_query($connection, $query); 

            $result = mysqli_num_rows($select_all_posts);

            confirmQuery ($result);
            return $result;

            // //shorter version
            // $query = "SELECT * FROM " . $table;
            // $select_all_posts = mysqli_query($connection, $query); 
            // return mysqli_num_rows($select_all_posts);

}

/////////////////////////////////////////////////////////////////////////////////////
//Function to replace post / comment / view count etc. in admin


//needs table, status, column inputs

function checkStatus($table, $column, $status){
    global $connection; 
    $query = "SELECT * FROM $table WHERE $column = '$status' ";
    $result = mysqli_query($connection, $query); 
    confirmQuery ($result);
    return mysqli_num_rows($result);

}

function checkUserRole($table, $column, $role){
    global $connection; 
    $query = "SELECT * FROM $table WHERE $column = '$role' ";
    $result = mysqli_query($connection, $query); 
    confirmQuery ($result);
    return mysqli_num_rows($result);

}

// /////////////////////////////////////////////////////////////////////////////////////
// //Function to approve / deny comments

// // if(isset($_GET['approve'])) {

// //     $the_comment_id = escape($_GET['approve']);
// //     $query = "UPDATE `comments` SET `comment_status` = 'approved' WHERE `comments`.`comment_id` = {$the_comment_id}";
// //    // $query = "UPDATE comments SET comment_status = 'approve' WHERE comment_id = {$the_comment_id}";
// //     $approve_comment_query = mysqli_query($connection, $query); 
// //     header("location:comments.php");
// // }


function commentApproval() {
    global $connection;  
     
        if(isset($_GET['approve'])) {
        $the_comment_id = escape($_GET['approve']);
        $query = "UPDATE `comments` SET `comment_status` = 'approved' WHERE `comments`.`comment_id` = {$the_comment_id}";
        $result = mysqli_query($connection, $query); 
        confirmQuery ($result);
        return $result;
}
}           


function commentUnapprove() {
    global $connection;  
     
        if(isset($_GET['unapprove'])) {
        $the_comment_id = escape($_GET['unapprove']);
        $query = "UPDATE `comments` SET `comment_status` = 'unapproved' WHERE `comments`.`comment_id` = {$the_comment_id}";
        $result = mysqli_query($connection, $query); 
        confirmQuery ($result);
        return $result;
}
}          

// /////////////////////////////////////////////////////////////////////////////////////
//Function to Delete

function deleteComment() {
    global $connection; 
    

        if(isset($_GET['delete'])) {
        $the_comment_id = escape($_GET['delete']);
        $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
        $result = mysqli_query($connection, $query); 
        confirmQuery ($result);
        return $result;
        }
    }


// /////////////////////////////////////////////////////////////////////////////////////
// //Function to check user status

function is_admin($username) {

    global $connection; 

    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    $row = mysqli_fetch_array($result);


    if($row['user_role'] == 'admin'){

        return true;

    }else {


        return false;
    }

}

// /////////////////////////////////////////////////////////////////////////////////////
// //Function to check there's not the same username twice

    function username_exists($username){

    global $connection;

    $query = "SELECT username FROM users WHERE username = '$username' ";
    $result = mysqli_query($connection, $query); 
    confirmQuery ($result);

    if(mysqli_num_rows($result) > 0) {
        return true;

    } else {
        return false;
    }


}

// /////////////////////////////////////////////////////////////////////////////////////
// //Function to check there's not the same email twice

function useremail_exists($email){

    global $connection;

    $query = "SELECT user_email FROM users WHERE user_email = '$email' ";
    $result = mysqli_query($connection, $query); 
    confirmQuery ($result);

    if(mysqli_num_rows($result) > 0) {
        return true;

    } else {
        return false;
    }


}

///////////////////////////////////////////////////////////////////////////////////////
////Function to register user

function register_user($username, $email, $password){

    global $connection;


        //clean data before sending to mySQL
        $username    = mysqli_real_escape_string($connection, $username);
        $email       = mysqli_real_escape_string($connection, $email);
        $password    = mysqli_real_escape_string($connection, $password);

        $password = password_hash( $password, PASSWORD_BCRYPT, array('cost' => 12) );

        $query = "INSERT INTO users (username, user_email, user_password, user_role) ";
        $query .= "VALUES ('{$username}','{$email}','{$password}', 'subscriber' )";
        $register_user_query = mysqli_query($connection,$query);

        confirmQuery($register_user_query);

}

///////////////////////////////////////////////////////////////////////////////////////
////Function to login user

function login_user($username, $password){

    global $connection;

    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);

    if (!$select_user_query) {

        die("QUERY FAILED" . mysqli_error($connection));

    }

    while ($row = mysqli_fetch_array($select_user_query)) {

        $db_id = $row ['user_id'];
        $db_username = $row ['username'];
        $db_user_password = $row ['user_password'];
        $db_user_firstname = $row ['user_firstname'];
        $db_user_lastname = $row ['user_lastname'];
        $db_user_role = $row ['user_role'];
        

            //use new function called password verify

    if (password_verify($password, $db_user_password)) {

        if (session_status() === PHP_SESSION_NONE) session_start();
    
            $_SESSION['username'] = $db_username;
            $_SESSION['user_firstname'] = $db_user_firstname;
            $_SESSION['user_lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
    
            redirect("/cms/admin/");

        } else {
            
            return false;
        }
    }

    return true;


}

////Function get a profile picture when logged in DOESNT WORK WHERE I NEED IT TO

// function isLoggedInGetProPic(){

//     global $connection;

//     $query = "SELECT * FROM users WHERE '{$_SESSION ['username']}' = username ";
//     $select_user_image_query = mysqli_query($connection, $query);
//     $row = mysqli_fetch_assoc($select_user_image_query);
//     $user_image = $row['user_image'];

//     confirmQuery($query);
// }  

?>










