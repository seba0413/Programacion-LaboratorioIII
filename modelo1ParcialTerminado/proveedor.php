<?php

class Proveedor {

    public $id;
    public $nombre;
    public $email;
    public $foto;

    public function constructor($id, $nombre, $email, $foto)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->foto = $foto;
    }

    public function guardarProveedor($path, $foto)
    {
        $datosProveedor = "{$this->id};{$this->nombre};{$this->email};{$this->foto}".PHP_EOL;

        if (file_exists($path))
        {
            $file = fopen($path, "a");
            fwrite($file, $datosProveedor);
            fclose($file);
        }  
        else
        {
            $file = fopen($path, "w");
            fwrite($file, $datosProveedor);
            fclose($file);
        }

        $this->guardarFoto($foto);
    }

    public static function consultarProveedor($path, $nombre)
    {
        $proveedorArray = Proveedor::listarProveedores($path);
        $arrayRetorno = Proveedor::ejecutarConsulta($proveedorArray, $nombre);

        if($arrayRetorno)
            Proveedor::mostrarDatos($arrayRetorno);
        else
            echo "No existe proveedor ". $nombre;
    }

    public static function proveedores($path)
    {
        $arrayProveedores = Proveedor::listarProveedores($path);
        Proveedor::mostrarDatos($arrayProveedores);
    }

    public static function listarProveedores($path)
    {
        if (file_exists($path))
        {
            $gestor = fopen($path, "r");
            while(!feof($gestor))
            {
                $datosProveedor = fgets($gestor, filesize($path));
                $arrayDatosProveedor = explode(";", $datosProveedor);
                if(count($arrayDatosProveedor)>1)
                {
                    $proveedor = new Proveedor();
                    $proveedor->constructor(trim($arrayDatosProveedor[0]), trim($arrayDatosProveedor[1]), trim($arrayDatosProveedor[2]), trim($arrayDatosProveedor[3]));
                    $arrayProveedores[] = $proveedor;
                }                
            }                          
            fclose($gestor);
        }  
        return $arrayProveedores;
    }

    static function ejecutarConsulta($proveedoresArray, $nombre)
    {
        foreach($proveedoresArray as $proveedor)
        {
            if (strcmp ($proveedor->nombre , $nombre ) == 0)
            {
                $arrayRetorno[] = $proveedor;                
            }                
        }
        return $arrayRetorno;
    }

    public static function mostrarDatos($proveedores)
    {
        foreach($proveedores as $proveedor)
        {
            echo "Id: {$proveedor->id}, Nombre: {$proveedor->nombre}, Email: {$proveedor->email}".PHP_EOL;
        }
    }

    public function guardarFoto($foto)
    {        
        //Ruta temporal de la foto.
        $ruta = $foto['tmp_name'];
        //Separo el string del nombre de la foto por puntos y me quedo con la ultima parte que es la extension
        $extension = explode(".",$foto['name']);
        $index = count($extension) - 1;
        //Guardo la ruta del servidor donde se va a guardar la foto. 
        $rutafoto = "./fotos/Id_{$this->id}.{$extension[$index]}";
        //Obtengo la fecha de hoy
        $fecha = date("d") . "-" . date("m") . "-" . date("Y");
        //Guardo la ruta del servidor donde voy a backupear las fotos viejas
        $rutaBackup = "./fotosBackup/{$this->id}_{$fecha}.{$extension[$index]}";
        
        if(!$this->backupFoto($ruta, $rutafoto, $rutaBackup))
        {
            move_uploaded_file($ruta, $rutafoto);            
        }       
    }

    function backupFoto($rutaTemporal, $rutaOriginal, $rutaDestino)
    {
        if(file_exists($rutaOriginal))
        {
            rename($rutaOriginal, $rutaDestino);
            move_uploaded_file($rutaTemporal, $rutaOriginal);
            return true;
        }

        return false;  
    }

    public function modificarProveedor($path, $foto)
    {
        $proveedoresArray = Proveedor::listarProveedores($path);
        $this->modificarDatos($proveedoresArray);        
        $this->escribirArchivoTXT($path, $proveedoresArray);
        $this->guardarFoto($foto);
    }

    function modificarDatos($proveedoresArray)
    {
        foreach($proveedoresArray as $proveedor)
        {
            if (strcmp ($proveedor->id , $this->id) == 0)
            {
                $proveedor->nombre = $this->nombre;
                $proveedor->email = $this->email;
                $proveedor->foto = $this->foto;
                break;
            }                
        }
    }

    function escribirArchivoTXT($path, $proveedoresArray)
    {
        $file = fopen($path, "w");
        foreach ($proveedoresArray as $proveedor)
        {
            $datosProveedor = "{$proveedor->id};{$proveedor->nombre};{$proveedor->email};{$proveedor->foto}".PHP_EOL;
            fwrite($file, $datosProveedor);
        }                
        fclose($file);
    }

    public static function fotosBack($path)
    {        
        if ($gestor = opendir('./fotosBackup')) 
        {
            while (false !== ($entrada = readdir($gestor))) 
            {
                if($entrada != '.' && $entrada != '..')
                {
                    $var = explode("_", $entrada);
                    $id = $var[0];
                    $var2 = explode(".", $var[1]);
                    $fecha = $var2[0];
                    $nombreProveedor = Proveedor::buscarProveedorPorId($path, $id);
                    echo $nombreProveedor."_".$fecha."\n";                
                }        
            }    
        }
        closedir($gestor);
    }

    static function buscarProveedorPorId($path, $id)
    {
        $arrayProveedores = Proveedor::listarProveedores($path);
        foreach($arrayProveedores as $proveedor)
        {
            if($proveedor->id == $id)
                return $proveedor->nombre;            
        }
    }
}

?>

