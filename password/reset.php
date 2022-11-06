<?php
session_start();
require "../app/data.php";
include "../app/inc/header.php";

$user = $_GET['userid'];
$code = $_GET['code'];
$email = getEmailById($user);
$language = 'en';
require "../app/languages/lang_en.php";

if(!isset($_GET['userid']) || !isset($_GET['code'])) {
    die(RESET_ERROR_ID);
}

if(sha1($code) != getPasswordToken($email)) {
    die(RESET_ERROR_INVALID);
}

if(getPasswordTokenTime($email) === null || strtotime(getPasswordTokenTime($email)) < (time()-24*3600) ) {
    die(RESET_ERROR_EXPIRED);
}


if(isset($_GET['action'])){
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = getEmailById($user);
    $oldPassword = getPassword($email);

    if($password != $password2) {
        $message = "<div class='error'><img src='../assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_PASSWORD_MATCH . "</p></div>";
    }

    if(strlen($password2) == 0 || strlen($password) ==  0) {
        $message = "<div class='error'><img src='../assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_PASSWORD_ENTER . "</p></div>";
    }

    if(password_verify($password, $oldPassword)) {
        $message = "<div class='error'><img src='../assets/icons/error.png' style='width:32px;height:32px;'><p>" . RESET_ERROR_SAME . "</p></div>";
    } else {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        setPassword($email, $hashed);
        resetPasswordToken($email);

        if(getPassword($email) != $oldPassword) {
            if(file_exists("../app/mail.php")){
                require "../app/mail.php";
                require "../app/config.php";
                $receiver = $email;
                $subject = "Account password has changed - Apply Page";
                $from = getFromName() . " <" . getFromMail() . ">";
                $replyTo = getReplyName() . " <" . getReplyMail() . ">";
                $header  = "MIME-Version: 1.0\r\n";
                $header .= "From: $from\r\n";
                $header .= "Reply-To: $replyTo\r\n";
                $header .= "Content-type: text/html; charset=utf-8\r\n";
                $header .= "X-Mailer: PHP ". phpversion();

                $body = str_replace(["superAdventageUrl", "%HOST%"], ["mailto:".getReplyMail(), HOST], file_get_contents("../app/email/html/password_reset.html"));
                mail($receiver, $subject, $body, $header);
            }

            $message = "<div class='success'><img src='../assets/icons/success.png' style='width:32px;height:32px;'><p>" . RESET_SUCCESS_PASSWORD . "</p></div>";
            ?><meta http-equiv="refresh" content="3; URL=/login.php">><?php
        }
    }
}
include "../app/inc/navbar.php";

if(isset($message)) {
    echo $message;
}
?>
    <div class='set'>
        <form action='?action=1&amp;userid=<?php echo htmlentities($user); ?>&amp;code=<?php echo htmlentities($code); ?>' method='post'>
            <div class='cluster'>
                <input type='password' placeholder='<?php echo PLACEHOLDER_PASSWORD; ?>' size='40' maxlength='128' name='password'>
            </div>
            <div class='cluster'>
                <input type='password' size='40' placeholder='<?php echo PLACEHOLDER_REPEAT_PASSWORD; ?>' maxlength='128' name='password2'>
            </div>
            <input type='submit' value='<?php echo BUTTON_SEND; ?>'>
        </form>
    </div>
<?php
include "../app/inc/footer.php";
?>