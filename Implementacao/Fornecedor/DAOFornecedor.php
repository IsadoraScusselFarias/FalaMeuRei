<?php
require_once "../Conexao/ControllerConexao.php";
require_once "../Cidade/Cidade.php";
require_once "../Estado/Estado.php";
require_once "Fornecedor.php";
class DAOFornecedor{
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
			$stmt=$this->conexao->prepare("insert into tbfornecedor(cnpj, nome,endereco,telefone,email,tbcidade_idtbCidade) values(?,?,?,?,?,?);");
			$stmt->bindValue(1,$model->getCnpj());
			$stmt->bindValue(2,$model->getNome());
			$stmt->bindValue(3,$model->getEndereco());
			$stmt->bindValue(4,$model->getTelefone());
			$stmt->bindValue(5,$model->getEmail());
			$stmt->bindValue(6,$model->getCidade()->getId());
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
			$stmt = $this->conexao->query("select * from tbfornecedor c inner join tbcidade cdd on (cdd.idtbCidade=c.tbcidade_idtbCidade) inner join tbestado e on(e.idtbEstado=cdd.tbestado_idtbEstado)");
			foreach ($stmt as $row) {
				$model = new Fornecedor();
				$model->setId($row["idtbFornecedor"]);
				$model->setEmail($row["email"]);
				$model->setCnpj($row["cnpj"]);
				$model->setNome($row["nome"]);
				$model->setEndereco($row["endereco"]);
				$model->setTelefone($row["telefone"]);
				$modele=new Estado();
				$modele->setId($row["idtbEstado"]);
				$modele->setUf($row["uf"]);
				$modele->setEstado($row["estado"]);
				$modelc= new Cidade();
				$modelc->setId($row["idtbCidade"]);
				$modelc->setCidade($row["cidade"]);
				$modelc->setEstado($modele);
				$model->setCidade($modelc);
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
			$query="select * from tbfornecedor c inner join tbcidade cdd on (cdd.idtbCidade=c.tbcidade_idtbCidade) inner join tbestado e on(e.idtbEstado=cdd.tbestado_idtbEstado) where";
			$criterios = 0;
			if ($model->getNome()!="") {
				$query=$query." nome like ? ";
			}	
			if ($model->getEmail() != "") {
				if ($criterios>0) {
					$query=$query." and ";
				}
				$query=$query." email=?";
			}
			if ($model->getCnpj() != "") {
				if ($criterios>0) {
					$query=$query." and ";
				}
				$query=$query." cnpj=?";
			}
			$vet = null;
			$pos = 0;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			if ($model->getNome() != ""){
				$pos++;
				$stmt->bindValue($pos,"%".$model->getNome()."%");
			}
			if ($model->getEmail() != ""){
				$pos++;
				$stmt->bindValue($pos,$model->getEmail());
			}
			if ($model->getCnpj() != ""){
				$pos++;
				$stmt->bindValue($pos,$model->getCnpj());
			}
			$stmt->execute();
			foreach ($stmt as $row) {
				$model = new Fornecedor();
				$model->setId($row["idtbFornecedor"]);
				$model->setEmail($row["email"]);
				$model->setCnpj($row["cnpj"]);
				$model->setNome($row["nome"]);
				$model->setEndereco($row["endereco"]);
				$model->setTelefone($row["telefone"]);
				$modele=new Estado();
				$modele->setId($row["idtbEstado"]);
				$modele->setUf($row["uf"]);
				$modele->setEstado($row["estado"]);
				$modelc= new Cidade();
				$modelc->setId($row["idtbCidade"]);
				$modelc->setCidade($row["cidade"]);
				$modelc->setEstado($modele);
				$model->setCidade($modelc);
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
			$stmt = $this->conexao->query("select * from tbfornecedor c inner join tbcidade cdd on (cdd.idtbCidade=c.tbcidade_idtbCidade) inner join tbestado e on(e.idtbEstado=cdd.tbestado_idtbEstado) where idtbFornecedor = ".$id);
			$model = null;
			foreach ($stmt as $row) {
				$model = new Fornecedor();
				$model->setId($row["idtbFornecedor"]);
				$model->setEmail($row["email"]);
				$model->setCnpj($row["cnpj"]);
				$model->setNome($row["nome"]);
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
			$stmt=$this->conexao->prepare("update tbfornecedor  set email = ?,nome=? , cnpj = ?,endereco=? , telefone= ?, tbcidade_idtbCidade=? where idtbFornecedor =?;");
			$stmt->bindValue(1,$model->getEmail());
			$stmt->bindValue(2,$model->getNome());
			$stmt->bindValue(3,$model->getCnpj());
			$stmt->bindValue(4,$model->getEndereco());
			$stmt->bindValue(5,$model->getTelefone());
			$stmt->bindValue(6,$model->getCidade()->getId());
			$stmt->bindValue(7,$model->getId());
			$r=$stmt->execute();
			$this->desconectar();
			return $r;
		}catch(PDOException $ex){
			echo "Erro".$ex->getMessage();
		}
	}
}
?>
