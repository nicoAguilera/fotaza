<?php

    class Index extends Controller{
        
        function __construct() {
            parent::__construct();
        }
        
        function index(){
            
            $this->view->render($this,'index');
            
        }
        
        /*function killItWithfire(){
            Session::destroy();
        }*/
        
    }
?>