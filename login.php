<?php
if(!file_exists("app/mysql.php")){
    header("Location: setup/index.php");
    exit;
}
session_start();

if(isset($_SESSION['userid'])){
    header("Location: account.php");
    exit;
}

require "app/data.php";
include "app/inc/header.php";
require "app/languages/lang_en.php";
include "app/inc/navbar.php";

if(isset($_GET['action'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $message = null;

    if (existsEmail($email) !== false && password_verify($password, getPassword($email))) {
        if(isEnabled($email)) {
            $_SESSION['userid'] = getID($email);
            $message = "<div class='success'><img src='assets/icons/success.png' style='width:32px;height:32px;'><p>" . LOGIN_SUCCESS . "</p></div>";
            ?><meta http-equiv="refresh" content="3; URL=account.php"><?php
        } else {
            $message = "<div class='error'><img src='assets/icons/error.png' style='width:32px;height:32px;'><p>" . LOGIN_NOT_VERIFIED . "</p></div>";
        }
    } else {
        $message = "<div class='error'><img src='assets/icons/error.png' style='width:32px;height:32px;'><p>" . LOGIN_ERROR . "</p></div>";
    }

}

if(isset($message)) {
    echo $message;
}

?> <div class="login">
    <form action="?action=1" method="post">
        <div class="cluster">
            <input type="email" placeholder="<?php echo PLACEHOLDER_EMAIL; ?>" size="40" maxlength="64" name="email">
        </div>
        <div class="cluster">
            <input type="password" size="40" placeholder="<?php echo PLACEHOLDER_PASSWORD; ?>" maxlength="128" name="password">
        </div>
     <input type="submit" value="<?php echo BUTTON_SEND; ?>">
    </form>
    Create an account: <a href="register.php">Register now!</a><br>
    Forgot password: <a href="reset.php">Reset here!</a>
</div> <?php
include "app/inc/footer.php";
?>