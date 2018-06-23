<?php
require_once "../Conexao/ControllerConexao.php";
require_once "Compra.php";
require_once "../Fornecedor/Fornecedor.php";
class DAOCompra{
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
			$stmt=$this->conexao->prepare("insert into tbcompra(data, valor, descricao,tbfornecedor_idtbFornecedor) values(?,?,?,?);");
			$stmt->bindValue(1,date("Y-m-d",strtotime(str_replace("/","-",$model->getData()))));
			$stmt->bindValue(2,$model->getValor());
			$stmt->bindValue(3,$model->getDescricao());
			$stmt->bindValue(4,$model->getFornecedor()->getId());
			$r=$stmt->execute();
			$stmt = $this->conexao->query("SELECT LAST_INSERT_ID() as id");
			foreach ($stmt as $row){
				$model->setId($row["id"]);
			}
			if ($model->getSucata()!=null) {
				$stmt = $this->conexao->prepare("insert into tbsucata(lote,leilao,dataLeilao,localizacao,tbCarro_idtbCarro,tbcompra_idtbCompra) values (?,?,?,?,?,?);");
				$stmt->bindValue(1,$model->getSucata()->getLote());
				$stmt->bindValue(2,$model->getSucata()->getLeilao());
				$stmt->bindValue(3,date("Y/m/d",strtotime(str_replace("/","-",$model->getSucata()->getDataLeilao()))));
				$stmt->bindValue(4,$model->getSucata()->getLocalizacao());
				$stmt->bindValue(5,$model->getSucata()->getCarro()->getId());
				$stmt->bindValue(6,$model->getId());
				$resu = $stmt->execute();
				$stmt = $this->conexao->query("SELECT LAST_INSERT_ID() as id");
				foreach ($stmt as $row){
					
					$model->getSucata()->setId($row["id"]);
				}
				if ($model->getSucata()->getCategorias()!=null) {
					foreach ($model->getSucata()->getCategorias() as $x) {
						$stmt = $this->conexao->prepare("insert into tbsucata_tbcategoria(tbsucata_idtbSucata,tbcategoria_idtbCategoria) values (?,?);");
						$stmt->bindValue(1,$model->getSucata()->getId());
						$stmt->bindValue(2,$x->getId());
						$resu = $stmt->execute();
					}
				}
				if ($model->getSucata()->getFotos()!=null) {
					foreach ($model->getSucata()->getFotos() as $foto) {
						$stmt = $this->conexao->prepare("insert into tbfoto(tbsucata_idtbSucata,caminho) values (?,?);");
						$stmt->bindValue(1,$model->getSucata()->getId());
						$stmt->bindValue(2,$foto->getCaminho());
						$resu = $stmt->execute();
					}
				}
			}
			if ($model->getItemCompra()!=null) {
				foreach ($model->getItemCompra() as $itemCompra) {
					$stmt = $this->conexao->prepare("insert into tbitemcompra(quantidade,valorTotal,tbpeca_idtbPeca,tbcompra_idtbCompra) values (?,?,?,?);");
					$stmt->bindValue(1,$itemCompra->getQuantidade());
					$stmt->bindValue(2,$itemCompra->getValorTotal());
					$stmt->bindValue(3,$itemCompra->getPeca()->getId());
					$stmt->bindValue(4,$model->getId());
					$resu = $stmt->execute();
					$stmtp = $this->conexao->prepare("update tbpeca set quantidade=quantidade+?  where idtbPeca=?");
					$stmtp->bindValue(1,$itemCompra->getQuantidadeParaPeca());
					$stmtp->bindValue(2,$itemCompra->getPeca()->getId());
					$resu = $stmtp->execute();

				}
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
			$stmt = $this->conexao->query("select * from tbcompra c inner join tbfornecedor f on(f.idtbFornecedor=c.tbfornecedor_idtbFornecedor) ");
			foreach ($stmt as $row) {
				$model = new Compra();
				$model->setId($row["idtbCompra"]);
				$model->setData(date("d/m/Y",strtotime(str_replace("-","/",$row["data"]))));
				$model->setValor($row["valor"]);
				$model->setDescricao($row["descricao"]);
				$modelFornecedor = new Fornecedor();
				$modelFornecedor->setId($row["idtbFornecedor"]);
				$modelFornecedor->setEmail($row["email"]);
				$modelFornecedor->setCnpj($row["cnpj"]);
				$modelFornecedor->setNome($row["nome"]);
				$modelFornecedor->setEndereco($row["endereco"]);
				$modelFornecedor->setTelefone($row["telefone"]);
				$model->setFornecedor($modelFornecedor);
				$vet[]=$model;
			}
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro".$ex->getMessage());
		}
	}
	public function consultarComFiltro($model,$dataInicial,$dataFinal){
		try{
			$query="select * from tbcompra c inner join tbfornecedor f on(f.idtbFornecedor=c.tbfornecedor_idtbFornecedor) where";
			$criterios = 0;
			if ($model!="") {
				if ($model->getValor() != "") {
					$query=$query." valor=?";
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
				if ($model->getValor() != "") {
					$pos++;
					$stmt->bindValue($pos,$model->getValor());
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
				$model = new Compra();
				$model->setId($row["idtbCompra"]);
				$model->setData(date("d/m/Y",strtotime(str_replace("-","/",$row["data"]))));
				$model->setValor($row["valor"]);
				$model->setDescricao($row["descricao"]);
				$modelFornecedor = new Fornecedor();
				$modelFornecedor->setId($row["idtbFornecedor"]);
				$modelFornecedor->setEmail($row["email"]);
				$modelFornecedor->setCnpj($row["cnpj"]);
				$modelFornecedor->setNome($row["nome"]);
				$modelFornecedor->setEndereco($row["endereco"]);
				$modelFornecedor->setTelefone($row["telefone"]);
				$model->setFornecedor($modelFornecedor);
				$vet[] = $model;
			}
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro".$ex->getMessage());
		}
	}
	public function excluir($id){
		try{
			$this->conectar();
			$excluido = $this->conexao->exec("delete from tbcompra where idtbCompra=".$id);
			$this->desconectar();
			return $excluido;
		}catch(PDOException $ex){
			echo "Erro: ".$ex->getMessage();
		}
	}
	public function consultarPorId($id){
		try{
			$this->conectar();
			$stmt = $this->conexao->query("select * from tbcompra c inner join tbfornecedor f on(f.idtbFornecedor=c.tbfornecedor_idtbFornecedor) where idtbCompra = ".$id);
			$model = null;
			foreach($stmt as $row) {
				$model = new Compra();
				$model->setId($row["idtbCompra"]);
				$model->setData(date("d/m/Y",strtotime(str_replace("-","/",$row["data"]))));
				$model->setValor($row["valor"]);
				$model->setDescricao($row["descricao"]);
				$modelFornecedor = new Fornecedor();
				$modelFornecedor->setId($row["idtbFornecedor"]);
				$modelFornecedor->setEmail($row["email"]);
				$modelFornecedor->setCnpj($row["cnpj"]);
				$modelFornecedor->setNome($row["nome"]);
				$modelFornecedor->setEndereco($row["endereco"]);
				$modelFornecedor->setTelefone($row["telefone"]);
				$model->setFornecedor($modelFornecedor);
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
			$stmt=$this->conexao->prepare("update tbcompra set data=?, valor=? , descricao= ?, tbfornecedor_idtbFornecedor=? where idtbCompra =?;");
			$stmt->bindValue(1,date("Y-m-d",strtotime(str_replace("/","-",$model->getData()))));
			$stmt->bindValue(2,$model->getValor());
			$stmt->bindValue(3,$model->getDescricao());
			$stmt->bindValue(4,$model->getFornecedor()->getId());
			$stmt->bindValue(5,$model->getId());
			$r=$stmt->execute();
			$this->conexao->exec("delete from tbitemcompra where tbcompra_idtbCompra=".$model->getId());
			if ($model->getItemCompra()!=null) {
				foreach ($model->getItemCompra() as $itemCompra) {
					$stmt = $this->conexao->prepare("insert into tbitemcompra(quantidade,valorTotal,tbpeca_idtbPeca,tbcompra_idtbCompra) values (?,?,?,?);");
					$stmt->bindValue(1,$itemCompra->getQuantidade());
					$stmt->bindValue(2,$itemCompra->getValorTotal());
					$stmt->bindValue(3,$itemCompra->getPeca()->getId());
					$stmt->bindValue(4,$model->getId());
					$resu = $stmt->execute();
					$stmtp = $this->conexao->prepare("update tbpeca set quantidade=quantidade+?  where idtbPeca=?");
					$stmtp->bindValue(1,$itemCompra->getQuantidadeParaPeca());
					$stmtp->bindValue(2,$itemCompra->getPeca()->getId());
					$resu = $stmtp->execute();
				}
			}			
			$this->desconectar();
			return $r;
		}catch(PDOException $ex){
			echo "Erro".$ex->getMessage();
		}
	}
}
?>
