<?php

include('../../Class/filterInput.php');
include('../../Class/Validations.php');
include('../../Class/Upload.php');
include('../../Class/DB.php');
$db = new DB();
function validated($data){
    return Validations::validate( [ ['title'=>['required','max:99','min:2','string']],['price'=>['required','numeric']],['description'=>['required','string']] ] ,$data);
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
    if(!empty($_FILES['image']['name'])) {
        if (validated($_POST) == false) {
            $upload = new Upload($_FILES, '/photograph/backEnd/uploader/','services/');
            $upload->setSize(4000);
            $upload->startMove();
            $message = $upload->getMessage();
            if (empty($message)) {
                $_POST['image'] = $upload->getPath()[0];
                responseQuery($db->insert('services', ['title', 'price','description','image'], $_POST), 'create', 'created');
            } else {
                $_SESSION['message'] = $message;
            }
        }
    }else{
        $_SESSION['message'] = "تصویری انتخاب نشده است";
    }
    $db->redirectTo('service/create.php');
}

if(isset($_POST['update'])){
    sunset('update');
    $filter = filter($_POST);
    $_POST['id'] = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    $photo = $db->find('services','id',$_POST['id']);
    $_POST['image'] = $photo->image;
    if(validated($_POST) == false) {
        if(!empty($_FILES['image']['name'])){
            $upload = new Upload($_FILES, '/photograph/backEnd/uploader/','services/');
            $upload->setSize(4000);
            $upload->startMove();
            $message = $upload->getMessage();
            if(empty($message)){
                Iunlink('../../../backEnd/'.$photo->image);
                $_POST['image'] = $upload->getPath()[0];
            }else{
                $_SESSION['message'] = $message;
                $db->redirectTo('service/update.php/'.$_POST['id']);
            }
        }
        responseQuery($db->update('services',['title', 'price','description','image'],$_POST),'update','updated');
    }
    $db->redirectTo('service/update.php/'.$_POST['id']);
}

if(isset($_POST['delete'])){
    $id = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    $service = $db->find('services','id',$id);
    Iunlink('../../../backEnd/'.$service->image);
    responseQuery($db->delete('services','id',$id),'delete','deleted');
    $db->redirectTo('service/index.php');

}