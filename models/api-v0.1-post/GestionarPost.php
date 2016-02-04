<?php 

require '../vendor/autoload.php';

//Cargo las clases necesarias
require '../GestorPost.php';

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app = new Slim\App();

$app->get('/', function ($request, $response, $args) {
    $response->write("Welcome to Slim!");
    return $response;
});

# recupero un post en particular para mostrarlo en detalle
$app->get('/posts/{id}', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
	$gestorPost = new GestorPost;
	$gestorPost->obtenerPost($args['id']);

		/* Compruebo si el post se encuentra activo
		if($gestorPost->getPost()->getVisibilidad() == 1){
			$gestorEtiqueta = new GestorEtiqueta;
			$gestorComentario = new GestorComentario;

			$gestorEtiqueta->obtenerEtiquetas($idPost);
			$gestorPost->getPost()->setEtiquetas($gestorEtiqueta->getEtiquetas());

			$gestorComentario->obtenerComentarios($idPost);
			$gestorPost->getPost()->setComentarios($gestorComentario->getComentarios());

			//return $gestorPost->getPost();
		}else{
			//return FALSE;
		}*/
    //$response->headers->set("Content-type", "app");
    //$response->status(200);
    //$response->body(json_encode($gestorPost->getPost()));

    //$body = $response->getBody();
	//$body->write(json_encode($gestorPost->getPost()));

    //return $body;
});


$app->run();

 ?>