<?php
require_once 'ErrorViewer.php';
class Database {
    private string $username;
    private string $password;
    private string $database;
    private string $host;  
    private mysqli $connection;
    public function __construct(string $username, string $password, string $database, string $host) {
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->host = $host;
    }
    public function tryConnect() : bool {
        try{
            $conn  = new mysqli($this->host, $this->username,$this->password,$this->database);
            $this->connection = $conn;
            return true;

        }catch(mysqli_sql_exception $e){
            echo SendError($e->getSqlState(),$e->getMessage(), $e->getTraceAsString());         
        }
        return false;
    }
    public function close() : bool {
        return $this->connection->close();
    }
    public function getConnection() : mysqli {
        return $this->connection;
    }

}

?>