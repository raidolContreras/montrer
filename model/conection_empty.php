<?php 

class Conexion{

  static public function conectar(){

    #PDO("nombre del servidor; nombre de la base de datos", "usuario", "contraseña")

    $link = new PDO("mysql:host=host;dbname=dbname", "user", "password");

    $link->exec("set names utf8");

    return $link;

  }

}