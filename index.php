<?php 
require_once "application/route/Route.php";
require_once "application/assets/View.php";
require_once "application/assets/HttpParamsCheck.php";
require_once "application/assets/Mysql/DB.php";
use Application\Assets\View;
use Application\Route\Route;
use Application\Assets\HttpParamsCheck;
use Application\Database\DB;

DB::DBInit();
Route::initialize($_SERVER, $_POST);

Route::get("/", function($params){
  header('Content-Type: application/json; charset=utf-8');
  echo DB::find("users", null, ["email" => "paragh.tibor71@gmail.com", "next" => "AND", "id" => 1])->json; 
});

Route::get("/teszt/{username}/{password}", function($params){  
  $req = array(
    "username" => "string|max:30", //TODO
    "password" => "string",
  );
  HttpParamsCheck::Check($params, $req); 

});


Route::handle();

?>
