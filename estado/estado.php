<?php 
include_once '../headers.php';

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