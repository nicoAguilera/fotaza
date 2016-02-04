<?php

    class Controller{
        
        function __construct() {
            Session::init();
            $this->view = new View();
            //$this->loadModel();
        }
        
        /*function loadModel(){
            $modelo = get_class($this).'_modelo';
            $path = MODELO.$modelo.'.php';
            
            if(file_exists($path)){
                require $path;
                $this->model = new $model();
            }
        }*/
        
    }
?>