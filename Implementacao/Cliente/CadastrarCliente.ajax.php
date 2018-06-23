<?php
	require_once "Cliente.php";
	require_once "DAOCliente.php";
	require_once "../Cidade/Cidade.php";
	require_once "../Cidade/DAOCidade.php";
	require_once "../Estado/DAOEstado.php";
	$model = new Cliente();
	$model->setEmail(strtolower($_GET["emailCliente"]));
	$model->setCpf($_GET["cpf"]);
	$model->setCnpj($_GET["cnpjCliente"]);
	$model->setNomeCompleto(strtoupper($_GET["nomeCompleto"]));
	$model->setEndereco(strtoupper($_GET["endereco"]));
	$model->setTelefone($_GET["telefone"]);
	$daoCidade = new DAOCidade();
	$model->setCidade($daoCidade->consultarPorId($_GET["cidade"]));
	$dao= new DAOCliente();
	if($dao->inserir($model)){
		$resposta=array(
			'id'=> $model->getId(),
			'nome'=> $model->getNome(),
			'pessoa'=> $model->getCpf().$model->getCnpj()
		);
	}else{
		$resposta="erro";
	}
	echo(json_encode($resposta));	
?>