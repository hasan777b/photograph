<?php

include('../../Class/filterInput.php');
include('../../Class/Validations.php');
include('../../Class/DB.php');

include('../../Class/Mailer.php');
$db = new DB();

function filter($data){
    $filter = new filterInput();
    return $filter->filter($data);
}

function sunset($value){
    unset($_POST[$value]);
}

function redirectError($url,$key,$value){
    $_SESSION[$key] = $value;
    header('Location: /photograph/'.$url);
}
function mailSend($email,$body){
    $mail = new Mailer($body,"یک پیام از طرف ".$_ENV['APP_NAME'],$email);
    return $mail->send();
}
if(isset($_POST['forget'])){
    sunset('forget');
    $_POST = filter($_POST);
    $validate = Validations::validate( [ ['email'=>['required','email']]] ,$_POST);
    if($validate == false) {
        $user = $db->find('users','email',$_POST['email']);
        if(!empty($user)) {
            $code = sha1(rand(0,9999999).str_shuffle($_POST['email']));
            $body = "
                <p style='font-size: 16px;'>برای بازیابی رمز عبور بر روی لینک زیر کلیک کنید</p><br>
                <a style='border: 1px solid gray;padding:5px;border-radius: 4px;text-decoration:none;color:orange;margin-bottom:10px;'  href='".$_ENV['FULL_URL'] . '/update-password.php?code=' . $code . '&email='.$user->email."'>ویرایش رمز عبور</a>
            ";
            $mail = mailSend($_POST['email'], $body);
            if ($mail == true) {
                $db->insert('update_password',['email','code'],[$_POST['email'],$code]);
                redirectError('forget-password.php','forget','ok');
            }else
                redirectError('forget-password.php','forget','error');
        }else
            redirectError('forget-password.php','forget','error');
    }else
        redirectError('forget-password.php','forget','error');
}
if(isset($_POST['update_password'])){
    $code = $_GET['code'];
    sunset('update_password');
    $_POST = filter($_POST);
    $user = $db->find('users','email',$_GET['email']);
    if(!empty($user)) {
        $validate = Validations::validate([['password' => ['required', 'min:4']]], $_POST);
        if ($validate == false) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            if ($db->update('users', ['password'], ['id'=>$user->id,'password'=>$password])) {
                $db->delete('update_password','email',$_GET['email']);
                redirectError('login.php','update','ok');
            }else{
                redirectError('update-password.php?'.$code.'&'.$_GET['email'],'update','error');
            }
        }else{
            redirectError('update-password.php?'.$code.'&'.$_GET['email'],'update','error');
        }
    }else{
        redirectError('update-password.php?'.$code.'&'.$_GET['email'],'update','error');
    }

}
