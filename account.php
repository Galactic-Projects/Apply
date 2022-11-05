<?php
if(!file_exists("app/mysql.php")){
    header("Location: setup/index.php");
    exit;
}
session_start();
require "app/data.php";
include "app/inc/header.php";

if(!isset($_SESSION['userid'])){
    header("Location: login.php");
    exit;
}
$id = $_SESSION['userid'];
$email = getEmailById($id);
$language = 'en';
if(getLanguage($email) != null) {
    $language = getLanguage($email);
}
include "app/languages/lang_" . $language . ".php";
include "app/inc/navbar.php";
if(getRank($email) > 1) {
    ?><a href="/admin/panel.php">ADMINISTRATOR PANEL</a><?php
}

if (isset($_POST['upload'])) {
    $path = '/assets/images/profiles/';
    $file = getUsername($email);
    $file_temp = $_FILES["file"]["tmp_name"];
    $file_size = $_FILES["file"]["size"];
    $newPath = null;

    if ($file_size >= (100 * 1024 * 1024)) {
        $message = "<div class='error'><img src='/assets/icons/error.png' style='width:32px;height:32px;'><p>" . ACCOUNT_PROFILE_IMAGE_ERROR_SIZE . "</p></div>";
    } else {
        $newPath = $path . $file;
        move_uploaded_file($file_temp, $newPath);
        $message = "<div class='success'><img src='/assets/icons/success.png' style='width:32px;height:32px;'></div>";
        updateProfilePicture($email, $newPath);
        header("Location: account.php");
    }
}
if(isset($_GET["logout"])) {
    $message = "<div class='success'><img src='/assets/icons/success.png' style='width:32px;height:32px;'><p>" . LOGOUT_SUCCESS . "</p></div>";
    ?><meta http-equiv="refresh" content="3; URL=index.php"><?php
    session_destroy();
}
?>
    <form action="?logout=1" method="post">
        <button type="submit"  href="logout.php"><?php echo ACCOUNT_PROFILE_LOGOUT; ?></button>
    </form>
    <img src="<?php echo getProfilePicture($email) ?>">

    <?php
        if(isset($message)) {
            echo $message;
        } ?>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file" id="upload" required>
        <label for="upload">
            <img src="/assets/icons/upload.png">
            <p>
                <strong>Drag and drop</strong> files here<br>
                or <span>browse</span> to begin the upload
            </p>
        </label>
        <button type="submit" name="upload" class="btn"><?php echo ACCOUNT_PROFILE_IMAGE_BUTTON; ?></button>
    </form>
<?php

include "app/inc/footer.php";
?>