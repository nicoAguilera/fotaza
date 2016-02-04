<?php

    class View{
        function render($controller,$view,$key=null,$value=null){
        	if(!is_null($key)){
                if(is_array($key)){
                    // extrae los keys y los convierte a variables
                    extract($key,EXTR_PREFIX_SAME,"");
                }else{
                        //("index","usus",$usuarios)
                        //$usus = $usuarios;
                    ${$key} = $value;
                }
            }

            $controller = get_class($controller);
            require './views/'.$controller.'/'.$view.'.php';
        }
    } 
?>