<?php
require_once("conexion.php");
Class usuario
{
	public function obtenerTodo()
	{
		$con=new conexion;
		$resultados=$con->consultar("usuario");
		$con=null;
		return $resultados;
	}
	
	public function verBiblioteca()
	{
		$con=new conexion;
		$resultados=$con->consultarBiblioteca();
		$con=null;
		return $resultados;
	}

	public function consultarTienda()
	{
		$con=new conexion;
		$resultados=$con->consultarTienda();
		$con=null;
		return $resultados;
	}

	public function registrar($datos)
	{
		$con=new conexion;
		$mensaje=$con->insertar("usuario",$datos);
		$con=null;
		return $mensaje;
	}
	
	public function comprarVideojuego($datos)
	{
		$con=new conexion;
		$mensaje=$con->comprarVideojuego("biblioteca",$datos);
		$con=null;
		return $mensaje;
	}

	public function eliminarDeBiblioteca($datos)
	{
		$con=new conexion;
		$mensaje=$con->eliminarDeBiblioteca("biblioteca",$datos);
		$con=null;
		return $mensaje;
	}

	public function añadirVideojuego($datos){
		$con=new conexion;
		$mensaje=$con->insertar("videojuego",$datos);
		$con=null;
		return $mensaje;
	}
	
	public function eliminarVideojuego($datos)
	{
		$con=new conexion;
		$mensaje=$con->eliminarVideojuego("videojuego",$datos);
		$con=null;
		return $mensaje;
	}

	public function actualizarVideojuego($datos)
	{
		$con=new conexion;
		$mensaje=$con->actualizarVideojuego("videojuego",$datos);
		$con=null;
		return $mensaje;
	}

	public function consultarusuario($filtro)
	{
		$con=new conexion;
		$datos=$con->consultarFiltro("usuario",$filtro);
		$con=null;
		return $datos;
	}


}
?>