<?php include "db.php"; ?>
<!--//starting a sesssion-->
<?php session_start(); ?>

<!--//receive username and password from login form-->
<?php   if(isset($_POST['login'])) {

    echo $_SESSION['username'];
    

    $username = $_POST['username'];
    $password = $_POST['password'];

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
    }

    //use new function called password verify

    if (password_verify($password, $db_user_password)) {

        $_SESSION['username'] = $db_username;
        $_SESSION['user_firstname'] = $db_user_firstname;
        $_SESSION['user_lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;

        header("Location: ../admin");
    } else {
        header("Location: ../index.php");
    }

}
?>
 