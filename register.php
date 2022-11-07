<?php
if(!file_exists("app/mysql.php")){
    header("Location: setup/index.php");
    exit;
}
session_start();
require "app/data.php";
include "app/inc/header.php";
require "app/languages/lang_en.php";
// include "app/inc/navbar.php";
require "app/config.php";

if(isset($_SESSION["userid"])){
    header("Location: index.php");
    exit;
}

if(isset($_GET['action'])) {
    $error = false;
    $email = $_POST['email'];
    $username = $_POST['username'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='error'><img src='assets/icons/error.png' style='width:32px;height:32px;'><p>" . ERROR_EMAIL_INVALID . "</p></div>";
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
        createUser($username, $email, sha1($id));
        $activate = HOST . "password/set.php?userid=" . getId($email) . "&code=" . $id;
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

            $body = str_replace(["superAdventageUrl", "%HOST%"], [$activate, HOST], file_get_contents("app/email/html/activate_account.html"));

            mail($receiver, $subject, $body, $header);

            ?><meta http-equiv="refresh" content="3; URL=login.php"><?php
        } else {
            $message .= "<br>" . str_replace("important", $activate, REGISTER_NO_MAIL);
        }
    }
}
?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form class="login100-form validate-form" action="?action=1" method="post">
					<span class="login100-form-title p-b-49">
						Register
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

                    <div class="wrap-input100 validate-input" data-validate="Username is required">
                        <span class="label-input100">Username</span>
                        <input class="input100" type="text" name="username" maxlength="64" placeholder="<?php echo PLACEHOLDER_USERNAME; ?>">
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

                    <div class="flex-col-c p-t-155">
						<span class="txt1 p-b-17">
							Already account?
						</span>

                        <a href="login.php">
                            Login
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
include "app/inc/footer.php";
?>