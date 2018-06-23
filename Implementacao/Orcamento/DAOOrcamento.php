<?php
	require_once '../Conexao/ControllerConexao.php';
	require_once 'Orcamento.php';
	require_once '../ItemVendaPeca/ItemVendaPeca.php';
	require_once '../ItemVendaSucata/ItemVendaSucata.php';
	require_once '../Cliente/Cliente.php';
	
class DAOOrcamento{
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
			$stmt = $this->conexao->prepare("insert into tborcamento(valor,desconto,dataOrcamento,tbcliente_idtbCliente) values (?,?,?,?);");
			$stmt->bindValue(1,$model->getValor());
			$stmt->bindValue(2,$model->getDesconto());
			$stmt->bindValue(3,date("Y-m-d",strtotime(str_replace("/","-",$model->getDataOrcamento()))));
			$stmt->bindValue(4,$model->getCliente()->getId());	
			$resu1 = $stmt->execute();
			$stmt = $this->conexao->query("SELECT LAST_INSERT_ID() as id");
			foreach ($stmt as $row){
				$model->setId($row["id"]);
			}
			$resu2=null;
			if ($model->getItemVendaPeca()!=null) {
				foreach ($model->getItemVendaPeca() as $modelItemVendaPeca) {
					$stmtivp=$this->conexao->prepare("insert into tbitemvendapeca(valorTotal,quantidadeItens,tbpeca_idtbPeca,tborcamento_idtbOrcamento) values(?,?,?,?);");
					$stmtivp->bindValue(1,$modelItemVendaPeca->getValorTotal());
					$stmtivp->bindValue(2,$modelItemVendaPeca->getQuantidade());
					$stmtivp->bindValue(3,$modelItemVendaPeca->getPeca()->getId());
					$stmtivp->bindValue(4,$model->getId());
					$resu2 = $stmtivp->execute();
					$stmtp = $this->conexao->prepare("update tbpeca set quantidade=quantidade-?  where idtbPeca=?");
					$stmtp->bindValue(1,$modelItemVendaPeca->getQuantidade());
					$stmtp->bindValue(2,$modelItemVendaPeca->getPeca()->getId());
					$resultado = $stmt->execute();
				}
			}
			$resu3=null;
			if ($model->getItemVendaSucata()!=null) {
				foreach ($model->getItemVendaSucata() as $modelItemVendaSucata) {
					$stmtivs=$this->conexao->prepare("insert into tbitemvendasucata(valorTotal,nomePeca,quantidadeItens,tbsucata_idtbSucata,tborcamento_idtbOrcamento) values(?,?,?,?,?);");
					$stmtivs->bindValue(1,$modelItemVendaSucata->getValorTotal());
					$stmtivs->bindValue(2,$modelItemVendaSucata->getNomePeca());
					$stmtivs->bindValue(3,$modelItemVendaSucata->getQuantidade());
					$stmtivs->bindValue(4,$modelItemVendaSucata->getSucata()->getId());
					$stmtivs->bindValue(5,$model->getId());
					$resu3 = $stmtivs->execute();
				}
			}
			$this->desconectar();
			return $resu1&&$resu2&&$resu3;
		}catch(PDOException $ex){
			echo("Erro:".$ex->getMessage());
		}
	}
	public function atualizar($model){
		try{
			$this->conectar();
			$stmt = $this->conexao->prepare("update tborcamento set valor=?, desconto =?,dataOrcamento=?, tbcliente_idtbCliente=? where idtbOrcamento=?;");
			$stmt->bindValue(1,$model->getValor());
			$stmt->bindValue(2,$model->getDesconto());
			$stmt->bindValue(3,date("Y-m-d",strtotime(str_replace("/","-",$model->getDataOrcamento()))));
			$stmt->bindValue(4,$model->getCliente()->getId());	
			$stmt->bindValue(5,$model->getId());	
			$resu1 = $stmt->execute();
			$resu2=null;
			$this->conexao->exec("delete from tbitemvendapeca where tborcamento_idtbOrcamento=".$model->getId());
			if ($model->getItemVendaPeca()!=null) {
				foreach ($model->getItemVendaPeca() as $modelItemVendaPeca) {
					$stmtivp=$this->conexao->prepare("insert into tbitemvendapeca(valorTotal,quantidade,tbpeca_idtbPeca,tborcamento_idtbOrcamento) values(?,?,?,?);");
					$stmtivp->bindValue(1,$modelItemVendaPeca->getValorTotal());
					$stmtivp->bindValue(2,$modelItemVendaPeca->getQuantidade());
					$stmtivp->bindValue(3,$modelItemVendaPeca->getPeca()->getId());
					$stmtivp->bindValue(4,$model->getId());
					$resu2 = $stmtivp->execute();
				}
			}
			$resu3=null;
			$this->conexao->exec("delete from tbitemvendasucata where tborcamento_idtbOrcamento=".$model->getId());
			if ($model->getItemVendaSucata()!=null) {
				foreach ($model->getItemVendaSucata() as $modelItemVendaSucata) {
					$stmtivs=$this->conexao->prepare("insert into tbitemvendasucata(valorTotal,nomePeca,quantidade,tbsucata_idtbSucata,tborcamento_idtbOrcamento) values(?,?,?,?,?);");
					$stmtivs->bindValue(1,$modelItemVendaSucata->getValorTotal());
					$stmtivs->bindValue(2,$modelItemVendaSucata->getNomePeca());
					$stmtivs->bindValue(3,$modelItemVendaSucata->getQuantidade());
					$stmtivs->bindValue(4,$modelItemVendaSucata->getSucata()->getId());
					$stmtivs->bindValue(5,$model->getId());
					$resu3 = $stmtivs->execute();
				}
			}
			$this->desconectar();
			return $resu1;
		}catch(PDOException $ex){
			echo("Erro:".$ex->getMessage());
		}
	}
	public function consultarComFiltro($model,$dataInicial,$dataFinal){
		try{			
			$query ="select * FROM tborcamento o inner join tbcliente c on(o.tbcliente_idtbCliente=c.idtbCliente) where";
			$criterios = 0;
			if ($model!="") {
				if ($model->getCliente()->getNomeCompleto()!="") {
					$query=$query." c.nomeCompleto like ?";
					$criterios++;	
				}	
				if ($model->getStatus()=="1") {
					$tipoData="dataVenda";
				}else{
					$tipoData="dataOrcamento";
				}
			}else{
				$tipoData="dataVenda";
			}
			if ($dataInicial!="") {
				if ($criterios>0) {
					$query=$query." and ";
				}
				$query=$query." ".$tipoData." >= ?";
				$criterios++;	
			}
			if ($dataFinal!="") {
				if ($criterios>0) {
					$query=$query." and ";
				}
				$query=$query." ".$tipoData." <= ?";
				$criterios++;	
			}
			if ($criterios>0) {
				$query=$query." and ";
			}
			$query=$query." o.status=?";
			$vet = null;
			$pos = 0;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			if ($model!="") {
				if ($model->getCliente()->getNomeCompleto()!=""){
					$pos++;
					$stmt->bindValue($pos,"%".$model->getCliente()->getNomeCompleto()."%");
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
			$pos++;
			if ($model!="") {
				$stmt->bindValue($pos,$model->getStatus());
			}else{
				$stmt->bindValue($pos,"1");
			}
			$stmt->execute();
			foreach($stmt as $row){
				$model = new Orcamento();
				$model->setId($row["idtbOrcamento"]);
				$model->setStatus($row["status"]);
				$model->setDataOrcamento(date("d/m/Y",strtotime(str_replace("-","/",$row["dataOrcamento"]))));
				$model->setValor($row["valor"]);
				$model->setDesconto($row["desconto"]);
				$model->setDataVenda(date("d/m/Y",strtotime(str_replace("-","/",$row["dataVenda"]))));
				$modelCliente = new Cliente();
				$modelCliente->setId($row["idtbCliente"]);
				$modelCliente->setEmail($row["email"]);
				$modelCliente->setCpf($row["cpf"]);
				$modelCliente->setCnpj($row["cnpj"]);
				$modelCliente->setNomeCompleto($row["nomeCompleto"]);
				$modelCliente->setEndereco($row["endereco"]);
				$modelCliente->setTelefone($row["telefone"]);
				$model->setCliente($modelCliente);
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
			$vetCategoria=null;
			$vetFoto=null;
			$stmt = $this->conexao->query("select * FROM tborcamento o inner join tbcliente c on(o.tbcliente_idtbCliente=c.idtbCliente) where o.idtbOrcamento=".$id);
			
			$model=null;
			foreach($stmt as $row){
				$model = new Orcamento();
				$model->setId($row["idtbOrcamento"]);
				$model->setStatus($row["status"]);
				$model->setDataOrcamento(date("d/m/Y",strtotime(str_replace("-","/",$row["dataOrcamento"]))));
				$model->setValor($row["valor"]);
				$model->setDesconto($row["desconto"]);
				$model->setDataVenda(date("d/m/Y",strtotime(str_replace("-","/",$row["dataVenda"]))));
				$modelCliente = new Cliente();
				$modelCliente->setId($row["idtbCliente"]);
				$modelCliente->setEmail($row["email"]);
				$modelCliente->setCpf($row["cpf"]);
				$modelCliente->setCnpj($row["cnpj"]);
				$modelCliente->setNomeCompleto($row["nomeCompleto"]);
				$modelCliente->setEndereco($row["endereco"]);
				$modelCliente->setTelefone($row["telefone"]);
				$model->setCliente($modelCliente);
			}
			
			$this->desconectar();
			return $model;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function vender($model){
		try{
			$this->conectar();
			$stmt=$this->conexao->prepare("update tborcamento set status=1, dataVenda=? where idtbOrcamento=?");		
			$stmt->bindValue(1,date("Y-m-d",strtotime(str_replace("/","-",$model->getDataVenda()))));
			$stmt->bindValue(2,$model->getId());	
			if ($model->getItemVendaPeca()!=null) {
				foreach ($model->getItemVendaPeca() as $modelItemVendaPeca) {
					$stmtp = $this->conexao->prepare("update tbpeca set quantidade=quantidade-? where idtbPeca=?");
					$stmtp->bindValue(1,$modelItemVendaPeca->getQuantidade());
					$stmtp->bindValue(2,$modelItemVendaPeca->getPeca()->getId());
					$resu = $stmtp->execute();
				}
			}
			$vendido=$stmt->execute();
			$this->desconectar();
			return $vendido;
		}catch(PDOException $ex){
			echo "Erro: ".$ex->getMessage();  
		}
	 }
}