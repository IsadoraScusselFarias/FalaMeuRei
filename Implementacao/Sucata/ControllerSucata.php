<?php
require_once "Sucata.php";
require_once "DAOSucata.php";
require_once "../Categoria/Categoria.php";
require_once "../Carro/Carro.php";
require_once "../Foto/Foto.php";
require_once "../Foto/DAOFoto.php";
require_once "../Carro/DAOCarro.php";
require_once "../Categoria/DAOCategoria.php";
require_once "../Marca/DAOMarca.php";
require_once "../Modelo/DAOModelo.php";
require_once "../ItemVendaSucata/DAOItemVendaSucata.php";
$cs = new ControllerSucata();
class ControllerSucata{
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
			if(($acao == "abrirCadastro")or($acao == "abrirConsulta")or($acao == "abrirLixeira")){
				$this->abrir($acao);
			}elseif ($acao=="cadastrar") {
				$this->cadastrar();
			}elseif (($acao=="consultar")or($acao=="consultarLixeira"))  {
				$this->consultar($acao,"");
			}elseif ($acao=="alterarStatus") {
				$this->alterarStatus();
			}elseif ($acao=="editar") {
				$this->editar();
			}elseif ($acao=="atualizar") {
				$this->atualizar();
			}elseif ($acao=="detalhar") {
				$this->detalhar();
			}
		}else{
			include_once"../Usuario/LoginUsuario.php";
		}
	}
	private function abrir($acao){
		$daoCarro = new DAOCarro();
		$vetCarro = $daoCarro->consultar("1");
		$daoMarca = new DAOMarca();
		$vetMarca= $daoMarca->consultar();
		if ($acao=="abrirCadastro") {
			$daoCategoria = new DAOCategoria();
			$vetCategoria = $daoCategoria->consultar("1");
			include_once 'CadastrarSucata.php';
		}else{
			$model = new Sucata();
			$modelCarro= new Carro();
			$daoMarca = new DAOMarca();
			$vetMarca= $daoMarca->consultar();
			$modelModelo = new Modelo();
			$modelMarca = new Marca();
			$modelModelo->setMarca($modelMarca);
			$modelCarro->setModelo($modelModelo);
			$model->setCarro($modelCarro);
			$dao= new DAOSucata();
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
			include_once 'ConsultarSucata.php';
		}
	}
	private function cadastrar(){
		$model = new Sucata();
		$model->setLote(strtoupper($_POST["lote"]));
		$model->setLeilao(strtoupper($_POST["leilao"]));
		$model->setDataLeilao($_POST["data"]);
		$model->setLocalizacao(strtoupper($_POST["localizacao"]));
		$daoCarro= new DAOCarro();
		$model->setCarro($daoCarro->consultarPorId($_POST["carro"]));
		if (isset($_POST["categoria"])) {
			$vetCategoriasCadastradas=$_POST["categoria"];
			$vetCategoria=null;
			foreach($vetCategoriasCadastradas as $categoriaCadastrada) {
				$modelCategoria= new Categoria();
				$modelCategoria->setId($categoriaCadastrada);
				$vetCategoria[]=$modelCategoria;
			}
			$model->setCategorias($vetCategoria);
		}
		if (isset($_FILES["foto"])) {
			$fotos = $_FILES["foto"];
			$vetFoto=null;
			for ($i=0; $i < count($fotos["name"]); $i++) { 
				$error=null;
		    	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $fotos["type"][$i])){
	 	 			$error[1] = "Por favor, entre com uma imagem.";
		 		} 
				if ($error == null) {
					$modelFoto = new Foto();
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $fotos["name"][$i], $ext);
		        	$modelFoto->setCaminho("../Fotos/" . md5(uniqid(time())) . "." . $ext[1]);
					move_uploaded_file($fotos["tmp_name"][$i], $modelFoto->getCaminho());
					$vetFoto[]=$modelFoto;
				}
			}
			$model->setFotos($vetFoto);
		}
		$dao= new DAOSucata();
		if($dao->inserir($model)){
			$daoCategoria= new DAOCategoria();
			$model->setCategorias($daoCategoria->consultarPorSucata($model->getId()));
			$erro=false;
			$resposta= "Sucata inserida com sucesso!";
		}else{
			$erro=true;
			$resposta= "Erro ao inserir Sucata.";
		}
		include_once 'SucessoSucata.php';
	}
	private function consultar($acao,$res){		
		$resposta=$res;
		$model = new Sucata();
		if (isset($_POST["leilao"])) {
			$model->setLeilao(strtoupper($_POST["leilao"]));
		}
		$modelCarro = new Carro();
		$modelModelo = new Modelo();
		$modelMarca= new Marca();
		if (isset($_POST["idMarca"])) {
			$modelMarca->setId($_POST["idMarca"]);
			if ($_POST["idModelo"]!="") {
				$modelModelo->setId($_POST["idModelo"]);
			}
		}
		$modelModelo->setMarca($modelMarca);
		$modelCarro->setModelo($modelModelo);
		$model->setCarro($modelCarro);
		$dao = new DAOSucata();
		if ($acao=="consultarLixeira") {
			$tipo="0";
		}else{
			$tipo="1";
		}
		if (($model->getLeilao() !="")or($model->getCarro()->getModelo()->getMarca()->getId() !="")) {
			$vet = $dao->consultarComFiltro($model,$tipo);
		}else{
			$vet = $dao->consultar($tipo);
		}	
		$daoMarca = new DAOMarca();
		$vetMarca= $daoMarca->consultar();
		if ($model->getCarro()->getModelo()->getMarca()->getId()!=null) {
			$daoModelo = new DAOModelo();
			$vetModelo=$daoModelo->consultar($model->getCarro()->getModelo()->getMarca()->getId());
		}
		if (isset($vet)){
			$tipoRes = "tabela";
		}else{
			$tipoRes="mensagem";
		}
		
		include_once "ConsultarSucata.php";
		
	}
	private function alterarStatus(){
		$id = $_GET["id"];
		$tipo = $_GET["tipo"];
		if(isset($id)){
			$dao = new DAOSucata();
			if ($tipo=="1") {
				$dao->desativar($id);
				$res = "Sucata inativada com sucesso!"; 
			}else{
				$dao->ativar($id);
				$res = "Sucata restaurada com sucesso!";
			}
		}
		$this->consultar("consultar",$res);
	}
	private function editar(){
		if(isset($_GET["id"])){
			$dao = new DAOSucata();
			$model = $dao->consultarPorId($_GET["id"]);
			if (isset($model)) {
				$daoCarro = new DAOCarro;
				$vetCarro = $daoCarro->consultar("1");	
				$daoCategoria = new DAOCategoria;
				$vetCategoria = $daoCategoria->consultar("1");	
				include_once 'EditarSucata.php';
			}
		}else{
			echo "Id não informado.";
		}
	}
	private function detalhar(){
		if(isset($_GET["id"])){
			$dao = new DAOSucata();
			$model = $dao->consultarPorId($_GET["id"]);
			if (isset($model)) {
				$daoItemVendaSucata = new DAOItemVendaSucata;
				$model->setPecasRetiradas($daoItemVendaSucata->consultarPorSucata($model->getId()));
				$resposta="Detalhar Sucata";
				$erro=false;
				include_once 'SucessoSucata.php';
			}
		}else{
			echo "Id não informado.";
		}
	}
	private function atualizar(){
		$model = new Sucata();
		$model->setId($_POST["idtbSucata"]);
		$model->setLote(strtoupper($_POST["lote"]));
		$model->setLeilao(strtoupper($_POST["leilao"]));
		$model->setDataLeilao($_POST["data"]);
		$model->setLocalizacao(strtoupper($_POST["localizacao"]));
		$daoCarro= new DAOCarro();
		$model->setCarro($daoCarro->consultarPorId($_POST["carro"]));
		if (isset($_POST["statusFotos"])) {
			$statusFotos=$_POST["statusFotos"];
		};
		$daoFoto = new DAOFoto();
		$vetFoto=$daoFoto->consultarPorSucata($model->getId());
		if (isset($vetFoto)) {
			for ($i=0; $i < count($vetFoto) ; $i++) { 
				if (!$statusFotos[$i]) {
					$vetFoto[$i]->setAcao("0");
					unlink($vetFoto[$i]->getCaminho());
				}
			}
		}	
		if (isset($_FILES["foto"])) {
			$fotos = $_FILES["foto"];
			for ($i=0; $i < count($fotos["name"]); $i++) { 
				$error=null;
		    	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $fotos["type"][$i])){
	 	 			$error[1] = "Por favor, entre com uma imagem.";
		 		} 
				if ($error == null) {
					$foto = new Foto();
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $fotos["name"][$i], $ext);
		        	$nome=md5(uniqid(time())) . "." . $ext[1];
		        	$foto->setCaminho("../Fotos/" . $nome);
					move_uploaded_file($fotos["tmp_name"][$i], $foto->getCaminho());
					$foto->setAcao("1");	
					$vetFoto[]=$foto;
				}
			}
		}
		$model->setFotos($vetFoto);
		$vetCategoria = null;
		if (isset($_POST["categoria"])) {
			$vetCategoriasCadastradas=$_POST["categoria"];
			if (isset($vetCategoriasCadastradas)) {
				foreach ($vetCategoriasCadastradas as $categoria) {
					$modelCategoria= new Categoria();
					$modelCategoria->setId($categoria);
					$vetCategoria[]=$modelCategoria;
				}
			}
		}
		$model->setCategorias($vetCategoria);
		$dao= new DAOSucata();
		if($dao->atualizar($model)){
			$daoCategoria= new DAOCategoria();
			$model->setCategorias($daoCategoria->consultarPorSucata($model->getId()));
			$resposta= "Sucata alterada com sucesso!";
		}else{
			$resposta= "Erro ao alterar sucata.";
		}
		$erro=false;
		include_once 'SucessoSucata.php';
	}
}
?>


	