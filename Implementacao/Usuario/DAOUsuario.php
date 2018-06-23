<?php
	require_once '../Conexao/ControllerConexao.php';
	require_once 'Usuario.php';
	
class DAOUsuario{
	private $conexao;
	
	private function conectar(){
		$ccon=new ControllerConexao();
		$this->conexao = $ccon->abreConexao();
	}
	
	private function desconectar(){
		$ccon=new ControllerConexao();
		$this->conexao = null;
	}
	
	public function inserir($model){
		try{
			$this->conectar();
			$stmt = $this->conexao->prepare("insert into tbusuario(email,senha,tipo) values (?,?,?);");
			$stmt->bindValue(1,$model->getEmail());
			$stmt->bindValue(2,$model->getSenha());
			$stmt->bindValue(3,$model->getTipo());
			$resu = $stmt->execute();
			$stmt = $this->conexao->query("SELECT LAST_INSERT_ID() as id");
			foreach ($stmt as $row){
				$model->setId($row["id"]);
			}
			$this->desconectar();
			return $resu;
		}catch(PDOException $ex){
			echo("Erro:".$ex->getMessage());
		}
	}
	public function atualizar($model){
		try{
			$this->conectar();
			$stmt = $this->conexao->prepare("update tbusuario set senha=?, email=?,tipo=? where idtbUsuario=?");	
			$stmt->bindValue(1, $model->getSenha());
			$stmt->bindValue(2, $model->getEmail());
			$stmt->bindValue(3, $model->getTipo());
			$stmt->bindValue(4, $model->getId());
			$resultado = $stmt->execute();
			$this->desconectar();
			return $resultado;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function confirmarLogin($model){
		try{
			$this->conectar();
			$modelConfirmado = new Usuario();
			$this->conectar();
			$query = "SELECT * FROM tbusuario where email = ? and senha = ?";
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1, $model->getEmail());
			$stmt->bindValue(2, $model->getSenha());
			$stmt->execute();
			foreach($stmt as $row){
				$model->setId($row["idtbUsuario"]);
				$model->setEmail($row["email"]);
				$model->setSenha($row["senha"]);
				$model->setTipo($row["tipo"]);
			}			
			$this->desconectar();
			return $model;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function verificar($model){
		try{
			$this->conectar();
			$modelConfirmado = new Usuario();
			$this->conectar();
			$vet=null;
			if ($model->getId()!="") {
				$query = "SELECT * FROM tbusuario where email = ? and idtbUsuario<>? ";
			}else{
				$query = "SELECT * FROM tbusuario where email = ? ";
			}
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1, $model->getEmail());
			if ($model->getId()!="") {
				$stmt->bindValue(2, $model->getId());
			}	
			$stmt->execute();
			foreach($stmt as $row){
				$model->setId($row["idtbUsuario"]);
				$model->setEmail($row["email"]);
				$model->setSenha($row["senha"]);
				$model->setTipo($row["tipo"]);
				$vet[]=$model;
			}			
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
}
?>
