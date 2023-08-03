<?php

Class Conexion
{
	private $usuario="root";
	private $pass="";
	private $dbcon=null;
	private $dns="mysql:host=localhost:3306;dbname=final";
	private $error=null;

	private function conectar()
	{
		try{
			$this->dbcon=new PDO($this->dns,$this->usuario,$this->pass);
			$this->dbcon->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			return true;
		}catch(PDOException $e)
		{
			$this->error=$e->getMessage();
			return false;
		}
	}

	public function consultar($tabla)
	{
		try{
			if(!$this->conectar())
			{
				return "No conecta: ".$this->error;
				exit;
			}
			$query="Select * from $tabla";
			$result_set=$this->dbcon->prepare($query);
			$result_set->execute();
			$resultados=$result_set->fetchAll();
			return $resultados;

		}catch(Exception $e)
		{
			return $e->getMessage();
		}
	}

	public function consultarBiblioteca()
	{
		try
		{
			if(!$this->conectar())
			{
				return "No conecta: ".$this->error;
				exit;
			}
			session_start();
			
			if (isset($_SESSION['usuario_id']))
			{
				$usuario_id = $_SESSION['usuario_id'];
			}
			$query="SELECT v.titulo, v.imagen, v.descripcion FROM videojuego v 
			INNER JOIN biblioteca b ON v.videojuego_id = b.v_id
			INNER JOIN usuario u ON b.u_id = 1 ";
			$result_set=$this->dbcon->prepare($query);
			$result_set->execute();
			$resultados = $result_set->fetchAll();
			return $resultados;
		}catch(Exception $e)
		{
			return $e->getMessage();
		}
	}

	public function consultarTienda()
    {
        try
        {
            if(!$this->conectar())
            {
                return "No conecta: ".$this->error;
                exit;
            }
            $query="SELECT v.titulo, v.imagen, v.descripcion FROM videojuego v";
            $result_set=$this->dbcon->prepare($query);
            $result_set->execute();
            $resultados = $result_set->fetchAll();
            return $resultados;
        }catch(Exception $e)
        {
            return $e->getMessage();
        }
    }

	public function consultarFiltro($tabla,$filtro)
	{
		try{
			if(!$this->conectar())
			{
				return "No conecta: ".$this->error;
				exit;
			}
			$query="Select * from $tabla where ";
			foreach($filtro as $clave=>$valor)
			{
				$query.= $clave."= :".$clave." and ";
			}
			$query=substr($query,0,strlen($query)-4);
			$result_set=$this->dbcon->prepare($query);
			foreach($filtro as $clave=>$valor)
			{
				$clave=":".$clave;
				$result_set->bindValue($clave,$valor);
			}
			$result_set->execute();
			$resultados=$result_set->fetchAll();
			return $resultados;

		}catch(Exception $e)
		{
			return $e->getMessage();
		}
	}
	
	public function insertar($tabla,$datos)
	{
		try{
			if(!$this->conectar())
			{
				return "No conecta: ".$this->error;
				exit;
			}
			$sentencia="Insert into $tabla (";
			foreach($datos as $clave=>$valor)
			{
				$sentencia.=$clave.",";
			}
			$sentencia=substr($sentencia,0,strlen($sentencia)-1).") values (";
			foreach($datos as $clave=>$valor)
			{
				$sentencia.=":".$clave.",";
			}
			$sentencia=substr($sentencia,0,strlen($sentencia)-1).")";
			$st=$this->dbcon->prepare($sentencia);
			foreach($datos as $clave=>$valor)
			{
				$clave=":".$clave;
				$st->bindValue($clave,$valor);
			}
			$st->execute();
			return "Registro guardado...";

		}catch(Exception $e)
		{
			return $e->getMessage();
		}
	}

	public function comprarVideojuego($tabla, $datos)
	{
		try {
			if (!$this->conectar()) {
				return "No conecta: " . $this->error;
				exit;
			}

			$sentencia = "Insert into $tabla (";
			foreach ($datos as $clave => $valor) {
				$sentencia .= $clave . ",";
			}
			$sentencia = substr($sentencia, 0, strlen($sentencia) - 1) . ") values (";
			foreach ($datos as $clave => $valor) {
				$sentencia .= ":" . $clave . ",";
			}
			$sentencia = substr($sentencia, 0, strlen($sentencia) - 1) . ")";
			$st = $this->dbcon->prepare($sentencia);
			foreach ($datos as $clave => $valor) {
				$clave = ":" . $clave;
				$st->bindValue($clave, $valor);

				// Manejar claves foráneas
				if ($valor == 'usuario_id' || $valor == 'videojuego_id') {
					$st->bindValue($clave, $valor, PDO::PARAM_INT);
				} else {
					$st->bindValue($clave, $valor);
				}
			}

			$st->execute();
			return "Juego añadido con éxito...";
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function eliminarDeBiblioteca($tabla, $datos){
		try{
			if (!$this->conectar()) {
				return "No conecta: " . $this->error;
				exit;
			}

			$sentencia = "DELETE FROM $tabla WHERE ";
			foreach($datos as $clave=>$valor)
			{
				$sentencia.= $clave."= :".$clave." and ";
			}
			$sentencia=substr($sentencia,0,strlen($sentencia)-4);
			$result_set=$this->dbcon->prepare($sentencia);
			foreach($datos as $clave=>$valor)
			{
				$clave=":".$clave;
				$result_set->bindValue($clave,$valor);
			}
			$result_set->execute();
			return "Juego eliminado de la Biblioteca...";
		}catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function eliminarVideojuego($tabla, $datos){
		try{
			if (!$this->conectar()) {
				return "No conecta: " . $this->error;
				exit;
			}

			$sentencia = "DELETE FROM $tabla WHERE ";
			foreach($datos as $clave=>$valor)
			{
				$sentencia.= $clave."= :".$clave." and ";
			}
			$sentencia=substr($sentencia,0,strlen($sentencia)-4);
			$result_set=$this->dbcon->prepare($sentencia);
			foreach($datos as $clave=>$valor)
			{
				$clave=":".$clave;
				$result_set->bindValue($clave,$valor);
			}
			$result_set->execute();
			return "Juego eliminado de la Página...";
		}catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function actualizarVideojuego($tabla, $datos){
		try{
			if (!$this->conectar()) {
				return "No conecta: " . $this->error;
				exit;
			}

			$sentencia = "UPDATE $tabla SET ";
			foreach($datos as $clave=>$valor)
			{
				$sentencia.= $clave."= :".$clave;
			}
			$sentencia=substr($sentencia,0,strlen($sentencia));
			$result_set=$this->dbcon->prepare($sentencia);
			foreach($datos as $clave=>$valor)
			{
				$clave=":".$clave;
				$result_set->bindValue($clave,$valor);
			}
			$result_set->execute();
			return "Juego actualizado...";
		}catch (Exception $e) {
			return $e->getMessage();
		}
	}
}

?>