<?php
	require_once '../Conexao/ControllerConexao.php';
	require_once 'Relatorio.php';
	require_once '../Orcamento/Orcamento.php';
	require_once '../Compra/Compra.php';
	require_once '../Despesa/Despesa.php';
	
class DAORelatorio{
	private $conexao;
	
	private function conectar(){
		$ccon=new ControllerConexao();
		$this->conexao = $ccon->abreConexao();
	}
	
	private function desconectar(){
		$ccon=new ControllerConexao();
		$this->conexao = null;
	}
	public function consultarPorCompras($model){
		try{
			$query="select count(idtbCompra) as qtd, sum(valor) as valor from tbcompra where data between ? and ?";
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1,date("Y/m/d",strtotime(str_replace("/","-",$model->getDataInicial()))));
			$stmt->bindValue(2,date("Y/m/d",strtotime(str_replace("/","-",$model->getDataFinal()))));
			$stmt->execute();
			foreach($stmt as $row){
				if (isset($row["valor"])) {
					$model->setValorCompras($row["valor"]);
				}else{
					$model->setValorCompras("0");
				}
				$model->setQuantidadeCompras($row["qtd"]);
			}
			$this->desconectar();
			return $model;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function consultarPorDespesas($model){
		try{	
			$query="select count(idtbDespesa) as qtd, sum(valor) as valor from tbdespesa where data between ? and ?";
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1,date("Y/m/d",strtotime(str_replace("/","-",$model->getDataInicial()))));
			$stmt->bindValue(2,date("Y/m/d",strtotime(str_replace("/","-",$model->getDataFinal()))));
			$stmt->execute();
			foreach($stmt as $row){
				if (isset($row["valor"])) {
					$model->setValorDespesas($row["valor"]);
				}else{
					$model->setValorDespesas("0");
				}
				$model->setQuantidadeDespesas($row["qtd"]);
			}
			$this->desconectar();
			return $model;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function consultarPorVendas($model){
		try{	
			$query="select count(idtbOrcamento) as qtd, sum(valor-desconto) as valor from tborcamento where dataVenda between ? and ? and status=1";
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1,date("Y/m/d",strtotime(str_replace("/","-",$model->getDataInicial()))));
			$stmt->bindValue(2,date("Y/m/d",strtotime(str_replace("/","-",$model->getDataFinal()))));
			$stmt->execute();
			foreach($stmt as $row){
				if (isset($row["valor"])) {
					$model->setValorVendas($row["valor"]);
				}else{
					$model->setValorVendas("0");
				}
				$model->setQuantidadeVendas($row["qtd"]);
			}
			$this->desconectar();
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
}