<?php
include('../../Class/Login.php');
include('../../Class/filterInput.php');
include('../../Class/Validations.php');
if(isset($_POST['login'])){
    $filter = new filterInput();
    $_POST = $filter->filter($_POST);
    if(Validations::validate( [ ['email'=>['required','max:120','email']],['password'=>['required','max:150','min:4']] ] ,$_POST) == false) {
        $remmber = array_key_exists('remmber', $_POST) ? $_POST['remmber'] : 'off';
        $login = new Login($_POST['email'], $_POST['password'], $remmber);
        $login->login();
    }else{
        header("Location: /photograph/login.php");
    }
}