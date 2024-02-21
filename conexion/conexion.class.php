<?php

class Conexion {

	/* ================================================
    * Informacion de la base de datos
    ================================================== */
    static public function infoDatabase(){

        $infoDB = array(
            "database" => "todolist",
            "user" => "usertodolist",
            "pass" => "1nf0rm4t1c4*2024"
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