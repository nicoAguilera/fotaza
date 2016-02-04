<?php

    require 'config.php';
    // -->Controller/Method/Params
    $url = (isset($_GET["url"])) ? $_GET["url"] : "GestorReqPrincipal/mostrarPosts/posts/1";

    $url = explode("/", $url);

    if(isset($url[0])){$controller = $url[0];}
    if(isset($url[1])){ if($url[1] != ''){ $method = $url[1];} }
    if(isset($url[2])){ if($url[2] != ''){ $params1 = $url[2];} }
    if(isset($url[3])){ if($url[3] != ''){ $params2 = $url[3];} }
    if(isset($url[4])){ if($url[4] != ''){ $params3 = $url[4];} }
    if(isset($url[5])){ if($url[5] != ''){ $params4 = $url[5];} }
    if(isset($url[6])){ if($url[6] != ''){ $params5 = $url[6];} }
    if(isset($url[7])){ if($url[7] != ''){ $params6 = $url[7];} }
    if(isset($url[8])){ if($url[8] != ''){ $params7 = $url[8];} }
    if(isset($url[9])){ if($url[9] != ''){ $params8 = $url[9];} }
    if(isset($url[10])){ if($url[10] != ''){ $params9 = $url[10];} }

    
    spl_autoload_register(function($class){
        if(file_exists(LIBS.$class.".php")){
            require LIBS.$class.".php";
        }elseif(file_exists(MODELO.$class.".php")){
            require MODELO.$class.".php";
        }
    });
    
    $path = './controllers/'.$controller.'.php';
    
    if(file_exists($path)){
        require $path;
        $controller = new $controller();
        
        if(isset($method)){
            if(method_exists($controller, $method)){
                if(isset($params9)){
                    $controller->{$method}($params1, $params2, $params3, $params4, $params5, $params6, $params7, $params8, $params9);
                }elseif(isset($params8)){
                    $controller->{$method}($params1, $params2, $params3, $params4, $params5, $params6, $params7, $params8);
                }elseif(isset($params7)){
                    $controller->{$method}($params1, $params2, $params3, $params4, $params5, $params6, $params7);
                }elseif(isset($params6)){
                    $controller->{$method}($params1, $params2, $params3, $params4, $params5, $params6);
                }elseif(isset($params5)){
                    $controller->{$method}($params1, $params2, $params3, $params4, $params5);
                }elseif(isset($params4)){
                     $controller->{$method}($params1, $params2, $params3, $params4);
                }elseif(isset($params3)){
                    $controller->{$method}($params1, $params2, $params3);
                }elseif(isset($params2)){
                    $controller->{$method}($params1, $params2);
                }elseif(isset($params1)){
                    $controller->{$method}($params1);
                }else{
                    $controller->{$method}();
                }
            }
        }else{
            $controller->index();
        }
    }else{
        echo 'Error';
    }

?>