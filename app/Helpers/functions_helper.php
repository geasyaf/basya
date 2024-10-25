<?php
date_default_timezone_set("Asia/Jakarta"); 
function genReg($code){
    $reg = $code . date("ymdHis"); 
    return $reg;
}
?>
