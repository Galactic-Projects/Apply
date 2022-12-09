<?php
if(!file_exists("../app/mysql.php")){
    header("Location: ../setup/index.php");
    exit;
}
session_start();
require "../app/data.php";
include "../app/inc/header.html";

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
    die("<div class='background'><div class='error'><p>".ADMIN_ERROR_PERMISSION."</p></div></div>");
}

echo (str_replace(["profilePicture", "userName"],[ getProfilePicture($email), getUsername($email) ],  file_get_contents("../app/inc/administration-nav.html")));


if(isset($_GET["add-query"])) {
    $name = $_POST['name'];
    $requirements = $_POST['require'];
    $minage = $_POST['minage'];

    createServerSetting($name, $requirements, $minage);
    header("Location: panel.php?settings=1");
}

?>
<section class="home-section">
    <?php
        if(isset($message)) {
            echo '<div class="alert-secondary alert-info justify-content">' . $message . '</div>';
        }
        ?>
    <div class="text">
        <?php
                if(isset($_GET["application"])) {
                    echo SERVER_APPLICATIONS;
                } else if(isset($_GET["add"])) {
                    echo SERVER_SETTINGS_ADD. '
    <div class="container-login100">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
            <form class="login100-form validate-form" action="?add-query=1" method="post">
                <span class="login100-form-title p-b-49">
                    Add
                </span>

                <div class="txt1 text-center p-t-54 p-b-20">
                    <span>
                    </span>
                </div>

                <div class="wrap-input100 validate-input m-b-23" data-validate="Name is required">
                    <span class="label-input100">Name</span>
                    <input class="input100" type="text" name="name" placeholder="Example: Sagittarius A">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-23" data-validate="Requirements is required">
                    <span class="label-input100">Requirements</span>
                    <input class="input100" type="text" name="require" placeholder="Example: Dear ...">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-23" data-validate="Minimum Age is required">
                    <span class="label-input100">Minimum Age</span>
                    <input class="input100" type="number" name="minage" placeholder="Example: 16">
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div

                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <button type="submit" class="login100-form-btn">
                            ' . BUTTON_SEND .'
                        </button>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>
';
                } else if(isset($_GET["settings"])) {
                    echo SERVER_SETTINGS .
                        '<div class="table-responsive bg-dark justify-content-center">

  <table class="table text-white">
    <thead>
      <tr>
        <th scope="col" style="font-size: 16px">ID</th>
        <th scope="col" style="font-size: 16px">Rank</th>
        <th scope="col" style="font-size: 16px">Requirements</th>
        <th scope="col" style="font-size: 16px">Minimum Age</th>
        <th scope="col" style="font-size: 16px">Enabled (C,N)</th>
        <th scope="col" style="font-size: 16px">Actions</th>
        <a href="?add=1" class="btn btn-dark">Add</a>
      </tr>
    </thead>
    <tbody>
      ';
      for($i = 1; $i <= maxCount(); $i++){
                        echo '   
      <tr>    
        <td style="font-size: 16px">'.$i.'</td>          
        <td style="font-size: 16px">'.getServerSettings($i)["NAME"].'</td>
        <td style="font-size: 16px">'.getServerSettings($i)["REQUIREMENTS"].'</td>
        <td style="font-size: 16px">'.getServerSettings($i)["MINAGE"].'</td>
        <td style="font-size: 16px">'.(getServerSettings($i)["CENABLED"] ? "true" : "false").' | '.(getServerSettings($i)["NENABLED"] ? "true" : "false").'</td>
        <td style="font-size: 16px"><a href="?edit=1&id=' .$i.'"><i class="far fa-edit"></i></a> / <a href="?remove=1&id=' .$i.'"><i class="fas fa-times"></i></a></td>
      </tr>';
                    }

                echo '
    </tbody>
  </table>
</div>';
                } else {
                    echo DASHBOARD;
                }
            ?>
    </div>
</section>

<script src="../assets/scripts/main.js"></script>
<?php
include "../app/inc/footer.html";
?>