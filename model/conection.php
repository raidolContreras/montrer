<?php 

class Conexion{

  static public function conectar(){

    #PDO("nombre del servidor; nombre de la base de datos", "usuario", "contraseña")

    $link = new PDO("mysql:host=https://tests.contreras-flota.click/;dbname=u895534236_tests", 
                  "u895534236_tests", 
                  "fjz6GG5l7ly{");

    $link->exec("set names utf8");

    return $link;

  }

}