<?php
if(file_exists("../app/mysql.php")){
    header("Location: ../index.php");
    exit;
}
session_start();
include "../app/inc/header.html";
if(isset($_SESSION["host"]) && isset($_SESSION["database"]) && isset($_SESSION["user"]) && isset($_SESSION["password"])){
    if(isset($_SESSION["fromMail"]) && isset($_SESSION["fromName"]) && isset($_SESSION["replyMail"]) && isset($_SESSION["replyName"])){
        if(isset($_POST["submit"])) {
            $mysqlfile = fopen("../app/mysql.php", "w");
            if(!$mysqlfile){
                ?><body>
                <div class="content">
                    <img src="https://cdni.galacticprojects.net//icons/error.png" alt="cross" id="status">
                    <h1>Error</h1>
                    <p>Installation failed. Reason: Can't write mysql.php.</p>
                    <br>
                    <a href="step3.php" class="btn">Try again</a>
                </div>
                </body><?php
                exit;
            }
            echo fwrite($mysqlfile, '<?php 
$host = "'.$_SESSION["host"].'";
$db = "'.$_SESSION["database"].'";
$user = "'.$_SESSION["user"].'";
$password = "'.$_SESSION["password"].'";
try {
    $mysql = new PDO("mysql:host=$host;dbname=$db", $user, $password);
} catch (PDOException $e){
    e->getMessage();
}
?>');
            fclose($mysqlfile);

            $mailInfo = fopen("../app/mail.php", "w");
            if(!$mailInfo){
                ?><body>
                <div class="content">
                    <img src="https://cdni.galacticprojects.net//icons/error.png" alt="cross" id="status">
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
?> ');
            fclose($mailInfo);

            $configFile = fopen("../app/config.php", "w");
            if(!$configFile){
                ?><body>
                <div class="content">
                    <img src="https://cdni.galacticprojects.net//icons/error.png" alt="cross" id="status">
                    <h1>Error</h1>
                    <p>Installation failed. Reason: Can't write config.php.</p>
                    <br>
                    <a href="step4.php" class="btn">Try again</a>
                </div>
                </body><?php
                exit;
            }
            echo fwrite($configFile, '<?php define("HOST", "' . $_POST["host"] . '" ?>');
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
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form action="step4.php" method="post">
                    <span class="login100-form-title p-b-49">
                        Host Settings
                        <p>Please enter a host name.</p>
					</span>

                    <div class="txt1 text-center p-t-54 p-b-20">
						<span>
							<?php
                            if(isset($message)) {
                                echo $message;
                            }
                            ?>
						</span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Hostname is required">
                        <span class="label-input100">Host</span>
                        <input class="input100" type="text" name="host" placeholder="http://localhost.xzy/"required>
                        <span class="focus-input100" data-symbol="&#xf1c0;"></span>
                    </div>
                    
                    <div class="text-right p-t-8 p-b-31">
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button type="submit" name="submit" class="login100-form-btn">Continue</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>    
    </div>
</body>
<?php include "../app/inc/footer.html" ?>
