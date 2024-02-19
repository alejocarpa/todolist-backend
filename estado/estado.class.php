<?php 

class Estado{
	
	public function buscarDatos($datos){
        
		require_once '../conexion/conexion.class.php';
		
		$link = Conexion::connect();

		$stmt = $link->prepare("SELECT * FROM estado");

		$stmt->execute();
		
		$resultado = $stmt->fetchAll();
		
		$link = null;
		
		return $resultado;

	}
	
	
}