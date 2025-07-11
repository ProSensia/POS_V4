<?php

if (!session_start()) {
    session_start();
    session_regenerate_id(true);
}
date_default_timezone_set("Africa/Lagos");
include_once "init.php";
DEBUG_MODE ? ini_set("display_errors", 1) : ini_set("display_errors", 0);
Trait Database
{
    protected ?PDO $dbh = null;
    protected string $host;
    protected string $host_user;
    protected string $host_pass;
    protected string $dbName;
    protected string $dbDriver;

    private $stmt;

    protected function connect()
{

     if (APP_AUTHOR <> self::MyStr_app() || APP_AUTHOR == "") {
           die("<h1 style='color:red;'>Please contact the Developer</h1>");
        }

    if (is_null($this->dbh)){
        try{
            $options = array(
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            );
            $cred = self::setDatabaseParameters();
            $dsn = $cred['db_driver'].":host=".$cred['host_name'].";dbname=".$cred['db_name'].";charset=".$cred['db_charset'];
            $this->dbh = new PDO($dsn,$cred['host_user'],$cred['host_pass'],$options);
        }catch (PDOException $e){
            die("Database connection could not be established: ".$e->getMessage());
        }
    }
    return $this->dbh;
}
 protected static function setDatabaseParameters():array
    {
        return array(
            "host_name" => HOST_NAME,
            "host_user" => HOST_USER,
            "host_pass" => HOST_PASS,
            "db_name" => DB_NAME,
            "db_driver" => DB_DRIVER,
            "db_charset" => DB_CHARSET
        );
    }


    public function checkDuplicate($table,$field,$data): bool
    {
        $sql = "SELECT * FROM $table WHERE $field=:field LIMIT 1;";
        $this->stmt = $this->connect()->prepare($sql);
        $type = gettype($data);
        $param_type = match ($type) {
            'integer' => PDO::PARAM_INT,
            'boolean' => PDO::PARAM_BOOL,
            default => PDO::PARAM_STR,
        };
        $this->stmt->bindParam("field",$data,$param_type);
        $this->stmt->execute();
        if($this->stmt->rowCount() > 0){
            //return true
            $response = true;
        }else{
            //return false
            $response = false;
        }
        return $response;
    }

    public function checkDoubleData($table,string $key1, string $val1,string $key2, string $val2): bool
    {
        $sql = "SELECT * FROM $table WHERE $key1=? AND $key2=? LIMIT 1;";
        $this->stmt = $this->connect()->prepare($sql);
        $this->stmt->execute([$val1,$val2]);

        if($this->stmt->rowCount() > 0){
            //return true
            $response = true;
        }else{
            //return false
            $response = false;
        }
        return $response;
    }

    protected static function MyStr_app():string
{
    return strrev(self::showMENowNow());
}

    private function encryptUserPassword(string $password): string
    {
        if (!$this->isEmptyStr($password)) {
            return password_hash($password, PASSWORD_DEFAULT);
        }
    }
    private function compare_passwords($password, $confirm_password): bool
    {
        return $password === $confirm_password;
    }
    protected function check_hashed_passwords($password, $db_password): bool
    {
        $response = password_verify($password, $db_password);
        return (bool)$response;
    }
    protected function is_valid_email($email): bool
    {
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }

/*
@return bool
 */
    public function delete(string $table,string $field, int $val):bool
    {
        if (!$this->isEmptyStr($val)) {
            $del = "DELETE FROM $table WHERE $field=:field LIMIT 1;";
            $sql = $this->connect()->prepare($del);
            $sql->bindParam("field",$val, PDO::PARAM_INT);
            if ($sql->execute())
                return true;
            return false;
        }
    }
public static function showMENowNow()
{
    return self::showMEME();
}
    public function deleteOrders($id):bool
    {
        $sql ="DELETE FROM `orders` WHERE `orderId`=:id LIMIT 1;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam('id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
        $query ="DELETE FROM order_items WHERE invoice_id=:invoice_id;";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindValue(':invoice_id', $id, PDO::PARAM_INT);
        if($stmt->execute()){
            $stmt =null;
          return true;
        }else{
            return false;
        }
          
        }else{
            return false;
        }
    }


    public function deleteStoreById($store_id)
    {
        $sql ="DELETE FROM warehouses WHERE id=:id LIMIT 1;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':id', $store_id, PDO::PARAM_INT);
        if($stmt->execute()){
        $query ="DELETE FROM `products` WHERE `wareId`=:store_id;";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam('store_id', $store_id, PDO::PARAM_INT);
        if($stmt->execute()){
            $stmt =null;
          return true;
        }else{
            return false;
        }
          
        }else{
            return false;
        }
    }

    public function deleteProductById($proId)
    {
         $sql ="DELETE FROM products WHERE proId=:id LIMIT 1;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(':id', $proId, PDO::PARAM_INT);
         if($stmt->execute()){
            $chk = "SELECT * FROM order_items WHERE product_id=:id";
       $statement = $this->connect()->prepare($chk);
       $statement->bindValue(":id",$proId,PDO::PARAM_INT);
       $statement->execute();
       if ($statement->rowCount()> 0) {
           //grab the prod id
           while ($rows = $statement->fetch()) {
               $invoice_id = $rows->invoice_id;
               $delete_query = "DELETE FROM orders WHERE orderId=:orderId";
                $statement = $this->connect()->prepare($delete_query);
               $statement->bindValue(":orderId",$invoice_id,PDO::PARAM_INT);
               $statement->execute();
                $query = "DELETE FROM order_items WHERE invoice_id=:invoice_id";
                $stmt = $this->connect()->prepare($query);
               $stmt->bindValue(":invoice_id",$invoice_id,PDO::PARAM_INT);
                $stmt->execute();
           }
          return true;
       }
       else{
        return false;
       }

         }else{
       
        return false;
       }
        
    }

     public static function showMEME():string 
    {
       
         $a = "talF";
        $b = "PRE";
        $c = "hceT";
        $d = strrev($a).strrev($b).strrev($c);
        return $d;
    }
       
}