<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

require_once 'tarea.class.php';
require_once '../API/api.class.php';

$_tarea = new Tarea;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    
    $datosArray = $_tarea->buscarDatos($_GET);

    Api::fncResponse($datosArray);

}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    $postBody = file_get_contents("php://input");

    $datosArray = $_tarea->guardarDatos($postBody);
    
    Api::fncResponse($datosArray);
    
}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    
    $postBody = file_get_contents("php://input");
    
    $datosArray = $_tarea->editarDatos($postBody);
    
    Api::fncResponse($datosArray);
    
}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    
    $postBody = file_get_contents("php://input");
    
    $datosArray = $_tarea->eliminarDatos($postBody);
    
    Api::fncResponse($datosArray);
    
}else{
	echo "metodo no permitido";
}

?>