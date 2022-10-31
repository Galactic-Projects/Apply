<?php
function uploadImage($profileName) {
    $path = __DIR__.'../../assets/images/profiles/';
    $file = $profileName;
    $file_temp = $_FILES["file"]["tmp_name"];
    $file_size = $_FILES["file"]["size"];

    if($file_size > (100 * 1024)) {
        echo "<div class='error'><img src='/assets/icons/error.png' style='width:32px;height:32px;'><p>File is to big (Max. 100MB)! </p></div>";
    } else {
        $newPath = $path . $file;
        move_uploaded_file($file_temp, $newPath);
        echo "<div class='success'><img src='/assets/icons/success.png' style='width:32px;height:32px;'></div>";
    }

    if($newPath != null) {
        return $newPath;
    }
}
?>