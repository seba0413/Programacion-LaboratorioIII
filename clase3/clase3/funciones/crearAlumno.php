<?php
    require_once "./clases/alumno.php";

    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $dni = $_POST['dni'];
    $legajo = $_POST['legajo'];
    $id = $_POST['id'];

    $alumno = new Alumno();
    $alumno->constructor($nombre, $edad, $dni, $legajo, $id);

    $alumno->InsertarAlumnoParametros();

    //$alumno->guardarAlumnoJSON("./archivos/alumnos.json");

    // $alumno->guardarAlumno("../archivos/alumnos.txt");

?>