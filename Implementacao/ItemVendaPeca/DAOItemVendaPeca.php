<?php
	require_once '../Conexao/ControllerConexao.php';
	require_once 'ItemVendaPeca.php';
	require_once '../Peca/Peca.php';
	require_once '../Carro/Carro.php';
	require_once '../Modelo/Modelo.php';
	require_once '../Marca/Marca.php';
	
class DAOItemVendaPeca{
	private $conexao;
	
	private function conectar(){
		$ccon=new ControllerConexao();
		$this->conexao = $ccon->abreConexao();
	}
	
	private function desconectar(){
		$ccon=new ControllerConexao();
		$this->conexao = null;
	}
	public function consultarPorOrcamento($orcamento){
		try{
			$this->conectar();
			$vet = null;
			$vetCategoria=null;
			$vetFoto=null;
			$stmt = $this->conexao->query("select * from tbitemvendapeca ivp inner join tbpeca p on (p.idtbPeca=ivp.tbpeca_idtbPeca) inner join tbcarro c on(c.idtbCarro=p.tbcarro_idtbCarro) inner join tbmodelo mo on(mo.idtbModelo=c.tbmodelo_idtbModelo) inner join tbmarca ma on (ma.idtbMarca=mo.tbmarca_idtbMarca) where ivp.tborcamento_idtbOrcamento=".$orcamento);
			
			$model=null;
			foreach($stmt as $row){
				$model = new ItemVendaPeca();
				$model->setId($row["idtbItemVendaPeca"]);
				$model->setValorTotal($row["valorTotal"]);
				$model->setQuantidade($row["quantidadeItens"]);
				$modelPeca = new Peca();
				$modelPeca->setId($row["idtbPeca"]);
				$modelPeca->setNome($row["nome"]);
				$modelPeca->setDescricao($row["descricao"]);
				$modelPeca->setQuantidade($row["quantidade"]);
				$modelPeca->setPreco($row["preco"]);					
				$modelCarro = new Carro();
				$modelCarro->setId($row["idtbCarro"]);
				$modelCarro->setAno($row["ano"]);
				$modelCarro->setVersao($row["versao"]);
				$modelModelo= new Modelo();
				$modelMarca = new Marca();
				$modelMarca->setMarca($row["marca"]);
				$modelMarca->setId($row["idtbMarca"]);
				$modelModelo->setMarca($modelMarca);
				$modelModelo->setModelo($row["modelo"]);
				$modelModelo->setId($row["idtbModelo"]);
				$modelCarro->setModelo($modelModelo);
				$modelPeca->setCarro($modelCarro);
				$model->setPeca($modelPeca);
				$vet[]=$model;
			}
			
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function atualizarQuantidade($model){
		try{
			$this->conectar();
			$stmt=$this->conexao->prepare("update tbitemvendapeca set quantidadeItens=? where idtbItemVendaPeca=?");		
			$stmt->bindValue(1,$model->getQuantidade());
			$stmt->bindValue(2,$model->getId());	
			$res=$stmt->execute();
			$this->desconectar();
			return $res;
		}catch(PDOException $ex){
			echo "Erro: ".$ex->getMessage();  
		}
	 }	
}