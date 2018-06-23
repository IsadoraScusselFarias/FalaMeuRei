<?php
require_once "Categoria.php";
require_once "DAOCategoria.php";
$controller = new ControllerCategoria();
class ControllerCategoria{
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
			if ($acao == "abrirCadastro") {
				$this->abrirCadastro();
			}elseif (($acao == "abrirConsulta")or($acao == "abrirLixeira")) {
				$this->abrirConsulta($acao);
			}elseif ($acao=="cadastrar") {
				$this->cadastrar();
			}elseif ($acao=="consultar") {
				$this->consultar($acao,"");
			}elseif ($acao=="alterarStatus") {
				$this->alterarStatus();
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
		include_once "CadastrarCategoria.php";
	}
	private function abrirConsulta($acao){
		$dao = new DAOCategoria();
		$model= new Categoria();
		if ($acao == "abrirLixeira") {
			$tipo="0";
		}else{
			$tipo="1";
		}
		$vet=$dao->consultar($tipo);
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{	
			$tipoRes="mensagem";
		}
		include_once "ConsultarCategoria.php";
	}
	private function alterarStatus(){
		$id = $_GET["id"];
		$tipo = $_GET["tipo"];
		if(isset($id)){
			$dao = new DAOCategoria();
			if ($tipo=="1") {
				$dao->desativar($id);
				$res="Categoria inativada com sucesso!"; 
			}else{
				$dao->ativar($id);
				$res="Categoria restaurada com sucesso!"; 
			}
		}
		$this->consultar("consultar",$res);
	}
	private function cadastrar(){
		$model = new Categoria();
		$model->setNome(strtoupper($_POST["nomeCategoria"]));
		$model->setDescricao(strtoupper($_POST["descricao"]));
		$dao= new DAOCategoria();
		if($dao->inserir($model)){
			$erro=false;
			$resposta="Categoria de Dano inserida com sucesso!";
		}else{
			$erro=true;
			$resposta="Erro ao inserir Categoria de Dano.";
		}
		include_once "SucessoCategoria.php";
	}
	private function consultar($acao,$res){
		$resposta=$res;
		$model = new Categoria();
		if (isset($_POST["nome"])) {
			$model->setNome(strtoupper($_POST["nome"]));
		}
		$dao = new DAOCategoria();
		if ($acao=="consultarLixeira") {
			$tipo="0";
		}else{
			$tipo="1";
		}
		if ($model->getNome()!= "") {
			$vet = $dao->consultarComFiltro($model,$tipo);
		}else{
			$vet = $dao->consultar($tipo);
		}	
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{	
			$tipoRes="mensagem";
		}
		include_once "ConsultarCategoria.php";
	}
	private function editar(){
		if(isset($_GET["id"])){
			$dao = new DAOCategoria();
			$model = $dao->consultarPorId($_GET["id"]);
			if (isset($model)) {
				include_once"EditarCategoria.php";
			}
		}
	}
	private function atualizar(){
		$model = new Categoria();
		$model->setId($_POST["id"]);
		$model->setNome(strtoupper($_POST["nomeCategoria"]));
		$model->setDescricao(strtoupper($_POST["descricao"]));
		$dao= new DAOCategoria();
		if($dao->atualizar($model)){
			$resposta="Categoria de Dano alterada com sucesso!";
		}else{
			$resposta="Erro ao alterar Categoria de Dano.";
		}
		$erro=false;
		include_once "SucessoCategoria.php";
	}
}
?>
