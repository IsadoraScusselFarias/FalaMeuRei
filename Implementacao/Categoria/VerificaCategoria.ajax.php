<?php
	require_once "../Categoria/Categoria.php";
	require_once "../Categoria/DAOCategoria.php";
	$model = new Categoria();
	$model->setNome(strtoupper($_GET["nome"]));
	$dao=new DAOCategoria();
	if($dao->verificar($model)==null){
		$resposta=true;
	}else{
		$resposta=false;
	}
	echo(json_encode($resposta));	
?>