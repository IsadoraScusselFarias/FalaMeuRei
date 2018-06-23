<?php
	require_once "../Modelo/Modelo.php";
	require_once "../Modelo/DAOModelo.php";
	$model = new Modelo();
	$model->setModelo(strtoupper($_GET["modelo"]));
	$dao=new DAOModelo();
	if ($dao->verificar($model)=="") {
		$resposta=true;
	}else{
		$resposta=false;
	}
	echo(json_encode($resposta));	
?>