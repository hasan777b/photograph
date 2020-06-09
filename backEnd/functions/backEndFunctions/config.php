<?php

include('../../Class/filterInput.php');
include('../../Class/Validations.php');
include('../../Class/Upload.php');
include('../../Class/DB.php');
$db = new DB();
function validated($data){
    return Validations::validate( [ ['phone'=>['required','numeric','max:15']],['email'=>['email','required']],['address'=>['required','string','min:3','max:150']],
        ['footer'=>['required','string','min:5','max:254']],['instagram'=>['max:59','string']],['twitter'=>['max:59','string']],['facebook'=>['max:59','string']],['youtube'=>['max:59','string']] ] ,$data);
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
if(isset($_POST['create'])){
    sunset('create');
    $_POST = filter($_POST);
    if(!empty($_FILES['logo']['name'])) {
        if (validated($_POST) == false) {
            $upload = new Upload($_FILES, '/photograph/backEnd/uploader/','config/');
            $upload->setSize(4000);
            $upload->startMove();
            $message = $upload->getMessage();
            if (empty($message)) {
                $_POST['logo'] = $upload->getPath()[0];
                responseQuery($db->insert('config', ['phone', 'email','address','instagram','twitter','facebook','youtube','footer','logo'], $_POST), 'create', 'created');
                $db->redirectTo('config/index.php');
            } else {
                $_SESSION['message'] = $message;
                $db->redirectTo('config/create.php');
            }
        }else{
            $db->redirectTo('config/create.php');
        }
    }else{
        $_SESSION['message'] = "تصویری انتخاب نشده است";
        $db->redirectTo('config/create.php');
    }
}

if(isset($_POST['update'])){
    sunset('update');
    $filter = filter($_POST);
    $_POST['id'] = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    $photo = $db->find('config','id',$_POST['id']);
    $_POST['logo'] = $photo->logo;
    if(validated($_POST) == false) {
        if(!empty($_FILES['logo']['name'])){
            $upload = new Upload($_FILES, '/photograph/backEnd/uploader/','config/');
            $upload->setSize(4000);
            $upload->startMove();
            $message = $upload->getMessage();
            if(empty($message)){
                Iunlink('../../../backEnd/'.$photo->logo);
                $_POST['logo'] = $upload->getPath()[0];
            }else{
                $_SESSION['message'] = $message;
                $db->redirectTo('config/update.php/'.$_POST['id']);
            }
        }
        responseQuery($db->update('config',['phone', 'email','address','instagram','twitter','facebook','youtube','footer','logo'],$_POST),'update','updated');
    }
    $db->redirectTo('config/update.php/'.$_POST['id']);
}
