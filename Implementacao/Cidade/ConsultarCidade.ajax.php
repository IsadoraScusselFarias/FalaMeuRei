<?php
	header('Cache-Control: no-cache');
	header('Content-type: application/xml',true);
	require_once "../Cidade/DAOCidade.php";
	$dao=new DAOCidade();
	$vet=$dao->consultar($_GET["estado"]);
	foreach ($vet as $cidade) {
		$cidades[] = array(
			'idtbCidade'=> $cidade->getId(),
			'cidade'=> $cidade->getCidade(),
		);
	}
	echo(json_encode($cidades));	
?>