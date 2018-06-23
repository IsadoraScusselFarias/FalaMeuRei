<?php
require_once "../Conexao/ControllerConexao.php";
require_once "Categoria.php";
class DAOCategoria{
	private $conexao;
	private function conectar(){
		$ccon=new ControllerConexao();
		$this->conexao=$ccon->abreConexao();
	}
	private function desconectar(){
		$this->conexao=null;
	}
	public function inserir($model){
		try{
			$this->conectar();
			$stmt=$this->conexao->prepare("insert into tbcategoria(nome, descricao) values(?,?);");
			$stmt->bindValue(1,$model->getNome());
			$stmt->bindValue(2,$model->getDescricao());
			$r=$stmt->execute();
			$stmt = $this->conexao->query("SELECT LAST_INSERT_ID() as id");
			foreach ($stmt as $row){
				$model->setId($row["id"]);
			}
			$this->desconectar();
			return $r;
		}catch(PDOException $ex){
			echo "Erro".$ex->getMessage();
		}
	}
	public function consultar($tipo){
		try{
			$this->conectar();
			$vet = null;
			$stmt = $this->conexao->query("select * from tbcategoria where status=".$tipo);
			foreach ($stmt as $row) {
				$model = new Categoria();
				$model->setId($row["idtbCategoria"]);
				$model->setNome($row["nome"]);
				$model->setDescricao($row["descricao"]);
				$vet[] = $model;
			}
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro".$ex->getMessage());
		}
	}
	public function consultarPorSucata($idSucata){
		try{
			$this->conectar();
			$vet = null;
			$stmt = $this->conexao->query("select * from tbcategoria c inner join tbsucata_tbcategoria sc on (c.idtbCategoria=sc.tbcategoria_idtbCategoria) where tbsucata_idtbSucata=".$idSucata);
			foreach ($stmt as $row) {
				$model = new Categoria();
				$model->setId($row["idtbCategoria"]);
				$model->setNome($row["nome"]);
				$model->setDescricao($row["descricao"]);
				$vet[] = $model;
			}
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro".$ex->getMessage());
		}
	}
	public function consultarComFiltro($model,$tipo){
		try{
			$query="select * from tbcategoria where";
			$criterios = 0;
			if ($model->getNome()!="") {
				$query=$query." nome =?";
				$criterios++;	
			}	
			$query=$query." and status=".$tipo;
			$vet = null;
			$pos = 0;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			if ($model->getNome()!=""){
				$pos++;
				$stmt->bindValue($pos,$model->getNome());
			}
			$stmt->execute();
			foreach ($stmt as $row) {
				$model = new Categoria();
				$model->setId($row["idtbCategoria"]);
				$model->setNome($row["nome"]);
				$model->setDescricao($row["descricao"]);
				$vet[] = $model;
			}
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro".$ex->getMessage());
		}
	}
	public function verificar($model){
		try{
			$query="select * from tbcategoria where nome =?";
			$vet = null;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1,$model->getNome());
			$stmt->execute();
			foreach ($stmt as $row) {
				$model = new Categoria();
				$model->setId($row["idtbCategoria"]);
				$model->setNome($row["nome"]);
				$model->setDescricao($row["descricao"]);
				$vet[] = $model;
			}
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro".$ex->getMessage());
		}
	}
	public function desativar($id){
		try{
			$this->conectar();
			$excluido = $this->conexao->exec("update tbcategoria set status='0' where idtbCategoria=".$id);
			$this->desconectar();
			return $excluido;
		}catch(PDOException $ex){
			echo "Erro: ".$ex->getMessage();
		}
	}
	public function ativar($id){
		try{
			$this->conectar();
			$excluido = $this->conexao->exec("update tbcategoria set status='1' where idtbCategoria=".$id);
			$this->desconectar();
			return $excluido;
		}catch(PDOException $ex){
			echo "Erro: ".$ex->getMessage();
		}
	}
	public function consultarPorId($id){
		try{
			$this->conectar();
			$stmt = $this->conexao->query("select * from tbcategoria where idtbCategoria = ".$id);
			$model = null;
			foreach($stmt as $row) {
				$model = new Categoria();
				$model->setId($row["idtbCategoria"]);
				$model->setNome($row["nome"]);
				$model->setDescricao($row["descricao"]);
			}
			$this->desconectar();
			return $model;
		}catch(PDOException $ex){
			echo ("Erro".$ex->getMessage());
		}
	}
	public function atualizar($model){
		try{
			$this->conectar();
			$stmt=$this->conexao->prepare("update tbcategoria set nome=? , descricao= ? where idtbCategoria =?;");
			$stmt->bindValue(1,$model->getNome());
			$stmt->bindValue(2,$model->getDescricao());
			$stmt->bindValue(3,$model->getId());
			$r=$stmt->execute();
			$this->desconectar();
			return $r;
		}catch(PDOException $ex){
			echo "Erro".$ex->getMessage();
		}
	}
}
?>