<?php
    include "alumno.php";

    echo "get";
    var_dump($_GET);

    echo "post";
    var_dump($_POST);

    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $dni = $_POST['dni'];
    $legajo = $_POST['legajo'];

    $alumno = new Alumno($nombre, $edad, $dni, $legajo);

    var_dump($alumno->retornarJson());


?>