<?php

include('../../Class/filterInput.php');
include('../../Class/Validations.php');
include('../../Class/Upload.php');
include('../../Class/DB.php');
$db = new DB();
function validated($data){
    return Validations::validate( [ ['username'=>['required','max:99','min:2','string']],['bio'=>['required']]] ,$data);
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

    if (validated($_POST) == false) {
        if(!empty($_FILES['image']['name'])) {
            $upload = new Upload($_FILES, '/photograph/backEnd/uploader/','partner/');
            $upload->setSize(4000);
            $upload->startMove();
            $message = $upload->getMessage();
            if (empty($message)) {
                $_POST['image'] = $upload->getPath()[0];
            } else {
                $_SESSION['message'] = $message;
            }
        }
    }
    responseQuery($db->insert('partners', ['username', 'bio','instagram','twitter','facebook','image'], $_POST), 'create', 'created');
    $db->redirectTo('partner/create.php');
}

if(isset($_POST['update'])){
    sunset('update');
    $filter = filter($_POST);
    $_POST['id'] = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    $photo = $db->find('partners','id',$_POST['id']);
    $_POST['image'] = $photo->image;
    if(validated($_POST) == false) {
        if(!empty($_FILES['image']['name'])){
            $upload = new Upload($_FILES, '/photograph/backEnd/uploader/','partner/');
            $upload->setSize(4000);
            $upload->startMove();
            $message = $upload->getMessage();
            if(empty($message)){
                Iunlink('../../../backEnd/'.$photo->image);
                $_POST['image'] = $upload->getPath()[0];
            }else{
                $_SESSION['message'] = $message;
                $db->redirectTo('partner/update.php/'.$_POST['id']);
            }
        }
        responseQuery($db->update('partners', ['username', 'bio','instagram','twitter','facebook','image'],$_POST),'update','updated');
    }
    $db->redirectTo('partner/update.php/'.$_POST['id']);
}

if(isset($_POST['delete'])){
    $id = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    $partner = $db->find('partners','id',$id);
    Iunlink('../../../backEnd/'.$partner->image);
    responseQuery($db->delete('partners','id',$id),'delete','deleted');
    $db->redirectTo('partner/index.php');

}