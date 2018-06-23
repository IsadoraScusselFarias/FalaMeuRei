<?php
	require_once "../Cliente/Cliente.php";
	require_once "../Cliente/DAOCliente.php";
	$model = new Cliente();
	$model->setEmail(strtolower($_GET["email"]));
	$model->setCpf($_GET["cpf"]);
	$model->setCnpj($_GET["cnpj"]);
	$model->setId($_GET["id"]);
	$dao=new DAOCliente();
	if($dao->verificar($model)==null){
		$resposta=true;
	}else{
		$resposta=false;
	}
	echo(json_encode($resposta));	
?>