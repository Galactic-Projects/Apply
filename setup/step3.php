<?php
if(file_exists("../app/mysql.php")){
    header("Location: ../index.php");
    exit;
}
session_start();
include "../app/inc/header.php";
if(isset($_SESSION["host"]) && isset($_SESSION["database"]) && isset($_SESSION["user"]) && isset($_SESSION["password"])){
    if(isset($_POST["submit"])){
        $mysqlfile = fopen("../app/mysql.php", "w");
        if(!$mysqlfile){
        ?><body>
            <div class="content">
                <img src="../assets/icons/error.png" alt="cross" id="status">
                <h1>Error</h1>
                <p>Installation failed. Reason: Can't write mysql.php.</p>
                <br>
                <a href="step3.php" class="btn">Try again</a>
            </div>
            </body><?php
            exit;
        }
        echo fwrite($mysqlfile, '
<?php
    $host = "'.$_SESSION["host"].'";
    $db = "'.$_SESSION["database"].'";
    $user = "'.$_SESSION["user"].'";
    $password = "'.$_SESSION["password"].'";
    
    try {
        $mysql = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    } catch (PDOException $e){
        e->getMessage();
    } 
?> 
        ');
        fclose($mysqlfile);

        $mailInfo = fopen("../app/mail.php", "w");
        if(!$mailInfo){
        ?><body>
            <div class="content">
                <img src="../assets/icons/error.png" alt="cross" id="status">
                <h1>Error</h1>
                <p>Installation failed. Reason: Can't write mail.php.</p>
                <br>
                <a href="step3.php" class="btn">Try again</a>
            </div>
            </body><?php
            exit;
        }
        echo fwrite($mailInfo, '<?php 
            function getFromMail(): string { return "'.$_POST["fromMail"].'"; }
            function getFromName(): string { return "'.$_POST["fromName"].'"; }
            function getReplyMail(): string { return "'.$_POST["replyMail"].'"; }
            function getReplyName(): string { return "'.$_POST["replyName"].'"; }
        ?>
        ');
        fclose($mailInfo);
        session_destroy();
        ?>
        <meta http-equiv="refresh" content="0; URL=../index.php">
        <?php
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
<div class="content">
    <p>Almost done! Please enter smtp email data.If you don't have one, leave it blank!</p>
    <h5>E-Mail Settings</h5>
    <form action="step3.php" method="post">
        <input type="email" name="fromMail" placeholder="From Mail" required>
        <input type="text" name="fromName" placeholder="From Name" required>
        <input type="email" name="replyMail" placeholder="Reply Mail" required>
        <input type="text" name="replyName" placeholder="Reply Name" required>
        <button type="submit" name="submit">Finish</button>
    </form>
</div>
<?php include "../app/inc/footer.php" ?>
