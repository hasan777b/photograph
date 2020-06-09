<?php

include('../../Class/filterInput.php');
include('../../Class/Validations.php');
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

function getUserAndRole($id){
    global $db;
    $user = $db->find('users','id',$id);
    $role_user = $db->find('role_user','user_id',$user->id);
    return [$user,$role_user];
}

if(isset($_POST['create'])){
    sunset('create');
    $_POST = filter($_POST);
    $validate = Validations::validate( [ ['username'=>['required','max:150','min:2','string']],['password'=>['required','string']],['email'=>['required','email']],['access'=>['required','numeric']]] ,$_POST);
    $access = $_POST['access'];
    sunset('access');
    if ($validate == false) {
        $_POST['password'] = password_hash($_POST['password'],PASSWORD_BCRYPT);
        $user = $db->insert('users', ['username', 'email','password'],$_POST,true);
        responseQuery(is_object($user), 'create', 'created');
        if(isset($_SESSION['error']) == false){
            $db->insert('role_user',['role_id','user_id'],['role_id'=>$access,'user_id'=>$user->id]);
        }
    }


    $db->redirectTo('user/create.php');
}

if(isset($_POST['update'])){
    sunset('update');
    $filter = filter($_POST);
    $validate = Validations::validate( [ ['username'=>['required','max:150','min:2','string']],['email'=>['required','email']],['access'=>['required','numeric']]] ,$_POST);
    $access = $_POST['access'];
    sunset('access');
    $_POST['id'] = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    if($validate == false) {
        [$user,$role_user] = getUserAndRole($_POST['id']);
        if(empty($_POST['password'])){
            $_POST['password'] = $user->password;
        }else{
            $_POST['password'] = password_hash($_POST['password'],PASSWORD_BCRYPT);
        }
        responseQuery($db->update('users', ['username', 'email','password'],$_POST),'update','updated');
        if(!isset($_SESSION['error'])){
            $data = ['id'=>$role_user->id,'role_id'=>$access];
            $db->update('role_user',['role_id'],$data);
        }
    }
    $db->redirectTo('user/update.php/'.$_POST['id']);
}

if(isset($_POST['delete'])){
    $id = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    [$user,$role_user] = getUserAndRole($id);
    Iunlink('../../../backEnd/'.$user->image);
    responseQuery($db->delete('users','id',$user->id),'delete','deleted');
    if(!isset($_SESSION['error'])){
        $db->delete('role_user','id',$role_user->id);
    }
    $db->redirectTo('user/index.php');

}