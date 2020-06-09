<?php

include('../../Class/filterInput.php');
include('../../Class/Validations.php');
include('../../Class/DB.php');
$db = new DB();
function validated($data){
    return Validations::validate( [ ['title'=>['required','max:70','min:2']],['position'=>['required','numeric']] ] ,$data);
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

if(isset($_POST['create'])){
    sunset('create');
    $_POST = filter($_POST);
    if( validated($_POST) == false) {
        $_POST['slug']=$db->slug($_POST['title']);
        responseQuery($db->insert('categories',['title','position','slug'],$_POST),'create','created');
    }
    $db->redirectTo('category/create.php');
}

if(isset($_POST['update'])){
    sunset('update');
    $_POST = filter($_POST);
    $_POST['id'] = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    if(validated($_POST) == false) {
        $_POST['slug']=$db->slug($_POST['title']);
        responseQuery($db->update('categories',['title','position','slug'],$_POST),'update','updated');
        $db->redirectTo('category/update.php/'.$_POST['id']);
    }
    $db->redirectTo('category/update.php/'.$_POST['id']);
}

if(isset($_POST['delete'])){
    $id = $db->fixParameterUrl($_SERVER['PATH_INFO']);
    responseQuery($db->delete('categories','id',$id),'delete','deleted');
    $db->redirectTo('category/category.php');

}