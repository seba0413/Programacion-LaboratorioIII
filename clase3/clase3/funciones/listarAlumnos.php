<?php
    require_once "./clases/alumno.php";

    $alumnos = Alumno::TraerTodoLosAlumnos();
    Alumno::mostrarDatos($alumnos);

    // $alumnos = Alumno::listarAlumnos("../archivos/datosAlumnos.txt");
    // Alumno::mostrarDatos($alumnos);

?> 