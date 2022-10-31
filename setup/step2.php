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
                ENABLEID VARCHAR(48) NOT NULL DEFAULT '',
                ENABLEDATE TIMESTAMP NULL,
                PASSWORD_CODE VARCHAR(255) NOT NULL,
                PASSWORD_TIME TIMESTAMP NULL,
                SECURITY_IDENTIFIER VARCHAR(255) NOT NULL,
                SECURITY_TOKEN VARCHAR(255) NOT NULL,
                SECURITY_CREATED TIMESTAMP NULL
            )");
            // USERS
            $dbUsers->execute();
            $account = $mysql->prepare("INSERT INTO users (USERNAME, EMAIL, PASSWORD, RANK, AGE, ENABLED) VALUES (:user, :email, :password, :rank, :age, :enabled)");
            $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $rank = "3";
            $age = date('Y-m-d H-M-s');
            $enable = true;
            $account->bindParam(":user", $_POST["username"], PDO::PARAM_STR);
            $account->bindParam(":email", $_POST["email"], PDO::PARAM_STR);
            $account->bindParam(":password", $hash, PDO::PARAM_STR);
            $account->bindParam(":rank",$rank, PDO::PARAM_INT);
            $account->bindParam(":age", $age);
            $account->bindParam(":enabled", $enable, PDO::PARAM_BOOL);
            $account->execute();
            // SETTINGS
            $dbSettings = $mysql->prepare("CREATE TABLE IF NOT EXISTS settings (
                ID INT AUTO_INCREMENT PRIMARY KEY,
                NAME VARCHAR(128) UNIQUE NOT NULL DEFAULT '',
                REQUIREMENTS LONGTEXT,
                MINAGE INT(12) DEFAULT 16,
                ENABLED BOOLEAN DEFAULT FALSE
            )");
            $dbSettings->execute();
            $settings= $mysql->prepare("INSERT INTO settings (NAME, REQUIREMENTS, MINAGE, ENABLED) VALUES (:name, :required, :min, :enable)");
            $name = "Developer";
            $requirements = "Dear user, our requirements are java basic knowledge/object, spigot/bukkit, bungeecord api, mysql! Good luck!";
            $min = 16;
            $enabled = true;
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
<div class="content">
    <h5>Create Account</h5>
    <form action="step2.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="submit">Continue</button>
    </form>
</div>
<?php
include "../app/inc/footer.php";
?>