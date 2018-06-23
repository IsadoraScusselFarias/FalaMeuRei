<?php
require_once "Peca.php";
require_once "DAOPeca.php";
require_once "../Foto/Foto.php";
require_once "../Foto/DAOFoto.php";
require_once "../Carro/Carro.php";
require_once "../Carro/DAOCarro.php";
require_once "../Marca/DAOMarca.php";
require_once "../Marca/Marca.php";
require_once "../Modelo/DAOModelo.php";
require_once "../Modelo/Modelo.php";
$cp = new ControllerPeca();
class ControllerPeca{
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
			}else if ($acao=="cadastrar") {
				$this->cadastrar();
			}else if (($acao=="consultar")or($acao=="consultarLixeira"))  {
				$this->consultar($acao,"");
			}else if ($acao=="alterarStatus") {
				$this->alterarStatus();
			}else if ($acao=="editar") {
				$this->editar();
			}else if ($acao=="atualizar") {
				$this->atualizar();
			}
		}else{
			include_once"../Usuario/LoginUsuario.php";
		}	
	}
	 private function abrir($acao){
		$daoCarro = new DAOCarro();
		$vetCarro = $daoCarro->consultar("1");
		if ($acao=="abrirCadastro") {
			$daoMarca = new DAOMarca();
			$vetMarca= $daoMarca->consultar();
			include_once 'CadastrarPeca.php';
		}else{
			$model = new Peca();
			$modelCarro= new Carro();
			$daoMarca = new DAOMarca();
			$vetMarca= $daoMarca->consultar();
			$modelModelo = new Modelo();
			$modelMarca = new Marca();
			$modelModelo->setMarca($modelMarca);
			$modelCarro->setModelo($modelModelo);
			$model->setCarro($modelCarro);
			$dao= new DAOPeca();
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
			include_once 'ConsultarPeca.php';
		}
	 }
	private function cadastrar(){
		$model = new Peca();
		$model->setNome(strtoupper($_POST["nomePeca"]));
		$model->setQuantidade($_POST["quantidade"]);
		$model->setPreco($_POST["preco"]);
		$model->setDescricao(strtoupper($_POST["descricao"]));
		$daoCarro= new DAOCarro();
        $model->setCarro($daoCarro->consultarPorId($_POST["carro"]));
		if (isset($_FILES["foto"])) {
			$fotos = $_FILES["foto"];
			$vetFotos=null;
			for ($i=0; $i < count($fotos["name"]); $i++) { 
				$error=null;
		    	if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $fotos["type"][$i])){
	 	 			$error[1] = "Isso não é uma imagem.";
		 		} 
				if ($error == null) {
					$foto = new Foto();
					preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $fotos["name"][$i], $ext);
		        	$foto->setCaminho("../Fotos/" . md5(uniqid(time())) . "." . $ext[1]);
					move_uploaded_file($fotos["tmp_name"][$i], $foto->getCaminho());
					$vetFotos[]=$foto;
				}
			}
			$model->setFotos($vetFotos);
		}
		$dao= new DAOPeca();
		if($dao->inserir($model)){
			$erro=false;
			$resposta= "Peça inserida com sucesso!";
		}else{
			$erro=true;
			$resposta= "Erro ao inserir Peça.";
		}
		include_once "SucessoPeca.php";
	}
	private function consultar($acao,$res){
		$resposta=$res;
		$model = new Peca();
		if (isset($_POST["nome"])) {
			$model->setNome(strtoupper($_POST["nome"]));
		}
		if (isset($_POST["preco"])) {
			$model->setPreco($_POST["preco"]);
		}
		$modelCarro = new Carro();
		$modelModelo = new Modelo();
		$modelMarca= new Marca();
		if (isset($_POST["idMarca"])) {
			$modelMarca->setId($_POST["idMarca"]);
			if (isset($_POST["idModelo"])) {
				$modelModelo->setId($_POST["idModelo"]);
			}
		}
		$modelModelo->setMarca($modelMarca);
		$modelCarro->setModelo($modelModelo);
		$model->setCarro($modelCarro);
		$dao = new DAOPeca();
		if ($acao=="consultarLixeira"){
			$tipo="0";
		}else{
			$tipo="1";
		}
		if (($model->getNome()!= "")or($model->getPreco() !="")or($model->getCarro()->getModelo()->getMarca()->getId() !="")) {
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
		
		include_once "ConsultarPeca.php";
		
	}
	private function alterarStatus(){
		$id = $_GET["id"];
		$tipo = $_GET["tipo"];
		if(isset($id)){
			$dao = new DAOPeca();
			if ($tipo=="1") {
				$dao->desativar($id);
				$res= "Peça inativada com sucesso!"; 
			}else{
				$dao->ativar($id);
				$res="Peça restaurada com sucesso!"; 
			}
		}
		$this->consultar("consultar",$res);
	}
	private function editar(){
		if(isset($_GET["id"])){
			$dao = new DAOPeca();
			$model = $dao->consultarPorId($_GET["id"]);
			if (isset($model)) {
				$daoCarro = new DAOCarro;
				$vetCarro = $daoCarro->consultar("1");
				$daoMarca = new DAOMarca();
				$vetMarca= $daoMarca->consultar();	
				include_once 'EditarPeca.php';
			}
		}else{
			echo "Id não informado.";
		}
	}
	private function atualizar(){
		$model = new Peca();
		$model->setId($_POST["id"]);
		$model->setNome(strtoupper($_POST["nomePeca"]));
		$model->setQuantidade($_POST["quantidade"]);
		$model->setPreco($_POST["preco"]);
		$model->setDescricao(strtoupper($_POST["descricao"]));
		$daoCarro= new DAOCarro();
		$model->setCarro($daoCarro->consultarPorId($_POST["carro"]));
		if (isset($_POST["statusFotos"])) {
			$statusFotos=$_POST["statusFotos"];
		};
		$daoFoto = new DAOFoto();
		$vetFoto=$daoFoto->consultarPorPeca($model->getId());
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
	 	 			$error[1] = "Por favor, entre com uam imagem.";
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
		$dao= new DAOPeca();
		if($dao->atualizar($model)){
			$resposta= "Peça alterada com sucesso!";
		}else{
			$resposta= "Erro ao alterar peça.";
		}
		$erro=false;
		include_once "SucessoPeca.php";
	}
}
?>
