<?php

class ACL
{
    private static $permission;

    /**
     * Join to table role_user and roles for get permission
     */
    private static function getPerm($id=null)
    {
        if(isset($_SESSION['id'])){
            $id = is_null($id) ? $_SESSION['id'] : $id;
            $pdo = new Connection();
            $con = $pdo->getConnection();
            $stmt = $con->prepare("SELECT * FROM `role_user` LEFT JOIN `roles` ON roles.id = role_user.role_id WHERE role_user.user_id = :id");
            $stmt->bindParam('id',$id);
            $stmt->execute();
            self::$permission = $stmt->fetch(PDO::FETCH_OBJ);
        }
    }

    /**
     * check access
     * @param string $access
     * @return bool
     */
    private static function checkAccess($access){
        self::getPerm();
        return self::$permission->name == $access ? true : false;
    }

    /**
     * this access for manager
     * @return bool
     */
    public static function manager(){
        return self::checkAccess('manager');
    }

    /**
     * this access for admin
     * @return bool
     */
    public static function admin(){
        return self::checkAccess('admin');
    }

    /**
     * this access for author
     * @return bool
     */
    public static function author(){
        return self::checkAccess('author');
    }

    /**
     * this access editor
     * @return bool
     */
    public static function editor(){
        return self::checkAccess('editor');
    }

    /**
     * this access for delete data
     * @return bool
     */
    public static function removal(){
        return self::checkAccess('removal');
    }

    /**
     * this access for show data
     * @return bool
     */
    public static function observer(){
        return self::checkAccess('observer');
    }

    /**
     * Anyone who has access to inserting
     * @return bool
     */
    public static function create(){
        return self::manager() or self::admin() or self::author();
    }

    /**
     * Anyone who has access to updating
     * @return bool
     */
    public static function update(){
        return self::create() or self::editor();
    }

    /**
     * Anyone who has access to deleting
     * @return bool
     */
    public static function delete(){
        return self::manager() or self::removal();
    }

    public static function getAccessName($id){
        self::getPerm($id);
        $access = self::$permission->name;
        switch ($access){
            case 'manager' :
                $name = 'مدیر';
                break;
            case 'admin' :
                $name = 'ادمین';
                break;
            case 'author' :
                $name = 'نویسنده';
                break;
            case 'editor' :
                $name = 'ویرایشگر';
                break;
            case 'removal' :
                $name = 'حذف کننده';
                break;
            case 'observer' :
                $name = 'مشاهده کننده';
                break;
        }

        return $name;
    }

}