<?php
if(file_exists("../app/mysql.php")){
    header("Location: ../index.php");
    exit;
}
session_start();
include "../app/inc/header.php";
if(isset($_SESSION["host"]) && isset($_SESSION["database"]) &&
    isset($_SESSION["user"]) && isset($_SESSION["password"])){
    if(isset($_POST["submit"])){

        if(($_POST['mailhost'] || $_POST['username'] || $_POST['port'] || $_POST['email'] || $_POST['password']) != null){
            $mailfile = fopen("../app/mail.php", "w");
            if(!$mailfile){ // TODO Bug-Fixing: Issue while create file!
                echo fwrite($mailfile, '<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once("../libs/PHPMailer/class.phpmailer.php");

function sendMail($address, $username, $replyAddress, $fromAddress, $subject, $altBody ,$htmlInput) {
    try {
        $host = "'.$_POST['mailhost'].'";
        $users = "'.$_POST["username"].'";
        $port = "'.$_POST["port"].'";
        $email = "'.$_POST["email"].'";
        $password = "'.$_POST["password"].'";

        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPDebug = 3;

        $mail->Host       = $host; 
        $mail->SMTPAuth   = true;             
        $mail->Port       = $port;                  
        $mail->Username   = $users; 
        $mail->Password   = $password;    
        $mail->AddReplyTo("username.name@a-bc.fr", "Firstname/Lastname");
        $mail->AddAddress($address, $username);
        $mail->SetFrom($email, "Firstname/Lastname");
        $mail->Subject = $subject;
        $mail->AltBody = $altBody;
        $mail->MsgHTML(file_get_contents($htmlInput));
        $mail->Send();

        echo "Message sent\n";
    } catch (phpmailerException $e) {
        echo $e->errorMessage(); 
    } catch (Exception $e) {
        echo $e->getMessage(); 
    }
}
?>');
                fclose($mailfile);
                session_destroy();
                ?>
                <meta http-equiv="refresh" content="0; URL=../index.php">
                <?php
                exit;
            }
        }

        $mysqlfile = fopen("../app/mysql.php", "w");
        if(!$mysqlfile){
            ?>
            <body>
            <div class="content">
                <img src="../assets/icons/error.png" alt="cross" id="status">
                <h1>Error</h1>
                <p>Installation failed. Reason: Can't write mysql.php.</p>
                <br>
                <a href="step3.php" class="btn">Try again</a>
            </div>
            </body>
            <?php
            exit;
        }
        echo fwrite($mysqlfile, '
            <?php
                $host = "'.$_SESSION["host"].'";
                $db = "'.$_SESSION["database"].'";
                $user = "'.$_SESSION["user"].'";
                $password = "'.$_SESSION["password"].'";
                try{
                $mysql = new PDO("mysql:host=$host;dbname=$db", $user, $password);
            } catch (PDOException $e){} ?> ');
        fclose($mysqlfile);
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
    <p>Almost done! Please enter smtp email data, leave it blank. If you don't have one!</p>
    <h5>E-Mail Settings</h5>
    <form action="step3.php" method="post">
        <input type="text" name="mailhost" placeholder="mail.provider.xyz">
        <input type="text" name="username" placeholder="User | most case email">
        <input type="password" name="password" placeholder="Password">
        <input type="text" name="port" placeholder="Port (default 25 or 465)">
        <input type="email" name="email" placeholder="name@provider.xyz">

        <button type="submit" name="submit">Finish</button>
    </form>
</div>
<?php include "../app/inc/footer.php" ?>
