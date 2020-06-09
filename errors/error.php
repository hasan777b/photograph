<?php

$errorList = ['400','401','403','404','405','408','414','500','502','504'];
if(isset($_GET['err']) and in_array($_GET['err'],$errorList)){
    include($_GET['err'].".php");
}else{
    include("err.php");
}

?>