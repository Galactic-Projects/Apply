<?php
session_start();
require "../app/data.php";
include "../app/inc/header.php";

$user = $_GET['userid'];
$code = $_GET['code'];
$email = getEmailById($user);
$language = 'en';
if(isset($email)) {
    $language = getLanguage($email);
}
require "../app/languages/lang_".$language.".php";

if(!isset($_GET['userid']) || !isset($_GET['code'])) {
    die(CODE_ERROR_ENABLEID);
}

if(isEnabled($email)) {
    die(CODE_ERROR_ENABLED_ALREADY);
}

if($code != getPassword($email)) {
    die(CODE_ERROR_INVALID);
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

    if(getPassword($email) != $code) {
        $message = "<div class='success'><img src='/assets/icons/success.png' style='width:32px;height:32px;'><p>" . CODE_SUCCESS_ENABLED . "</p></div>";
        ?><meta http-equiv="refresh" content="3; URL=/login.php">><?php
    }
}
include "../app/inc/navbar.php";

if(isset($message)) {
    echo $message;
}
?>
<div class='set'>
     <form action='set.php?action=1&amp;userid=<?php echo htmlentities($user); ?>&amp;code=<?php echo htmlentities($code); ?>' method='post'>
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