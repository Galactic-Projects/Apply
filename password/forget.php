<?php
if(!file_exists("../app/mysql.php")){
    header("Location: ../setup/index.php");
    exit;
}
session_start();
if(isset($_SESSION['userid'])){
    header("Location: ../account.php");
    exit;
}

require "../app/data.php";
include "../app/inc/header.php";
require "../app/languages/lang_en.php";
// include "../app/inc/navbar.php";
require "../app/config.php";

if(isset($_GET['action'])) {
    $email = $_POST['email'];
    $message = null;

    if(!isset($email) || empty($email)) {
        $message = "<div class='error'><img src='/assets/icons/error.png' style='width:32px;height:32px;'><p>" . ERROR_EMAIL_INVALID . "</p></div>";
    }

    if(!existsEmail($email)){
        $message = "<div class='error'><img src='/assets/icons/error.png' style='width:32px;height:32px;'><p>" . FORGET_ERROR_USER_EXISTS . "</p></div>";
    }

    require "../app/security/generate.php";
    $id = generateRandom();
    setPasswordReset($email, sha1($id));
    $link = HOST . "password/reset.php?userid=".getID($email)."&code=".$id;

    $message =  "<div class='success'><img src='/assets/icons/success.png' style='width:32px;height:32px;'><p>" . FORGET_SUCCESS_RESET_EMAIL . "</p></div>";
    if(file_exists("../app/mail.php")){
        require "../app/mail.php";
        $receiver = $email;
        $subject = "Reset Password - Apply Page";
        $from = getFromName() . " <" . getFromMail() . ">";
        $replyTo = getReplyName() . " <" . getReplyMail() . ">";
        $header  = "MIME-Version: 1.0\r\n";
        $header .= "From: $from\r\n";
        $header .= "Reply-To: $replyTo\r\n";
        $header .= "Content-type: text/html; charset=utf-8\r\n";
        $header .= "X-Mailer: PHP ". phpversion();

        $body = str_replace(["superAdventageUrl", "%HOST%"], [$link, HOST], file_get_contents("../app/email/html/reset_password.html"));

        mail($receiver, $subject, $body, $header);

        ?><meta http-equiv="refresh" content="3; URL=/login.php"><?php
    } else {
        $message .= "<br>" . str_replace("important", $link, FORGET_NO_MAIL);
    }
}?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form class="login100-form validate-form" action="?action=1" method="post">
					<span class="login100-form-title p-b-49">
						Forget password
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

                    <div class="wrap-input100 validate-input m-b-23" data-validate = "Email is required">
                        <span class="label-input100">Email</span>
                        <input class="input100" type="text" name="email" maxlength="64" placeholder="<?php echo PLACEHOLDER_EMAIL; ?>">
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
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
include "../app/inc/footer.php";

