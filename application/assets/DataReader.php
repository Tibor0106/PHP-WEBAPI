<?php


namespace Application\Assets;

class DataReader
{
    public static function initialize()
    {
        $filePath = __DIR__."/.env";
        
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue; 
            }

            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }

    public static function ReadMySqlConnection()
    {
        $datas = [];

        $datas["username"] = getenv("DB_USERNAME");
        $datas["host"] = getenv("DB_HOST");
        $datas["password"] = getenv("DB_PASSWORD");
        $datas["database"] = getenv("DB_DATABASE");

        return $datas;
    }
}
?>

