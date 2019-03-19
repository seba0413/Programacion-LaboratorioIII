<?php
    include "alumno.php";

    echo "get";
    var_dump($_GET);

    echo "post";
    var_dump($_POST);

    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];

    $alumno = new Alumno($nombre, $edad);

    var_dump($alumno->retornarJson());
?>