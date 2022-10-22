<?php
session_start();
require "../app/mysql.php";
require "../app/data.php";
require "../app/languages/lang_en.php";
include "../app/inc/header.php";

if(!isset($_GET['userid']) || !isset($_GET['enableid'])) {
    die(CODE_ERROR_ENABLEID);
    header("/");
    exit();
}

$user = getUserDataById($_GET['userid']);
$code = $_GET['enableid'];

if($user['ENABLE_ID'] || trtotime($user['ENABLE_TIME']) < (time()-30*60)) {
    die(CODE_ERROR_TIME);
    deleteAccount($user['EMAIL']);
    header("/");
    exit();
}

if(sha1($code) != $user['ENABLE_ID']) {
    die(CODE_ERROR_INVALID);
    header("/");
    exit();
}

if(isset($_GET['action'])){
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = $user['EMAIL'];

    if($password != $password2) {
        $message = "<div class='error'><img href='/assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_PASSWORD_MATCH . "</p></div>";
    }

    if(strlen($password2) == 0 || strlen($password) ==  0) {
        $message = "<div class='error'><img href='/assets/icons/error.png' style='width:32px;height:32px;'><p>" . REGISTER_ERROR_PASSWORD_ENTER . "</p></div>";
    }

    updatePassword($email, password_hash($password, PASSWORD_DEFAULT));
    enableAccount($email);
    resetRequestId($email);
    if($user['PASSWORD'] != null){
        $message = "<div class='success'><img href='/assets/icons/success.png' style='width:32px;height:32px;'><p>" . CODE_SUCCESS_ENABLED . "</p></div>";
    }
}
include "../app/inc/navbar.php";

?>
<div class='set'>
     <form action='set.php?action=1&amp;userid=<?php echo htmlentities($user['ID']); ?>&amp;code=<?php echo htmlentities($user['ENABLE_ID']); ?>' method='post'>
        <div class='cluster'>
            <input type='password' placeholder='<?php PLACEHOLDER_PASSWORD ?>' size='40' maxlength='128' name='password'>
        </div>
        <div class='cluster'>
            <input type='password' size='40' placeholder='<?php PLACEHOLDER_REPEAT_PASSWORD ?>' maxlength='128' name='password2'>
        </div>
     <input type='submit' value='<?php BUTTON_SEND ?>'>
    </form>
</div>
<?php echo $message;

include "../app/inc/footer.php";
?>