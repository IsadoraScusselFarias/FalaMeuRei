<?php
require_once "Fornecedor.php";
require_once "DAOFornecedor.php";
require_once "../Cidade/Cidade.php";
require_once "../Cidade/DAOCidade.php";
require_once "../Estado/DAOEstado.php";
$controller = new ControllerFornecedor();
class ControllerFornecedor{
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
		include_once("CadastrarFornecedor.php");
	}
	private function abrirConsulta(){
		$model= new Fornecedor();
		$dao = new DAOFornecedor();
		$vet=$dao->consultar();
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{	
			$tipoRes="mensagem";
		}
		include_once "ConsultarFornecedor.php";
	}
	private function cadastrar(){
		$model = new Fornecedor();
		$model->setEmail(strtolower($_POST["emailFornecedor"]));
		$model->setCnpj($_POST["cnpjFornecedor"]);
		$model->setNome(strtoupper($_POST["nome"]));
		$model->setEndereco(strtoupper($_POST["endereco"]));
		$model->setTelefone($_POST["telefone"]);
		$daoCidade = new DAOCidade();
		if ($_POST["cidade"]!="") {
			$model->setCidade($daoCidade->consultarPorId($_POST["cidade"]));
		}else{
			$modelCidade = new Cidade();
			$model->setCidade($modelCidade);
		}
		$dao= new DAOFornecedor();
		if($dao->inserir($model)){
			$erro=false;
			$resposta ="Fornecedor inserido com sucesso!";
		}else{
			$erro=true;
			$resposta= "Erro ao inserir Fornecedor.";
		}
		include_once "SucessoFornecedor.php";
	}
	private function consultar(){
		$model = new Fornecedor();
		if (isset($_POST["nome"])) {
			$model->setNome(strtoupper($_POST["nome"]));
		}
		if (isset($_POST["cnpj"])) {
			$model->setCnpj($_POST["cnpj"]);
		}
		$dao = new DAOFornecedor();
		if (($model->getNomeCompleto()!= "")or($model->getCnpj() !="")) {
			$vet = $dao->consultarComFiltro($model);
		}else{
			$vet = $dao->consultar();
		}	
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{
			$tipoRes="mensagem";
		}
		include_once "ConsultarFornecedor.php";
	}
	private function editar(){
		if(isset($_GET["id"])){
			$dao = new DAOFornecedor();
			$model = $dao->consultarPorId($_GET["id"]);
			if (isset($model)) {
				$daoEstado = new DAOEstado();
				$vetEstado=$daoEstado->consultar();
				$daoCidade = new DAOCidade();
				$vetCidade=$daoCidade->consultar($model->getCidade()->getEstado()->getId());
				include_once"EditarFornecedor.php";
			}
		}
	}
	private function atualizar(){
		$model = new Fornecedor();
		$model->setId($_POST["id"]);
		$model->setEmail(strtolower($_POST["emailFornecedor"]));
		$model->setCnpj($_POST["cnpjFornecedor"]);
		$model->setNome(strtoupper($_POST["nome"]));
		$model->setEndereco(strtoupper($_POST["endereco"]));
		$model->setTelefone($_POST["telefone"]);
		$daoCidade = new DAOCidade();
		if ($_POST["cidade"]!="") {
			$model->setCidade($daoCidade->consultarPorId($_POST["cidade"]));
		}else{
			$modelCidade = new Cidade();
			$model->setCidade($modelCidade);
		}
		$dao= new DAOFornecedor();
		if($dao->atualizar($model)){
			$resposta ="Fornecedor atualizado com sucesso!";
		}else{
			$resposta = "Erro ao atualizar Fornecedor.";
		}
		$erro=false;
		include_once "SucessoFornecedor.php";
	}
}
?>
