<?php
	require_once '../Conexao/ControllerConexao.php';
	require_once 'ItemVendaSucata.php';
	require_once '../Sucata/Sucata.php';
	require_once '../Carro/Carro.php';
	require_once '../Modelo/Modelo.php';
	require_once '../Marca/Marca.php';
	
class DAOItemVendaSucata{
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
			$stmt = $this->conexao->query("select * from tbitemvendasucata ivs inner join tbsucata s on (s.idtbSucata=ivs.tbsucata_idtbSucata) inner join tbcarro c on(c.idtbCarro=s.tbcarro_idtbCarro) inner join tbmodelo mo on(mo.idtbModelo=c.tbmodelo_idtbModelo) inner join tbmarca ma on (ma.idtbMarca=mo.tbmarca_idtbMarca) where ivs.tborcamento_idtbOrcamento=".$orcamento);
			
			$model=null;
			foreach($stmt as $row){
				$model = new ItemVendaSucata();
				$model->setId($row["idtbItemVendaSucata"]);
				$model->setValorTotal($row["valorTotal"]);
				$model->setNomePeca($row["nomePeca"]);
				$model->setQuantidade($row["quantidadeItens"]);
				$modelSucata = new Sucata();
				$modelSucata->setId($row["idtbSucata"]);
				$modelSucata->setLote($row["lote"]);
				$modelSucata->setLeilao($row["leilao"]);
				$modelSucata->setDataLeilao($row["dataLeilao"]);
				$modelSucata->setLocalizacao($row["localizacao"]);
				$modelCarro = new Carro();
				$modelCarro->setId($row["idtbCarro"]);
				$modelModelo= new Modelo();
				$modelMarca = new Marca();
				$modelMarca->setMarca($row["marca"]);
				$modelMarca->setId($row["idtbMarca"]);
				$modelModelo->setMarca($modelMarca);
				$modelModelo->setModelo($row["modelo"]);
				$modelModelo->setId($row["idtbModelo"]);
				$modelCarro->setModelo($modelModelo);
				$modelCarro->setVersao($row["versao"]);
				$modelCarro->setAno($row["ano"]);
				$modelSucata->setCarro($modelCarro);
				$model->setSucata($modelSucata);
				$vet[]=$model;
			}
			
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function consultarPorSucata($sucata){
		try{
			$this->conectar();
			$vet = null;
			$stmt = $this->conexao->query("select * from tbitemvendasucata ivs inner join tborcamento o on(o.idtbOrcamento=ivs.tborcamento_idtbOrcamento) where o.status=1 and ivs.tbsucata_idtbSucata=".$sucata);			
			$model=null;
			foreach($stmt as $row){
				$model = new ItemVendaSucata();
				$model->setId($row["idtbItemVendaSucata"]);
				$model->setValorTotal($row["valorTotal"]);
				$model->setNomePeca($row["nomePeca"]);
				$model->setQuantidade($row["quantidadeItens"]);
				$vet[]=$model;
			}
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
}