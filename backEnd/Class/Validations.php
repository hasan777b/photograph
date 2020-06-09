<?php
session_start();

class Validations
{
    /**
     * validation data
     * @param array $validation
     * @param array $datas
     * @return bool
     */
    public static function validate($validation, $datas){
        $ch = false;
        foreach ($datas as $key=>$data){
            foreach ($validation as $validate){
                if(in_array($key, array_keys($validate))){
                    $_SESSION[$key] = self::check($validate[$key],$data, $key);
                    if(isset($_SESSION[$key]))
                        $ch = true;
                }
            }
        }
        return $ch;
    }


    /**
     * check validation value
     * @param array $data
     * @param string $value
     * @param string $key
     * @return string
     */
    private static function check($data, $value, $key){
        foreach ($data as $d){
            $k = self::convertKey($key);
            if($d == 'required'){
                if(empty($value))
                    return "فیلد $k نمیتواند خالی باشد";
            }elseif(strstr($d,':')){
                $str = explode(':',$d);
                if($str[0] == 'max'){
                    if($str[1] < strlen($value))
                        return "فیلد ".$k." نباید بزرگتر از ".$str[1]." کاراکتر باشد ";
                }elseif($str[0] == 'min'){
                    if($str[1] > strlen($value))
                        return "فیلد ".$k." نباید کوچکتر از ".$str[1]." کاراکتر باشد ";
                }
            }elseif ($d == 'email'){
                if(!filter_var($value,FILTER_VALIDATE_EMAIL)){
                    return "$k وارد شده معتبر نیست";
                }
            }elseif($d == 'numeric'){
                if(!is_numeric($value)){
                    return "مقدار فیلد $k عدد نیست";
                }
            }elseif ($d == 'string'){
                if(!is_string($value)){
                    return "مقدار فیلد $k رشته نیست";
                }
            }
        }
    }

    /**
     * convert english key to persian
     * @param string $key
     * @return string
     */
    private static function convertKey($key){
        if($key == 'email')
            return 'ایمیل';
        if($key == 'password')
            return 'پسورد';
        if($key == 'title')
            return 'عنوان';
        if($key == 'position')
            return 'مکان';
        if($key == 'description')
            return 'توضیحات';
        if($key == 'price')
            return 'قیمت';
        if($key == 'answer')
            return 'پاسخ';
        if($key == 'access')
            return 'سطح دسترسی';
        if($key == 'username')
            return 'نام کاربری';
        if($key == 'lastname')
            return 'نام خانوادگی';
        if($key == 'subject')
            return 'موضوع';
        if($key == 'message')
            return 'پیام';
    }

}