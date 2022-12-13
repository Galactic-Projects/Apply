<?php
function generateRandom($j = 32): string
{
    $string = "";
    for($i=0; $i < $j; $i++){
        $x = mt_rand(0, 2);
        switch($x){
            case 0: $string.= chr(mt_rand(97,122));break;
            case 1: $string.= chr(mt_rand(65,90));break;
            case 2: $string.= chr(mt_rand(48,57));break;
        }
    }
    return $string;
}
?>
