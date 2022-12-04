<?php
session_start();
require "../app/data.php";
include "../app/inc/header.html";

$user = $_GET['userid'];
$code = $_GET['code'];
$email = getEmailById($user);
require "../app/languages/lang_en.php";

if(!isset($_GET['userid']) || !isset($_GET['code'])) {
    die("<div class='background'><div class='error'><p>".CODE_ERROR_ENABLEID. "</p></div></div>");
}

if(isEnabled($email)) {
    die("<div class='background'><div class='error'><p>".CODE_ERROR_ENABLED_ALREADY. "</p></div></div>");
}

if(sha1($code) != getPassword($email)) {
    die("<div class='background'><div class='error'><p>".CODE_ERROR_INVALID. "</p></div></div>");
}

if(isset($_GET['action'])){
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = getEmailById($user);

    if($password != $password2) {
        $message = "<div class='error'><img src='/assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_PASSWORD_MATCH . "</p></div>";
    }

    if(strlen($password2) == 0 || strlen($password) ==  0) {
        $message = "<div class='error'><img src='/assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_PASSWORD_ENTER . "</p></div>";
    }

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    setPassword($email, $hashed);
    enableAccount($email);

    if(getPassword($email) != sha1($code)) {
        if(file_exists("../app/mail.php")){
            require "../app/mail.php";
            require "../app/config.php";
            $receiver = $email;
            $subject = "Account enabled - Apply Page";
            $from = getFromName() . " <" . getFromMail() . ">";
            $replyTo = getReplyName() . " <" . getReplyMail() . ">";
            $header  = "MIME-Version: 1.0\r\n";
            $header .= "From: $from\r\n";
            $header .= "Reply-To: $replyTo\r\n";
            $header .= "Content-type: text/html; charset=utf-8\r\n";
            $header .= "X-Mailer: PHP ". phpversion();

            $body = str_replace("%HOST%", HOST, file_get_contents("../app/email/html/account_enabled.html"));
            mail($receiver, $subject, $body, $header);
        }

        $message = "<div class='success'><img src='/assets/icons/success.png' style='width:32px;height:32px;'><p>" . CODE_SUCCESS_ENABLED . "</p></div>";
        ?>
<meta http-equiv="refresh" content="3; URL=/login.php">><?php
    }
}
include "../app/inc/navbar.html";

?>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
            <form class="login100-form validate-form"
                action="?action=1&amp;userid=<?php echo htmlentities($user); ?>&amp;code=<?php echo htmlentities($code); ?>"
                method="post">
                <span class="login100-form-title p-b-49">
                    Activate Account
                </span>

                <div class="txt1 text-center p-t-54 p-b-20">
                    <span>
                        <?php
                            if(isset($message)) {
                                echo $message;
                            }
                            ?>
                    </span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <span class="label-input100">Password</span>
                    <input class="input100" type="password" name="password" maxlength="64"
                        placeholder="<?php echo PLACEHOLDER_PASSWORD; ?>">
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <span class="label-input100">Password</span>
                    <input class="input100" type="password" name="password2"
                        placeholder="<?php echo PLACEHOLDER_REPEAT_PASSWORD; ?>">
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                </div>

                <div class="text-right p-t-8 p-b-31">
                </div>


                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button type="submit" class="login100-form-btn">
                            <?php echo BUTTON_SEND; ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include "../app/inc/footer.html";
?>