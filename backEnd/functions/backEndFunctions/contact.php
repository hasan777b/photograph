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

function responseQuery($response,$key,$value){
    if($response){
        $_SESSION[$key] = $value;
    }else{
        $_SESSION['error']='error';
    }
    return 0;
}

function mailSend($email){
    $mail = new Mailer($_POST['answer'],"یک پیام از طرف ".$_ENV['APP_NAME'],$email);
    return $mail->send();
}
if(isset($_POST['contact'])){
    sunset('contact');
    $_POST = filter($_POST);
    $validate = Validations::validate( [ ['username'=>['required','string','min:3','max:80']],['lastname'=>['required','string','min:3','max:80']],['email'=>['required','email']],['subject'=>['required','string','min:2','max:80']],['message'=>['required','string','min:5']]] ,$_POST);
    if($validate == false) {
        $contact = $db->insert('contacts',['username','lastname','email','subject','message'],$_POST,true);
        responseQuery(is_object($contact),'create','created');
        if(isset($_SESSION['error']) == false){
            $db->insert('notifications',['type','data','read_at'],['contacts',json_encode(['data'=>(array)$contact]) ,'read_at'=>null]);
        }
    }
    header('Location: /photograph/contact.php');
}

if(isset($_POST['update'])){
    $_POST['id'] = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    sunset('update');
    $_POST = filter($_POST);

    $validate = Validations::validate( [ ['answer'=>['required','string','min:5']]] ,$_POST);
    if($validate == false) {
        $contact = $db->find('contacts','id',$_POST['id']);
        $mail = mailSend($contact->email);
        if($mail == true)
            responseQuery($db->update('contacts',['answer',],$_POST),'email','ok');
        else
            $_SESSION['email'] = 'error';
        $db->redirectTo('contact/update.php/'.$_POST['id']);
    }
    $db->redirectTo('contact/update.php/'.$_POST['id']);
}

if(isset($_POST['delete'])){
    $id = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    responseQuery($db->delete('contact','id',$id),'delete','deleted');
    $db->redirectTo('contact/index.php');

}