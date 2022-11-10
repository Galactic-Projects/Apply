<?php
if(!file_exists("../app/mysql.php")){
    header("Location: ../setup/index.php");
    exit;
}
session_start();
require "../app/data.php";
include "../app/inc/header.php";

if(!isset($_SESSION['userid'])){
    header("Location: ../login.php");
    exit;
}
$id = $_SESSION['userid'];
$email = getEmailById($id);
$language = 'en';
if(getLanguage($email) != null) {
    $language = getLanguage($email);
}
include "../app/languages/lang_" . $language . ".php";
if(getRank($email) <= 1) {
    die("<div class='background'><div class='error'><p>".ADMIN_ERROR_PERMISSION. "</p></div></div>");
}

echo (str_replace(["profilePicture", "userName"],[ getProfilePicture($email), getUsername($email) ],  file_get_contents("../app/inc/administration-nav.html")));

?>
    <section class="home-section">
        <?php
        if(isset($message)) {
            echo '<div class="messages" style="display: inline-block;">' . $message . '</div>';
        }
        ?>
        <div class="text">
        </div>
    </section>




    <script src="../assets/scripts/main.js"></script>
<?php
include "../app/inc/footer.php";
?>