<?php
require_once "Cliente.php";
require_once "DAOCliente.php";
require_once "../Cidade/Cidade.php";
require_once "../Cidade/DAOCidade.php";
require_once "../Estado/DAOEstado.php";
$controller = new ControllerCliente();
class ControllerCliente{
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
			if ($acao=="abrirCadastro") {
				$this->abrirCadastro();
			}elseif ($acao=="abrirConsulta") {
				$this->abrirConsulta();
			}elseif ($acao=="cadastrar") {
				$this->cadastrar();
			}elseif ($acao=="consultar") {
				$this->consultar();
			}elseif ($acao=="detalhar") {
				$this->detalhar();
			}elseif ($acao=="editar") {
				$this->editar();
			}elseif ($acao=="atualizar") {
				$this->atualizar();
			}
		}else{
			include_once"../Usuario/LoginUsuario.php";
		}
	}
	private function abrirCadastro(){
		$daoEstado = new DAOEstado();
		$vetEstado=$daoEstado->consultar();
		include_once("CadastrarCliente.php");
	}
	private function abrirConsulta(){
		$model= new Cliente();
		$dao = new DAOCliente();
		$vet=$dao->consultar();
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{	
			$tipoRes="mensagem";
		}
		include_once "ConsultarCliente.php";
	}
	private function cadastrar(){
		$model = new Cliente();
		$model->setEmail(strtolower($_POST["emailCliente"]));
		$model->setCpf($_POST["cpf"]);
		$model->setCnpj($_POST["cnpjCliente"]);
		$model->setNomeCompleto(strtoupper($_POST["nomeCompleto"]));
		$model->setEndereco(strtoupper($_POST["endereco"]));
		$model->setTelefone($_POST["telefone"]);
		$daoCidade = new DAOCidade();
		$model->setCidade($daoCidade->consultarPorId($_POST["cidade"]));
		$dao= new DAOCliente();
		if($dao->inserir($model)){
			$erro=false;
			$resposta ="Cliente inserido com sucesso!";
		}else{
			$erro=true;
			$resposta= "Erro ao inserir Cliente.";
		}
		include_once "SucessoCliente.php";
	}
	private function consultar(){
		$model = new Cliente();
		if (isset($_POST["nomeCompleto"])) {
			$model->setNomeCompleto(strtoupper($_POST["nomeCompleto"]));
		}
		if (isset($_POST["cpf"])) {
			$model->setCpf($_POST["cpf"]);
		}
		if (isset($_POST["cnpj"])) {
			$model->setCnpj($_POST["cnpj"]);
		}
		$dao = new DAOCliente();
		if (($model->getNomeCompleto()!= "")or($model->getCpf() !="")or($model->getCnpj() !="")) {
			$vet = $dao->consultarComFiltro($model);
		}else{
			$vet = $dao->consultar();
		}	
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{
			$tipoRes="mensagem";
		}
		include_once "ConsultarCliente.php";
	}
	private function detalhar(){
		if(isset($_GET["id"])){
			$dao = new DAOCliente();
			$model = $dao->consultarPorId($_GET["id"]);
			if (isset($model)) {
				$resposta="Detalhar Cliente";
				$erro=false;
				include_once"SucessoCliente.php";
			}
		}
	}
	private function editar(){
		if(isset($_GET["id"])){
			$dao = new DAOCliente();
			$model = $dao->consultarPorId($_GET["id"]);
			if (isset($model)) {
				$daoEstado = new DAOEstado();
				$vetEstado=$daoEstado->consultar();
				$daoCidade = new DAOCidade();
				$vetCidade=$daoCidade->consultar($model->getCidade()->getEstado()->getId());
				include_once"EditarCliente.php";
			}
		}
	}
	private function atualizar(){
		$model = new Cliente();
		$model->setId($_POST["id"]);
		$model->setEmail(strtolower($_POST["emailCliente"]));
		$model->setCpf($_POST["cpf"]);
		$model->setCnpj($_POST["cnpjCliente"]);
		$model->setNomeCompleto(strtoupper($_POST["nomeCompleto"]));
		$model->setEndereco(strtoupper($_POST["endereco"]));
		$model->setTelefone($_POST["telefone"]);
		$daoCidade = new DAOCidade();
		$modelCidade=$daoCidade->consultarPorId($_POST["cidade"]);
		$model->setCidade($modelCidade);
		$dao= new DAOCliente();
		if($dao->atualizar($model)){
			$resposta ="Cliente atualizado com sucesso!";
		}else{
			$resposta = "Erro ao atualizar Cliente.";
		}
		$erro=false;
		include_once "SucessoCliente.php";
	}
}
?>
