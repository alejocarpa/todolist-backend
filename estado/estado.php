<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

require_once 'estado.class.php';
require_once '../API/api.class.php';

$_estado = new Estado;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    
    $datosArray = $_estado->buscarDatos($_GET);

    Api::fncResponse($datosArray);

}else{
	echo "metodo no permitido";
}

?>