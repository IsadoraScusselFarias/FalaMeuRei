<?php
	require_once "../Peca/Peca.php";
	require_once "../Carro/Carro.php";
	require_once "../Peca/DAOPeca.php";
	$model = new Peca();
	$model->setNome(strtolower($_GET["nome"]));
	$modelCarro = new Carro();
	$modelCarro->setId($_GET["carro"]);
	$model->setCarro($modelCarro);
	$dao=new DAOPeca();
	if($dao->verificar($model)==null){
		$resposta=true;
	}else{
		$resposta=false;
	}
	echo(json_encode($resposta));	
?>