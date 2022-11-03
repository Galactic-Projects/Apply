<?php
if(!file_exists("app/mysql.php")){
    header("Location: setup/index.php");
    exit;
}
session_start();
require "app/data.php";
include "app/inc/header.php";
require "app/languages/lang_en.php";
include "app/inc/navbar.php";

if(isset($_SESSION["userid"])){
    header("Location: index.php");
    exit;
}

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
        require "app/security/generate.php";
        $id = generateRandom();
        createUser($username, $email, $id);
        $activate = "https://test.galacticprojects.net/password/set.php?userid=" . getId($email) . "&code=" . $id;
        if (existsUsername($username)) {
            $message = "<div class='success'><img src='assets/icons/success.png' style='width:32px;height:32px;'><p>" . REGISTER_SUCCESS . "</p></div>";
        } else {
            $message = "<div class='error'><img src='assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_SAVE . "</p></div>";
            ?><meta http-equiv="refresh" content="3; URL=register.php"><?php
        }

        if(file_exists("app/mail.php")){
            require "app/mail.php";
            $receiver = $email;
            $subject = "Register - Apply Page";
            $from = getFromName() . " <" . getFromMail() . ">";
            $replyTo = getReplyName() . " <" . getReplyMail() . ">";
            $header  = "MIME-Version: 1.0\r\n";
            $header .= "From: $from\r\n";
            $header .= "Reply-To: $replyTo\r\n";
            $header .= "Content-type: text/html; charset=utf-8\r\n";
            $header .= "X-Mailer: PHP ". phpversion();

            mail($receiver, $subject, str_replace("superAdventageUrl", $activate, file_get_contents("app/email/html/activate_account.html")), $header);

            ?><meta http-equiv="refresh" content="3; URL=login.php"><?php
        } else {
            $message .= "<br>" . str_replace("important", $activate, REGISTER_NO_MAIL);
        }
    }
}

if(isset($message)) {
    echo $message;
}

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
include "app/inc/footer.php";

?>