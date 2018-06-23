<?php
require_once "../ItemVendaPeca/ItemVendaPeca.php";
require_once "../ItemVendaPeca/DAOItemVendaPeca.php";
require_once "../ItemVendaSucata/ItemVendaSucata.php";
require_once "../ItemVendaSucata/DAOItemVendaSucata.php";
require_once "../Peca/Peca.php";
require_once "../Peca/DAOPeca.php";
require_once "../Cliente/Cliente.php";
require_once "../Cliente/DAOCliente.php";
require_once "../Estado/DAOEstado.php";
require_once "../Cidade/DAOCidade.php";
require_once "../Sucata/Sucata.php";
require_once "../Sucata/DAOSucata.php";
require_once "Orcamento.php";
require_once "DAOOrcamento.php";
$co = new ControllerOrcamento();
class ControllerOrcamento{
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
			if($acao == "abrirCadastro"){
				$this->abrirCadastro();
			}elseif (($acao=="abrirConsultaOrcamento")or($acao=="abrirConsultaVenda")) {
				$this->abrirConsulta($acao);
			}elseif ($acao=="cadastrar") {
				$this->cadastrar();
			}elseif (($acao=="consultarOrcamento")or($acao=="consultarVenda")) {
				$this->consultar($acao);
			}elseif ($acao=="detalhar") {
				$this->detalhar();
			}elseif ($acao=="editar") {
				$this->editar();
			}elseif ($acao=="vender") {
				$this->vender();
			}elseif ($acao=="atualizar") {
				$this->atualizar();
			}
		}else{
			include_once"../Usuario/LoginUsuario.php";
		}	
	}
	private function abrirCadastro(){
		$daoCliente = new DAOCliente();
		$vetCliente = $daoCliente->consultar();	
		$daoEstado = new DAOEstado();
		$vetEstado = $daoEstado->consultar();	
		include_once "CadastrarOrcamento.php";
	}
	private function abrirConsulta($acao){
		$model= new Orcamento();
		if ($acao == "abrirConsultaOrcamento") {
			$model->setStatus("0");
		}else{
			$model->setStatus("1");
		}
		$dataInicial="";
		$dataFinal="";
		$modelCliente = new Cliente();
		$model->setCliente($modelCliente);
		$dao=new DAOOrcamento();
		$vet=$dao->consultarComFiltro($model,$dataInicial,$dataFinal);
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{	
			$tipoRes="mensagem";
		}
		include_once 'ConsultarOrcamento.php';
	}
	private function cadastrar(){
		$model=new Orcamento();
		date_default_timezone_set('America/Sao_Paulo');
		$model->setDataOrcamento(date('d/m/Y'));
		$model->setValor($_POST["valorTotal"]);
		$model->setDesconto($_POST["descontoValor"]);
		$modelCliente=new Cliente();
		if ($_POST["idCliente"]!=null) {	
			$daoCliente= new DAOCliente();			
			$modelCliente=$daoCliente->consultarPorId($_POST["idCliente"]);
		}else{
			$modelCliente->setEmail($_POST["email"]);
			if($_POST["cpf"]!=null){
				$modelCliente->setCpf($_POST["cpf"]);
			}else{
				$modelCliente->setCnpj($_POST["cnpj"]);
			}
			$modelCliente->setNomeCompleto($_POST["nomeCompleto"]);
			$modelCliente->setEndereco($_POST["endereco"]);
			$modelCliente->setTelefone($_POST["telefone"]);
			$daoCidade = new DAOCidade();
			$modelCliente->setCidade($daoCidade->consultarPorId($_POST["cidade"]));
			$daoCliente= new DAOCliente();
			$daoCliente->inserir($modelCliente);
		}
		$model->setCliente($modelCliente);
		if (isset($_POST["peca"])) {
			$vetp=$_POST["peca"];
			$vetqp=$_POST["quantidadePeca"];
			$vetvp=$_POST["valorPeca"];
			$x=count($vetp);
			$vetItemVendaPeca=null;
			$daoPeca= new DAOPeca();
			for ($i=0; $i <= $x-1; $i++) { 
				$modelItemVendaPeca = new ItemVendaPeca();
				$modelItemVendaPeca->setQuantidade($vetqp[$i]);
				$modelItemVendaPeca->setValorTotal($vetvp[$i]);
				$modelPeca=$daoPeca->consultarPorId($vetp[$i]);
				$modelItemVendaPeca->setPeca($modelPeca);
				$vetItemVendaPeca[]=$modelItemVendaPeca;
			}
			$model->setItemVendaPeca($vetItemVendaPeca);
		}
		if (isset($_POST["sucata"])) {
			$vets=$_POST["sucata"];
			$vetnps=$_POST["pecaSucata"];
			$vetqs=$_POST["quantidadeSucata"];
			$vetvs=$_POST["valorSucata"];
			$x=count($vets);
			$vetItemVendaSucata=null;
			$daoSucata= new DAOSucata();
			for ($i=0; $i <= $x-1; $i++) { 
				$modelItemVendaSucata = new ItemVendaSucata();
				$modelItemVendaSucata->setQuantidade($vetqs[$i]);
				$modelItemVendaSucata->setValorTotal($vetvs[$i]);
				$modelItemVendaSucata->setNomePeca(strtoupper($vetnps[$i]));
				$modelSucata=$daoSucata->consultarPorId($vets[$i]);
				$modelItemVendaSucata->setSucata($modelSucata);
				$vetItemVendaSucata[]=$modelItemVendaSucata;
			}
			$model->setItemVendaSucata($vetItemVendaSucata);
		}
		$dao= new DAOOrcamento();
		if($dao->inserir($model)){
			$erro=false;
			$resposta="Cadastrado com sucesso!";
		}else{
			$erro=true;
			$resposta="erro ao cadastrar";
		}
		include_once 'DetalharOrcamento.php';
	}
	private function consultar($acao){
		$model = new Orcamento();
		$model->setStatus($_POST["status"]);
		if (isset($_POST["data"])) {
			$model->setDataOrcamento($_POST["data"]);
		}
		$modelCliente= new Cliente();
		if (isset($_POST["nomeCliente"])) {
			$modelCliente->setNomeCompleto($_POST["nomeCliente"]);
		}
		$model->setCliente($modelCliente);
		if ($acao == "consultarOrcamento") {
			$model->setStatus("0");
		}else{
			$model->setStatus("1");
		}
		$dataInicial=$_POST["dataInicial"];
		$dataFinal=$_POST["dataFinal"];
		$dao = new DAOOrcamento();
		$vet = $dao->consultarComFiltro($model,$dataInicial,$dataFinal);
		$daoCliente = new daoCliente();
		$vetCliente= $daoCliente->consultar();
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{
			$tipoRes="mensagem";
		}
		include_once "ConsultarOrcamento.php";
		
	}
	private function detalhar(){
		$dao = new DAOOrcamento();
		$model = $dao->consultarPorId($_GET["id"]);
		$daoItemVendaPeca = new DAOItemVendaPeca();
		$model->setItemVendaPeca($daoItemVendaPeca->consultarPorOrcamento($_GET["id"]));
		$daoItemVendaSucata = new DAOItemVendaSucata();
		$model->setItemVendaSucata($daoItemVendaSucata->consultarPorOrcamento($_GET["id"]));
		$model->setVendaAprovada("");
		$resposta="Detalhamento de Orçamento.";
		$erro=false;
		include_once 'DetalharOrcamento.php';			
	}
	private function editar(){
		$dao = new DAOOrcamento();
		$model = $dao->consultarPorId($_GET["id"]);
		$daoItemVendaPeca = new DAOItemVendaPeca();
		$model->setItemVendaPeca($daoItemVendaPeca->consultarPorOrcamento($_GET["id"]));
		$daoItemVendaSucata = new DAOItemVendaSucata();
		$model->setItemVendaSucata($daoItemVendaSucata->consultarPorOrcamento($_GET["id"]));
		$daoPeca = new DAOPeca();
		$vetPeca = $daoPeca->consultar("1");
		$daoSucata = new DAOSucata();
		$vetSucata = $daoSucata->consultar("1");	
		$daoCliente = new DAOCliente();
		$vetCliente = $daoCliente->consultar();	
		include_once 'EditarOrcamento.php';
	}
	private function vender(){
		$dao = new DAOOrcamento();
		$model = $dao->consultarPorId($_GET["id"]);
		$daoItemVendaPeca = new DAOItemVendaPeca();
		$model->setItemVendaPeca($daoItemVendaPeca->consultarPorOrcamento($_GET["id"]));
		$daoItemVendaSucata = new DAOItemVendaSucata();
		$model->setItemVendaSucata($daoItemVendaSucata->consultarPorOrcamento($_GET["id"]));
		if ($_GET['status']=="0") {
			$verificador=0;
			foreach ($model->getItemVendaPeca() as $modelItemVendaPeca) {
				if ($modelItemVendaPeca->getQuantidade()>$modelItemVendaPeca->getPeca()->getQuantidade()) {
					$modelItemVendaPeca->setAprovado(false);
					$modelItemVendaPeca->setQuantidadePendente($modelItemVendaPeca->getQuantidade()-$modelItemVendaPeca->getPeca()->getQuantidade());
					$verificador++;	
				}
			}
			if ($verificador==0) {
				$model->setVendaAprovada("1");
			}else{
				$resposta="Venda Pendente!";
				$model->setVendaAprovada("0");
			}				
		}elseif ($_GET['status']=="1") {
			$daoPeca = new DAOPeca();
			$vetPeca = $daoPeca->consultar("1");
			$daoSucata = new DAOSucata();
			$vetSucata = $daoSucata->consultar("1");	
			$daoCliente = new DAOCliente();
			$vetCliente = $daoCliente->consultar();	
			include_once 'EditarOrcamento.php';
		}else{
			$model->setVendaAprovada("1");
		}
		if ($model->getVendaAprovada()) {
			$resposta="Venda realizada com Sucesso!";
			$model->setStatus("1");
			$model->setDataVenda(date("d/m/Y"));
			$dao->vender($model);
		}
		include_once 'DetalharOrcamento.php';			
	}
	private function atualizar(){
		$model=new Orcamento();
		$model->setId($_POST["idOrcamento"]);
		$model->setValor($_POST["valorTotal"]);
		$model->setDesconto($_POST["descontoValor"]);
		$modelCliente=new Cliente();
		if ($_POST["idCliente"]!=null) {				
			$daoCliente= new DAOCliente();			
			$modelCliente=$daoCliente->consultarPorId($_POST["idCliente"]);
		}else{
			$modelCliente->setEmail($_POST["email"]);
			if($_POST["cpf"]!=null){
				$modelCliente->setCpf($_POST["cpf"]);
			}else{
				$modelCliente->setCnpj($_POST["cnpj"]);
			}
			$modelCliente->setNomeCompleto($_POST["nomeCompleto"]);
			$modelCliente->setEndereco($_POST["endereco"]);
			$modelCliente->setTelefone($_POST["telefone"]);
			$daoCidade = new DAOCidade();
			$modelCliente->setCidade($daoCidade->consultarPorId($_POST["cidade"]));
			$daoCliente= new DAOCliente();
			$daoCliente->inserir($modelCliente);
		}
		$model->setCliente($modelCliente);
		if (isset($_POST["peca"])) {
			$vetp=$_POST["peca"];
			$vetqp=$_POST["quantidadePeca"];
			$vetvp=$_POST["valorPeca"];
			$x=count($vetp);
			$daoPeca= new DAOPeca();
			$vetItemVendaPeca=null;
			for ($i=0; $i <= $x-1; $i++) { 
				$modelItemVendaPeca = new ItemVendaPeca();
				$modelItemVendaPeca->setQuantidade($vetqp[$i]);
				$modelItemVendaPeca->setValorTotal($vetvp[$i]);
				$modelPeca=$daoPeca->consultarPorId($vetp[$i]);
				$modelItemVendaPeca->setPeca($modelPeca);
				$vetItemVendaPeca[]=$modelItemVendaPeca;
			}
			$model->setItemVendaPeca($vetItemVendaPeca);
		}
		if (isset($_POST["sucata"])) {
			$vets=$_POST["sucata"];
			$vetnps=$_POST["pecaSucata"];
			$vetqs=$_POST["quantidadeSucata"];
			$vetvs=$_POST["valorSucata"];
			$x=count($vets);
			$daoSucata= new DAOSucata();
			$vetItemVendaSucata=null;
			for ($i=0; $i <= $x-1; $i++) { 
				$modelItemVendaSucata = new ItemVendaSucata();
				$modelItemVendaSucata->setQuantidade($vetqs[$i]);
				$modelItemVendaSucata->setValorTotal($vetvs[$i]);
				$modelItemVendaSucata->setNomePeca(strtoupper($vetnps[$i]));
				$modelSucata=$daoSucata->consultarPorId($vets[$i]);
				$modelItemVendaSucata->setSucata($modelSucata);
				$vetItemVendaSucata[]=$modelItemVendaSucata;
			}
			$model->setItemVendaSucata($vetItemVendaSucata);
		}
		$dao= new DAOOrcamento();
		if($dao->atualizar($model)){
			$resposta="Atualizado com sucesso!";
		}else{
			$resposta="Erro ao atualizar.";
		}
		$erro=false;
		include_once 'DetalharOrcamento.php';
	}
}
