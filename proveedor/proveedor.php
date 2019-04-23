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
            echo "No existe proveedor ". $this->nombre;
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
                    $proveedor->constructor(trim($arrayDatosProveedor[0]), $arrayDatosProveedor[1], $arrayDatosProveedor[2], $arrayDatosProveedor[3]);
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
            echo "Id: {$proveedor->id}, Nombre: {$proveedor->nombre}, Edad: {$proveedor->email}".PHP_EOL;
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
        $rutafoto = "./fotos/{$this->nombre}_{$this->id}.{$extension[$index]}";
        //Obtengo la fecha de hoy
        $fecha = date("d") . "-" . date("m") . "-" . date("Y");
        //Guardo la ruta del servidor donde voy a backupear las fotos viejas
        $rutaBackup = "./fotosBackup/{$this->nombre}_{$this->id}_{$fecha}.{$extension[$index]}";
        //Ruta de la imagen png
        $estampa = "./fotos/estampa.png";
        
        //if(!$this->backupFoto($ruta, $rutafoto, $rutaBackup))
        //{
        move_uploaded_file($ruta, $rutafoto);            
        //}  

        //$this->insertarEstampa($rutafoto, $estampa);        
    }
}

?>

