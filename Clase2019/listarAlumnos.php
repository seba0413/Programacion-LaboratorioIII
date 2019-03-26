<?php
    include "alumno.php";

    $alumnos = Alumno::listarAlumnos("datosAlumnos.txt");
    foreach($alumnos as $alumno)
    {
        echo $alumno->mostrarDatos($alumno);
    }

    //var_dump(Alumno::listarAlumnosJSON("datosAlumnos.json"));
?> 