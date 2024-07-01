<?php 
require_once "application/route/Route.php";
use Application\Route\Route;


Route::initialize($_SERVER);

Route::get("/", function(){
    echo "asd";
});





?>
