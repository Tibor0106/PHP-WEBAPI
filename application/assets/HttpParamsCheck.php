<?php 
namespace Application\Assets;
class HttpParamsCheck{
    public static function Check($params, $requitments) {
        $errorFoud = false;
        foreach ($params as $key => $value) {
            if(!array_key_exists($key, $requitments)){
               $errorFoud = true;
               break;
            }
            
        }
        http_response_code($errorFoud ? 415 : 200);
    }
}
?>