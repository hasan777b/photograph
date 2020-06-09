<?php
include ('backEnd/Class/Connection.php');
class migration{
    private $db,$db_name;
    public function __construct()
    {
        $this->db_name = $_ENV['DB_NAME'];
        $db = new Connection();
        $this->db = $db->getConnection();
    }

    /**
     * Create all tables at database
     * @return array
     */
    public function createTable(){
        $tables = $this->tableQuery();
        try{
            $result = $this->db->exec($tables);
            if($result === 0){
                return [" تیبل ها با موفقیت ساخته شدند",true];
            }else{
                return ["ساخت تیبل با مشکل مواجه شد ممکن است تیبل ها از قبل وجود داشته باشند یا دیتابیس دارای مشکل باشد",false];
            }
        }catch (PDOException $e){
            return [$e->getMessage(),false];
        }
    }

    /**
     * Empty tables
     * @param array $tables
     * @return array
     */
    public function truncate($tables){
        foreach ($tables as $table) {
            try {
                $result = $this->db->exec("TRUNCATE $this->db_name.$table");
                if ($result !== 0) {
                    return ["خالی کردن تیبل ها با مشکل مواجه شد به نظر تیبل {$table} دارای مشکل است",false];
                    break;
                }
            } catch (PDOException $e) {
                return [$e->getMessage(),false];
                break;
            }
        }
        return ["تمامی تیبل ها با موفقیت خالی شدند",true];
    }

    /**
     * Drop tables
     * @param array $tables
     * @return array
     */
    public function drop($tables){
        foreach ($tables as $table) {
            try {
                $result = $this->db->exec("DROP TABLE $this->db_name.$table");
                if ($result !== 0) {
                    return ["حذف تیبل ها با مشکل مواجه شد به نظر تیبل {$table} دارای مشکل است یا وجود ندارد",false];
                    break;
                }
            } catch (PDOException $e) {
                return [$e->getMessage(),false];
                break;
            }
        }
        return ["با موفقیت تمامی تیبل ها حذف شداند",true];
    }

    /**
     * Insert data in tables
     * @return array
     */
    public function seed(){
        $queries = $this->seedQueriesList();
        foreach ($queries as $query){
            try{
                $stmt = $this->db->prepare($query);
                $result = $stmt->execute();
                if($result == false){
                    return ["وارد کردن اطلاعات با مشکل مواجه شده است احتمالا دیتای فعلی تکراری است"."<br>".$query,false];
                    break;
                }
            }catch (PDOException $e){
                return [$e->getMessage(),false];
                break;
            }
        }
        return ["دیتاها با موفقیت وارد شدند",true];
    }

    /**
     * Change this file name
     */
    public function renameMigrationFile(){
        $platfrom = DIRECTORY_SEPARATOR === '\\' ? 'Win' : 'Linux';
        if ($platfrom == 'Win') {
            system('REN migration.php .migration.php');
        } else {
            system('mv migration.php .migration.php');
        }
        header("Location:".$_ENV['FULL_URL']."/register.php");
    }

    /**
     * Queries list for create table
     * @return string
     */
    private function tableQuery(){
        return "

        CREATE TABLE `$this->db_name`.`users` ( `id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL , `image` VARCHAR(100) NULL, PRIMARY KEY (`id`), UNIQUE (`username`)) ENGINE = MyISAM;
    
        CREATE TABLE `$this->db_name`.`permissions` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`name`)) ENGINE = MyISAM;
        
        CREATE TABLE `$this->db_name`.`permission_role` ( `id` INT NOT NULL AUTO_INCREMENT , `role_id` INT NOT NULL , `permission_id` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
        
        CREATE TABLE `$this->db_name`.`roles` ( `id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`, `name`)) ENGINE = MyISAM;
        
        CREATE TABLE `$this->db_name`.`role_user` ( `id` INT NOT NULL AUTO_INCREMENT , `role_id` INT NOT NULL , `user_id` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
    
        CREATE TABLE `$this->db_name`.`update_password` ( `id` INT NOT NULL AUTO_INCREMENT , `email` VARCHAR(100) NOT NULL , `code` VARCHAR(150) NOT NULL , PRIMARY KEY (`id`), UNIQUE (`email`)) ENGINE = MyISAM;

        CREATE TABLE `$this->db_name`.`categories` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `title` VARCHAR(150) NOT NULL , `position` INT(11) NOT NULL, `slug` VARCHAR(150) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
    
        CREATE TABLE `$this->db_name`.`gallery` ( `id` INT NOT NULL AUTO_INCREMENT , `category_id` INT(11) NOT NULL , `image` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
    
        CREATE TABLE `$this->db_name`.`captions` ( `id` INT NOT NULL AUTO_INCREMENT , `photo_id` INT(11) NOT NULL , `title` VARCHAR(100) NOT NULL , `description` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
    
        CREATE TABLE `$this->db_name`.`services` ( `id` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(100) NOT NULL , `price` INT NOT NULL , `image` VARCHAR(120) NOT NULL , `description` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
    
        CREATE TABLE `$this->db_name`.`partners` ( `id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(100) NOT NULL , `bio` TEXT NOT NULL , `image` VARCHAR(120) NULL , `instagram` VARCHAR(100) NULL , `twitter` VARCHAR(100) NULL , `facebook` VARCHAR(100) NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
    
        CREATE TABLE `$this->db_name`.`abouts` ( `id` INT NOT NULL AUTO_INCREMENT , `description` TEXT NOT NULL , `image` VARCHAR(120) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
    
    
        CREATE TABLE `$this->db_name`.`contacts` ( `id` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(120) NOT NULL , `lastname` VARCHAR(120) NOT NULL , `email` VARCHAR(120) NOT NULL , `subject` VARCHAR(120) NOT NULL , `message` TEXT NOT NULL , `answer` TEXT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
    
        CREATE TABLE `$this->db_name`.`config` ( `id` INT NOT NULL AUTO_INCREMENT , `phone` VARCHAR(16) NOT NULL , `email` VARCHAR(150) NOT NULL , `address` VARCHAR(150) NOT NULL , `instagram` VARCHAR(60) NOT NULL , `twitter` VARCHAR(60) NOT NULL , `facebook` VARCHAR(60) NOT NULL , `youtube` VARCHAR(60) NOT NULL , `footer` VARCHAR(255) NOT NULL , `logo` VARCHAR(120) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
    
        CREATE TABLE `$this->db_name`.`notifications` ( `id` INT NOT NULL AUTO_INCREMENT , `type` VARCHAR(100) NOT NULL , `data` TEXT NOT NULL , `read_at` TIMESTAMP NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;
    
        CREATE TABLE `$this->db_name`.`many_login` ( `id` INT NOT NULL AUTO_INCREMENT , `email` VARCHAR(255) NOT NULL , `end_time` VARCHAR(100) NOT NULL , PRIMARY KEY (`id`)) ENGINE = MyISAM;

        ";
    }

    /**
     * Queries list for insert
     * @return array
     */
    private function seedQueriesList(){
        $lorem = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est hic magnam numquam rem? A dolores expedita incidunt iusto officiis? Aut ea, earum nesciunt obcaecati officiis quod quos sunt tempora totam!";
        return [
            "INSERT INTO `permissions` (`id`, `name`) VALUES (NULL, 'show'), (NULL, 'create'), (NULL, 'update'), (NULL, 'delete')",
            "INSERT INTO `permission_role` (`id`, `role_id`, `permission_id`) VALUES (NULL, '1', '1'), (NULL, '1', '2'), (NULL, '1', '3'), (NULL, '1', '4'), (NULL, '2', '1'), (NULL, '2', '2'), (NULL, '2', '3'), (NULL, '3', '2'), (NULL, '3', '3'), (NULL, '4', '1'), (NULL, '4', '3'), (NULL, '5', '1'), (NULL, '5', '4'), (NULL, '6', '1')",
            "INSERT INTO `roles` (`id`, `name`) VALUES (NULL, 'manager'), (NULL, 'admin'), (NULL, 'author'), (NULL, 'editor'), (NULL, 'removal'), (NULL, 'observer')",
            "INSERT INTO `categories` (`id`, `title`, `position`, `slug`) VALUES (NULL, 'حیوانات', '1', 'حیوانات'), (NULL, 'ورزش ها', '2', 'ورزش-ها'), (NULL, 'طبیعت', '3', 'طبیعت')",
            "INSERT INTO `gallery` (`id`, `category_id`, `image`) VALUES (NULL, '1','uploader/gallery/gary-bendig-6GMq7AGxNbE-unsplash_1.jpg'), (NULL, '1','uploader/gallery/laura-college-K_Na5gCmh38-unsplash_1.jpg'), (NULL, '1','uploader/gallery/linnea-sandbakk-HQqIOc8oYro-unsplash_1.jpg'), (NULL, '1','uploader/gallery/raoul-croes-q4fxCjCj_GI-unsplash_1.jpg'), (NULL, '1','uploader/gallery/smit-patel-dGMcpbzcq1I-unsplash-(1)_1.jpg'), (NULL, '2','uploader/gallery/gentrit-sylejmani-JjUyjE-oEbM-unsplash_1.jpg'), (NULL, '2','uploader/gallery/john-arano-h4i9G-de7Po-unsplash_1.jpg'), (NULL, '2','uploader/gallery/jonathan-chng-3R4vPrSB1c4-unsplash_1.jpg'), (NULL, '2','uploader/gallery/markus-spiske-WUehAgqO5hE-unsplash_1.jpg'), (NULL, '2','uploader/gallery/serena-repice-lentini-hawN8XnaJuY-unsplash_1.jpg'), (NULL, '2','uploader/gallery/vince-fleming-aZVpxRydiJk-unsplash_1.jpg'), (NULL, '2','uploader/gallery/x-N4QTBfNQ8Nk-unsplash_1.jpg'), (NULL, '3','uploader/gallery/blake-richard-verdoorn-cssvEZacHvQ-unsplash_1.jpg'), (NULL, '3','uploader/gallery/lukasz-szmigiel-jFCViYFYcus-unsplash_1.jpg'), (NULL, '3','uploader/gallery/peter-jan-rijpkema-wI6o8OwUwdw-unsplash_1.jpg'), (NULL, '3','uploader/gallery/philipp-pilz-iQRKBNKyRpo-unsplash_1.jpg'), (NULL, '3','uploader/gallery/qingbao-meng-01_igFr7hd4-unsplash_1.jpg'), (NULL, '3','uploader/gallery/shifaaz-shamoon-oR0uERTVyD0-unsplash_1.jpg'), (NULL, '3','uploader/gallery/thomas-kelley-JoH60FhTp50-unsplash_1.jpg')",
            "INSERT INTO `captions` (`id`, `photo_id`,`title`,`description`) VALUES (NULL, '13','طبیعت 1','$lorem'), (NULL, '17','طبیعت 2','$lorem'), (NULL, '7','ورزش 1','$lorem'), (NULL, '8','ورزش 2','$lorem'), (NULL, '1','حیوانات 1','$lorem'), (NULL, '2','حیوانات 2','$lorem'), (NULL, '3','حیوانات 3','$lorem')",
            "INSERT INTO `partners` (`id`, `username`,`bio`,`image`,`instagram`,`twitter`,`facebook`) VALUES (NULL, 'Jean Smith','$lorem','uploader/partner/smith_1.jpg','@Smith','@Smith','@Smith'), (NULL, 'Claire Smith','$lorem','uploader/partner/claire_1.jpg','@claire','@claire','@claire'), (NULL, 'John Smith','$lorem','uploader/partner/john_1.jpg','@john','@john','@john')",
            "INSERT INTO `services` (`id`, `title`,`price`,`image`,`description`) VALUES (NULL, 'Camera','290000','uploader/services/cam_1.png','$lorem'), (NULL, 'Wedding Photography','460000','uploader/services/photography_1.png','$lorem'), (NULL, 'Animal','240000','uploader/services/animal_1.png','$lorem'), (NULL, 'Video Editing','150000','uploader/services/editing_1.png','$lorem')",
            "INSERT INTO `abouts` (`id`, `description`,`image`) VALUES (NULL, '$lorem', 'uploader/about/lukasz-szmigiel-jFCViYFYcus-unsplash_1.jpg')",
            "INSERT INTO `config` (`id`, `phone`,`email`,`address`,`instagram`,`twitter`,`facebook`,`youtube`,`footer`,`logo`) VALUES (NULL, '09907777777','photograph@gmail.com','ابران تهران','@photograph_instagram','@photograph_twitter','@photograph_facebook','@photograph_youtube','Copyright &copy;2020 All rights reserved |','uploader/config/cam_3.png')",
        ];
    }

}
$tablesList = [
    'users','permissions','permission_role','roles','role_user','update_password','categories','gallery','captions',
    'services','partners','abouts','contacts','config','notifications','many_login'
];
$migration = new migration();
$message = '';
if(isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        $message = $migration->drop($tablesList)[0];
    } elseif ($_GET['action'] == 'create') {
        $message = $migration->createTable()[0];

    } elseif ($_GET['action'] == 'empty') {
        $message = $migration->truncate($tablesList)[0];

    } elseif ($_GET['action'] == 'insert') {
        $message = $migration->seed()[0];

    } elseif ($_GET['action'] == 'file') {
        $migration->renameMigrationFile();
    } elseif ($_GET['action'] == 'all') {
        $create = $migration->createTable();
        if($create[1] != false) {
            $message = $create[0];
            $truncate = $migration->truncate($tablesList);
            if($truncate[1] != false) {
                $message = $truncate[0];
                $seed = $migration->seed();
                if($seed[1] != false) {
                    $message = $seed[0];
                    $migration->renameMigrationFile();
                }else{
                    $message = $seed[0];
                }
            }else{
                $message = $truncate[0];
            }
        }else{
            $message = $create[0];
        }
    }else {
        $message = "عملیات نا معتبر است";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/photograph/assets/css/bootstrap.min.css">
    <title><?php echo $_ENV['APP_NAME']; ?></title>
</head>
<body>
    <div>
        <h2 style="margin: 10px" class="header-title">عملیات برای دیتابیس</h2>
        <h5 style="margin: 0px 10px 0px 10px;color:red;">توجه کنید این فایل دارای اهمیت زیادی است بعد از انجام کارهای خود روی دکه حذف فایل کلیک کنید</h5><br>
        <h5 style="direction: rtl;margin: 0px 10px 0px 10px;color:red">بعد ار کلیک روی دکمه حذف فایل نام این فایل به " migration.php. " تغییر خواهد کرد و برای دسترسی دوباره به ان باید نام ان را به " migration.php " تغییر دهید</h5><br>
    </div>
    <div>
        <h4 style="margin: 8px; direction: rtl;"><?php echo $message ?></h4>
    </div>
    <br>
    <div class="row col-sm-12">
        <div class="col-sm-2">
            <a href="?action=delete" class="col-sm-12 btn btn-danger">حذف تمامی تیبل ها</a>
        </div>
        <div class="col-sm-2">
            <a href="?action=create" class="col-sm-12 btn btn-success">ساخت تیبل ها</a>
        </div>
        <div class="col-sm-2">
            <a href="?action=empty" class="col-sm-12 btn btn-warning">خالی کردن تیبل ها</a>
        </div>
        <div class="col-sm-2">
            <a href="?action=insert" class="col-sm-12 btn btn-info">وارد کردن دیتا</a>
        </div>
        <div class="col-sm-2">
            <a href="?action=file" class="col-sm-12 btn btn-dark">حذف فایل</a>
        </div>
        <div class="col-sm-2">
            <a href="?action=all" class="col-sm-12 btn btn-primary">اجرای خود کار تمامی موارد</a>
        </div>
    </div>

</body>
</html>
