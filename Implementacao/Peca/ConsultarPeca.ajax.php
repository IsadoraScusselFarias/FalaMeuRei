<?php
	header('Cache-Control: no-cache');
	header('Content-type: application/xml; charset="utf-8"',true);
	require_once "../Peca/DAOPeca.php";
	$dao=new DAOPeca();
	$vet=$dao->consultar("1");
	foreach ($vet as $peca) {
		$pecas[] = array(
			'idtbPeca'=> $peca->getId(),
			'nome'=> $peca->getNome(),
			'carro'=> $peca->getCarro()->getModelo()->getModelo()." ".$peca->getCarro()->getVersao()."/".$peca->getCarro()->getModelo()->getMarca()->getMarca()."/".$peca->getCarro()->getAno(),
		);
	};
	echo( json_encode($pecas));	
?>