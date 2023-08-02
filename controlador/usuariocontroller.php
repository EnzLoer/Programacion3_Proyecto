<?php
require_once("../modelo/usuario.php");
$usuobj=new usuario;
switch ($_POST['opcion']) {
	case 'consulta':
		$datos=$usuobj->obtenerTodo();
		$tabla="";
		foreach ($datos as $fila) {
			$tabla.="<tr><td>".$fila['codigo']."</td>";
			$tabla.="<td>".$fila['usuario']."</td>";
			$tabla.="<td>".$fila['password']."</td>";
			$tabla.="<td>".$fila['rol']."</td>";
			$tabla.="<td>".$fila['correo']."</td>";
			$tabla.="<td>".$fila['fecha_creacion']."</td></tr>";
		}
		echo $tabla;
		break;
	case 'registrar':
		$datos['username']=$_POST['username'];
		$datos['password']=$_POST['password'];
		$datos['rol']=$_POST['rol'];
		$datos['correo']=$_POST['correo'];
		$datos['fecha_creacion']=date("Y-m-d"); 
		echo ($usuobj->registrar($datos));
		break;
	case 'login':
		$filtro['usuario']=$_POST['usuario'];
		$filtro['password']=$_POST['password'];
		$usuario=$usuobj->consultarusuario($filtro);
		if(empty($usuario))
		{
			echo "No se pueden validar credenciales";
		}
		else
		{
			session_start();
			$_SESSION['usuario']=$usuario[0]['usuario'];
			echo true;
		}
		break;
	case 'validarsesion':
		session_start();
		if (isset($_SESSION['usuario'])){
			echo true;
		}else{
			echo false;
		}
		break;
	case 'cerrarsesion':
		session_start();
		if (isset($_SESSION['usuario'])){
			unset($_SESSION['usuario']);
			echo false;
		}
		break;
	case 'verBiblioteca':
		$datos=$usuobj->verBiblioteca();
		$tabla="";
		foreach ($datos as $fila) {
			$tabla.="<tr><td>".$fila['titulo']."</td>";
			$imagen = base64_encode($fila['imagen']);
			$tabla .= '<td><img src="data:image/jpeg;base64,' . $imagen . '" width="100" height="100" /></td>';
			$tabla.="<td>".$fila['descripcion']."</td></tr>";
		}
		echo $tabla;
		break;
	case 'comprarVideojuego':
		session_start();
		$datos['usuario_id'] = $_SESSION['usuario_id'];
		$datos['videojuego_id'] = $_POST['videojuego_id']; //formulario donde seleccionas el videojuego a comprar.
		$datos['fecha_creacion'] = date("Y-m-d");
		echo ($usuobj->comprarVideojuego($datos));
		break;
	case 'eliminarDeBiblioteca':
		session_start();
		$datos['usuario_id'] = $_SESSION['usuario_id'];
		$datos['videojuego_id'] = $_POST['videojuego_id'];
		echo ($usuobj->eliminarDeBiblioteca($datos));
		break;
	case 'registrarNuevoVideojuego':
		$datos['titulo']=$_POST['titulo'];
		$datos['descripcion']=$_POST['descripcion'];
		$datos['imagen'] = file_get_contents($_FILES['imagen']['tmp_name']);
		echo ($usuobj->añadirVideojuego($datos));
		break;
	case 'eliminarVideojuego':
		$datos['videojuego_id'] = $_POST['videojuego_id'];
		echo ($usuobj->eliminarVideojuego($datos));
		break;
	case 'actualizarVideojuego':
		$datos['id']=$_POST['id'];
		$datos['titulo']=$_POST['titulo'];
		$datos['descripcion']=$_POST['descripcion'];
		$datos['imagen'] = file_get_contents($_FILES['imagen']['tmp_name']);
		$usuobj->actualizarVideojuego($datos);
		break;
	default:
		// code...
		break;
}
?>