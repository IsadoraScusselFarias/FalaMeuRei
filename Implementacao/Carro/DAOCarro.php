<?php
	require_once '../Conexao/ControllerConexao.php';
	require_once 'Carro.php';
	require_once '../Marca/Marca.php';
	require_once '../Modelo/Modelo.php';
	
class DAOCarro{
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
			$stmt = $this->conexao->prepare("insert into tbcarro(tbmodelo_idtbModelo,tbmodelo_tbmarca_idtbMarca,ano,versao) values (?,?,?,?);");
			$stmt->bindValue(1,$model->getModelo()->getId());
			$stmt->bindValue(2,$model->getModelo()->getMarca()->getId());
			$stmt->bindValue(3,$model->getAno());
			$stmt->bindValue(4,$model->getVersao());
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
			$stmt = $this->conexao->prepare("update tbcarro set tbmodelo_tbmarca_idtbMarca=?, ano=?, tbmodelo_idtbModelo=?, versao=?  where idtbCarro=?");			
			$stmt->bindValue(1, $model->getModelo()->getMarca()->getId());
			$stmt->bindValue(2, $model->getAno());
			$stmt->bindValue(3, $model->getModelo()->getId());
			$stmt->bindValue(4, $model->getVersao());
			$stmt->bindValue(5, $model->getId());
			$resultado = $stmt->execute();
			$this->desconectar();
			return $resultado;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function consultarPorId($id){
		try{
			$this->conectar();
			$model = null;
			$stmt = $this->conexao->query("select * FROM tbcarro c inner join tbmodelo mo on (c.tbmodelo_idtbModelo=mo.idtbModelo) inner join tbmarca ma on(mo.tbmarca_idtbMarca=ma.idtbMarca) where idtbCarro=".$id);
			foreach($stmt as $row){
				$model = new Carro();
				$model->setId($row["idtbCarro"]);
				$model->setAno($row["ano"]);
				$model->setVersao($row["versao"]);
				$modelModelo= new Modelo();
				$modelMarca = new Marca();
				$modelMarca->setMarca($row["marca"]);
				$modelMarca->setId($row["idtbMarca"]);
				$modelModelo->setMarca($modelMarca);
				$modelModelo->setModelo($row["modelo"]);
				$modelModelo->setId($row["idtbModelo"]);
				$model->setModelo($modelModelo);
			}
			
			$this->desconectar();
			return $model;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function consultar($tipo){
		try{
			$this->conectar();
			$vet = null;
			$stmt = $this->conexao->query("select * FROM tbcarro c inner join tbmodelo mo on (c.tbmodelo_idtbModelo=mo.idtbModelo) inner join tbmarca ma on(mo.tbmarca_idtbMarca=ma.idtbMarca) where status=".$tipo);
			foreach($stmt as $row){
				$model = new Carro();
				$model->setId($row["idtbCarro"]);
				$model->setAno($row["ano"]);
				$model->setVersao($row["versao"]);
				$modelModelo= new Modelo();
				$modelMarca = new Marca();
				$modelMarca->setMarca($row["marca"]);
				$modelMarca->setId($row["idtbMarca"]);
				$modelModelo->setMarca($modelMarca);
				$modelModelo->setModelo($row["modelo"]);
				$modelModelo->setId($row["idtbModelo"]);
				$model->setModelo($modelModelo);
				$vet[] = $model;
			}
			
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}	
	public function consultarComFiltro($model,$tipo){
		try{			
			$query ="select * FROM tbcarro c inner join tbmodelo mo on (c.tbmodelo_idtbModelo=mo.idtbModelo) inner join tbmarca ma on(mo.tbmarca_idtbMarca=ma.idtbMarca) where";
			$criterios = 0;
			if ($model->getModelo()->getMarca()->getId()!=null) {
				if ($model->getModelo()->getId()!=null) {
					$query = $query." mo.idtbModelo = ?";
				}else{
					$query = $query." ma.idtbMarca = ?";
				}
				$criterios++;
			}
			$query=$query." and c.status=".$tipo;
			$vet = null;
			$pos=0;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			if ($model->getModelo()->getMarca()->getId()!=""){
				$pos++;
				if ($model->getModelo()->getId()!="") {
					$stmt->bindValue($pos,$model->getModelo()->getId());
				}else{
					$stmt->bindValue($pos,$model->getModelo()->getMarca()->getId());
				}
			}
			$stmt->execute();
			foreach($stmt as $row){
				$model = new Carro();
				$model->setId($row["idtbCarro"]);
				$model->setAno($row["ano"]);
				$model->setVersao($row["versao"]);
				$modelModelo= new Modelo();
				$modelMarca = new Marca();
				$modelMarca->setMarca($row["marca"]);
				$modelMarca->setId($row["idtbMarca"]);
				$modelModelo->setMarca($modelMarca);
				$modelModelo->setModelo($row["modelo"]);
				$modelModelo->setId($row["idtbModelo"]);
				$model->setModelo($modelModelo);
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
			$query ="select * FROM tbcarro c inner join tbmodelo mo on (c.tbmodelo_idtbModelo=mo.idtbModelo) inner join tbmarca ma on(mo.tbmarca_idtbMarca=ma.idtbMarca) where mo.modelo=? and ma.marca=? and c.ano=? and c.versao=?";
			$this->conectar();
			$vet=null;
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1,$model->getModelo()->getModelo());
			$stmt->bindValue(2,$model->getModelo()->getMarca()->getMarca());
			$stmt->bindValue(3,$model->getAno());
			$stmt->bindValue(4,$model->getVersao());
			$stmt->execute();
			foreach($stmt as $row){
				$model = new Carro();
				$model->setId($row["idtbCarro"]);
				$model->setAno($row["ano"]);
				$model->setVersao($row["versao"]);
				$modelModelo= new Modelo();
				$modelMarca = new Marca();
				$modelMarca->setMarca($row["marca"]);
				$modelMarca->setId($row["idtbMarca"]);
				$modelModelo->setMarca($modelMarca);
				$modelModelo->setModelo($row["modelo"]);
				$modelModelo->setId($row["idtbModelo"]);
				$model->setModelo($modelModelo);
				$vet[] = $model;
			}
			
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function desativar ($id){
		try{
			$this->conectar();
			$excluido = $this->conexao->exec("update tbcarro set status=0 where idtbCarro=".$id);
			
			$this->desconectar();
			return $excluido;
		}catch(PDOException $ex){
			echo "Erro: ".$ex->getMessage();  
		}
	}
	public function ativar ($id){
		try{
			$this->conectar();
			$ativado = $this->conexao->exec("update tbcarro set status=1 where idtbCarro=".$id);
			
			$this->desconectar();
			return $ativado;
		}catch(PDOException $ex){
			echo "Erro: ".$ex->getMessage();  
		}
	 }
}
?>
