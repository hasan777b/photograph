<?php
require('Connection.php');

class DB
{
    private $con;
    public function __construct(){

        $pdo = new Connection();
        $this->con = $pdo->getConnection();
    }

    /**
     * Get on row in table
     * @param string $table
     * @param array|string $columns
     * @return mixed
     */
    public function getOneRow($table, $columns='*'){
        if(is_array($columns)){
            $columns = '`'.implode('`',$columns).'`';
        }
        $stmt = $this->con->prepare("SELECT $columns FROM `$table` LIMIT 0,1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * get all data;
     * @param $table
     * @param bool $latest
     * @param string $limit
     * @param string $groupOrOrderBy
     * @return mixed
     */
    public function get($table, $latest=false, $limit='',$groupOrOrderBy = null){
        $latest = $latest ? 'ORDER BY `id` DESC' : '';
        $stmt = $this->con->prepare("SELECT * FROM `$table` $groupOrOrderBy $latest $limit");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    /**
     * Find data in table
     * @param string $table
     * @param string $column
     * @param string $value
     * @param boolean $limit
     * @return mixed
     */
    public function find($table, $column, $value, $limit = true){
        $limit = $limit ? 'LIMIT 0,1' : '';
        $stmt = $this->con->prepare("SELECT * FROM `$table` WHERE `$column`=:$column $limit");
        $stmt->bindParam($column, $value);
        $stmt->execute();
        return $limit ? $stmt->fetch(PDO::FETCH_OBJ) : $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Find rows are null
     * @param $table
     * @param $column
     * @param bool $limit
     * @return mixed
     */
    public function findNull($table, $column, $limit = true){
        $limit = $limit ? 'LIMIT 0,1' : '';
        $stmt = $this->con->prepare("SELECT * FROM `$table` WHERE ISNULL(`$column`) $limit");
        $stmt->execute();
        return $limit ? $stmt->fetch(PDO::FETCH_OBJ) : $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * find manual condition
     * @param string $table
     * @param string $condition
     * @return mixed
     */
    public function where($table, $condition){
        $stmt = $this->con->prepare("SELECT * FROM `$table` WHERE $condition");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * for pagination data
     * @param string $table
     * @param bool $latest
     * @param int $page
     * @param int $per_page
     * @param null $groupBy
     * @return array
     */
    public function paginate($table, $latest=false, $page=0, $per_page=10, $groupBy=null){
        $res = $this->get($table,false,'',$groupBy);
        $total_page = ceil(count($res) / $per_page);
        if($page > $total_page){
            $fixPage = 0;
        }elseif($page < 0){
            $fixPage = 0;
        }else{
            $fixPage = $page;
        }
        $latest = $latest ? 'ORDER BY `id` DESC' : '';
        $query = $this->con->prepare("SELECT * FROM `{$table}` {$groupBy} {$latest} LIMIT {$fixPage},{$per_page}");
        $query->execute();
        return ['results'=>$query->fetchAll(\PDO::FETCH_OBJ),'total_page'=>$total_page];
    }

    /**
     * get count data
     * @param string $table
     * @return int
     */
    public function countData($table){
        return count($this->get($table));
    }
    /**
     * Insert Data In Database
     * @param array $columns
     * @param array $values
     * @param string $table
     * @return
     */
    public function insert($table,$columns, $values, $lastInsert = false){
        $values = array_values($values);
        $bind = ':'.implode(",:",$columns);
        $fixColumns = '`'.implode('`,`',$columns).'`';
        $stmt = $this->con->prepare("INSERT INTO `$table` ($fixColumns) VALUES ($bind)");
        foreach ($columns as $key=>$column){
            $stmt->bindParam($column,$values[$key]);
        }
        $data = $stmt->execute();
        if($lastInsert == true){
            return $this->find($table,'id',$this->con->lastInsertId());
        }

        return $data;
    }

    /**
     * @param string $table
     * @param array $columns
     * @param array $values
     * @param boolean $lastInsertId
     * @return mixed
     */
    public function update($table, $columns, $values){
        $id = $values['id'];unset($values['id']);
        $values = array_values($values);
        $columnAndValue = null;
        foreach ($columns as $key=>$column){
            $columnAndValue .= "`$column` = :$column";
            $columnAndValue .= $key < count($values)-1 ? ", " : '';
        }
        $stmt = $this->con->prepare("UPDATE `$table` SET $columnAndValue WHERE `id`=:id");
        foreach ($columns as $key=>$column){
            $stmt->bindParam($column,$values[$key]);
        }
        $stmt->bindParam('id',$id);
        return $stmt->execute();

    }
    /**
     * Delete data in database
     * @param string $table
     * @param string $column
     * @param string $value
     * @return mixed
     */
    public function delete($table, $column, $value){
        $stmt = $this->con->prepare("DELETE FROM `$table` WHERE `$column`=:$column");
        $stmt->bindParam($column, $value);
        return $stmt->execute();
    }


    /**
     * create slug
     * @param string $value
     * @return mixed
     */
    public function slug($value){
        return str_replace(' ','-',$value);
    }

    /**
     * delete string on url
     * @param $param
     * @return string|string[]|null
     */
    public function fixParameterUrl($param,$op = ''){
        if(empty($op))
            $fixedParam = preg_replace("/[^0-9]/",'',$param);
        elseif($op == 'string')
            $fixedParam = str_replace("/",'',$param);
        return $fixedParam;
    }

    /**
     * redirect to panel path
     * @param string $path
     */
    public function redirectTo($path){
        header("Location: /photograph/panel/".$path);
    }
}