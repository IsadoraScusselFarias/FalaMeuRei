<?php
	require_once "../Peca/DAOPeca.php";
	$dao=new DAOPeca();
	$model=$dao->consultarPorId($_GET["idPeca"]);
	$resposta = array(
		'preco' => $model->getPreco(), 
		'quantidade' => $model->getQuantidade() 
	);
	echo( json_encode($resposta));	
?>