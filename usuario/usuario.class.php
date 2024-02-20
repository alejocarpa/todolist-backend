<?php 

class Usuario{
	
	public function buscarDatos($datos){
        
		require_once '../conexion/conexion.class.php';
		
		$link = Conexion::connect();

		$stmt = $link->prepare("SELECT nombre_usuario_tarea FROM tarea GROUP BY nombre_usuario_tarea");

		$stmt->execute();
		
		$resultado = $stmt->fetchAll();
		
		$link = null;
		
		return $resultado;

	}
	
	
}