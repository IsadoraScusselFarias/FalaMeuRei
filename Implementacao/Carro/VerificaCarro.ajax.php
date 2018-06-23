<?php
	require_once "../Carro/Carro.php";
	require_once "../Carro/DAOCarro.php";
	require_once "../Modelo/Modelo.php";
	require_once "../Modelo/DAOModelo.php";
	require_once "../Marca/Marca.php";
	require_once "../Marca/DAOMarca.php";
	$model = new Carro();
	$modelModelo = new Modelo();
	$daoModelo = new DAOModelo();
	if($_GET["idModelo"]!=null){
		$modelModelo = $daoModelo->consultarPorId($_GET["idModelo"]);
	}else{
		$modelModelo->setModelo(strtoupper($_GET["modelo"]));
		$modelMarca = new Marca();
		$daoMarca = new DAOMarca();
		if($_GET["idMarca"]==null){
			$modelMarca->setMarca(strtoupper($_GET["marca"]));
			$daoMarca->inserir($modelMarca);
		}else{
			$modelMarca= $daoMarca->consultarPorId($_GET["idMarca"]);
		}
		$modelModelo->setMarca($modelMarca);
		$daoModelo->inserir($modelModelo);
	}
	$model->setModelo($modelModelo);
	$model->setAno($_GET["ano"]);
	$model->setVersao(strtoupper($_GET["versao"]));
	$dao=new DAOCarro();
	if ($dao->verificar($model)=="") {
		$resposta=true;
	}else{
		$resposta=false;
	}
	echo(json_encode($resposta));	
?>