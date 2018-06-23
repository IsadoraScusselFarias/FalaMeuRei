<?php
require_once "Compra.php";
require_once "../Carro/Carro.php";
require_once "../Carro/DAOCarro.php";
require_once "../Fornecedor/Fornecedor.php";
require_once "../Fornecedor/DAOFornecedor.php";
require_once "../Sucata/Sucata.php";
require_once "../Sucata/DAOSucata.php";
require_once "../Categoria/DAOCategoria.php";
require_once "../ItemCompra/ItemCompra.php";
require_once "../ItemCompra/DAOItemCompra.php";
require_once "../Peca/Peca.php";
require_once "../Peca/DAOPeca.php";
require_once "DAOCompra.php";
require_once "../Marca/Marca.php";
require_once "../Marca/DAOMarca.php";
require_once "../Modelo/Modelo.php";
require_once "../Modelo/DAOModelo.php";
require_once "../Estado/DAOEstado.php";
$controller = new ControllerCompra();
class ControllerCompra{
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
			if ($acao=='abrirCadastro') {
				$this->abrirCadastro();
			}elseif($acao=='abrirConsulta'){
				$this->abrirConsulta();
			}elseif ($acao=="cadastrar") {
				$this->cadastrar();
			}elseif ($acao=="consultar") {
				$this->consultar();
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
		$daoFornecedor = new DAOFornecedor();
		$daoCarro = new DAOCarro();
		$daoMarca = new DAOMarca();
		$daoCategoria = new DAOCategoria();
		$daoEstado = new DAOEstado();
		$vetEstado=$daoEstado->consultar();
		$vetFornecedor = $daoFornecedor->consultar();
		$vetCarro = $daoCarro->consultar("1");
		$vetCategoria = $daoCategoria->consultar("1");
		$vetMarca = $daoMarca->consultar();
		include_once "CadastrarCompra.php";
	}
	private function abrirConsulta(){
		$dao=new DAOCompra();
		$vet=$dao->consultar();
		$dataInicial="";
		$dataFinal="";
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{	
			$tipoRes="mensagem";
		}
		include_once 'ConsultarCompra.php';
	}
	private function cadastrar(){
		$model = new Compra();
		$model->setData($_POST["data"]);
		$model->setvalor($_POST["valor"]);
		$model->setDescricao(strtoupper($_POST["descricao"]));
		$daoFornecedor = new DAOFornecedor();
		$modelFornecedor=$daoFornecedor->consultarporId($_POST["idFornecedor"]);
		$model->setFornecedor($modelFornecedor);
		if ($_POST["lote"]!="") {
			$modelSucata = new Sucata();
			$modelSucata->setLote(strtoupper($_POST["lote"]));
			$modelSucata->setLeilao(strtoupper($_POST["leilao"]));
			$modelSucata->setDataLeilao($_POST["dataLeilao"]);
			$modelSucata->setLocalizacao(strtoupper($_POST["localizacao"]));
			$modelCarro= new Carro();
			if ($_POST["carro"]!=null) {
				$daoCarro= new DAOCarro();
	       		$modelCarro = $daoCarro->consultarPorId($_POST["carro"]);
			}else{
				$modelModelo = new Modelo();
				if($_POST["idModelo"]!=null){
					$daoModelo = new DAOModelo();
					$modelModelo = $daoModelo->consultarPorId($_POST["idModelo"]);
				}else{
					$modelModelo->setModelo($_POST["modelo"]);
					if($_POST["idMarca"]==null){
						$modelMarca = new Marca();
						$modelMarca->setMarca($_POST["marca"]);
						$daoMarca = new DAOMarca();
						$daoMarca->inserir($modelMarca);
						$modelModelo->setMarca($modelMarca);
					}
					$daoModelo = new DAOModelo();
					$daoModelo->inserir($modelModelo);
				}
				$modelCarro->setModelo($modelModelo);
				$modelCarro->setAno($_POST["ano"]);
				$daoCarro= new DAOCarro();
				$daoCarro->inserir($modelCarro);
	        }
	        $modelSucata->setCarro($modelCarro);
			if (isset($_POST["categoria"])) {
				$vetCategoriasCadastradas=$_POST["categoria"];
				$vetCategoria=null;
				foreach($vetCategoriasCadastradas as $categoriaCadastrada) {
					$modelCategoria= new Categoria();
					$modelCategoria->setId($categoriaCadastrada);
					$vetCategoria[]=$modelCategoria;
				}
				$modelSucata->setCategorias($vetCategoria);
			}
		
			if (isset($_FILES["foto"])) {
				
				$fotos = $_FILES["foto"];
				$vetFoto=null;
				for ($i=0; $i < count($fotos["name"]); $i++) { 
					$error=null;
			    	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $fotos["type"][$i])){
		 	 			$error[1] = "Isso não é uma imagem.";
			 		} 
					if ($error == null) {
						$modelFoto = new Foto();
						preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $fotos["name"][$i], $ext);
			        	$modelFoto->setCaminho("../Fotos/" . md5(uniqid(time())) . "." . $ext[1]);
						move_uploaded_file($fotos["tmp_name"][$i], $modelFoto->getCaminho());
						$vetFoto[]=$modelFoto;
					}
				}
				$modelSucata->setFotos($vetFoto);
			}
			$model->setSucata($modelSucata);
		}
		if (isset($_POST["peca"])) {
			$vetp=$_POST["peca"];
			$vetqp=$_POST["quantidadePeca"];
			$vetvp=$_POST["valorPeca"];
			$x=count($vetp);
			for ($i=0; $i <= $x-1; $i++) { 
				$modelItemCompra = new ItemCompra();
				$modelItemCompra->setQuantidade($vetqp[$i]);
				$modelItemCompra->setQuantidadeParaPeca($vetqp[$i]);
				$modelItemCompra->setValorTotal($vetvp[$i]);
				$daoPeca=new DAOPeca();
				$modelPeca=$daoPeca->consultarPorId($vetp[$i]);
				$modelItemCompra->setPeca($modelPeca);
				$vetItemCompra[]=$modelItemCompra;
			}
			$model->setItemCompra($vetItemCompra);
		}
		$dao= new DAOCompra();
		if($dao->inserir($model)){
			if($model->getSucata()!=null){
				$daoCategoria= new DAOCategoria();
				$modelSucata->setCategorias($daoCategoria->consultarPorSucata($model->getId()));
				$model->setSucata($modelSucata);
			}
			$resposta= "Compra inserida com sucesso!";
		}else{
			$resposta= "Erro ao inserir compra.";
		}
		$cadastrar=true;
		include_once 'SucessoCompra.php';
	}
	private function consultar(){
		$model = new Compra();
		if (isset($_POST["data"])) {
			$model->setData($_POST["data"]);
		}
		if (isset($_POST["valor"])) {
			$model->setValor($_POST["valor"]);
		}
		$dataInicial=$_POST["dataInicial"];
		$dataFinal=$_POST["dataFinal"];
		$dao = new DAOCompra();
		if (($model->getData()!= "")or($model->getValor()!= "")or($dataInicial!= "")or($dataFinal!= "")) {
			$vet = $dao->consultarComFiltro($model,$dataInicial,$dataFinal);
		}else{
			$vet = $dao->consultar();
		}	
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{
			$tipoRes="mensagem";
		}
		include "ConsultarCompra.php";
	}
	private function editar(){
		if(isset($_GET["id"])){
			$dao = new DAOCompra();
			$model = $dao->consultarPorId($_GET["id"]);
			if (isset($model)) {
				$daoFornecedor = new DAOFornecedor();
				$vetFornecedor = $daoFornecedor->consultar();
				$daoCarro= new DAOCarro();
				$vetCarro=$daoCarro->consultar("1");
				$daoPeca= new DAOPeca();
				$vetPeca=$daoPeca->consultar("1");
				$daoCategoria = new DAOCategoria;
				$vetCategoria = $daoCategoria->consultar("1");	
				$daoItemCompra= new DAOItemCompra();
				$model->setItemCompra($daoItemCompra->consultarPorCompra($model->getId()));
				$daoSucata= new DAOSucata();
				$model->setSucata($daoSucata->consultarPorCompra($model->getId()));
				include_once"EditarCompra.php";
			}
		}
	}
	private function detalhar(){
		if(isset($_GET["id"])){
			$dao = new DAOCompra();
			$model = $dao->consultarPorId($_GET["id"]);
			if (isset($model)) {
				$cadastrar=false;
				$daoItemCompra= new DAOItemCompra();
				$model->setItemCompra($daoItemCompra->consultarPorCompra($model->getId()));
				$daoSucata= new DAOSucata();
				$model->setSucata($daoSucata->consultarPorCompra($model->getId()));
				$resposta="Detalhamento de Compra";
				include_once"SucessoCompra.php";
			}
		}
	}
	private function atualizar(){
		$model = new Compra();
		$model->setId($_POST["id"]);
		$model->setData($_POST["data"]);
		$model->setvalor($_POST["valor"]);
		$model->setDescricao(strtoupper($_POST["descricao"]));
		$daoFornecedor = new DAOFornecedor();
		$modelFornecedor=$daoFornecedor->consultarporId($_POST["idFornecedor"]);
		$model->setFornecedor($modelFornecedor);
		if ($_POST["status"]=="1") {
			$modelSucata = new Sucata();
			$modelSucata->setId($_POST["idSucata"]);
			$modelSucata->setLote(strtoupper($_POST["lote"]));
			$modelSucata->setLeilao(strtoupper($_POST["leilao"]));
			$modelSucata->setDataLeilao($_POST["data"]);
			$modelSucata->setLocalizacao(strtoupper($_POST["localizacao"]));
			if ($_POST["carro"]!=null) {
				$daoCarro= new DAOCarro();
	       		$modelCarro = $daoCarro->consultarPorId($_POST["carro"]);
			}else{
				$modelModelo = new Modelo();
				if($_POST["idModelo"]!=null){
					$daoModelo = new DAOModelo();
					$modelModelo = $daoModelo->consultarPorId($_POST["idModelo"]);
				}else{
					$modelModelo->setModelo($_POST["modelo"]);
					if($_POST["idMarca"]==null){
						$modelMarca = new Marca();
						$modelMarca->setMarca($_POST["marca"]);
						$daoMarca = new DAOMarca();
						$daoMarca->inserir($modelMarca);
						$modelModelo->setMarca($modelMarca);
					}
					$daoModelo = new DAOModelo();
					$daoModelo->inserir($modelModelo);
				}
				$modelCarro->setModelo($modelModelo);
				$modelCarro->setAno($_POST["ano"]);
				$daoCarro= new DAOCarro();
				$daoCarro->inserir($modelCarro);
	        }
	        $modelSucata->setCarro($modelCarro);
			if (isset($_POST["categoria"])) {
				$vetCategoriasCadastradas=$_POST["categoria"];
				$vetCategoria=null;
				foreach($vetCategoriasCadastradas as $categoriaCadastrada) {
					$modelCategoria= new Categoria();
					$modelCategoria->setId($categoriaCadastrada);
					$vetCategoria[]=$modelCategoria;
				}
				$modelSucata->setCategorias($vetCategoria);
			}
			if (isset($_FILES["foto"])) {
				$fotos = $_FILES["foto"];
				$vetFoto=null;
				for ($i=0; $i < count($fotos["name"]); $i++) { 
					$error=null;
			    	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $fotos["type"][$i])){
		 	 			$error[1] = "Isso não é uma imagem.";
			 		} 
					if ($error == null) {
						$modelFoto = new Foto();
						preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $fotos["name"][$i], $ext);
			        	$modelFoto->setCaminho("../Fotos/" . md5(uniqid(time())) . "." . $ext[1]);
						move_uploaded_file($fotos["tmp_name"][$i], $modelFoto->getCaminho());
						$vetFoto[]=$modelFoto;
					}
				}
				$modelSucata->setFotos($vetFoto);
			}
			$daoSucata= new DAOSucata();
			$daoSucata->atualizar($modelSucata);
			$model->setSucata($modelSucata);
		}
		if ($_POST["status"]=="0"){
			$vetp=$_POST["peca"];
			$vetqp=$_POST["quantidadePeca"];
			$vetqpa=$_POST["quantidadePecaAnterior"];
			$vetvp=$_POST["valorPeca"];
			$x=count($vetp);
			for ($i=0; $i <= $x-1; $i++) { 
				$modelItemCompra = new ItemCompra();
				$modelItemCompra->setQuantidade($vetqp[$i]);
				$modelItemCompra->setQuantidadeParaPeca($vetqp[$i]-$vetqpa[$i]);
				$modelItemCompra->setValorTotal($vetvp[$i]);
				$modelPeca=new Peca();
				$modelPeca->setId($vetp[$i]);
				$modelItemCompra->setPeca($modelPeca);
				$vetItemCompra[]=$modelItemCompra;
			}
			$model->setItemCompra($vetItemCompra);
		}
		$dao= new DAOCompra();
		if($dao->atualizar($model)){
			$resposta="Compra alterada com sucesso!";
		}else{
			$resposta="Erro ao alterar compra.";
		}
		$cadastrar=false;
		include_once "SucessoCompra.php";
	}
}
?>
