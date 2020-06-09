<?php
require('DB.php');
class Login
{
    private $password, $email,$db,$remember;
    public function __construct($email, $password, $remember='off'){
        $this->email = $email;
        $this->remember = $remember;
        $this->password = $password;
        $this->db = new DB();
    }

    // Login User
    public function login(){
        if($this->checkLoginCount()){

            $user = $this->db->find('users','email',$this->email);
            if($this->checkUser($user)){
                $_SESSION['loginCount'] = 1;
                header("Location: /photograph/panel/index.php");
            }else{
                header("Location: /photograph/login.php");
            }
        }else{
            unset($_SESSION['login']);
            $_SESSION['manyLogin'] = 'ok';
            header("Location: /photograph/login.php");
        }

    }

    private function checkUser($user){
        if($this->email == $user->email and password_verify($this->password, $user->password)){
            if($this->remember == 'on'){
                setcookie('user',$user->email,time()+86400*2,'/');
            }
            $_SESSION['id']=$user->id;
            $_SESSION['name']=$user->username;
            return true;
        }else{
            $_SESSION['login'] = 'error';
            return false;
        }
    }

    private function checkLoginCount(){
        $manyLogin = $this->db->find('many_login','email',$this->email);
        if(empty($manyLogin)) {
            if ($_SESSION['loginCount'] > 5) {
                $result = $this->db->insert('many_login',['email','end_time'],[$this->email,time()+30*30]);
                $result == true ? $_SESSION['loginCount'] = 1 : '';
                return false;
            }else{
                $_SESSION['loginCount'] += 1;
                return true;
            }
        }else{
            if(time() > $manyLogin->end_time){
                $result = $this->db->delete('many_login','email',$this->email);
                $_SESSION['loginCount'] = 1;
                unset($_SESSION['manyLogin']);
                return true;
            }
            return false;
        }
    }
}