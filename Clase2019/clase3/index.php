<?php
    /* Crear un archivo guardarFoto.php y desde ahi recibir los datos por post y pasarlos por parametro
    al alumno, que va a tener una funcion guardarFoto y otra backupFoto, que se va a llamar dentro 
    de la anterior

        Guardar las fotos con marca de agua. Usar imageCopyMerge.
    */
    require_once "clases/alumno.php";

    $nombre = $_POST['nombre'];
    $legajo = $_POST['legajo'];
    
    //Ruta del archivo temporal
    $ruta = $_FILES['foto']['tmp_name'];
    //Separo el string del nombre del archivo por puntos y me quedo con la ultima parte que es la extension
    $extension = explode(".",$_FILES['foto']['name']);
    $index = count($extension) - 1;
    //Guardo la ruta del servidor donde se va a guardar el archivo
    $rutaArchivo = "fotos/{$legajo}{$nombre}.{$extension[$index]}";
    //Obtengo la fecha de hoy
    $fecha = date("d") . "-" . date("m") . "-" . date("Y");
    //Guardo la ruta del servidor donde voy a backupear las fotos viejas
    $rutaBackup = "fotosBackup/{$legajo}{$nombre}{$fecha}.{$extension[$index]}";
      
    if(file_exists($rutaArchivo))
    {
        rename($rutaArchivo, $rutaBackup);        
        move_uploaded_file($ruta, $rutaArchivo);
    }  
    else
    {
        move_uploaded_file($ruta, $rutaArchivo);
    }       

    var_dump($_FILES);


    // require "crearAlumno.php";
    // echo " <br> <h1> Hola </h1>";

    // $nombre = "Sebastian";

    // // var_dump($nombre);

    // $array = array(
    //     "nombre" => "Jose",
    //     "edad" => 22,
    // );

    // $miArray = array();
    // $miArray["nombre"] = "Sebastian";
    // $miArray["edad"] = 31;

    // // var_dump($array);

    // $miObj = new stdClass();
    // $miObj->nombre = "Sebastian";
    // $miObj->edad = 31;

    // $alumno = new Alumno("pepe", 24);
    // $otroAlumno = new Alumno("jose", 22);

    // var_dump($alumno); 
    // var_dump($otroAlumno); 

    // var_dump($otroAlumno->retornarJson()); 
?>