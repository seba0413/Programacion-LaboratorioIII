<?php

require_once "./proveedor.php";

class Pedido
{
    public $producto;
    public $cantidad;
    public $idProveedor;

    public function constructor($producto, $cantidad, $idProveedor)
    {
        $this->producto = $producto;
        $this->cantidad = $cantidad;
        $this->idProveedor = $idProveedor;
    }

    public function hacerPedido($pathPedido, $pathProveedor)
    {
        $datosPedido = "{$this->producto};{$this->cantidad};{$this->idProveedor}".PHP_EOL;

        if (file_exists($pathPedido))        
            $this->validarIdProveedor($pathPedido, $pathProveedor, $datosPedido, "a");
        else
            $this->validarIdProveedor($pathPedido, $pathProveedor, $datosPedido, "w");         
        
    }

    function validarIdProveedor($pathPedido, $pathProveedor, $datosPedido, $modo)
    {
        $arrayProveedores[] = Proveedor::listarProveedores($pathProveedor);
        for($i = 0; $i < count($arrayProveedores); $i++)
        {
            for($j = 0; $j < count($arrayProveedores[$i]); $j++)
            {
                if($arrayProveedores[$i][$j]->id == $this->idProveedor)
                {
                    $file = fopen($pathPedido, $modo);
                    fwrite($file, $datosPedido);
                    fclose($file);
                    break;
                }
            }
        }            
    }

    public static function arrayDePedidos($pathPedido)
    {
        if (file_exists($pathPedido))
        {
            $gestor = fopen($pathPedido, "r");
            while(!feof($gestor))
            {
                $datosPedido = fgets($gestor, filesize($pathPedido));
                $arrayDatosPedido = explode(";", $datosPedido);
                if(count($arrayDatosPedido)>1)
                {
                    $pedido = new Pedido();
                    $pedido->constructor($arrayDatosPedido[0], $arrayDatosPedido[1], trim($arrayDatosPedido[2]));
                    $arrayPedidos[] = $pedido;
                }                
            }                      
            fclose($gestor);
        }
        return $arrayPedidos;
    } 

    public static function listarPedidos($pathPedido, $pathProveedor)
    {
        $arrayPedidos[] = Pedido::arrayDePedidos($pathPedido);
        $arrayProveedores[] = Proveedor::listarProveedores($pathProveedor);

        for($i = 0; $i < count($arrayPedidos[0]); $i++)
        {
            for($j = 0; $j < count($arrayProveedores[0]); $j++)
            {
                if($arrayPedidos[0][$i]->idProveedor == $arrayProveedores[0][$j]->id)
                {
                    Pedido::mostrarDatos($arrayPedidos[0][$i], $arrayProveedores[0][$j]);
                }                    
            }
        }
    }
    
    public static function mostrarDatos($pedido, $proveedor)
    {
        echo "Producto: {$pedido->producto}, Cantidad: {$pedido->cantidad}, Id: {$pedido->idProveedor}, Nombre: {$proveedor->nombre}".PHP_EOL;        
    }

    public static function listarPedidoProveedor($pathPedido, $idProveedor)
    {   
        $arrayPedidos[] = Pedido::arrayDePedidos($pathPedido);
        for($i = 0; $i < count($arrayPedidos[0]); $i++)
        {
            if($arrayPedidos[0][$i]->idProveedor == $idProveedor)
            {
                echo "Producto: {$arrayPedidos[0][$i]->producto}, Cantidad: {$arrayPedidos[0][$i]->cantidad}, IdProveedor: {$arrayPedidos[0][$i]->idProveedor}".PHP_EOL;
            }
        }
    }
}

?>