<?php
	require_once '../Conexao/ControllerConexao.php';
	require_once 'Modelo.php';
	require_once '../Marca/Marca.php';
	
class DAOModelo{
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
			$stmt = $this->conexao->prepare("insert into tbmodelo(modelo,tbmarca_idtbMarca) values (?,?);");
			$stmt->bindValue(1,$model->getModelo());
			$stmt->bindValue(2,$model->getMarca()->getId());
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
	public function consultar($marca){
		try{
			$this->conectar();
			$vet = null;
			$stmt = $this->conexao->query("select * FROM tbmodelo where tbmarca_idtbMarca=".$marca);
			foreach($stmt as $row){
				$model = new Modelo();
				$model->setId($row["idtbModelo"]);
				$model->setModelo($row["modelo"]);
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
			$query ="select * FROM tbmodelo where modelo=?";
			$this->conectar();
			$vet=null;
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1,$model->getModelo());
			$stmt->execute();
			foreach($stmt as $row){
				$model = new Modelo();
				$model->setId($row["idtbModelo"]);
				$model->setModelo($row["modelo"]);
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
			$model=null;
			$stmt = $this->conexao->query("select * FROM tbmodelo mo inner join tbmarca ma on (ma.idtbMarca=mo.tbmarca_idtbMarca) where mo.idtbModelo=".$id);
			foreach($stmt as $row){
				$model = new Modelo();
				$model->setId($row["idtbModelo"]);
				$model->setModelo($row["modelo"]);
				$modelma= new Marca();
				$modelma->setId($row["idtbMarca"]);
				$modelma->setMarca($row["marca"]);
				$model->setMarca($modelma);
			}
			
			$this->desconectar();
			return $model;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
}
?>