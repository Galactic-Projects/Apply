<?php
if(file_exists("../app/mysql.php")){
    header("Location: ../index.php");
    exit;
}
session_start();
include "../app/inc/header.php";
if(isset($_SESSION["host"]) && isset($_SESSION["database"]) && isset($_SESSION["user"]) && isset($_SESSION["password"])){
    if(isset($_POST["submit"])){
        $_SESSION["fromMail"] = $_POST["fromMail"];
        $_SESSION["fromName"] = $_POST["fromMail"];
        $_SESSION["replyMail"] = $_POST["fromMail"];
        $_SESSION["replyName"] = $_POST["fromMail"];
        ?>
        <meta http-equiv="refresh" content="0; URL=step3.php">
        <?php
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
<div class="content">
    <p>Almost done! Please enter an email address with reply address. You can choose whatever you want!</p>
    <h5>E-Mail Settings</h5>
    <form action="step3.php" method="post">
        <input type="email" name="fromMail" placeholder="From Mail" required>
        <input type="text" name="fromName" placeholder="From Name" required>
        <input type="email" name="replyMail" placeholder="Reply Mail" required>
        <input type="text" name="replyName" placeholder="Reply Name" required>
        <button type="submit" name="submit">Continue</button>
    </form>
</div>
<?php include "../app/inc/footer.php" ?>
