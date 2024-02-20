<?php 
include_once '../headers.php';

require_once 'usuario.class.php';
require_once '../API/api.class.php';

$_usuario = new Usuario;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    
    $datosArray = $_usuario->buscarDatos($_GET);

    Api::fncResponse($datosArray);

}else{
	echo "metodo no permitido";
}

?>