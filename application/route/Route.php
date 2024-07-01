<?php 

namespace Application\Route;
class Route{
    private bool $displayErrorHandler = false;

    private String $errorMessage;

    private static $request;

    public static function initialize($_request){
        $request = $_request;
    }


    public static function get(String $path, $callback){
        call_user_func($callback);
    }
}
?>