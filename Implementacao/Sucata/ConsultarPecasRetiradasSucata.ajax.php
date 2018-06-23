<?php
	require_once "../ItemVendaSucata/DAOItemVendaSucata.php";
	$dao = new DAOItemVendaSucata();
	$vet = $dao->consultarPorSucata($_GET["sucata"]);
	$pecas=null;
	if ($vet!=null) {
		foreach ($vet as $pecasRetiradas) {
			$pecas[] = $pecasRetiradas->getNomePeca()." - ".$pecasRetiradas->getQuantidade();
		};
	}else{
		$pecas="Nenhuma Peca Retirada";
	}
	echo(json_encode($pecas));	
?>