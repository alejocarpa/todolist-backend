<?php

class Conexion {

	/* ================================================
    * Informacion de la base de datos
    ================================================== */
    static public function infoDatabase(){

        $infoDB = array(
            "database" => "todolist",
            "user" => "admin",
            "pass" => "4dm1n2018*"
        );

        return $infoDB;

    }
    
    /* ================================================
     * Conexion a la base de datos
     ================================================== */
    static public function connect(){
        
        try{
            
            $link = new PDO(
                "mysql:host=localhost;dbname=".Conexion::infoDatabase()['database'],
                Conexion::infoDatabase()['user'],
                Conexion::infoDatabase()['pass']
                );
            
            $link->exec("set names utf8");
            
        }catch(PDOException $e){
            die("Error: ".$e->getMessage());
        }
        
        return $link;
    }
}