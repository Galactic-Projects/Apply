<?php
if(!file_exists("app/mysql.php")){
    header("Location: setup/index.php");
    exit;
}
session_start();
require "app/data.php";
include "app/inc/header.php";
require "app/languages/lang_en.php";

if(isset($_SESSION["userid"])){
    header("Location: index.php");
    exit;
}

$showFormular = true;
if(isset($_GET['action'])) {
    $error = false;
    $email = $_POST['email'];
    $username = $_POST['username'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='error'><img src='assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_EMAIL_INVALID . "</p></div>";
        $error = true;
    }

    if(strlen($username) == 0) {
        $message = "<div class='error'><img src='assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_USERNAME_EMPTY . "</p></div>";
        $error = true;
    }

    if (existsEmail($email)) {
        $message = "<div class='error'><img src='assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_EMAIL_ALREADY . "</p></div>";
        $error = true;
    }

    if (existsUsername($username)) {
        $message = "<div class='error'><img src='assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_USERNAME_ALREADY . "</p></div>";
        $error = true;
    }

    if(!$error) {
        $id = generateRandomString(32);
        $activate = "https://test.galacticprojects.net/password/set.php?userid=" . getId($email) . "&code=" . $id;
        echo $activate;
        createUser($username, $email, $id);
        $message = "<div class='success'><img src='assets/icons/success.png' style='width:32px;height:32px;'><p>" . REGISTER_SUCCESS . "</p></div>";
        /*if (file_exists("app/mail.php")) {
            $mailBody = "app/email/html/activate_account.html";
            sendMail($email, $username, "no-reply@galacticprojects.net", "no-reply@galacticprojects.net", "Register - Apply Page", "Please get a email provider that supports html mails!", $mailBody);
        } else {
            $receiver = $email;
            $subject = "Register - Apply Page";
            $from = "From: no-reply <no-reply@galacticprojects.net>";
            $mailBody = str_replace("superAdventageUrl", $activate, file_get_contents("app/email/html/activate_account.html"));

            mail($receiver, $subject, $mailBody, $from);
        }*/

        $showFormular = false;
        header("Location: login.php");

        if (!existsUsername($username)) {
            $message = "<div class='error'><img src='assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_SAVE . "</p></div>";
        }
    }
}
include "app/inc/navbar.php";

if(isset($message)) {
    echo $message;
}
if($showFormular) {
?><div class="register">
        <form action="?action=1" method="post">
            <div class="cluster">
                <input type="email" placeholder="<?php echo PLACEHOLDER_EMAIL; ?>" size="40" maxlength="64" name="email">
            </div>

            <div class="cluster">
                <input type="text" placeholder="<?php echo PLACEHOLDER_USERNAME; ?>" size="40" maxlength="64" name="username">
            </div>
            <input type="submit" value="<?php echo BUTTON_SEND; ?>">
        </form>
    </div>
<?php
}
include "app/inc/footer.php";
?>