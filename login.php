<?php
if(!file_exists("app/mysql.php")){
    header("Location: setup/index.php");
    exit;
}
session_start();
require "app/mysql.php";
require "app/data.php";
require "app/languages/lang_en.php";
include "app/inc/header.php";

if(isset($_GET['action'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $language = 'en';
    $message = null;
    $user = getUserData($email);
    if ($user != null) {
        $language = $user["LANGUAGE"];
    }
    require "../app/languages/lang_".$language.".php";

    if ($user !== false && password_verify($password, $user['PASSWORD'])) {
        if($user["ENABLED"]) {
            $_SESSION['USERID'] = $user["ID"];
            $message = "<div class='success'><img href='assets/icons/success.png' style='width:32px;height:32px;'><p>" . LOGIN_SUCCESS . "</p></div>";
            updateLatestAccess($email);
        } else {
            $message = "<div class='error'><img href='assets/icons/error.png' style='width:32px;height:32px;'><p>" . LOGIN_NOT_VERIFIED . "</p></div>";
        }
    } else {
        $message = "<div class='error'><img href='assets/icons/error.png' style='width:32px;height:32px;'><p>" . LOGIN_ERROR . "</p></div>";
    }

}
include "app/inc/navbar.php";
echo "<div class='login'>
    <form action='login.php?action=1' method='post'>
        <div class='cluster'>
            <input type='email' placeholder='" . PLACEHOLDER_EMAIL . "' size='40' maxlength='64' name='email'>
        </div>
        <div class='cluster'>
            <input type='password' size='40' placeholder='". PLACEHOLDER_PASSWORD ."' maxlength='128' name='password'>
        </div>
     <input type='submit' value='" . BUTTON_SEND ."'>
    </form>
    Create an account: <a href='register.php'>Register now!</a>
</div>";
if(isset($message)) {
    echo $message;
}
include "app/inc/footer.php";
?>