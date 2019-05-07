<?php

require_once './clases/AccesoDatos.php';

class Usuario
{
	public $id;
 	public $usuario;
  	public $password;

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
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (usuario,password)values('$this->usuario','$this->password')");
				$consulta->execute();
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
				

	}

	public function ModificarUsuarioParametros()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update usuario 
				set usuario=:usuario,
				password=:password
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


  	public static function TraerTodosLosUsuarios()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,usuario, password as constraseña from usuario");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");		
	}

	public static function TraerUnUsuario($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id,usuario, password as constraseña from usuario where id = $id");
			$consulta->execute();
			$cdBuscado= $consulta->fetchObject('Usuario');
			return $cdBuscado;				

			
	}

	public function mostrarDatos()
	{
	  	return "Metodo mostar:".$this->titulo."  ".$this->cantante."  ".$this->año;
	}

}