<?php
include('DB.php');


class Auth
{
    private static $db;
    private static function db(){
        self::$db = new DB();
    }

    public static function user(){
        if(isset($_SESSION['name'],$_SESSION['id'])){
            Auth::db();
            return self::$db->find('users','id',$_SESSION['id']);
        }
    }
}