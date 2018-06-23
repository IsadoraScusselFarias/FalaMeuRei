<?php
require_once "Despesa.php";
require_once "DAODespesa.php";
$controller = new ControllerDespesa();
class ControllerDespesa{
	function __construct(){
		if(isset($_POST["acao"])){
			$acao = $_POST["acao"];
		}else{
			$acao = $_GET["acao"];
		}
		if (isset($acao)) {
			$this->processarAcao($acao);
		}
	}
	public function processarAcao($acao){
		session_start();
		if (isset($_SESSION['usuario'])) {
			if(($acao == "abrirCadastro")){
				$this->abrirCadastro();
			}elseif(($acao == "abrirConsulta")){
				$this->abrirConsulta();
			}elseif ($acao=="cadastrar") {
				$this->cadastrar();
			}elseif ($acao=="consultar") {
				$this->consultar();
			}elseif ($acao=="alterarStatus") {
				$this->alterarStatus();
			}elseif ($acao=="editar") {
				$this->editar();
			}elseif ($acao=="detalhar") {
				$this->detalhar();
			}elseif ($acao=="atualizar") {
				$this->atualizar();
			}
		}else{
			include_once"../Usuario/LoginUsuario.php";
		}
	}
	private function abrirCadastro(){
		include_once"CadastrarDespesa.php";
	}
	private function abrirConsulta(){
		$dao = new DAODespesa();
		$vet=$dao->consultar();
		$model= new Despesa();
		$dataInicial="";
		$dataFinal="";
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{	
			$tipoRes="mensagem";
		}
		include_once "ConsultarDespesa.php";
	}
	private function cadastrar(){
		$model = new Despesa();
		$model->setNome(strtoupper($_POST["nome"]));
		$model->setObservacao(strtoupper($_POST["observacao"]));
		$model->setValor($_POST["valor"]);
		$model->setData($_POST["data"]);
		$dao= new DAODespesa();
		if($dao->inserir($model)){
			$erro=false;
			$resposta="Despesa inserida com sucesso!";
		}else{
			$erro=true;
			$resposta="Erro ao inserir Despesa.";
		}
		$cadastrar=true;
		include_once "SucessoDespesa.php";
	}
	private function consultar(){
		$model = new Despesa();
		if (isset($_POST["nome"])) {
			$model->setNome(strtoupper($_POST["nome"]));
		}
		$dataInicial=$_POST["dataInicial"];
		$dataFinal=$_POST["dataFinal"];
		$dao = new DAODespesa();
		if (($model->getNome()!= "")or($dataInicial!= "")or($dataFinal!= "")) {
			$vet = $dao->consultarComFiltro($model,$dataInicial,$dataFinal);
		}else{
			$vet = $dao->consultar();
		}	
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{	
			$tipoRes="mensagem";
		}
		include_once "ConsultarDespesa.php";
	}
	private function editar(){
		if(isset($_GET["id"])){
			$dao = new DAODespesa();
			$model = $dao->consultarPorId($_GET["id"]);
			if (isset($model)) {
				include_once "EditarDespesa.php";
			}
		}
	}
	private function detalhar(){
		$dao = new DAODespesa();
		$model = $dao->consultarPorId($_GET["id"]);
		$cadastrar=false;
		include_once "SucessoDespesa.php";
	}
	private function atualizar(){
		$model = new Despesa();
		$model->setId($_POST["id"]);
		$model->setNome(strtoupper($_POST["nome"]));
		$model->setObservacao(strtoupper($_POST["observacao"]));
		$model->setValor($_POST["valor"]);
		$model->setData($_POST["data"]);
		$dao= new DAODespesa();
		if($dao->atualizar($model)){
			$resposta= "Despesa alterada com sucesso!";
		}else{
			$resposta= "Erro ao alterar Despesa.";
		}
		$erro=false;
		$cadastrar=false;
		include_once "SucessoDespesa.php";
	}
}
?>
