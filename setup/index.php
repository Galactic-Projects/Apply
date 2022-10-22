<?php
if(file_exists("../app/mysql.php")){
    header("Location: ../index.php");
    exit;
}
session_start();
include "../app/inc/header.php";
?>
<body>
<div class="content">
<?php
if(isset($_POST["submit"])){
    $host = $_POST["host"];
    $name = $_POST["database"];
    $user = $_POST["user"];
    $password = $_POST["password"];
    try{
        $mysql = new PDO("mysql:host=$host;dbname=$name", $user, $password);
        $_SESSION["host"] = $_POST["host"];
        $_SESSION["database"] = $_POST["database"];
        $_SESSION["user"] = $_POST["user"];
        $_SESSION["password"] = $_POST["password"];
        ?>
        <meta http-equiv="refresh" content="0; URL=step2.php">
        <?php
        exit;
    } catch (PDOException $e){
        echo $e->getMessage();
    }
}
    ?>
<h5>MySQL Database</h5>
<form action="index.php" method="post">
    <input type="text" name="host" placeholder="Host" value="localhost" required>
    <input type="text" name="database" placeholder="Database" required>
    <input type="text" name="user" placeholder="User" required>
    <input type="password" name="password" placeholder="Password">
    <button type="submit" name="submit">Continue</button>
</form>
</div>

</body>
<?php include "../app/inc/footer.php" ?>