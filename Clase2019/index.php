<?php

    require "crearAlumno.php";
    echo " <br> <h1> Hola </h1>";

    $nombre = "Sebastian";

    // var_dump($nombre);

    $array = array(
        "nombre" => "Jose",
        "edad" => 22,
    );

    $miArray = array();
    $miArray["nombre"] = "Sebastian";
    $miArray["edad"] = 31;

    // var_dump($array);

    $miObj = new stdClass();
    $miObj->nombre = "Sebastian";
    $miObj->edad = 31;

    $alumno = new Alumno("pepe", 24);
    $otroAlumno = new Alumno("jose", 22);

    var_dump($alumno); 
    var_dump($otroAlumno); 

    var_dump($otroAlumno->retornarJson()); 

?>