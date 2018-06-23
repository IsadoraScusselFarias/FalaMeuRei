<?php
	require_once "../Sucata/Sucata.php";
	require_once "../Sucata/DAOSucata.php";
	$model = new Sucata();
	$model->setLote(strtoupper($_GET["lote"]));
	$dao=new DAOSucata();
	if($dao->verificar($model)==null){
		$resposta=true;
	}else{
		$resposta=false;
	}
	echo(json_encode($resposta));	
?>