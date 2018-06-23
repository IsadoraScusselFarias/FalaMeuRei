<?php
	require_once '../Conexao/ControllerConexao.php';
	require_once 'Marca.php';
	
class DAOMarca{
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
			$stmt = $this->conexao->prepare("insert into tbmarca(marca) values (?);");
			$stmt->bindValue(1,$model->getMarca());
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
	public function consultar(){
		try{
			$this->conectar();
			$vet = null;
			$stmt = $this->conexao->query("select * FROM tbmarca");
			foreach($stmt as $row){
				$model = new Marca();
				$model->setId($row["idtbMarca"]);
				$model->setMarca($row["marca"]);
				$vet[] = $model;
			}
			
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function verificar($model){
		try{			
			$query ="select * FROM tbmarca where marca=?";
			$this->conectar();
			$vet=null;
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1,$model->getMarca());
			$stmt->execute();
			foreach($stmt as $row){
				$model = new Marca();
				$model->setId($row["idtbMarca"]);
				$model->setMarca($row["marca"]);
				$vet[] = $model;
			}
			
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function consultarPorId($id){
		try{
			$this->conectar();
			$model = null;
			$stmt = $this->conexao->query("select * FROM tbmarca where idtbMarca=".$id);
			foreach($stmt as $row){
				$model = new Marca();
				$model->setId($row["idtbMarca"]);
				$model->setMarca($row["marca"]);
			}
			
			$this->desconectar();
			return $model;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
}
?>