<?php

global $db;
global $productid;

// Your database login: host, user, password, database
$db = mysqli_connect("127.0.0.1", "root", "", "smart_recruiter");

if (mysqli_connect_errno($db)) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// checks if user is logged in for admin panel
function isLoggedin ($db)
{
    if (isset($_SESSION['login'])) {
    
        //$query = mysqli_query($db, "SELECT id, email FROM user WHERE id='".mysqli_real_escape_string($db, $_SESSION['login_userId'])."'") or die(mysql_error());
        $query = mysqli_query($db, "SELECT id, email FROM user WHERE id='".$_SESSION['login_userId']."'") or die(mysql_error());
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        
        if ($_SESSION['login_hash'] == hash('sha512', $row['email'] . $row['id'])) {
            return true;
        } else {
            session_destroy();
            header("location: login.php");
        }
    } else {
      session_destroy();
      header("location: login.php");
    }
}

?>