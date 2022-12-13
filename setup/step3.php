<?php
if(file_exists("../app/mysql.php")){
    header("Location: ../index.php");
    exit;
}
session_start();
include "../app/inc/header.html";
if(isset($_SESSION["host"]) && isset($_SESSION["database"]) && isset($_SESSION["user"]) && isset($_SESSION["password"])){
    if(isset($_POST["submit"])){
        $_SESSION["fromMail"] = $_POST["fromMail"];
        $_SESSION["fromName"] = $_POST["fromName"];
        $_SESSION["replyMail"] = $_POST["replyMail"];
        $_SESSION["replyName"] = $_POST["replyName"];
        ?>
        <meta http-equiv="refresh" content="0; URL=step4.php">
        <?php
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>
<body>
    
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form action="step3.php" method="post">
                    <span class="login100-form-title p-b-49">
                        E-Mail Settings
                        <p>Almost done! Please enter an email address with reply address. You can choose whatever you want!</p>
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

                    <div class="wrap-input100 validate-input" data-validate="Email is required">
                        <span class="label-input100">From Mail</span>
                        <input class="input100" type="email" name="fromMail" placeholder="server@provider.xyz" required>
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Name is required">
                        <span class="label-input100">From Name</span>
                        <input class="input100" type="text" name="fromName" placeholder="Example: Reply for help" required>
                        <span class="focus-input100" data-symbol="&#xf209;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Email is required">
                        <span class="label-input100">Reply Mail</span>
                        <input class="input100" type="email" name="replyMail" placeholder="support@provider.xyz" required>
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Name is required">
                        <span class="label-input100">Reply Name</span>
                        <input class="input100" type="text" name="replyName" placeholder="Example: Support" required>
                        <span class="focus-input100" data-symbol="&#xf209;"></span>
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
