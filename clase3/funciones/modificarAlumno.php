<?php
require_once "../clases/Alumno.php";

$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$dni = $_POST['dni'];
$legajo = $_POST['legajo'];

$alumno = new Alumno($nombre, $edad, $dni, $legajo);

$alumno->modificarAlumno("../archivos/alumnos.json");

?>