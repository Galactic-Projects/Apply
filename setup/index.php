<?php
if(file_exists("../app/mysql.php")){
    header("Location: ../index.php");
    exit;
}
session_start();
include "../app/inc/header.html";
?>
<body>
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
        $message = $e->getMessage();
    }
}
    ?>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form action="index.php" method="post">
                    <span class="login100-form-title p-b-49">
						MySQL-Database
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
                        <input class="input100" type="text" name="host" placeholder="localhost" value="localhost" required>
                        <span class="focus-input100" data-symbol="&#xf1c0;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Database is required">
                        <span class="label-input100">Database</span>
                        <input class="input100" type="text" name="database" placeholder="apply" required>
                        <span class="focus-input100" data-symbol="&#xf1c5;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="User is required">
                        <span class="label-input100">User</span>
                        <input class="input100" type="text" name="user" placeholder="root" required>
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
<?php include "../app/inc/footer.html" ?>