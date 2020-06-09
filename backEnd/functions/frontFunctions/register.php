<?php

include('../../Class/filterInput.php');
include('../../Class/Validations.php');
include('../../Class/Upload.php');
include('../../Class/DB.php');
$db = new DB();

function filter($data){
    $filter = new filterInput();
    return $filter->filter($data);
}

function sunset($value){
    unset($_POST[$value]);
}

function responseQuery($response,$key,$value){
    if($response){
        $_SESSION[$key] = $value;
    }else{
        $_SESSION['error']='error';
    }
    return 0;
}

function Iunlink($path){
    if(file_exists($path)){
        unlink($path);
    }
}

if(isset($_POST['register'])){
    $user = $db->getOneRow('users');
    if(empty($user)) {
        sunset('register');
        $_POST = filter($_POST);
        $validate = Validations::validate([['username' => ['required', 'max:150', 'min:2', 'string']], ['password' => ['required', 'string','min:4','max:150']], ['email' => ['required', 'email']]], $_POST);
        $access = 1;
        sunset('access');
        if ($validate == false) {
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $user = $db->insert('users', ['username', 'email', 'password'], $_POST, true);
            responseQuery(is_object($user), 'register', 'registered');
            if (isset($_SESSION['error']) == false) {
                $db->insert('role_user', ['role_id', 'user_id'], ['role_id' => $access, 'user_id' => $user->id]);
                header('Location: /photograph/login.php');
            }
        }
    }
    header('Location: /photograph/register.php');
}
