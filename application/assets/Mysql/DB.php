<?php

namespace Application\Database;

require_once "Connection.php";
require_once "DBResponse.php";
require_once __DIR__ . "\HelperObjects/JoinTables.php";

use Application\Assets\Mysql\Connection;
use Application\Assets\Mysql\DBResponse;
use Application\Assets\Mysql\HelperObjects\JoinTables;
use Application\Assets\Mysql\HelperObjects\SqlJoinType;
use PDO;

class DB
{
    private static PDO $connection;

    public static function DBInit()
    {
        self::$connection = Connection::TryConnect();
    }
    public static function find(String $table, JoinTables $join = null, $params) :DBResponse
    {
        $keys = array_keys($params);
        $q = "";
        foreach ($keys as $i) {
            if ($i == "next") {
                $q .= $params[$i] . " ";
            } else {
                $q .= $i . " = :" . $i . " ";
            }
        }
        $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $q;
        $stmt = self::$connection->prepare($sql);
        foreach ($keys as $i) {
            if ($i == "next") continue;
            $stmt->bindParam(':' . $i, $params[$i], PDO::PARAM_STR);
        }
        $stmt->execute();

        $eredmenyek = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return new DBResponse(json_encode($eredmenyek),$eredmenyek);

        
    }
}
