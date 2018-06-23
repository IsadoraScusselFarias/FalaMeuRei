<?php
	require_once "Fornecedor.php";
	require_once "DAOFornecedor.php";
	require_once "../Cidade/Cidade.php";
	require_once "../Cidade/DAOCidade.php";
	require_once "../Estado/DAOEstado.php";
	$model = new Fornecedor();
	$model->setEmail(strtolower($_GET["emailFornecedor"]));
	$model->setCnpj($_GET["cnpjFornecedor"]);
	$model->setNome(strtoupper($_GET["nome"]));
	$model->setEndereco(strtoupper($_GET["endereco"]));
	$model->setTelefone($_GET["telefone"]);
	$daoCidade = new DAOCidade();
	if ($_GET["cidade"]!="") {
		$model->setCidade($daoCidade->consultarPorId($_GET["cidade"]));
	}else{
		$modelCidade = new Cidade();
		$model->setCidade($modelCidade);
	}
	$dao= new DAOFornecedor();
	if($dao->inserir($model)){
		$resposta=array(
			'id'=> $model->getId(),
			'nome'=> $model->getNome(),
			'pessoa'=> $model->getCnpj()
		);
	}else{
		$resposta="erro";
	}
	echo(json_encode($resposta));	
?>