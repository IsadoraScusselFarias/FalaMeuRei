<?php
	require_once "Peca.php";
	require_once "DAOPeca.php";
	require_once "../Carro/Carro.php";
	require_once "../Carro/DAOCarro.php";
	$model = new Peca();
	$model->setNome(strtoupper($_GET["nomePeca"]));
	$model->setQuantidade(0);
	$model->setPreco($_GET["preco"]);
	$model->setDescricao(strtoupper($_GET["descricao"]));
	$daoCarro= new DAOCarro();
    $model->setCarro($daoCarro->consultarPorId($_GET["carro"]));
	$dao= new DAOPeca();
	if($dao->inserir($model)){
		$resposta=array(
			'id'=> $model->getId(),
			'nome'=> $model->getNome()
		);
	}else{
		$resposta="erro";
	}
	echo(json_encode($resposta));	
?>