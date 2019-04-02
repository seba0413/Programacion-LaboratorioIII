<?php
include "persona.php";

class Alumno extends Persona{
  
    public $legajo;

    function __construct($nombre, $edad, $dni, $legajo) 
    {
        parent::__construct($nombre, $edad, $dni);
        $this->legajo = $legajo;
    }

    public function guardarAlumno($path)
    {
        $datosAlumnos = "{$this->nombre};{$this->edad};{$this->dni};{$this->legajo}".PHP_EOL;

        if (file_exists($path))
        {
            $file = fopen($path, "a");
            fwrite($file, $datosAlumnos);
            fclose($file);
        }  
        else
        {
            $file = fopen($path, "w");
            fwrite($file, $datosAlumnos);
            fclose($file);
        }
    }

    
    public function guardarAlumnoJSON($path)
    {
        if (file_exists($path))
        {
            $file = fopen($path, "a");
            fwrite($file, $this->retornarJson());
            fclose($file);
        }  
        else
        {
            $file = fopen($path, "w");
            fwrite($file, $this->retornarJson());
            fclose($file);
        }
    }

    public static function listarAlumnos($path)
    {
        if (file_exists($path))
        {
            $gestor = fopen($path, "r");
            while(!feof($gestor))
            {
                $contenido = fgets($gestor, filesize($path));
                $arrayDatosAlumno = explode(";", $contenido);
                $alumno = new Alumno($arrayDatosAlumno[0], $arrayDatosAlumno[1], $arrayDatosAlumno[2], $arrayDatosAlumno[3]);
                $arrayAlumnos = array();
                array_push($arrayAlumnos, $alumno);
            }            
            fclose($gestor);
        }  

        return $arrayAlumnos;
    }

    public function mostrarDatos($alumno)
    {
        $datosFormateados = "Nombre: {$alumno->nombre}, Edad: {$alumno->edad}, Dni: {$alumno->dni}, Legajo: {$alumno->legajo}";
        return $datosFormateados;
    }

    public static function listarAlumnosJSON($path)
    {
        if (file_exists($path))
        {
            $gestor = fopen($path, "r");
            $contenido = fread($gestor, filesize($path));
            fclose($gestor);
        }  
       return json_decode($contenido);
    }

    public function guardarFoto($archivoTemporal)
    {        
        //Ruta del archivo temporal
        $ruta = $archivoTemporal['foto']['tmp_name'];
        //Separo el string del nombre del archivo por puntos y me quedo con la ultima parte que es la extension
        $extension = explode(".",$archivoTemporal['foto']['name']);
        $index = count($extension) - 1;
        //Guardo la ruta del servidor donde se va a guardar el archivo
        $rutaArchivo = "fotos/{$this->legajo}{$this->nombre}.{$extension[$index]}";
        //Obtengo la fecha de hoy
        $fecha = date("d") . "-" . date("m") . "-" . date("Y");
        //Guardo la ruta del servidor donde voy a backupear las fotos viejas
        $rutaBackup = "fotosBackup/{$this->legajo}{$this->nombre}{$fecha}.{$extension[$index]}";
        
        if(file_exists($rutaArchivo))
        {
            rename($rutaArchivo, $rutaBackup);        
            move_uploaded_file($ruta, $rutaArchivo);
        }  
        else
        {
            move_uploaded_file($ruta, $rutaArchivo);
        } 
    }
}
?>