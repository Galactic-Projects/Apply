<?php
if(!file_exists("app/mysql.php")){
    header("Location: setup/index.php");
    exit;
}
session_start();
require "app/data.php";
include "app/inc/header.php";
include "app/inc/navbar.php";

if(!isset($_SESSION['userid'])){
    header("Location: login.php");
    exit;
}
$id = $_SESSION['userid'];
$email = getEmailById($id);

echo "Welcome in control panel!<a href='logout.php'>Logout!</a><img src=". getProfilePicture($email).">";


include "app/inc/footer.php";
?>