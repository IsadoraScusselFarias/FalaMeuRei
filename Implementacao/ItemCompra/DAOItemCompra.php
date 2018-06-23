<?php
	require_once '../Conexao/ControllerConexao.php';
	require_once 'ItemCompra.php';
	require_once '../Peca/Peca.php';
	require_once '../Carro/Carro.php';
	require_once '../Modelo/Modelo.php';
	require_once '../Marca/Marca.php';
	
class DAOItemCompra{
	private $conexao;
	
	private function conectar(){
		$ccon=new ControllerConexao();
		$this->conexao = $ccon->abreConexao();
	}
	
	private function desconectar(){
		$ccon=new ControllerConexao();
		$this->conexao = null;
	}
	public function consultarPorCompra($compra){
		try{
			$this->conectar();
			$vet = null;
			$vetCategoria=null;
			$vetFoto=null;
			$stmt = $this->conexao->query("select * from tbitemcompra ic inner join tbpeca p on (p.idtbPeca=ic.tbpeca_idtbPeca) inner join tbcarro c on(c.idtbCarro=p.tbcarro_idtbCarro) inner join tbmodelo mo on(mo.idtbModelo=c.tbmodelo_idtbModelo) inner join tbmarca ma on (ma.idtbMarca=mo.tbmarca_idtbMarca) where ic.tbcompra_idtbCompra=".$compra);
			
			$model=null;
			foreach($stmt as $row){
				$model = new ItemCompra();
				$model->setId($row["idtbItemCompra"]);
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
}