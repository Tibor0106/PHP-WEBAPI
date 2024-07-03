<?php 
namespace Application\Assets\Mysql;

class DBResponse {
    public $json;
    public $phpArray;

    public function __construct($json, $phpArray){
        $this->json = $json;
        $this->phpArray = $phpArray;
    }

}
?>