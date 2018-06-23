<?php
	require_once '../Conexao/ControllerConexao.php';
	require_once 'Peca.php';
	require_once '../Carro/Carro.php';
	require_once '../Modelo/Modelo.php';
	require_once '../Marca/Marca.php';
	require_once '../Foto/Foto.php';
class DAOPeca{
	private $conexao;
	
	private function conectar(){
		$ccon=new ControllerConexao();
		$this->conexao = $ccon->abreConexao();
	}
	
	private function desconectar(){
		$ccon=new ControllerConexao();
		$this->conexao = null;
	}
	
	public function inserir($peca){
		try{
			$this->conectar();
			$stmt = $this->conexao->prepare("insert into tbpeca(nome,descricao,quantidade,preco,tbCarro_idtbCarro) values (?,?,?,?,?);");
			$stmt->bindValue(1,$peca->getNome());
			$stmt->bindValue(2,$peca->getDescricao());
			$stmt->bindValue(3,$peca->getQuantidade());
			$stmt->bindValue(4,$peca->getPreco());
			$stmt->bindValue(5,$peca->getCarro()->getId());
			$resu = $stmt->execute();
			$stmt = $this->conexao->query("SELECT LAST_INSERT_ID() as id");
			foreach ($stmt as $row){
				$peca->setId($row["id"]);
			}
			if ($peca->getFotos()!=null) {
				foreach ($peca->getFotos() as $foto) {
					$stmt = $this->conexao->prepare("insert into tbfoto(tbpeca_idtbPeca,caminho) values (?,?);");
					$stmt->bindValue(1,$peca->getId());
					$stmt->bindValue(2,$foto->getCaminho());
					$resu = $stmt->execute();
				}
			}
			$this->desconectar();
			return $resu;
		}catch(PDOException $ex){
			echo("Erro:".$ex->getMessage());
		}
	}


	public function atualizar($peca){
		try{
			$this->conectar();
			$stmt = $this->conexao->prepare("update tbpeca set nome=? ,descricao=?,quantidade=?,preco=?,tbCarro_idtbCarro=?  where idtbPeca=?");
			$stmt->bindValue(1,$peca->getNome());
			$stmt->bindValue(2,$peca->getDescricao());
			$stmt->bindValue(3,$peca->getQuantidade());
			$stmt->bindValue(4,$peca->getPreco());
			$stmt->bindValue(5,$peca->getCarro()->getId());
			$stmt->bindValue(6,$peca->getId());
			$resultado = $stmt->execute();
			if ($peca->getFotos()!=null) {
				foreach ($peca->getFotos() as $foto) {
					if ($foto->getAcao()=="1") {
						$stmt = $this->conexao->prepare("insert into tbfoto(tbpeca_idtbPeca,caminho) values (?,?);");
						$stmt->bindValue(1,$peca->getId());
						$stmt->bindValue(2,$foto->getCaminho());
						$resu = $stmt->execute();
					}else if($foto->getAcao()=="0"){
						$resu = $this->conexao->exec("delete from tbfoto where idtbFoto=".$foto->getId());
					}
				}
			}
			$this->desconectar();
			return $resultado;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function consultarPorId($id){
		try{
			$this->conectar();
			$vetCategoria = null;
			$vetFoto=null;
			$stmt = $this->conexao->query("select * from tbpeca p inner join tbcarro c on (p.tbCarro_idtbCarro=c.idtbCarro)  inner join tbmodelo mo on(mo.idtbModelo=c.tbmodelo_idtbModelo) inner join tbmarca ma on (ma.idtbMarca=mo.tbmarca_idtbMarca) left outer join tbfoto f on(p.idtbPeca=f.tbpeca_idtbPeca) where idtbPeca = ".$id." and p.status<>0");
			
			$model=null;
			foreach($stmt as $row){
				if ($model==null) {
					$model = new Peca();
					$model->setId($row["idtbPeca"]);
					$model->setNome($row["nome"]);
					$model->setDescricao($row["descricao"]);
					$model->setQuantidade($row["quantidade"]);
					$model->setPreco($row["preco"]);					
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
					$model->setCarro($modelCarro);
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
				}else{
					$modelFoto=new Foto();
					$modelFoto->setId($row["idtbFoto"]);
					$modelFoto->setCaminho($row["caminho"]);
					$vetFoto[]=$modelFoto;
					$model->setFotos($vetFoto);
				}
			}
			
			$this->desconectar();
			return $model;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function consultar($tipo){
		try{
			$this->conectar();
			$vet = null;
			$vetFoto=null;
			$stmt = $this->conexao->query("select * FROM tbpeca p inner join tbcarro c on (p.tbCarro_idtbCarro=c.idtbCarro)  inner join tbmodelo mo on(mo.idtbModelo=c.tbmodelo_idtbModelo) inner join tbmarca ma on (ma.idtbMarca=mo.tbmarca_idtbMarca)left outer join tbfoto f on(p.idtbPeca=f.tbpeca_idtbPeca) where p.status=".$tipo);
			foreach($stmt as $row){
				if ($vet==null) {
					$model = new Peca();
					$model->setId($row["idtbPeca"]);
					$model->setNome($row["nome"]);
					$model->setDescricao($row["descricao"]);
					$model->setQuantidade($row["quantidade"]);
					$model->setPreco($row["preco"]);					
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
					$model->setCarro($modelCarro);
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
					$vet[] = $model;
				}else if($vet[count($vet)-1]->getId()!=$row["idtbPeca"]){
					$vetFoto=null;
					$model = new Peca();
					$model->setId($row["idtbPeca"]);
					$model->setNome($row["nome"]);
					$model->setDescricao($row["descricao"]);
					$model->setQuantidade($row["quantidade"]);
					$model->setPreco($row["preco"]);					
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
					$model->setCarro($modelCarro);
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
					$vet[] = $model;
				}else{
					$modelFoto=new Foto();
					$modelFoto->setId($row["idtbFoto"]);
					$modelFoto->setCaminho($row["caminho"]);
					$vetFoto[]=$modelFoto;
					$vet[count($vet)-1]->setFotos($vetFoto);
				}
			}
			
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	
	public function consultarComFiltro($model,$tipo){
		try{
			
			$query ="select * from tbpeca p inner join tbcarro c on (p.tbCarro_idtbCarro=c.idtbCarro) inner join tbmodelo mo on(mo.idtbModelo=c.tbmodelo_idtbModelo) inner join tbmarca ma on (ma.idtbMarca=mo.tbmarca_idtbMarca) left outer join tbfoto f on(p.idtbPeca=f.tbpeca_idtbPeca) where ";
			$criterios = 0;
			
			if($model->getNome() != ""){
				$query = $query." p.nome like ?";
				$criterios++;
			}
			if($model->getPreco() != ""){
				if($criterios>0){
					$query = $query ." AND ";
				}
				$query = $query." p.preco = ?";
				$criterios++;
			}
			if ($model->getCarro()->getModelo()->getMarca()->getId()!=null) {
				if($criterios>0){
					$query = $query ." AND ";
				}
				if ($model->getCarro()->getModelo()->getId()!=null) {
					$query = $query." mo.idtbModelo = ?";
				}else{
					$query = $query." ma.idtbMarca = ?";
				}
				$criterios++;
			}
			$query=$query." and p.status=".$tipo;
			$vet = null;
			$vetFoto=null;
			$pos=0;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			if($model->getNome() != ""){
				$pos++;
				$stmt->bindValue($pos,"%".$model->getNome()."%");
			}
			if($model->getPreco() != ""){
				$pos++;
				$stmt->bindValue($pos,$model->getPreco());
			}
			if ($model->getCarro()->getModelo()->getMarca()->getId()!=""){
				$pos++;
				if ($model->getCarro()->getModelo()->getId()!="") {
					$stmt->bindValue($pos,$model->getCarro()->getModelo()->getId());
				}else{
					$stmt->bindValue($pos,$model->getCarro()->getModelo()->getMarca()->getId());
				}
			}
			$stmt->execute();
			foreach($stmt as $row){
				if ($vet==null) {
					$model = new Peca();
					$model->setId($row["idtbPeca"]);
					$model->setNome($row["nome"]);
					$model->setDescricao($row["descricao"]);
					$model->setQuantidade($row["quantidade"]);
					$model->setPreco($row["preco"]);					
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
					$model->setCarro($modelCarro);
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
					$vet[] = $model;
				}else if($vet[count($vet)-1]->getId()!=$row["idtbPeca"]){
					$vetFoto=null;
					$model = new Peca();
					$model->setId($row["idtbPeca"]);
					$model->setNome($row["nome"]);
					$model->setDescricao($row["descricao"]);
					$model->setQuantidade($row["quantidade"]);
					$model->setPreco($row["preco"]);					
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
					$model->setCarro($modelCarro);
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
					$vet[] = $model;
				}else{
					$modelFoto=new Foto();
					$modelFoto->setId($row["idtbFoto"]);
					$modelFoto->setCaminho($row["caminho"]);
					$vetFoto[]=$modelFoto;
					$vet[count($vet)-1]->setFotos($vetFoto);
				}
			}
			
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function verificar($model){
		try{
			
			$query ="select * from tbpeca where nome=? and tbCarro_idtbCarro=?";
			$vet = null;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1,$model->getNome());
			$stmt->bindValue(2,$model->getCarro()->getId());
			$stmt->execute();
			foreach($stmt as $row){
					$model = new Peca();
					$model->setId($row["idtbPeca"]);
					$model->setNome($row["nome"]);
					$model->setDescricao($row["descricao"]);
					$model->setQuantidade($row["quantidade"]);
					$model->setPreco($row["preco"]);					
					$vet[]=$model;
			}
			
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function desativar ($id){
		try{
			$this->conectar();
			$excluido = $this->conexao->exec("update tbpeca set status=0 where idtbPeca=".$id);
			
			$this->desconectar();
			return $excluido;
		}catch(PDOException $ex){
			echo "Erro: ".$ex->getMessage();  
		}
	 }
	 public function ativar ($id){
		try{
			$this->conectar();
			$excluido = $this->conexao->exec("update tbpeca set status=1 where idtbPeca=".$id);
			
			$this->desconectar();
			return $excluido;
		}catch(PDOException $ex){
			echo "Erro: ".$ex->getMessage();  
		}
	 }
}
?>
