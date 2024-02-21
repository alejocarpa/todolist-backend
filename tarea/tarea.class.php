<?php 

class Tarea{
	
	public function buscarDatos($datos){
	    
	    $informe = $_GET['informe'];
	    
	    if( $informe ){
	        Tarea::descargarCsv();
	        return "informe";
	    }
	    
	    $resultado = "";
	    
        if( sizeof($datos) > 0 ){
            
            $resultado = Tarea::buscarDatosConFiltro($datos);
        }
        
        if( $resultado == "" ){
        
    		require_once '../conexion/conexion.class.php';
    		
    		$link = Conexion::connect();
    
    		$stmt = $link->prepare("SELECT *, nombre_estado 
                                    FROM tarea t
                                    LEFT JOIN estado e on (e.id_estado = t.id_estado_tarea)
                                    ORDER BY id_tarea DESC");
    
    		$stmt->execute();
    		
    		$resultado = $stmt->fetchAll();
    		
    		$link = null;
		
        }
		
		return $resultado;

	}
	
	public function buscarDatosConFiltro($datos){
	    
	    $where = "1=1";
	    
	    $id_estado = $_GET['estado'];
	    $usuario = $_GET['usuario'];
	    
	    if( $id_estado ) $where .= " AND t.id_estado_tarea = :estado";
	    if( $usuario ) $where .= "  AND t.nombre_usuario_tarea = :usuario";
	    
	    require_once '../conexion/conexion.class.php';
	    
	    $link = Conexion::connect();
	    
	    $stmt = $link->prepare("SELECT *, nombre_estado
                                FROM tarea t
                                LEFT JOIN estado e on (e.id_estado = t.id_estado_tarea)
                                WHERE $where
                                ORDER BY id_tarea DESC");
	    //die( $where );
	    if( $id_estado ) $stmt->bindParam(':estado', $id_estado);
	    if( $usuario ) $stmt->bindParam(':usuario', $usuario);
	    
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
	
	public function descargarCsv() {
	    
	    require_once '../conexion/conexion.class.php';
	    
	    $link = Conexion::connect();
	    
	    $stmt = $link->prepare("SELECT *, nombre_estado
                                    FROM tarea t
                                    LEFT JOIN estado e on (e.id_estado = t.id_estado_tarea)
                                    WHERE id_estado_tarea = 2
                                    ORDER BY id_tarea DESC");
	    
	    $stmt->execute();
	    
	    
	    $encabezado = "NOMBRE;USUARIO;FECHA;ESTADO\n";
	    
	    $registros = "";
	    
	    while ($arr = $stmt->fetch(PDO::FETCH_ASSOC)) {
	        
	        $registros .= $arr['nombre_tarea'].";".$arr['nombre_usuario_tarea'].";".$arr['fecha_creacion_tarea'].";".$arr['nombre_estado']."\n";
	    }
	    
	    $cuerpo = "$registros";
	    
	    $salida = "$encabezado"."$cuerpo";
	    
		header('Content-Type: text/csv; charset=UTF-8');
		header("Content-Disposition: attachment; filename=ReporteGeneral.csv");
		header('Expires: 0');
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
	    
		echo $salida;
	}
	
	
}