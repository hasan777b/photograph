<?php
session_start();
if(file_exists('../backEnd/Class/Auth.php')){
    include('../backEnd/Class/Auth.php');
}elseif(file_exists('backEnd/Class/Auth.php')){
    include('backEnd/Class/Auth.php');
}else{
    include('../../backEnd/Class/Auth.php');
}
function getUser(){
    $db = new DB();
    return $db->getOneRow('users');
}

function checkCookie(){
    if(!isset($_SESSION['name'], $_SESSION['id'])) {
        if (!empty($_COOKIE['user'])) {
            $db = new DB();
            $user = $db->find('users', 'email', $_COOKIE['user']);
            $_SESSION['id'] = $user->id;
            $_SESSION['name'] = $user->username;
        }
    }
}
// check for login user
function is_login(){
    if(!empty(getUser())) {
        checkCookie();
        if (isset($_SESSION['name'], $_SESSION['id'])) {
            return true;
        } else {
            return false;
        }
    }else{
        return false;
    }
}

// log out user
function logOut(){
    if(isset($_SESSION['name'],$_SESSION['id'])){
        unset($_SESSION['name'],$_SESSION['id']);
    }else{
        $user = Auth::user();
        setcookie($user->name,$user->email,time()-3600);
    }

    header('Location: /photograph/login.php');
}

// Auto logout user after 3 hover
function logOutAfterTime(){
    if((isset($_SESSION['logoutTime']) and $_SESSION['logoutTime'] < time()) == true){
        unset($_SESSION['logoutTime']);
        logOut();
    }else{
        $_SESSION['logoutTime'] = time()+3*60*60;
    }
}
// unset session
function _unset($value){
    unset($_SESSION[$value]);
}


function renderPaginate($total_page,$page){
    $page = preg_replace("/[^0-9]/",'',$page);
    $paginate = '<nav aria-label="Page navigation example"><ul class="pagination justify-content-end">';
    $previous = $page - 1;
    if($page > 1) {
        $paginate .= '<li class="page-item"><a class="page-link" href="?page='.$previous.' " tabindex="-1">قبلی</a></li>';
    }else{
        $paginate .= '<li class="page-item disabled"><a class="page-link" tabindex="-1" disabled>قبلی</a></li>';
    }
    for($i=1; $i<= $total_page; $i++){
        $paginate.='<li class="page-item"><a class="page-link"';
        if($i==$page){
            $paginate .= 'style="background-color: #141119;"';
        }
        $paginate .= 'href="?page='.$i.'">'.$i.'</a></li>';
    }
    $next = $page + 1;
    if($total_page > $page) {
        $paginate .= '<li class="page-item"><a class="page-link" href="?page='.$next.'" tabindex="-1">بعدی</a></li>';
    }else{
        $paginate .= '<li class="page-item disabled"><a class="page-link" tabindex="-1" disabled>بعدی</a></li>';
    }
    $paginate.='</ul></nav>';
    return $paginate;

}

// show error message
function errorMessage(){
    if(isset($_SESSION['create']) and $_SESSION['create'] == 'created') {
        _unset('create');
        return '<div class="alert alert-success text-center">با موفقیت ثبت شد</div>';
    }
    elseif(isset($_SESSION['update']) and $_SESSION['update'] == 'updated') {
        _unset('update');
        return '<div class="alert alert-success text-center">با موفقیت ویرایش شد</div>';
    }
    elseif(isset($_SESSION['delete']) and $_SESSION['delete'] == 'deleted') {
        _unset('delete');
        return '<div class="alert alert-success text-center">با موفقیت حذف شد</div>';
    }elseif(isset($_SESSION['message'])){
        $m = $_SESSION['message'];
        _unset('message');
        return '<div class="alert alert-warning text-center">'.$m.'</div>';
    }
    elseif(isset($_SESSION['email']) and $_SESSION['email'] == 'ok'){
        _unset('email');
        return '<div class="alert alert-success text-center">پاسخ با موفقیت ارسال شد</div>';
    }elseif(isset($_SESSION['email']) and $_SESSION['email'] == 'error'){
        _unset('email');
        return '<div class="alert alert-danger text-center">پاسخ با ارسال نشد به نظر در سرور مشکلی پیش امده است</div>';
    }
    elseif(isset($_SESSION['passwordBad']) and $_SESSION['passwordBad'] == 'error'){
        _unset('passwordBad');
        return '<div class="alert alert-danger text-center">پسورد قبلی اشتباه است</div>';
    }
    elseif(isset($_SESSION['error']) and $_SESSION['error'] == 'error') {
        _unset('error');
        return '<div class="alert alert-danger text-center">مشکلی پیش  امده است بعدا امتحان کنید</div>';
    }
}

// show error input
function errorInput($filed){
    $filed_ = isset($_SESSION[$filed]) ? $_SESSION[$filed] : false;
    if($filed_) {
        _unset($filed);
        return '<strong>' . $filed_ . '</strong>';
    }
}

function pathBackend(){
    return '../../backEnd/functions/backEndFunctions/';
}

function config(){
    $db = new DB();
    return $db->getOneRow('config');
}

function pathImage($image){
    return '/photograph/backEnd/'.$image;
}
