<?php

function createUser($username, $email,  $passwd): void {
    require("mysql.php");
    $stmt = $mysql->prepare("INSERT INTO users (USERNAME, EMAIL, PASSWORD, RANK, AGE) VALUES (:user, :email, :passwd, 1, current_timestamp)");
    $stmt->bindParam(":user", $username, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":passwd", $passwd, PDO::PARAM_STR);
    $stmt->execute();
}

function existsEmail($email): bool {
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $data = 0;
    while ($row = $stmt->fetch()) {
        $data++;
    }
    if($data == 0){
        return false;
    } else {
        return true;
    }
}
function existsUsername($username): bool {
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE USERNAME = :user");
    $stmt->bindParam(":user", $username, PDO::PARAM_STR);
    $stmt->execute();
    $data = 0;
    while ($row = $stmt->fetch()) {
        $data++;
    }
    if($data == 0){
        return false;
    } else {
        return true;
    }
}

function getLanguage($email): string {
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["LANGUAGE"];
    }
    return "en";
}

function getUsername($email): string {
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["USERNAME"];
    }
    return "";
}

function getProfilePicture($email): string {
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["PROFILEPICTURE"];
    }
    return "";
}


function getID($email): int  {
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["ID"];
    }
    return -1;
}
function getEmailById($id): string {
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE ID = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["EMAIL"];
    }
    return "";
}
function updateProfilePicture($email, $path): void {
    require("mysql.php");
    $stmt = $mysql->prepare("UPDATE users SET PROFILEPICTURE = :value WHERE EMAIL = :email");
    $stmt->bindParam(":user", $email, PDO::PARAM_STR);
    $stmt->bindParam(":value", $path, PDO::PARAM_STR);
    $stmt->execute();
}
function enableAccount($email): void {
    require("mysql.php");
    $stmt = $mysql->prepare("UPDATE users SET ENABLED = true WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_STR);
    $stmt->execute();
}
function isEnabled($email): bool {
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        if($row["ENABLED"] == 0) {
            return false;
        } else {
            return true;
        }
    }
    return false;
}
function getRank($email): int {
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["RANK"];
    }
    return 0;
}

function setPasswordReset($email, $code): void {
    require("mysql.php");
    $stmt = $mysql->prepare("UPDATE users SET PASSWORD_CODE = :code, PASSWORD_TIME = CURRENT_TIMESTAMP WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_STR);
    $stmt->bindParam(":code", $code, PDO::PARAM_STR);
    $stmt->execute();
}
function getPasswordToken($email): string {
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["PASSWORD_CODE"];
    }
    return "";
}
function getPasswordTokenTime($email): string {
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["PASSWORD_TIME"];
    }
    return "";
}
function resetPasswordToken($email): void {
    require("mysql.php");
    $stmt = $mysql->prepare("UPDATE users SET PASSWORD_CODE = NULL, PASSWORD_TIME = NULL WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_STR);
    $stmt->execute();
}
function setPassword($email, $passwd): void {
    require("mysql.php");
    $stmt = $mysql->prepare("UPDATE users SET PASSWORD = :passwd WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_STR);
    $stmt->bindParam(":passwd", $passwd, PDO::PARAM_STR);
    $stmt->execute();
}
function getPassword($email): string {
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["PASSWORD"];
    }
    return "";
}

function maxCount(): int {
    require ("mysql.php");
    $stmt = $mysql->prepare("SELECT COUNT(*) AS COUNT FROM settings");
    $stmt->execute();
    return $stmt->fetch()["COUNT"];
}

function getServerSettings($id): array|string
{
require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM settings WHERE ID = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch();
    return array("NAME"=>$row["NAME"], "REQUIREMENTS"=>$row["REQUIREMENTS"], "MINAGE"=>$row["MINAGE"],"CENABLED"=>$row["CENABLED"],"NENABLED"=>$row["NENABLED"]);
}

function createServerSetting($name, $requirements, $minage)
{
    require("mysql.php");
    $stmt = $mysql->prepare("INSERT INTO settings (NAME, REQUIREMENTS, MINAGE) VALUES(:name, :require, :age)");
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":require", $requirements, PDO::PARAM_STR);
    $stmt->bindParam(":age", $minage, PDO::PARAM_INT);
    $stmt->execute();
}

?>