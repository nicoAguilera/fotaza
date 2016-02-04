<?php
/*
* Clase que gestiona todos los requerimientos del sistema a traves de la interacción con las vistas
* 
*/

class GestorReqPrincipal extends Controller
{

	function __construct() {
        parent::__construct();
    }

    /**
        Metodos que corresponden a la funcionalidad de gestión de usuarios
    */

    //los parametros los paso por la variable post
    public function validarDatosUsuario()
    {
    	# toma los datos ingresados por el usuario y si son validos inicia una sesión
    	$gestionarSesion = new GestionarSesion;
    	$gestionarSesion->validarSesion($_POST["email"], $_POST["password"]);
    }

    public function destruirSession()
    {
    	$gestionarSesion = new GestionarSesion;
    	$gestionarSesion->destroySession();
    }

    public function registrarNuevoUsuario()
    {
    	$gestionarSesion = new GestionarSesion;
    	$gestionarSesion->nuevoUsuario($_POST["nombre"], $_POST["apellido"], $_POST["domicilio"], $_POST["email"], $_POST["password"]);
    }

    public function obtenerUsuario($idUsuario)
    {
        $gestionarSesion = new GestionarSesion;
        return $gestionarSesion->obtenerUsuario($idUsuario);
    }

    public function actualizarUsuario()
    {
        $gestionarSesion = new GestionarSesion;
        $gestionarSesion->actualizarUsuario($_POST['id'], $_POST['columna'], $_POST['dato']);
    }

    public function actualizarPass()
    {
        $gestionarSesion = new GestionarSesion;
        $gestionarSesion->actualizarPass($_POST['id'], $_POST['passActual'], $_POST['passNuevo']); 
    }

    public function eliminarUsuario()
    {
        # doy de baja la cuenta del usuario
        $gestionarSesion = new GestionarSesion;
        $gestionarSesion->ocultarUsuario($_POST['idUsuario']);

        # doy de baja los posts del usuario
        $posts = $this->listarPosts(NULL, $_POST['idUsuario'], NULL);
        $gestionarPost = new GestionarPost;
        foreach ($posts as $value) {
            $gestionarPost->actualizarPost($value->getID(), "P_Visibilidad", 0);
        }

        echo 1;
    }



    /**
        Metodos que corresponden a la funcionalidad de gestion de posts
    */

    /**
    * Publica un post de imagen o video dependiendo de la variable visibImg que determina el tipo publicacion
    * llamando al metodo correspondiente
        Este metodo tiene logica de negocio que es la de determinar a que metodo llamar de la clase GestionarPost que deberia delegar a dicho
        subgestor, colocando campos opcionales y comprobando en el subgestor a cual corresponden
    */
    public function publicarPost(){
        $gestionarPost = new GestionarPost;
        if(isset($_POST)){
            extract($_POST);
            # Compruebo que todas las variables no estan vacias
            if($titulo!="" && $detalle!="" && ($etiqueta1!="" || $etiqueta2!="" || $etiqueta3!="") && ( isset($imagen) || isset($video) ) && $idUsuario!=""){
                if($_POST['visibImg']==1){
                    # Se quiere publicar una imagen por lo que llamo al metodo subirImagen()
                    $idPost = $gestionarPost->subirImagen($titulo, $detalle, $etiqueta1, $etiqueta2, $etiqueta3, $_FILES['imagen']['type'], $_FILES['imagen']['name'], $_FILES['imagen']['tmp_name'], $idUsuario );
                }
                else{
                    # Se quiere publicar un video por lo que llamo al metodo subirVideo()
                    $idPost = $gestionarPost->subirVideo($titulo, $detalle, $etiqueta1, $etiqueta2, $etiqueta3, $idVideo, $idUsuario );
                }
                
                # Si se publico exitosamente el post redirije al usuario a la pagina del post
                if($idPost!=0){
                    $this->mostrarPost($idPost);
                }else{
                    # redirijir a la pagina error.php
                    echo "error";
                }
            }
        }else{
            echo "error";
        }
    }

    /*
    * Recupera las publicaciones de la db y la retorna a la vista "publicaciones.php" como un arreglo de objetos de tipo Publicacion
    */
    public function listarPosts($limite, $idUsuario=NULL, $tipo=NULL)
    {
        $gestionarPost = new GestionarPost;
        return $gestionarPost->listarPosts($limite, $idUsuario, $tipo);
    }

    # obtiene los datos asociados a la publicacion solicitada
    public function obtenerPost($idPost)
    {
        $gestionarPost = new GestionarPost;
        return $gestionarPost->obtenerPost($idPost);
    }

    public function denunciarPost()
    {
        $gestionarPost = new GestionarPost;
        $gestionarPost->denunciarPost($_POST['motivo'], $_POST['argumento'], $_POST['idPost'], $_POST['idUsuarioDenuncia'], $_POST['idUsuarioDenunciado']);
    }

    # busca en la bd si el usuario realizo una denuncia sobre el post que esta viendo o no
    public function buscarDenuncia($idUsuario, $idPost){
        $gestionarPost = new GestionarPost;
        return $gestionarPost->buscarDenuncia($idUsuario, $idPost);
    }


    public function obtenerDenuncias($idPost)
    {
        $gestionarPost = new GestionarPost;
        return $gestionarPost->obtenerDenuncias($idPost);
    }

    public function agregarComentario()
    {
        $gestionarPost = new GestionarPost;
        $gestionarPost->guardarComentario($_POST['comentario'], $_POST['idPost'], $_POST['idUsuarioRecibe'], $_POST['idUsuarioGenera']);
        //$gestionarPost->guardarComentario($comentario, $idPost, $idUsuario);
    }

    /* 
    * Elimina un comentario y redirije automaticamente al post que se estaba visualizando 
    */
    public function eliminarComentario($idComentario, $idPost)
    {
        $gestionarPost = new GestionarPost;
        $gestionarPost->eliminarComentario($idComentario);

        $this->mostrarPost($idPost);
    }

    public function obtenerNotificaciones($idUsuario)
    {
        $gestionarPost = new GestionarPost;
        return $gestionarPost->obtenerNotificaciones($idUsuario);
    }

    public function obtenerDenuncia($idUsuarioGenera, $idPost)
    {
        $gestionarPost = new GestionarPost;
        return $gestionarPost->obtenerDenuncia($idUsuarioGenera, $idPost);
    }


    public function eliminarPost()
    {
        $gestionarPost = new GestionarPost;
        $resultado = $gestionarPost->darDeBaja($_POST['idPost']);
    }
    
    public function eliminarDenuncia()
    {
        $gestionarPost = new GestionarPost;
        $gestionarPost->desestimarDenuncia($_POST['idPost']);
    }

    /*
    * Funcion para obtener la cantidad total de paginas a mostrar en la paginacion
    */
    public function obtenerCantPaginas($idUsuario=NULL, $tipoPost=NULL)
    {
        $gestionarPost = new GestionarPost;
        return $gestionarPost->cantidadPaginas($idUsuario, $tipoPost);
    }

    #  Funcion que busca coincidencias de etiquetas ingresadas
    public function buscarCoincidenciasEtiquetas()
    {
        $gestionarPost = new GestionarPost;
        $resultado = $gestionarPost->buscarCoincidenciaEtiqueta($_GET['term']);

        print_r(json_encode($resultado));
    }

    public function actualizarPost()
    {
        $gestionarPost = new GestionarPost;
        $gestionarPost->actualizarPost($_POST['idPost'], $_POST['columna'], $_POST['dato']);
    }
    


    /**
        Metodos que correspondes al renderizado de las vistas
    */

    public function mostrarLogin()
    {
        $this->view->render($this, 'login');
    }

    /*
    * Renderiza la pagina posts.php con los posts más recientes según el limite que se pasa como parametro
    * y se envia a la pagina post la variable $publicaciones que se obtiene mediante el metodo listarPosts($limite)

    * Recibe como parametro la pagina a renderizar, el numero de página que se esta mostrando, el id del usuario y el tipo de post a mostrar
    * Determina que pagina renderizar dependiendo del parametro $pagina
    * Recupera la cantidad de post por tipo y usuario o en total dependiendo del caso
    */
    public function mostrarPosts($pagina, $numPagina, $idUsuario=NULL)
    {
        $totalPaginas = $this->obtenerCantPaginas($idUsuario, $pagina);
        $inicio = ($numPagina - 1) * PAGINACION;
        if($pagina=='posts'){
            $this->view->render($this, $pagina, array('publicaciones'=>$this->listarPosts($inicio), "pagina"=>$pagina, "totalPaginas"=>$totalPaginas, "numPagina"=>$numPagina) );
        }else{
            # Obtengo el usuario y verifico que su cuenta se encuentra activa
            $usuario = $this->obtenerUsuario($idUsuario);
            if($usuario->getEstadoCuenta()==1){
                $this->view->render($this, $pagina, array("publicaciones"=>$this->listarPosts($inicio, $idUsuario, $pagina), "pagina"=>$pagina, "idUsuario"=>$idUsuario, "totalPaginas"=>$totalPaginas, "numPagina"=>$numPagina) );
            }else{
                # La cuenta del usuario fue dada de baja
                $this->view->render($this, 'error', 'tipoError', '¡La cuenta del usuario '. $usuario->getNombreCompleto() .' fue eliminada!');
            }
        }
    }

    # Renderiza la pagina post.php con el detalle de la publicacion solicitada
    public function mostrarPost($idPost)
    {
        //$this->view->render($this, 'post', 'post', $this->verPost($idPost));
        $post = $this->obtenerPost($idPost);
        if($post != FALSE){
            $this->view->render($this, 'post', array("post"=>$post, "usuario"=>$this->obtenerUsuario($post->getIdUsuario())));
        }
        else{
            $this->view->render($this, 'error', 'tipoError', '¡El post fue eliminado!');
        }
    }

    # Renderiza la pagina perfil.php que corresponde al usuario solicitado
    public function mostrarPerfil($idUsuario)
    {
        $usuario = $this->obtenerUsuario($idUsuario);
        if($usuario->getEstadoCuenta()==1){
            $this->view->render($this, 'perfil', 'idUsuario', $idUsuario);
        }else{
            $this->view->render($this, 'error', 'tipoError', '¡Cuenta Eliminada!');
        }
    }

    # Renderiza la pagina infoPerfil.php con la información del usuario
    public function mostrarInfoPerfil($idUsuario)
    {
        $usuario = $this->obtenerUsuario($idUsuario);

        # Compruebo el estado de la cuenta
        if($usuario->getEstadoCuenta()==1){
            $this->view->render($this, 'infoPerfil', 'usuario', $this->obtenerUsuario($idUsuario));
        }else{
            $this->view->render($this, 'error', 'tipoError', '¡Cuenta Eliminada!');
        }
    }

    # Renderiza la página notificacion.php
    public function mostrarNotificacion($idUsuario)
    {
        $usuario = $this->obtenerUsuario($idUsuario);

        # Compruebo el estado de la cuenta
        if($usuario->getEstadoCuenta()==1){
            $this->view->render($this, 'notificacion', 'notificaciones', $this->obtenerNotificaciones($idUsuario));
        }else{
            $this->view->render($this, 'error', 'tipoError', '¡Cuenta Eliminada!');
        }
    }

    # Renderiza la página panelControl.php del administrador
    public function mostrarPanelControl()
    {
        $this->view->render($this, 'panelControl', 'notificaciones', $this->obtenerNotificaciones(1));
    }

    # Renderiza la pagina resultadoBusqueda.php
    public function mostrarResultadoBusqueda($clave)
    {
        $this->view->render($this, 'resultadoBusqueda', array('clave'=> $clave, 'resultado'=>$this->buscadorPrincipal($clave) ) );
    }
    


    /**
    Metodos que corresponden a la funcionalidad del motor de busqueda
    */
    public function buscadorPrincipal($clave = NULL){
        $gestionarBusqueda = new GestionarBusqueda;
        if($clave == NULL){
            echo json_encode( $gestionarBusqueda->buscar($_POST['clave']) ) ;
        }else{
            return $gestionarBusqueda->buscar($clave);
        }
    }
}

?>