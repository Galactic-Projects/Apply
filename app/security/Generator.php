<?php
function generateRandomString() {
    $length = 16;
    if(function_exists('random_bytes')) {
        $bytes = random_bytes($length);
        $str = bin2hex($bytes);
    } else if(function_exists('openssl_rnadom_pseudo_bytes')) {
        $bytes = openssl_random_pseudo_bytes($length);
        $str = bin2hex($bytes);
    } else {
        $str = md5(uniqid('very_secret_code', true));
    }
    return $str;
}
?>