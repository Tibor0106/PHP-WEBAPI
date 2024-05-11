<?php 

class RouteData {
    public string $path;
    public string $method;
    public $callback;

    public function __construct(string $path, string $method, $callback) { 
        $this->path = $path;
        $this->method = $method;
        $this->callback = $callback;
    }
}
class RouteResponse {
    public $Get;
    public $Post;
    public function __construct($get, $post) {
        $this->Get = $get;
        $this->Post = $post;
    }
}
class EndPoint{
    public $url;
    public $requestType;

    public $reqData;

    public function __construct($url, $requestType, $reqData){
        $this->url = $url;
        $this->requestType = $requestType;
        $this->reqData = $reqData;
    }
}
class Route{
    public  $allEndPoint = [];
    public array $params = [];

    public function __construct() {
    }
    public function get($path, $callback, $req = null){
        $this->params[] = new RouteData($path, "GET", $callback);
        $this->allEndPoint[] = new EndPoint($path, "GET", $req);
    }
    public function post($path, $callback, $req = null, ){
        $this->params[] = new RouteData($path, "POST", $callback);
        $this->allEndPoint[] = new EndPoint($path, "POST", $req);
    }
    public function put($path, $callback, $req = null){
        $this->params[] = new RouteData($path, "PUT", $callback);
        $this->allEndPoint[] = new EndPoint($path, "PUT", $req);
    }
    public function delete($path, $callback, $req = null){
        $this->params[] = new RouteData($path, "DELETE", $callback);
        $this->allEndPoint[] = new EndPoint($path, "DELETE", $req);
    }
    public function execute($request) {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($request, PHP_URL_PATH);
        $json = file_get_contents('src/API/api_info.json'); 
        $ApiData = json_decode($json);
        if($request == "/doc" && $ApiData->accessToEndPointDoc){
            $boxes = "";
          
            foreach($this->allEndPoint as $i){   
                $key = array_search($i, $this->allEndPoint);     
                $jsonData = ($i->reqData != null) ? json_encode($i->reqData, JSON_PRETTY_PRINT) : '';
                $jsonData = str_replace('null', '""', $jsonData);  
                $jsonData = str_replace('"', '&quot;', $jsonData);
                $jsonData = str_replace(' ', '', $jsonData);           
                $boxes.= ' <div class="endpoint border bg-light p-4 mt-3">
                <div class="row">
                    <div class="col-1">
                        <div class="request border '.strtolower($i->requestType).' text-center p-2" type="'.$i->requestType.'">
                        </div>       
                    </div>
                    <div class="col">
                            <div class="url">
                                <p class="url_p p-2">'.$i->url.'</p>
                            </div>
                     </div>
                </div>
                <input type="text" class="border des w-100" value="'.$jsonData .'" id="'.$key.'"/>
                   
                <div class="d-flex justify-content-end"><button class="btn btn-danger mt-3" style="width: 100px" onClick="testEndpoint('.trim($key).',`'.$i->url.'`,`'.$i->requestType.'`)">Test</button></div>
                <div class="response bg-dark p-2 mt-4" id="res-'.$key.'"></div>
            </div>';
            }
           echo '
           <!doctype html>
           <html lang="en">
           
           <head>
               <title>PT UI - PT Dev Studio</title>
               <!-- Required meta tags -->
               <meta charset="utf-8" />
               <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
               <link rel="stylesheet" href="https://paraghtibor.hu/ptui/style.v1.css">
           
               <!-- Bootstrap CSS v5.2.1 -->
               <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
               <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
               </head>
           
           <body>
               <header>
                   <nav class="navbar navbar-expand-lg bg-body-tertiary">
                       <div class="container-fluid">
                           <a class="navbar-brand d-flex" href="#">
                               <img src="https://paraghtibor.hu/ptui/media/pt_ui_logo.png" alt="Bootstrap" width="95" height="64">
                               <p class="fw-bold mt-3">PT UI</p>
                           </a>
                           <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                               <span class="navbar-toggler-icon"></span>
                           </button>
                           <div class="collapse navbar-collapse" id="navbarSupportedContent">
                               <ul class="navbar-nav me-auto ms-auto mb-2 mb-lg-0">
                                   <li class="nav-item">
                                       <a class="nav-link active" aria-current="page" href="#">Documentation</a>
                                   </li>
                                   <li class="nav-item">
                                       <a class="nav-link active" aria-current="page" href="#">Donate</a>
                                   </li>
                                   <li class="nav-item">
                                       <a class="nav-link active" aria-current="page" href="#">GitHub</a>
                                   </li>
           
                               </ul>
                               <div class="d-flex">
        
                               </div>
                           </div>
                       </div>
                   </nav>
               </header>
              
               <main>
                   <div class="container">
                       <div class="border bg-light p-4 mt-3">
                           <h3 class="text-black-50">'.$ApiData->apiname.' '.$ApiData->version.'</h3>
                           <p class="mt-2">
                               '.$ApiData->description.'
                           </p>
                       </div>
                      '.$boxes.'
                   </div>
               </main>
               <footer>
                   <!-- place footer here -->
               </footer>
               <!-- Bootstrap JavaScript Libraries -->
               <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
           
               <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
                <script> 
                    function testEndpoint(key, endpoint, type){

                        var _data = document.getElementById(key).value;
                       
                   
                        $.ajax({
                            type: type,
                            url: window.location.origin+endpoint,
                            data:JSON.parse(_data),
                            headers: {
                                "My-First-Header":"first value",
                                "My-Second-Header":"second value"
                            },
                            success: function (data, xhr) {
                                document.getElementById("res-"+key).innerHTML = data;
                            },
                            error: function (data, xhr) {
                                document.getElementById("res-"+key).innerHTML = `<p class="text-danger">${data.status} ${data.statusText}</p>`;              
                            },
                        });
                        
                        document.getElementById("res-"+key).style.display = "block";
                    }
                </script>
               </body>
           
           </html>';
           
        }       
        $found = false;
        foreach ($this->params as $route) {
            if($route->path === $path){
                $found = true;
                if ($route->method === $method) {
                    $callback = $route->callback; 
                    
  
                if (is_callable($callback)) {
                        call_user_func($callback, new RouteResponse($_GET, $_POST));
                        return null;
                    } else {
                        echo "Error: Callback for $method $path is not callable";
                        return null;
                    }
                } else {
                    http_response_code(405);
                    break;
                }
            }  
            $found ? "" : http_response_code(404);    
        }
        return null;        
    }   
}
?>
