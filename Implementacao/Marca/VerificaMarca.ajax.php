<?php
	require_once "../Marca/Marca.php";
	require_once "../Marca/DAOMarca.php";
	$model = new Marca();
	$model->setMarca(strtoupper($_GET["marca"]));
	$dao=new DAOMarca();
	if ($dao->verificar($model)=="") {
		$resposta=true;
	}else{
		$resposta=false;
	}
	echo(json_encode($resposta));	
?>