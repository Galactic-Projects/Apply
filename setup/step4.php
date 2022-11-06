<?php
if(file_exists("../app/mysql.php")){
    header("Location: ../index.php");
    exit;
}
session_start();
include "../app/inc/header.php";
if(isset($_SESSION["host"]) && isset($_SESSION["database"]) && isset($_SESSION["user"]) && isset($_SESSION["password"])){
    if(isset($_SESSION["fromMail"]) && isset($_SESSION["fromName"]) && isset($_SESSION["replyMail"]) && isset($_SESSION["replyName"])){
        if(isset($_POST["submit"])) {
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
            function getFromMail(): string { return "'.$_SESSION["fromMail"].'"; }
            function getFromName(): string { return "'.$_SESSION["fromName"].'"; }
            function getReplyMail(): string { return "'.$_SESSION["replyMail"].'"; }
            function getReplyName(): string { return "'.$_SESSION["replyName"].'"; }
            ?>
            ');
            fclose($mailInfo);

            $configFile = fopen("../app/config.php", "w");
            if(!$configFile){
                ?><body>
                <div class="content">
                    <img src="../assets/icons/error.png" alt="cross" id="status">
                    <h1>Error</h1>
                    <p>Installation failed. Reason: Can't write config.php.</p>
                    <br>
                    <a href="step4.php" class="btn">Try again</a>
                </div>
                </body><?php
                exit;
            }
            echo fwrite($mailInfo, '<?php 
            define("HOST", '. $_POST["host"].')
            ?>
            ');
            fclose($configFile);
            session_destroy();
            ?>
            <meta http-equiv="refresh" content="0; URL=step4.php">
            <?php
            exit;
        }
    } else {
        header("Location: step3.php");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
<div class="content">
    <p>Please enter a host name.</p>
    <h5>Host Settings</h5>
    <form action="step4.php" method="post">
        <input type="text" name="host" placeholder="http://localhost.xzy/" required>
        <button type="submit" name="submit">Finish</button>
    </form>
</div>
<?php include "../app/inc/footer.php" ?>
