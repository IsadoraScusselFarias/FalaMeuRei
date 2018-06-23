<?php
require_once "Usuario.php";
require_once "DAOUsuario.php";
$ca = new ControllerUsuario();
class ControllerUsuario{
	function __construct(){
		if(isset($_POST["acao"])){
			$acao = $_POST["acao"];
		}else{
			$acao = $_GET["acao"];
		}
		$this->processarAcao($acao);
	}
	public function processarAcao($acao){
		if($acao == "abrirCadastro"){
			$this->abrirCadastro();
		}elseif($acao == "abrirAlterarConta"){
			$this->abrirAlterarConta();
		}elseif($acao == "logar"){
			$this->logar();
		}elseif($acao == "sair"){
			$this->sair();
		}elseif ($acao=="cadastrar") {
			$this->cadastrar();
		}elseif ($acao=="alterarConta") {
			$this->atualizar();
		}
	}
	public function abrirCadastro(){
		include_once "CadastrarUsuario.php";
	}
	public function abrirAlterarConta(){
		session_start();
		$model=$_SESSION['usuario'];
		include_once "AlterarContaUsuario.php";
	}
	private function logar(){	
		$model = new Usuario();
		$model->setEmail(strtolower($_POST["email"])); 
		$model->setSenha(sha1(trim($_POST["senha"])));
		$dao = new DAOUsuario();
		$model= $dao->confirmarLogin($model);
		if($model->getId()!=""){
			session_start();
			$_SESSION['usuario'] = $model;
			include_once '../Index/index.php';
		}else{
			echo("Usuario invalido.");
			include_once '../Usuario/LoginUsuario.php';
		}
	}
	private function sair(){
		session_start();
		$_SESSION['usuario'] = null;
		session_destroy();
		include_once '../Index/index.php';
	}
	private function cadastrar(){
		$model = new Usuario();	
		$model->setEmail(strtolower($_POST["emailUsuario"]));
		$model->setSenha(sha1(trim($_POST["senha"])));
		$model->setTipo($_POST["tipo"]);
		$dao= new DAOUsuario();
		if($dao->inserir($model)){
			$resposta="Usuario inserido com sucesso.";
			$erro=false;
			include_once 'SucessoUsuario.php';
		}else{
			$resposta="Erro ao inserir usuario.";
			$erro=true;
			include_once "SucessoUsuario.php";
		}
	}
	private function atualizar(){
		session_start();
		$dao= new DAOUsuario();
		$model = $_SESSION['usuario'];
		$model->setId("");
		$model->setSenha(sha1(trim($_POST["senhaAtual"])));
		$model= $dao->confirmarLogin($model);
		if($model->getId()!=""){
			$model->setEmail(strtolower($_POST["emailUsuario"]));
			$model->setSenha(sha1(trim($_POST["senha"])));
			$model->setTipo($_POST["tipo"]);
			if($dao->atualizar($model)){
				$resposta = "Conta alterada com sucesso!";
			}else{
				$resposta = "Erro ao alterar conta.";
			}
		}else{
			$resposta="Senha Inválida";
		}
		$erro=false;
		include_once "SucessoUsuario.php";
	}
}
?>
