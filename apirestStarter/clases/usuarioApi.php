<?php

require_once 'usuario.php';
require_once 'IApiUsable.php';

class UsuarioApi extends Usuario implements IApiUsable
{
	public function TraerUno($request, $response, $args) 
	{
     	$id=$args['id'];
    	$usuario=Usuario::TraerUnUsuario($id);
     	$newResponse = $response->withJson($usuario, 200);  
    	return $newResponse;
	}
	
	public function TraerTodos($request, $response, $args) 
	{
      	$todosLosUsuarios=Usuario::TraerTodosLosUsuarios();
     	$newResponse = $response->withJson($todosLosUsuarios, 200);  
    	return $newResponse;
	}
	
	public function CargarUno($request, $response, $args) {
	  $ArrayDeParametros = $request->getParsedBody();
	  //var_dump($ArrayDeParametros);
	  $usuario= $ArrayDeParametros['usuario'];
	  $password= $ArrayDeParametros['password'];
	  
	  $miUsuario = new Usuario();
	  $miUsuario->usuario=$usuario;
	  $miUsuario->password=$password;
	  $miUsuario->InsertarElUsuarioParametros();

	//   $archivos = $request->getUploadedFiles();
	//   $destino="./fotos/";
	//   //var_dump($archivos);
	//   //var_dump($archivos['foto']);

	//   $nombreAnterior=$archivos['foto']->getClientFilename();
	//   $extension= explode(".", $nombreAnterior)  ;
	//   //var_dump($nombreAnterior);
	//   $extension=array_reverse($extension);

	//   $archivos['foto']->moveTo($destino.$titulo.".".$extension[0]);
	   $response->getBody()->write("se guardo el usuario");

	  return $response;
  }
	  
	public function BorrarUno($request, $response, $args) 
	{
     	$ArrayDeParametros = $request->getParsedBody();
     	$id=$ArrayDeParametros['id'];
     	$usuario= new Usuario();
     	$usuario->id=$id;
     	$cantidadDeBorrados=$usuario->BorrarUsuario();

     	$objDelaRespuesta= new stdclass();
	    $objDelaRespuesta->cantidad=$cantidadDeBorrados;
	    if($cantidadDeBorrados>0)
	    	{
	    		 $objDelaRespuesta->resultado="algo borro!!!";
	    	}
	    	else
	    	{
	    		$objDelaRespuesta->resultado="no Borro nada!!!";
	    	}
	    $newResponse = $response->withJson($objDelaRespuesta, 200);  
      	return $newResponse;
	}
	
	public function ModificarUno($request, $response, $args) 
	{
		echo "Dale Forro!!!!";
     	//$response->getBody()->write("<h1>Modificar  uno</h1>");
     	$ArrayDeParametros = $request->getParsedBody();
	    //var_dump($ArrayDeParametros);    	
	    $miUsuario = new Usuario();
	    $miUsuario->id=$ArrayDeParametros['id'];
	    $miUsuario->usuario=$ArrayDeParametros['usuario'];
	    $miUsuario->password=$ArrayDeParametros['password'];

	   	$resultado =$miUsuario->ModificarUsuarioParametros();
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;
		return $response->withJson($objDelaRespuesta, 200);		
    }

/* final especiales para slimFramework*/
  	public function BorrarUsuario()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
			delete 
			from usuario 				
			WHERE id=:id");	
			$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
			$consulta->execute();
			return $consulta->rowCount();
	}

	// public static function BorrarUsuarioPorAnio($año)
	//  {

	// 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	// 		$consulta =$objetoAccesoDato->RetornarConsulta("
	// 			delete 
	// 			from usuario 				
	// 			WHERE jahr=:anio");	
	// 			$consulta->bindValue(':anio',$año, PDO::PARAM_INT);		
	// 			$consulta->execute();
	// 			return $consulta->rowCount();

	//  }

	public function ModificarUsuario()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
			update usuario 
			set usuario='$this->usuario',
			password='$this->password',
			WHERE id='$this->id'");
		return $consulta->execute();

	}	
  
	public function InsertarElUsuario()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (usuario,password)values('$this->usuario','$this->password'");
		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
				

	}

	  public function ModificarUsuarioParametros()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update usuario 
				set usuario=:usuario,
				password=:password,
				WHERE id=:id");
			$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
			$consulta->bindValue(':usuario',$this->usuario, PDO::PARAM_INT);
			$consulta->bindValue(':password', $this->password, PDO::PARAM_STR);
			return $consulta->execute();
	 }

	 public function InsertarElUsuarioParametros()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (usuario,password)values(:usuario,:password)");
				$consulta->bindValue(':usuario',$this->usuario, PDO::PARAM_INT);
				$consulta->bindValue(':password', $this->password, PDO::PARAM_STR);
				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }
	 public function GuardarUsuario()
	 {

	 	if($this->id>0)
	 		{
	 			$this->ModificarUsuarioParametros();
	 		}else {
	 			$this->InsertarElUsuarioParametros();
	 		}

	 }


  	public static function TraerTodoLosUsuarios()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,usuario, password as contraseña from usuario");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");		
	}

	public static function TraerUnUsuario($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,usuario, password as contraseña from usuario where id = $id");
			$consulta->execute();
			$cdBuscado= $consulta->fetchObject('Usuario');
			return $cdBuscado;				

			
	}

	// public static function TraerUnUsuarioAnio($id,$anio) 
	// {
	// 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	// 		$consulta =$objetoAccesoDato->RetornarConsulta("select  titel as titulo, interpret as cantante,jahr as año from cds  WHERE id=? AND jahr=?");
	// 		$consulta->execute(array($id, $anio));
	// 		$cdBuscado= $consulta->fetchObject('cd');
    //   		return $cdBuscado;				

			
	// }

	// public static function TraerUnUsuarioAnioParamNombre($id,$anio) 
	// {
	// 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	// 		$consulta =$objetoAccesoDato->RetornarConsulta("select  titel as titulo, interpret as cantante,jahr as año from cds  WHERE id=:id AND jahr=:anio");
	// 		$consulta->bindValue(':id', $id, PDO::PARAM_INT);
	// 		$consulta->bindValue(':anio', $anio, PDO::PARAM_STR);
	// 		$consulta->execute();
	// 		$cdBuscado= $consulta->fetchObject('cd');
    //   		return $cdBuscado;				

			
	// }
	
	// public static function TraerUnUsuarioAnioParamNombreArray($id,$anio) 
	// {
	// 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	// 		$consulta =$objetoAccesoDato->RetornarConsulta("select  titel as titulo, interpret as cantante,jahr as año from cds  WHERE id=:id AND jahr=:anio");
	// 		$consulta->execute(array(':id'=> $id,':anio'=> $anio));
	// 		$consulta->execute();
	// 		$cdBuscado= $consulta->fetchObject('cd');
    //   		return $cdBuscado;				

			
	// }

	public function mostrarDatos()
	{
	  	return "Metodo mostar:".$this->titulo."  ".$this->cantante."  ".$this->año;
	}

}