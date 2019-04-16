<?php
    require_once "./clases/alumno.php";

    $datosPUT = fopen("php://input", "r");
    $fp = fopen("./archivos/mificheroput.json", "w");    
    while ($datos = fread($datosPUT, 1024))
      fwrite($fp, $datos);
    
    fclose($fp);
    fclose($datosPUT);

    


    $alumno = new Alumno($nombre, $edad, $dni, $legajo);

    $alumno->modificarAlumno("./archivos/alumnos.json");

?>