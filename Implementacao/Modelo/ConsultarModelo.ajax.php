<?php
	header('Cache-Control: no-cache');
	header('Content-type: application/xml; charset="utf-8"',true);
	require_once "../Modelo/DAOModelo.php";
	$dao=new DAOModelo();
	$vet=$dao->consultar($_GET["marca"]);
	foreach ($vet as $modelo) {
		$modelos[] = array(
			'idtbModelo'=> $modelo->getId(),
			'modelo'=> $modelo->getModelo(),
		);
	};
	echo( json_encode($modelos));	
?>