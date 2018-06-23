<?php
require_once "../Conexao/ControllerConexao.php";
require_once "Despesa.php";
class DAODespesa{
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
			$stmt=$this->conexao->prepare("insert into tbdespesa(nome, observacao, valor,data) values(?,?,?,?)");
			$stmt->bindValue(1,$model->getNome());
			$stmt->bindValue(2,$model->getObservacao());
			$stmt->bindValue(3,$model->getValor());
			$stmt->bindValue(4,date("Y/m/d",strtotime(str_replace("/","-",$model->getData()))));
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
	public function consultar(){
		try{
			$this->conectar();
			$vet = null;
			$stmt = $this->conexao->query("select * from tbdespesa");
			foreach ($stmt as $row) {
				$model = new Despesa();
				$model->setId($row["idtbDespesa"]);
				$model->setNome($row["nome"]);
				$model->setObservacao($row["observacao"]);
				$model->setValor($row["valor"]);
				$model->setData(date("d/m/Y",strtotime(str_replace("-","/",$row["data"]))));
				$vet[] = $model;
			}
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro".$ex->getMessage());
		}
	}
	public function consultarComFiltro($model,$dataInicial,$dataFinal){
		try{
			$query="select * from tbdespesa where";
			$criterios = 0;
			if ($model!="") {
				if ($model->getNome()!="") {
					$query=$query." nome like ?";
					$criterios++;	
				}	
			}
			if ($dataInicial!="") {
				if ($criterios>0) {
					$query=$query." and ";
				}
				$query=$query." data >= ?";
				$criterios++;	
			}
			if ($dataFinal!="") {
				if ($criterios>0) {
					$query=$query." and ";
				}
				$query=$query." data <= ?";
				$criterios++;	
			}
			$vet = null;
			$pos = 0;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			if ($model!="") {
				if ($model->getNome()!=""){
					$pos++;
					$stmt->bindValue($pos,"%".$model->getNome()."%");
				}
			}
			if ($dataInicial!="") {
				$pos++;
				$stmt->bindValue($pos,date("Y/m/d",strtotime(str_replace("/","-",$dataInicial))));
			}
			if ($dataFinal!="") {
				$pos++;
				$stmt->bindValue($pos,date("Y/m/d",strtotime(str_replace("/","-",$dataFinal))));
			}
			$stmt->execute();
			foreach ($stmt as $row) {
				$model = new Despesa();
				$model->setId($row["idtbDespesa"]);
				$model->setNome($row["nome"]);
				$model->setObservacao($row["observacao"]);
				$model->setValor($row["valor"]);
				$model->setData(date("d/m/Y",strtotime(str_replace("-","/",$row["data"]))));
				$vet[] = $model;
			}
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro".$ex->getMessage());
		}
	}
	public function consultarPorId($id){
		try{
			$this->conectar();
			$stmt = $this->conexao->query("select * from tbdespesa where idtbDespesa = ".$id);
			$model = null;
			foreach($stmt as $row) {
				$model = new Despesa();
				$model->setId($row["idtbDespesa"]);
				$model->setNome($row["nome"]);
				$model->setObservacao($row["observacao"]);
				$model->setValor($row["valor"]);
				$model->setData(date("d/m/Y",strtotime(str_replace("-","/",$row["data"]))));
				$vet[] = $model;
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
			$stmt=$this->conexao->prepare("update tbdespesa set nome=? , observacao= ?, valor = ?, data=? where idtbDespesa =?;");
			$stmt->bindValue(1,$model->getNome());
			$stmt->bindValue(2,$model->getObservacao());
			$stmt->bindValue(3,$model->getValor());
			$stmt->bindValue(4,date("Y/m/d",strtotime(str_replace("/","-",$model->getData()))));
			$stmt->bindValue(5,$model->getId());
			$r=$stmt->execute();
			$this->desconectar();
			return $r;
		}catch(PDOException $ex){
			echo "Erro".$ex->getMessage();
		}
	}
}
?>