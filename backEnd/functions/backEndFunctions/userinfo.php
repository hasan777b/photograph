<?php

include('../../Class/filterInput.php');
include('../../Class/Validations.php');
include('../../Class/Upload.php');
include('../../Class/DB.php');
$db = new DB();

function validated($data){
    return Validations::validate( [ ['username'=>['required','max:150','min:2','string']],['password'=>['required','string']],['email'=>['required','email']]] ,$data);

}

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

if(isset($_POST['update'])){
    sunset('update');
    $filter = filter($_POST);
    $_POST['id'] = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    $user = $db->find('users','id',$_POST['id']);
    if(password_verify($_POST['previous_password'],$user->password)) {
        sunset('previous_password');
        if (validated($_POST) == false) {
            $_POST['image'] = $user->image;
            $_POST['password'] = password_hash($_POST['password'],PASSWORD_BCRYPT);
            if (!empty($_FILES['image']['name'])) {
                $upload = new Upload($_FILES, '/photograph/backEnd/uploader/','userImage/');
                $upload->setSize(4000);
                $upload->startMove();
                $message = $upload->getMessage();
                if (empty($message)) {
                    Iunlink('../../../backEnd/' . $user->image);
                    $_POST['image'] = $upload->getPath()[0];
                } else {
                    $_SESSION['message'] = $message;
                    $db->redirectTo('userinfo/update.php/' . $_POST['id']);
                }
            }
            responseQuery($db->update('users', ['username', 'email', 'password', 'image'], $_POST), 'update', 'updated');
        }
    }else{
        $_SESSION['passwordBad'] = 'error';
    }
    $db->redirectTo('userinfo/update.php/'.$_POST['id']);
}
