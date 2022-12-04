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
                } else if(isset($_GET["settings"])) {
                    echo SERVER_SETTINGS . 
                    '<table class="table align-middle mb-0 bg-black justify-content">
  <thead class="text-white">
    <tr>
      <th>Name</th>
      <th>Title</th>
      <th>Status</th>
      <th>Position</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>
        <div class="d-flex align-items-center">
          <img
              src="https://mdbootstrap.com/img/new/avatars/8.jpg"
              alt=""
              style="width: 45px; height: 45px"
              class="rounded-circle"
              />
          <div class="ms-3">
            <p class="fw-bold mb-1 text-white">John Doe</p>
            <p class="text-muted mb-0 text-white">john.doe@gmail.com</p>
          </div>
        </div>
      </td>
      <td>
        <p class="fw-normal mb-1 text-white">Software engineer</p>
        <p class="text-muted mb-0 text-white">IT department</p>
      </td>
      <td>
        <span class="badge badge-success rounded-pill d-inline text-white">Active</span>
      </td>
      <td class="text-white">Senior</td>
      <td>
        <button type="button" class="btn btn-link btn-sm btn-rounded text-white">
          Edit
        </button>
      </td>
    </tr>
  </tbody>
</table>
';
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