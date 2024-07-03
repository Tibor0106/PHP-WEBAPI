<?php 

namespace Application\Route;
require_once __DIR__ . '/../../application/Objects/RouteStruct.php';
require_once __DIR__ . '/../../application/Objects/RouteParams.php';

use Application\Objects\RouteStruct;
use Application\Objects\RouteParams;
use Exception;

class Route{
    private bool $displayErrorHandler = false; //TODO

    private String $errorMessage;

    private static $routes = [];

    private static $postParams;

    private static $request;

    public static function initialize($request, $post){
        self::$request = $request;
        self::$postParams = $post;
    }

    public static function handle(){
        $path = self::$request["REQUEST_URI"];
        $rqMethod = self::$request["REQUEST_METHOD"];
      
        foreach(self::$routes as $i){
            $routeHandle = self::HandleRouteParams($path, $i->path);
            if("/".$routeHandle->trimmedRoute == $path){
                if($rqMethod != $i->routeMethod){
                    http_response_code(405);
                    break;
                }      
                $params = array_merge($routeHandle->params, self::$postParams);              
                call_user_func($i->callback, $params);          
            }       
        }
    }
    private static function HandleRouteParams($route, $routePattern) {

        $trimmedRoute = trim($route, "/");
        $pattern = preg_replace('/\{([^\}]+)\}/', '([^/]+)', trim($routePattern, '/'));
        $pattern = "/^" . str_replace('/', '\/', $pattern) . "$/";
        if (preg_match($pattern, $trimmedRoute, $matches)) {
            array_shift($matches); 
            preg_match_all('/\{([^\}]+)\}/', $routePattern, $paramNames);
            $paramNames = $paramNames[1]; 

            $params = array_combine($paramNames, $matches);
            return new RouteParams($params, $trimmedRoute);
        } else {
            return false; 
        }
    }

   
    public static function get(String $path, $callback){
        self::$routes[] = new RouteStruct($path, $callback, "GET");
    }
    public static function post(String $path, $callback){
        self::$routes[] = new RouteStruct($path, $callback, "POST");
    }
    public static function delete(String $path, $callback){
        self::$routes[] = new RouteStruct($path, $callback, "DELETE");
    }
    public static function update(String $path, $callback){
        self::$routes[] = new RouteStruct($path, $callback, "UPDATE");
    }
}
?>