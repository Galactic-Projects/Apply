<?php

function createUser($username, $password, $email) {
    require("mysql.php");
    $stmt = $mysql->prepare("INSERT INTO users (USERNAME, EMAIL, PASSWORD, RANK, AGE) VALUES (:user, :email, :password, 1, :age)");
    $age = time();
    $enabled = false;
    $enableDate = time();
    $stmt->bindParam(":user", $username, PDO::PARAM_STR);
    $stmt->bindParam(":password", $password, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":age", $age);
    $stmt->execute();
}

function existsEmail($email){
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
function existsUsername($username){
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

function getLanguage($email){
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["LANGUAGE"];
    }
}

function getUsername($email){
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["USERNAME"];
    }
}

function getProfilePicture($email){
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["PROFILEPICTURE"];
    }
}
function getID($email){
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["ID"];
    }
}
function getEmailById($id){
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE ID = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["EMAIL"];
    }
}
function updateProfilePicture($email, $path){
    require("mysql.php");
    $stmt = $mysql->prepare("UPDATE users SET PROFILEPICTURE = :value WHERE EMAIL = :email");
    $stmt->bindParam(":user", $email, PDO::PARAM_STR);
    $stmt->bindParam(":value", '', PDO::PARAM_STR);
    $stmt->execute();
}
function enableAccount($email){
    require("mysql.php");
    $stmt = $mysql->prepare("UPDATE users SET ENABLED = :enable WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_STR);
    $stmt->bindParam(":enable", true, PDO::PARAM_BOOL);
    $stmt->execute();
}
function isEnabled($email){
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["ENABLED"];
    }
}
function setPassword($email, $password){
    require("mysql.php");
    $stmt = $mysql->prepare("UPDATE users SET PASSWORD = :passwd WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_STR);
    $stmt->bindParam(":passwd", $password, PDO::PARAM_STR);
    $stmt->execute();
}
function getPassword($email){
    require("mysql.php");
    $stmt = $mysql->prepare("SELECT * FROM users WHERE EMAIL = :mail");
    $stmt->bindParam(":mail", $email, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch()) {
        return $row["PASSWORD"];
    }
}
?>