<?php 
namespace Application\Assets\Mysql;
use  Application\Assets\DataReader;
use mysqli;

class Connection{
    public static function Connect() : mysqli{
        DataReader::initialize();
        $mysql_login = DataReader::ReadMySqlConnection();
        $mysqli = new mysqli($mysql_login["host"], $mysql_login["username"], $mysql_login["password"], $mysql_login["database"]);
        if ($mysqli->connect_error) {
            
        }
        return $mysqli;
    }
}

?>