<?php
$ci = new ControllerIndex();
class ControllerIndex{
	function __construct(){
		if(isset($_POST["acao"])){
			$acao = $_POST["acao"];
		}else{
				$acao = $_GET["acao"];
		}
		$this->processarAcao($acao);
	}
	public function processarAcao($acao){
		session_start();
		if(($acao == "abrirIndex")){
			$this->abrir();
		}
	}
	public function abrir(){
		include_once "index.php";
	}
}
?>
