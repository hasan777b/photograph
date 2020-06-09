<?php

include('../../Class/filterInput.php');
include('../../Class/Validations.php');
include('../../Class/Upload.php');
include('../../Class/DB.php');
$db = new DB();
function validated($data){
    return Validations::validate( [ ['category_id'=>['required','numeric']] ] ,$data);
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
    if(!empty($_FILES['images']['name'][0])) {
        if (validated($_POST) == false) {
            $upload = new Upload($_FILES, '/photograph/backEnd/uploader/','gallery/');
            $upload->setSize(6000);
            $upload->startMove();
            $message = $upload->getMessage();
            if (empty($message)) {
                foreach ($upload->getPath() as $path) {
                    $_POST['image'] = $path;
                    responseQuery($db->insert('gallery', ['category_id', 'image'], $_POST), 'create', 'created');
                }
            } else {
                $_SESSION['message'] = $message;
            }
        }
    }else{
        $_SESSION['message'] = "تصویری انتخاب نشده است";
    }
    $db->redirectTo('gallery/create.php');
}

if(isset($_POST['update'])){
    sunset('update');
    $filter = filter($_POST);
    $_POST['id'] = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    $photo = $db->find('gallery','id',$_POST['id']);
    $_POST['image'] = $photo->image;
    if(validated($_POST) == false) {
        if(!empty($_FILES['image']['name'])){
            $upload = new Upload($_FILES, '/photograph/backEnd/uploader/','gallery/');
            $upload->setSize(6000);
            $upload->startMove();
            $message = $upload->getMessage();
            if(empty($message)){
                Iunlink('../../../backEnd/'.$photo->image);
                $_POST['image'] = $upload->getPath()[0];
            }else{
                $_SESSION['message'] = $message;
                $db->redirectTo('gallery/update.php/'.$_POST['id']);
            }
        }
        responseQuery($db->update('gallery',['category_id','image'],$_POST),'update','updated');
    }
    $db->redirectTo('gallery/update.php/'.$_POST['id']);
}

if(isset($_POST['delete'])){
    $category_id = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    $photos = $db->find('gallery','category_id',$category_id,false);
    foreach ($photos as $photo){
        $db->delete('captions','photo_id',$photo->id);
        Iunlink('../../../backEnd/'.$photo->image);
    }
    responseQuery($db->delete('gallery','category_id',$category_id),'delete','deleted');
    $db->redirectTo('gallery/index.php');

}

