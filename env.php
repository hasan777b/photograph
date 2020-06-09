<?php
    // ممواردی که جلوی انها توضیح توشته شده است میتوانید با اطلاعات خود جایگزین کنید
    $_ENV['URL'] = "http://localhost:8080/";//localhohost path and port
    $_ENV['FULL_URL'] = "http://localhost:8080/photograph";//path project
    $_ENV['APP_NAME'] = 'گالری عکس';
    $_ENV['DB_HOST'] = 'localhost';
    $_ENV['DB_NAME'] = 'photograph'; // Database name
    $_ENV['DB_USERNAME'] = 'root'; // Database username
    $_ENV['DB_PASSWORD'] = ''; // Database password

    $_ENV['HOST']='smtp.gmail.com';
    $_ENV['USERNAME']='';// your gmail address
    $_ENV['PASSWORD']=''; // your gmail password 
    $_ENV['PORT']=587;
    $_ENV['FROM']=$_ENV['USERNAME'];
?>