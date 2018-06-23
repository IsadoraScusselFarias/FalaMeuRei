<?php
require_once "Carro.php";
require_once "DAOCarro.php";
require_once "../Marca/DAOMarca.php";
require_once "../Marca/Marca.php";
require_once "../Modelo/DAOModelo.php";
require_once "../Modelo/Modelo.php";
$cc = new ControllerCarro();
class ControllerCarro{
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
			}elseif(($acao == "abrirConsulta")or($acao == "abrirLixeira")){
				$this->abrirConsulta($acao);
			}elseif ($acao=="cadastrar") {
				$this->cadastrar();
			}elseif ($acao=="consultar"or($acao=="consultarLixeira")) {
				$this->consultar($acao,"");
			}elseif ($acao=="alterarStatus") {
				$this->alterarStatus();
			}elseif ($acao=="editar") {
				$this->editar();
			}elseif ($acao=="atualizar") {
				$this->atualizar();
			}
		}else{
			include_once "../Usuario/LoginUsuario.php";
		}
	}
	private function abrirCadastro(){
		$daoMarca = new DAOMarca();
		$vetMarca= $daoMarca->consultar();
		include_once "CadastrarCarro.php";
	}
	private function abrirConsulta($acao){
		$dao = new DAOCarro();
		$daoMarca = new DAOMarca();
		$vetMarca= $daoMarca->consultar();
		$model= new Carro();
		$modelModelo = new Modelo();
		$modelMarca = new Marca();
		$modelModelo->setMarca($modelMarca);
		$model->setModelo($modelModelo);
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
		include_once "ConsultarCarro.php";
	}
	private function cadastrar(){
		$model = new Carro();
		$modelModelo = new Modelo();
		$daoModelo = new DAOModelo();
		if($_POST["idModelo"]!=null){
			$modelModelo = $daoModelo->consultarPorId($_POST["idModelo"]);
		}else{
			$modelModelo->setModelo(strtoupper($_POST["modelo"]));
			$modelMarca = new Marca();
			$daoMarca = new DAOMarca();
			if($_POST["idMarca"]==null){
				$modelMarca->setMarca(strtoupper($_POST["marca"]));
				$daoMarca->inserir($modelMarca);
			}else{
				$modelMarca= $daoMarca->consultarPorId($_POST["idMarca"]);
			}
			$modelModelo->setMarca($modelMarca);
			$daoModelo->inserir($modelModelo);
		}
		$model->setModelo($modelModelo);
		$model->setAno($_POST["ano"]);
		$model->setVersao(strtoupper($_POST["versao"]));
		$dao= new DAOCarro();
		if($dao->inserir($model)){
			$resposta="Carro inserido com sucesso!";
			$erro=false;
		}else{
			$erro=true;
			$resposta="Erro ao inserir carro.";
		}
		include_once "SucessoCarro.php";
	}
	private function consultar($acao,$res){
		$resposta=$res;
		$model = new Carro();
		$modelModelo = new Modelo();
		$modelMarca= new Marca();
		if (isset($_POST["idMarca"])) {
			$modelMarca->setId($_POST["idMarca"]);
			if (isset($_POST["idModelo"])) {
				$modelModelo->setId($_POST["idModelo"]);
			}
		}
		$modelModelo->setMarca($modelMarca);
		$model->setModelo($modelModelo);
		$dao = new DAOCarro();
		if ($acao=="consultarLixeira") {
			$tipo="0";
		}else{
			$tipo="1";
		}
		if (($model->getAno() !=null)or($model->getModelo()->getMarca()->getId()!=null)) {
			$vet = $dao->consultarComFiltro($model,$tipo);
		}else{
			$vet = $dao->consultar($tipo);
		}	
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{	
			$tipoRes="mensagem";
		}
		$daoMarca = new DAOMarca();
		$vetMarca= $daoMarca->consultar();
		if ($model->getModelo()->getMarca()->getId()!=null) {
			$daoModelo = new DAOModelo();
			$vetModelo=$daoModelo->consultar($model->getModelo()->getMarca()->getId());
		}
		include_once "ConsultarCarro.php";
	}
	private function alterarStatus(){
		$id = $_GET["id"];
		$tipo = $_GET["tipo"];
		if(isset($id)){
			$dao = new DAOCarro();
			if ($tipo=="1") {
				$dao->desativar($id);
				$res="Carro inativado com sucesso!"; 
			}else{
				$dao->ativar($id);
				$res= "Carro restaurado com sucesso!"; 
			}
		}
		$this->consultar("consultar",$res);
	}
	private function editar(){
		if(isset($_GET["id"])){
			$dao = new DAOCarro();
			$model = $dao->consultarPorId($_GET["id"]);
			if (isset($model)) {
				$daoMarca = new DAOMarca();
				$vetMarca=$daoMarca->consultar();
				$daoModelo = new DAOModelo();
				$vetModelo=$daoModelo->consultar($model->getModelo()->getMarca()->getId());
				include_once"EditarCarro.php";
			}else{
				echo "id não informado";
			}
		}
	}
	private function atualizar(){
		$model = new Carro();
		$model->setId($_POST["id"]);
		$modelModelo = new Modelo();
		if($_POST["idModelo"]!=null){
			$daoModelo = new DAOModelo();
			$modelModelo = $daoModelo->consultarPorId($_POST["idModelo"]);
		}else{
			$modelModelo->setModelo(strtoupper($_POST["modelo"]));
			$modelMarca = new Marca();
			$daoMarca = new DAOMarca();
			if($_POST["idMarca"]==null){
				$modelMarca->setMarca(strtoupper($_POST["marca"]));
				$daoMarca->inserir($modelMarca);
			}else{
				$modelMarca= $daoMarca->consultarPorId($_POST["idMarca"]);
			}
			$modelModelo->setMarca($modelMarca);
			$daoModelo = new DAOModelo();
			$daoModelo->inserir($modelModelo);
		}
		$model->setModelo($modelModelo);		
		$model->setAno($_POST["ano"]);
		$model->setVersao(strtoupper($_POST["versao"]));
		$dao= new DAOCarro();
		if($dao->atualizar($model)){
			$resposta = "Carro alterado com sucesso!";
		}else{
			$resposta = "Erro ao alterar carro.";
		}
		$erro=false;
		include_once "SucessoCarro.php";
	}
}
?>
