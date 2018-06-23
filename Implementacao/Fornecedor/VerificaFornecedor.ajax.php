<?php
	require_once "../Fornecedor/Fornecedor.php";
	require_once "../Fornecedor/DAOFornecedor.php";
	$model = new Fornecedor();
	$model->setEmail(strtolower($_GET["email"]));
	$model->setCnpj($_GET["cnpj"]);
	$dao=new DAOFornecedor();
	if($dao->consultarComFiltro($model)==null){
		$resposta=true;
	}else{
		$resposta=false;
	}
	echo(json_encode($resposta));	
?>