<?php
   class Response {
    public $response;
    public $responseJson;
    public $state_code;
    public function __construct($response, $responseJson, $state_code) {
        $this->response = $response; 
        $this->state_code = $state_code;
        $this->responseJson = $responseJson;
    }
}
?>