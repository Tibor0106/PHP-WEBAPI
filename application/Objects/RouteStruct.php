<?php 
namespace Application\Objects;

class RouteStruct{
    public $path;
    public $callback;

    public $routeMethod;
    public function __construct($path, $callback, $routeMethod){
        $this->path = $path;
        $this->callback = $callback;
        $this->routeMethod = $routeMethod;
    }
}
?>