<?php

include('../../Class/filterInput.php');
include('../../Class/Validations.php');
include('../../Class/DB.php');
$db = new DB();
function validated($data){
    return Validations::validate( [ ['title'=>['required','max:99','min:5']],['description'=>['required','string']] ] ,$data);
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

function param(){
    global $db;
    $path = explode('/',$_SERVER['PATH_INFO']);
    $id_one = $db->fixParameterUrl($path[1]);
    $id_tow = $db->fixParameterUrl($path[2]);
    return [$id_one,$id_tow];
}

if(isset($_POST['create'])){
    sunset('create');
    $_POST = filter($_POST);
    $_POST['photo_id'] = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    if( validated($_POST) == false) {
        responseQuery($db->insert('captions',['title','description','photo_id'],$_POST),'create','created');
        $db->redirectTo('gallery/index.php');
    }else{
        $db->redirectTo('gallery/add_caption.php/'.$_POST['photo_id']);
    }

}

if(isset($_POST['update'])){
    sunset('update');
    $_POST = filter($_POST);
    [$_POST['id'],$_POST['photo_id']] = param();
    if(validated($_POST) == false) {
        responseQuery($db->update('captions',['title','description','photo_id'],$_POST),'update','updated');
        $db->redirectTo('gallery/update_caption.php/'.$_POST['id'].'/'.$_POST['photo_id']);
    }
    $db->redirectTo('gallery/update_caption.php/'.$_POST['id'].'/'.$_POST['photo_id']);
}

if(isset($_POST['delete'])){
    $path = explode('/',$_SERVER['PATH_INFO']);
    [$id, $category_id] = param();
    responseQuery($db->delete('captions','id',$id),'delete','deleted');
    $db->redirectTo('gallery/show.php/'.$category_id);

}