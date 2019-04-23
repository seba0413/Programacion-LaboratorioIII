<?php

    require_once "./proveedor.php";
    require_once "./pedidos.php";

    $dato = $_SERVER['REQUEST_METHOD'];
   

    switch($dato)
    {
        case "POST": 
        $caso = $_POST['caso'];           
            if($caso == "cargarProveedor")
            {
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];   
                $email = $_POST['email'];
                $foto = $_FILES['foto'];
                $proveedor = new Proveedor();
                $proveedor->constructor($id, $nombre, $email, $nombre.".jpg");
                $proveedor->guardarProveedor("./archivos/proveedores.txt", $foto);
            } 
            if($caso == "hacerPedido") 
            {
                $idProveedor = $_POST['idProveedor'];
                $producto = $_POST['producto'];   
                $cantidad = $_POST['cantidad'];  
                $pedido = new Pedido();
                $pedido->constructor($producto, $cantidad, $idProveedor);
                $pedido->hacerPedido("./archivos/pedidos.txt", "./archivos/proveedores.txt");  
            }              
            break;
        case "GET": 
        $caso = $_GET['caso'];           
            if($caso == "consultarProveedor")
            {
                $nombre = $_GET['nombre'];
                Proveedor::consultarProveedor("./archivos/proveedores.txt", $nombre);
            }
            if($caso == "proveedores")
                Proveedor::proveedores("./archivos/proveedores.txt");

            if($caso == "listarPedidos")
                Pedido::listarPedidos("./archivos/pedidos.txt", "./archivos/proveedores.txt");

            if($caso == "listarPedidoProveedor")
            {
                $id = $_GET['id'];
                Pedido::listarPedidoProveedor("./archivos/pedidos.txt", $id);      
            }
                
            break;
    }


?>