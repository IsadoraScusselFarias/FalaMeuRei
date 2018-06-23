<?php
	require_once "../Usuario/Usuario.php";
	require_once "../Usuario/DAOUsuario.php";
	$model = new Usuario();
	$model->setEmail(strtolower($_GET["email"]));
	$model->setId(strtolower($_GET["id"]));
	$dao=new DAOUsuario();
	if($dao->verificar($model)==null){
		$resposta=true;
	}else{
		$resposta=false;
	}
	echo(json_encode($resposta));	
?>