<!DOCTYPE html>
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
        $host = $_SESSION["host"];
        $name = $_SESSION["database"];
        $user = $_SESSION["user"];
        $password = $_SESSION["password"];
        /////////////////////////////////////////////////
        try {
            $mysql = new PDO("mysql:host=$host;dbname=$name", $user, $password);

            $dbUsers = $mysql->prepare("CREATE TABLE IF NOT EXISTS users (
                ID INT AUTO_INCREMENT PRIMARY KEY,
                USERNAME VARCHAR(64) NOT NULL DEFAULT '',
                EMAIL VARCHAR(64) UNIQUE NOT NULL DEFAULT '',
                PASSWORD VARCHAR(128) NOT NULL DEFAULT '',
                RANK TINYINT(1) DEFAULT 1,
                LANGUAGE VARCHAR(12) NOT NULL DEFAULT 'en',
                PROFILEPICTURE VARCHAR(256) NOT NULL DEFAULT '/assets/images/profiles/default.jpg',
                AGE TIMESTAMP NULL,
                CREATED_AT TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                LATEST_ACCESS TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                ENABLED BOOLEAN DEFAULT FALSE,
                PASSWORD_CODE VARCHAR(255) NULL,
                PASSWORD_TIME TIMESTAMP NULL,
                SECURITY_IDENTIFIER VARCHAR(255) NULL,
                SECURITY_TOKEN VARCHAR(255) NULL,
                SECURITY_CREATED TIMESTAMP NULL
            )");
            // USERS
            $dbUsers->execute();
            $account = $mysql->prepare("INSERT INTO users (USERNAME, EMAIL, PASSWORD, RANK, AGE, ENABLED) VALUES (:user, :email, :passwd, :rank, :age, :enabled)");
            $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $rank = "3";
            $age = date('Y-m-d H-M-s');
            $enable = true;
            $account->bindParam(":user", $_POST["username"], PDO::PARAM_STR);
            $account->bindParam(":email", $_POST["email"], PDO::PARAM_STR);
            $account->bindParam(":passwd", $hash, PDO::PARAM_STR);
            $account->bindParam(":rank",$rank, PDO::PARAM_INT);
            $account->bindParam(":age", $age);
            $account->bindParam(":enabled", $enable);
            $account->execute();
            // SETTINGS
            $json = json_encode('{"community": false, "network": false}');
            $dbSettings = $mysql->prepare('CREATE TABLE IF NOT EXISTS settings (
                ID INT AUTO_INCREMENT PRIMARY KEY,
                NAME VARCHAR(128) UNIQUE NOT NULL DEFAULT "",
                REQUIREMENTS LONGTEXT,
                MINAGE INT(12) DEFAULT 16,
                CENABLED BOOLEAN DEFAULT FALSE,
                NENABLED BOOLEAN DEFAULT FALSE
            )');
            $dbSettings->execute();
            $settings= $mysql->prepare("INSERT INTO settings (NAME, REQUIREMENTS, MINAGE) VALUES (:name, :required, :min)");
            $name = "Developer";
            $requirements = "Dear user, our requirements are java basic knowledge/object, spigot/bukkit, bungeecord api, mysql! Good luck!";
            $min = 16;
            $settings->bindParam(":name", $name, PDO::PARAM_STR);
            $settings->bindParam(":required", $requirements, PDO::PARAM_STR);
            $settings->bindParam(":min", $min, PDO::PARAM_INT);
            $settings->bindParam(":enable", $enabled, PDO::PARAM_BOOL);
            $settings->execute();
            // APPLICATIONS
            $dbApplications = $mysql->prepare("CREATE TABLE IF NOT EXISTS applications (
                ID INT AUTO_INCREMENT PRIMARY KEY,
                USERID INT(12) UNIQUE,
                TEXT LONGTEXT,
                TYPE VARCHAR(32) NOT NULL DEFAULT '',
                AGED BOOLEAN DEFAULT FALSE,
                DISCORD BOOLEAN DEFAULT FALSE, 
                TEAMSPEAK BOOLEAN DEFAULT FALSE,
                MICROFON BOOLEAN DEFAULT FALSE
            )");
            $dbApplications->execute();

            header("Location: step3.php");
            exit;
        } catch (PDOException $e){
        ?>
<script type="text/javascript">
alert("Unable to connect to the MySQL database or an error occurred.<?php echo $e->getMessage(); ?>");
</script>
<?php
        }
    }
} else {
  header("Location: index.php");
  exit;
} ?>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
            <form action="step2.php" method="post">
                <span class="login100-form-title p-b-49">
                    Create Account
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

                <div class="wrap-input100 validate-input" data-validate="Username is required">
                    <span class="label-input100">Username</span>
                    <input class="input100" type="text" name="username" placeholder="EveryNameYouWant" required>
                    <span class="focus-input100" data-symbol="&#xf209;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Email is required">
                    <span class="label-input100">Email</span>
                    <input class="input100" type="email" name="email" placeholder="name@provider.xyz" required>
                    <span class="focus-input100" data-symbol="&#xf206;"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <span class="label-input100">Password</span>
                    <input class="input100" type="password" name="password" placeholder="superS$cretpassw0rd">
                    <span class="focus-input100" data-symbol="&#xf190;"></span>
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
<?php
include "../app/inc/footer.php";
?>