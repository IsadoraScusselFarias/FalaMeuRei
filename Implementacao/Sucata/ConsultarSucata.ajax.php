<?php
	header('Cache-Control: no-cache');
	header('Content-type: application/xml; charset="utf-8"',true);
	require_once "../Sucata/DAOSucata.php";
	$daoSucata = new DAOSucata();
	$vet = $daoSucata->consultar("1");
	foreach ($vet as $sucata) {
		$sucatas[] = array(
			'idtbSucata'=> $sucata->getId(),
			'lote'=> $sucata->getLote(),
			'carro'=> $sucata->getCarro()->getModelo()->getModelo()." ".$sucata->getCarro()->getVersao()."/".$sucata->getCarro()->getModelo()->getMarca()->getMarca()."/".$sucata->getCarro()->getAno(),
		);
	};
	echo(json_encode($sucatas));	
?>