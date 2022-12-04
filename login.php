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
include "app/inc/header.html";
require "app/languages/lang_en.php";
include "app/inc/navbar.html";

if(isset($_GET['action'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $message = null;

    if (existsEmail($email) && password_verify($password, getPassword($email))) {
        if(isEnabled($email)) {
            $_SESSION['userid'] = getID($email);
            $message = "<div class='success'><img src='/assets/icons/success.png' style='width:32px;height:32px;'><p>" . LOGIN_SUCCESS . "</p></div>";
            ?>
<meta http-equiv="refresh" content="3; URL=account.php"><?php
        } else {
            $message = "<div class='error'><img src='/assets/icons/error.png' style='width:32px;height:32px;'><p>" . LOGIN_NOT_VERIFIED . "</p></div>";
        }
    } else {
        $message = "<div class='error'><img src='/assets/icons/error.png' style='width:32px;height:32px;'><p>" . LOGIN_ERROR . "</p></div>";
    }

}

?>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
            <form class="login100-form validate-form" action="?action=1" method="post">
                <span class="login100-form-title p-b-49">
                    Login
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

                <div class="wrap-input100 validate-input m-b-23" data-validate="Email is required">
                    <span class="label-input100">Email</span>
                    <input class="input100" type="text" name="email" placeholder="<?php echo PLACEHOLDER_EMAIL; ?>">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <span class="label-input100">Password</span>
                    <input class="input100" type="password" name="password"
                        placeholder="<?php echo PLACEHOLDER_PASSWORD; ?>">
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
                </div>

                <div class="text-right p-t-8 p-b-31">
                    <a href="password/forget.php">
                        Forgot password?
                    </a>
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
                        Not a member?
                    </span>

                    <a href="register.php">
                        Create Account
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include "app/inc/footer.html";
?>