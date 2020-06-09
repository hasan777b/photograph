<?php
include($_SERVER['DOCUMENT_ROOT'].'/photograph/env.php');
class Connection
{
    private $connection;

    public function __construct(){
        $this->connection = $this->_connection();
    }

    /**
     * getter method for connection
     * @return mixed
     */
    public function getConnection(){
        return $this->connection;
    }

    /**
     * create connection
     * @return PDO
     */
    private function _connection(){
        try {
            unset($this->connection);
            !defined('HOST') ? define('HOST',$_ENV['DB_HOST']) : '';
            !defined('DATABASE') ? define('DATABASE',$_ENV['DB_NAME']) : '';
            !defined('USERNAME') ? define('USERNAME',$_ENV['DB_USERNAME']) : '';
            !defined('PASSWORD') ? define('PASSWORD',$_ENV['DB_PASSWORD']) : '';
            return new \PDO("mysql:host=".HOST.";dbname=".DATABASE.";charset=utf8", USERNAME, PASSWORD);
        }catch (\PDOException $e){
            die('مشکلی رخ داده است بعدا امتحان کنید');
        }
    }


}
