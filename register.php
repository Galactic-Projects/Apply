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
$showFormular = true;

if(isset($_GET['action'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $language = 'en';
    $error = false;
    $user = getUserData($email);
    if ($user != null) {
        $language = $user["LANGUAGE"];
    }
    require "app/languages/lang_" . $language . ".php";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='error'><img href='assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_EMAIL_INVALID . "</p></div>";
        $error = true;
    }

    if (getUserData($email) == null) {
        $message = "<div class='error'><img href='assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_EMAIL_ALREADY . "</p></div>";
        $error = true;
    }

    if (isNameExists($email, $username)) {
        $message = "<div class='error'><img href='assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_USERNAME_ALREADY . "</p></div>";
        $error = true;
    }

    if(!$error) {
        $age = date("Y-m-d");
        createUser($username, $email, null, $age);

        $message = "<div class='success'><img href='assets/icons/success.png' style='width:32px;height:32px;'><p>" . REGISTER_SUCCESS . "</p></div>";
        $mailBody = file_get_contents("app/email/html/activate_account.html");
        $id =  generateRandomString();
        updateRequestId($email, $id);
        $showFormular = false;
        $activate = "http://test.galacticprojects.net/password/set.php?userid=" . $user['ID'] . "&code=" . $id;
        mail($email, "Register - Apply Page", $mailBody . $username . $activate);

        if(!isNameExists($email, $username)) {
            $message = "<div class='error'><img href='assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_SAVE . "</p></div>";
        }
    }

}
include "app/inc/navbar.php";

echo $message;

if($showFormular) {
?><div class='register'>
        <form action='?action=1' method='post'>
            <div class='cluster'>
                <input type='email' placeholder='<?php echo PLACEHOLDER_EMAIL; ?>' size='40' maxlength='64' name='email'>
            </div>

            <div class='cluster'>
                <input type='text' placeholder='<?php echo PLACEHOLDER_USERNAME; ?>' size='40' maxlength='64' name='username'>
            </div>
            <input type='submit' value='<?php echo BUTTON_SEND; ?>'>
        </form>
    </div>
<?php
}
include "app/inc/footer.php";
?>