<?php
require_once "../Conexao/ControllerConexao.php";
require_once "../Cidade/Cidade.php";
require_once "../Estado/Estado.php";
class DAOCliente{
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
			$stmt=$this->conexao->prepare("insert into tbcliente(cpf, cnpj, nomeCompleto,endereco, telefone,email,tbcidade_idtbCidade) values(?,?,?,?,?,?,?)");
			$stmt->bindValue(1,$model->getCpf());
			$stmt->bindValue(2,$model->getCnpj());
			$stmt->bindValue(3,$model->getNomeCompleto());
			$stmt->bindValue(4,$model->getEndereco());
			$stmt->bindValue(5,$model->getTelefone());
			$stmt->bindValue(6,$model->getEmail());
			$stmt->bindValue(7,$model->getCidade()->getId());
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
			$stmt = $this->conexao->query("select * from tbcliente c inner join tbcidade cdd on (cdd.idtbCidade=c.tbcidade_idtbCidade) inner join tbestado e on(e.idtbEstado=cdd.tbestado_idtbEstado)");
			foreach ($stmt as $row) {
				$model = new Cliente();
				$model->setId($row["idtbCliente"]);
				$model->setEmail($row["email"]);
				$model->setCpf($row["cpf"]);
				$model->setCnpj($row["cnpj"]);
				$model->setNomeCompleto($row["nomeCompleto"]);
				$model->setEndereco($row["endereco"]);
				$model->setTelefone($row["telefone"]);
				$modelEstado=new Estado();
				$modelEstado->setId($row["idtbEstado"]);
				$modelEstado->setUf($row["uf"]);
				$modelEstado->setEstado($row["estado"]);
				$modelCidade= new Cidade();
				$modelCidade->setId($row["idtbCidade"]);
				$modelCidade->setCidade($row["cidade"]);
				$modelCidade->setEstado($modelEstado);
				$model->setCidade($modelCidade);
				$vet[] = $model;
			}
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro".$ex->getMessage());
		}
	}
	public function consultarComFiltro($model){
		try{
			$query="select * from tbcliente c inner join tbcidade cdd on (cdd.idtbCidade=c.tbcidade_idtbCidade) inner join tbestado e on(e.idtbEstado=cdd.tbestado_idtbEstado) where";
			$criterios = 0;
			if ($model->getNomeCompleto()!="") {
				$query=$query." nomeCompleto like ? ";
			}	
			if ($model->getCpf() != "") {
				if ($criterios>0) {
					$query=$query." and ";
				}
				$query=$query." cpf=?";
			}
			if ($model->getCnpj() != "") {
				if ($criterios>0) {
					$query=$query." and ";
				}
				$query=$query." cnpj=?";
			}
			if ($model->getEmail() != "") {
				if ($criterios>0) {
					$query=$query." and ";
				}
				$query=$query." email=?";
			}
			$vet = null;
			$pos = 0;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			if ($model->getNomeCompleto() != ""){
				$pos++;
				$stmt->bindValue($pos,"%".$model->getNomeCompleto()."%");
			}
			if ($model->getCpf() != ""){
				$pos++;
				$stmt->bindValue($pos,$model->getCpf());
			}
			if ($model->getCnpj() != ""){
				$pos++;
				$stmt->bindValue($pos,$model->getCnpj());
			}
			if ($model->getEmail() != ""){
				$pos++;
				$stmt->bindValue($pos,$model->getEmail());
			}
			$stmt->execute();
			foreach ($stmt as $row) {
				$model = new Cliente();
				$model->setId($row["idtbCliente"]);
				$model->setEmail($row["email"]);
				$model->setCpf($row["cpf"]);
				$model->setCnpj($row["cnpj"]);
				$model->setNomeCompleto($row["nomeCompleto"]);
				$model->setEndereco($row["endereco"]);
				$model->setTelefone($row["telefone"]);
				$modelEstado=new Estado();
				$modelEstado->setId($row["idtbEstado"]);
				$modelEstado->setUf($row["uf"]);
				$modelEstado->setEstado($row["estado"]);
				$modelCidade= new Cidade();
				$modelCidade->setId($row["idtbCidade"]);
				$modelCidade->setCidade($row["cidade"]);
				$modelCidade->setEstado($modelEstado);
				$model->setCidade($modelCidade);
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
			$query="select * from tbcliente where ";
			$criterios = 0;
			if ($model->getNomeCompleto()!="") {
				$query=$query." idtbCliente = ? ";
				$criterios++;
			}	
			if ($model->getCpf() != "") {
				if ($criterios>0) {
					$query=$query." and ";
				}
				$query=$query." cpf=?";
				$criterios++;
			}
			if ($model->getCnpj() != "") {
				if ($criterios>0) {
					$query=$query." and ";
				}
				$query=$query." cnpj=?";
				$criterios++;
			}
			if ($model->getEmail() != "") {
				if ($criterios>0) {
					$query=$query." and ";
				}
				$query=$query." email=?";
				$criterios++;
			}
			$vet = null;
			$pos = 0;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			if ($model->getNomeCompleto() != ""){
				$pos++;
				$stmt->bindValue($pos,$model->getId());
			}
			if ($model->getCpf() != ""){
				$pos++;
				$stmt->bindValue($pos,$model->getCpf());
			}
			if ($model->getCnpj() != ""){
				$pos++;
				$stmt->bindValue($pos,$model->getCnpj());
			}
			if ($model->getEmail() != ""){
				$pos++;
				$stmt->bindValue($pos,$model->getEmail());
			}
			$stmt->execute();
			foreach ($stmt as $row) {
				$model = new Cliente();
				$model->setId($row["idtbCliente"]);
				$model->setEmail($row["email"]);
				$model->setCpf($row["cpf"]);
				$model->setCnpj($row["cnpj"]);
				$model->setNomeCompleto($row["nomeCompleto"]);
				$model->setEndereco($row["endereco"]);
				$model->setTelefone($row["telefone"]);
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
			$stmt = $this->conexao->query("select * from tbcliente c inner join tbcidade cdd on (cdd.idtbCidade=c.tbcidade_idtbCidade) inner join tbestado e on(e.idtbEstado=cdd.tbestado_idtbEstado) where idtbCliente = ".$id);
			$model = null;
			foreach ($stmt as $row) {
				$model = new Cliente();
				$model->setId($row["idtbCliente"]);
				$model->setEmail($row["email"]);
				$model->setCpf($row["cpf"]);
				$model->setCnpj($row["cnpj"]);
				$model->setNomeCompleto($row["nomeCompleto"]);
				$model->setEndereco($row["endereco"]);
				$model->setTelefone($row["telefone"]);
				$modelEstado=new Estado();
				$modelEstado->setId($row["idtbEstado"]);
				$modelEstado->setUf($row["uf"]);
				$modelEstado->setEstado($row["estado"]);
				$modelCidade= new Cidade();
				$modelCidade->setId($row["idtbCidade"]);
				$modelCidade->setCidade($row["cidade"]);
				$modelCidade->setEstado($modelEstado);
				$model->setCidade($modelCidade);
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
			$stmt=$this->conexao->prepare("update tbcliente  set email = ?,nomeCompleto=? , cpf= ?, cnpj = ?,endereco=? , telefone= ?, tbcidade_idtbCidade=? where idtbCliente =?;");
			$stmt->bindValue(1,$model->getEmail());
			$stmt->bindValue(2,$model->getNomeCompleto());
			$stmt->bindValue(3,$model->getCpf());
			$stmt->bindValue(4,$model->getCnpj());
			$stmt->bindValue(5,$model->getEndereco());
			$stmt->bindValue(6,$model->getTelefone());
			$stmt->bindValue(7,$model->getCidade()->getId());
			$stmt->bindValue(8,$model->getId());
			$r=$stmt->execute();
			$this->desconectar();
			return $r;
		}catch(PDOException $ex){
			echo "Erro".$ex->getMessage();
		}
	}
}
?>
