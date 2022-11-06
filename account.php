<?php
session_start();
if(!isset($_SESSION['userid'])){
    header("Location: login.php");
    exit;
}
include "app/inc/header.php";
include "app/data.php";
$id = $_SESSION['userid'];
$email = getEmailById($id);
function getEmail() :string {
    return $email = getEmailById($_SESSION['userid']);
}
$language = 'en';
if(getLanguage($email) != null) {
    $language = getLanguage($email);
}
include "app/languages/lang_" . $language . ".php";
function isAllowed(): bool {
    if(getRank(getEmail()) > 1) {
       return true;
    }
    return false;
}

if(isset($_GET['settings'])) {
    if (isset($_GET['upload'])) {
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
        }
    }
}
if(isset($_GET["profilepicture"])) {
    ?>
        <form action="?upload=1" method="post" enctype="multipart/form-data">
        <input type="file" name="file" id="upload" required>
        <label for="upload">
            <img src="/assets/icons/upload.png">
            <p>
                <strong>Drag and drop</strong> files here<br>
                or <span>browse</span> to begin the upload
            </p>
        </label>
        <button type="submit" name="upload" class="btn"><?php echo ACCOUNT_PROFILE_IMAGE_BUTTON; ?></button>
</form><?php
}
if(isset($_GET["logout"])) {
    $message = "<div class='success'><img src='/assets/icons/success.png' style='width:32px;height:32px;'><p>" . LOGOUT_SUCCESS . "</p></div>";
    ?><meta http-equiv="refresh" content="3; URL=index.php"><?php
    session_destroy();
}
$replace = file_get_contents("app/inc/account-nav.html");
$translated = null;
if(isAllowed()) {
    $translated = str_replace(["profilePicture", "userName", 'class="admin" style="display: none;"'],[ getProfilePicture($email), getUsername($email), 'class="admin" style="display: flex;"' ],  $replace);
} else {
    $translated = str_replace(["profilePicture", "userName"],[ getProfilePicture($email), getUsername($email) ],  $replace);
}
echo $translated;
?>



    <section class="home-section">
        <?php
        if(isset($message)) {
            echo '<div class="messages" style="display: inline-block;">' . $message . '</div>';
        }
        ?>
        <div class="text">
            Dashboard
        </div>
    </section>




    <script src="assets/scripts/main.js"></script>
<?php
include "app/inc/footer.php";
?>