<?php 

class Tarea{
	
	public function buscarDatos($datos){
        
		require_once '../conexion/conexion.class.php';
		
		$link = Conexion::connect();

		$stmt = $link->prepare("SELECT *, nombre_estado 
                                FROM tarea t
                                LEFT JOIN estado e on (e.id_estado = t.id_estado_tarea)");

		$stmt->execute();
		
		$resultado = $stmt->fetchAll();
		
		$link = null;
		
		return $resultado;

	}
	
	public function guardarDatos($datos){
	    
	    $datos = json_decode($datos);	  	   
	    
	    $nombre = ucfirst($datos->nombre);
	    $nombre_usuario = ucwords($datos->nombre_usuario);
	    
	    $nombre = htmlentities($nombre, ENT_QUOTES);
	    $descripcion = htmlentities($descripcion, ENT_QUOTES);
	    $nombre_usuario = htmlentities($nombre_usuario, ENT_QUOTES);
	    
	    require_once '../conexion/conexion.class.php';
	    
	    $link = Conexion::connect();
	    
	    $stmt = $link->prepare("INSERT INTO tarea (nombre_tarea, nombre_usuario_tarea, fecha_creacion_tarea) VALUES (:nombre_tarea, :nombre_usuario_tarea, current_date)");
	    
	    $stmt->bindParam(':nombre_tarea', $nombre);
	    $stmt->bindParam(':nombre_usuario_tarea', $nombre_usuario);
	    // Excecute
	    $stmt->execute();
	    
	    $arr_error = $stmt->errorInfo();
	    
	    $id = $link->lastInsertId();
	    
	    $link = null;
	    
	    if(!$arr_error[2]){
	        return array("id" => $id);
	    }else{
	        return array("error" => $arr_error[2]);
	    }

	}
	
	public function editarDatos( $datos ){
	    
	    $datos = json_decode($datos);
	    
	    $id_tarea = $datos->tarea;
	    $estado = $datos->estado;
	    
	    require_once '../conexion/conexion.class.php';
	    
	    $link = Conexion::connect();
	    
	    $stmt = $link->prepare("UPDATE tarea set id_estado_tarea = :estado, fecha_modificacion_tarea = current_date WHERE id_tarea = :tarea");
	    
	    $stmt->bindParam(':estado', $estado);
	    $stmt->bindParam(':tarea', $id_tarea);
	    // Excecute
	    $stmt->execute();
	    
	    $arr_error = $stmt->errorInfo();
	    
	    $link = null;
	    
	    if(!$arr_error[2]){
	        return array("id" => $id_tarea);
	    }else{
	        return array("error" => $arr_error[2]);
	    }
	}
	
	public function eliminarDatos( $datos ){
	    
	    $datos = json_decode($datos);
	    
	    $id_tarea = $datos->tarea;
	    
	    require_once '../conexion/conexion.class.php';
	    
	    $link = Conexion::connect();
	    
	    $stmt = $link->prepare("DELETE FROM tarea WHERE id_tarea = :tarea");
	    
	    $stmt->bindParam(':tarea', $id_tarea);
	    // Excecute
	    $stmt->execute();
	    
	    $arr_error = $stmt->errorInfo();
	    
	    $link = null;
	    
	    if(!$arr_error[2]){
	        return array("id" => $id_tarea);
	    }else{
	        return array("error" => $arr_error[2]);
	    }
	}
	
	
}