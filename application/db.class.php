<?php

class db {

    private static  $con = null;
    private static $isTransaction=false;
    
    private $buildQuery=null;
    
    public function __construct() {
        $this->openConnect();
    }

    private function openConnect() {
       
      
        $dsn = 'mysql:dbname=roma;host=localhost';
        $user = 'root';
        $password = '';
        if (self::$con != null)
            return;
        try {
            self::$con = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
      
      

    }

    private function closeConnect() {
                     
    }
    
    protected function beginTransaction(){
         self::$con->beginTransaction();  
         self::$isTransaction = true;
    }
    
    protected function commitTransaction(){
       self::$con->commit();
       self::$isTransaction = false;
    }
    
    protected function rollbackTransaction(){
        
        self::$con->rollBack();
        self::$isTransaction = false;

    }

    protected function executeNoneQuery($query= null) {
        if ($query == null)
        {
            $stmt = self::$con->prepare($this->buildQuery);
        }
        else {
            $stmt = self::$con->prepare($query);
        }
        
      return $stmt->execute();
    }

   

    protected function excuteAffectedRows($query) {
        
        if (!self::$isTransaction)
            $this->openConnect();
    
        $result = sqlsrv_query(self::$con,$query);
        $num = 0;
        if (!$result) {
            return $result;
        } else {
            $num = sqlsrv_rows_affected($result);
        }
        
        return $num;
    }

    protected function fetch($query =null,$fetch_type=PDO::FETCH_OBJ) {
        global  $registry;
        
        if ( isset($registry->isDebug) )
            die($this->buildQuery);
        if ($query == null)
       {
           
            $stmt =  self::$con->query($this->buildQuery);
            $this->buildQuery= null;
       }
           else
        $stmt =  self::$con->query($query);
      //  self::$con->execute();
      try {
      
          return $stmt->fetchAll($fetch_type);
      } catch (Exception $exc) {
          echo $exc->getTraceAsString();
      }
      return null;
        
    }
    
    protected  function insert($table, $array)
    {
        $name_field="";
        $value_field ="";
        if ($array == null || count($array) == 0)
        {
            return null;
        }
        
        foreach ($array as $key => $value) {
            if ($name_field != "")
                $name_field .=",{$key}";
                else
                $name_field .="{$key}";
           if ($value_field != "")
                $value_field .=",'{$value}'";
                else
                $value_field .="'{$value}'";     
        }
        
        $query="INSERT INTO {$table} ($name_field) VALUES($value_field )";
        return $this->executeNoneQuery($query);
    }
    
    protected function selectFrom($table,$field_list =null,  $where = null)
    {
        $condition="";
        $list ="";
        if ($field_list ==null)
        {
            $list=" * ";
        }
        else
        if ($field_list != null && is_string($field_list))
        {
            $list = $field_list;
        }
        else
        if (is_array($field_list))
        {
            foreach ($field_list as $key => $value) {
                if ($list != "")
                    $list .=", ";
                if ($key == null)
                {
                $list .=" {$value} ";    
                }
                else
                {
                $list .=" $key as '{$value}'";    
                }
                
            }
        }
        
        if ($where != null)
            $condition =" WHERE ";
        if (!is_array($where))
            $condition= $where;
        else
        {
            foreach ($where as $key => $value) {
                if ($condition !="" && $condition != " WHERE " )
                    $condition.=" AND ";
                if ($value == null)
                $condition .=" $key = NULL ";
                else
                $condition .=" $key ='{$value}' ";
            }
        }
        $this->buildQuery="SELECT $list FROM $table  $condition";
        return  $this;
    }
    
   
    
    protected function order($order)
    {
        $this->buildQuery .=" ORDER BY $order";
        return $this;
    }
    
    protected function limit($limit, $offset =null)
    {
        if ($this->buildQuery == null || $this->buildQuery == "")
            return;
        $segment ="";
        if ($offset != null)
            $segment = " $offset ,";
        $this->buildQuery.=" LIMIT $segment $limit ";
        return $this;
    }

    protected  function delete($table, $where)
    {
        $condition ="";
          
        if (!is_array($where))
            $condition= $where;
        else
        {
            foreach ($where as $key => $value) {
                if ($condition !="")
                    $condition.=" AND ";
                $condition .=" $key ='{$value}' ";
            }
        }
        $this->buildQuery="DELETE FROM $table  WHERE   $condition";
        return $this->executeNoneQuery();
    }
    
    public function update($table, $arr_update,$arr_where)
    {
        $update_list="";
        foreach ($arr_update as $key => $value) {
            if ($update_list != "")
                $update_list .=", ";
            $update_list .="$key = '{$value}'";
        }
        $where_list="";
         foreach ($arr_where as $key => $value) {
            if ($where_list != "")
                $where_list .=" AND ";
            $where_list="$key = '{$value}'";
        }
        
        $this->buildQuery ="UPDATE $table SET $update_list WHERE $where_list";
        
        return $this->executeNoneQuery();
    }

    protected function fetchRow($query = null) {
        
        $result = $this->fetch($query );
        if ($result == null || count($result) == 0)
            return null;
        return $result[0];
    }

   
    protected function countQuery($query) {
        $result = $this->fetch($query,PDO::FETCH_COLUMN);
         if ($result == null || count($result) == 0)
            return null;
        return $result[0][0];

    }

    protected function insertLog($idmember, $query) {
        $query = str_replace('\'', '"', $query);
        $query = "INSERT INTO " . __PREFIX_DATABASE . "core_log
                    (idmember, datelog, stringlog)
                    VALUES('" . $idmember . "','" . date("m/d/Y h:i:s") ."',N'" . $query ."')";
        $this->executeNoneQuery($query);
    }
    
    
    
}
?>