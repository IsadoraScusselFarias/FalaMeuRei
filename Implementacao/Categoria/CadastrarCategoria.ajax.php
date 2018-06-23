<?php
	require_once "../Categoria/Categoria.php";
	require_once "../Categoria/DAOCategoria.php";
	$model = new Categoria();
	$model->setNome(strtoupper($_GET["nome"]));
	$model->setDescricao(strtoupper($_GET["descricao"]));
	$dao= new DAOCategoria();
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