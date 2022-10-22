<?php
$user = getUserDataById($_GET['USERID']);
$language = 'en';
$langPath = __DIR__ . '../languages/lang_' . $language . '.php';
if(isset($user)){
    $language = $user['LANGUAGE'];
}

?>
<body>
<div class="navigation">
    <div class="logo">
        <a href="../../index.php">
            <img class="image" src="../../assets/images/logos/0108221659359489510D3E38-29B1-470256x.png" alt="Galactic Projects : Logo">
        </a>
    </div>
    <div class="navbar">
        <div class="item">
            <a href="../../index.php"><?php echo NAVBAR_HOME; ?></a>
        </div>
        <div class="item">
            <a href="../../apply.php"><?php echo NAVBAR_APPLY; ?></a>
        </div>
        <div class="item">
            <a href="../../account.php"><?php echo NAVBAR_ACCOUNT; ?></a>
        </div>
    </div>
</div>