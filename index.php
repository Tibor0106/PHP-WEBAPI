<?php 
require_once "application/route/Route.php";
require_once "application/assets/View.php";
require_once "application/assets/HttpParamsCheck.php";
use Application\Assets\View;
use Application\Route\Route;
use Application\Assets\HttpParamsCheck;


Route::initialize($_SERVER, $_POST);

Route::get("/", function($params){
  View::view("index.php");
});

Route::get("/teszt/{username}/{password}", function($params){  
  $req = array( //kötelező paraméterek listája
    "username" => "string|max:30", //TODO
    "password" => "string",
  );
  HttpParamsCheck::Check($params, $req); //415-ös hibát ad vissza, ha a kötelező paraméterek nem feleltek meg

});


Route::handle();

?>
