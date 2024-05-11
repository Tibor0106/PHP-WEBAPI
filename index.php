<?php
require_once "./src/API/Database.php";
require_once "./src/API/Mysql.php";
require_once "./src/API/Route.php";
require_once "./src/API/Mailer.php";

$databaseAction = new DatabaseAction(); 
$request = $_SERVER["REQUEST_URI"];
$headers = getallheaders();

$Router = new Route();

//this is dto ->Data Transfer Object
class User{
    public $id = 0;
    public $valami = "";
}

$Router->get("/game/upload", function($params) use ($databaseAction, $headers){
    http_response_code(200);

},new User); 




$Router->execute($request);




?>
