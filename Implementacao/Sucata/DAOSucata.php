<?php
	require_once '../Conexao/ControllerConexao.php';
	require_once 'Sucata.php';
	require_once '../Carro/Carro.php';
	require_once '../Modelo/Modelo.php';
	require_once '../Marca/Marca.php';
	require_once '../Categoria/Categoria.php';
	require_once '../Foto/Foto.php';
	
class DAOSucata{
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
			$stmt = $this->conexao->prepare("insert into tbsucata(lote,leilao,dataLeilao,localizacao,tbCarro_idtbCarro) values (?,?,?,?,?);");
			$stmt->bindValue(1,$model->getLote());
			$stmt->bindValue(2,$model->getLeilao());
			$stmt->bindValue(3,date("Y/m/d",strtotime(str_replace("/","-",$model->getDataLeilao()))));
			$stmt->bindValue(4,$model->getLocalizacao());
			$stmt->bindValue(5,$model->getCarro()->getId());
			$resu = $stmt->execute();
			$stmt = $this->conexao->query("SELECT LAST_INSERT_ID() as id");
			foreach ($stmt as $row){
				$model->setId($row["id"]);
			}
			if ($model->getCategorias()!=null) {
				foreach ($model->getCategorias() as $x) {
					$stmt = $this->conexao->prepare("insert into tbsucata_tbcategoria(tbsucata_idtbSucata,tbcategoria_idtbCategoria) values (?,?);");
					$stmt->bindValue(1,$model->getId());
					$stmt->bindValue(2,$x->getId());
					$resu = $stmt->execute();
				}
			}
			if ($model->getFotos()!=null) {
				foreach ($model->getFotos() as $foto) {
					$stmt = $this->conexao->prepare("insert into tbfoto(tbsucata_idtbSucata,caminho) values (?,?);");
					$stmt->bindValue(1,$model->getId());
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


	public function atualizar($model){
		try{
			$this->conectar();
			$stmt = $this->conexao->prepare("update tbsucata set lote=? ,leilao=?,dataLeilao=?,localizacao=?,tbcarro_idtbCarro=?  where idtbSucata=?");
			$stmt->bindValue(1,$model->getLote());
			$stmt->bindValue(2,$model->getLeilao());
			$stmt->bindValue(3,date("Y/m/d",strtotime(str_replace("/","-",$model->getDataLeilao()))));
			$stmt->bindValue(4,$model->getLocalizacao());
			$stmt->bindValue(5,$model->getCarro()->getId());
			$stmt->bindValue(6,$model->getId());
			$resultado = $stmt->execute();
			$this->conexao->exec("delete from tbsucata_tbcategoria where tbsucata_idtbSucata=".$model->getId());
			if ($model->getCategorias()!=null) {
				foreach ($model->getCategorias() as $categoria) {
					$stmt = $this->conexao->prepare("insert into tbsucata_tbcategoria(tbsucata_idtbSucata,tbcategoria_idtbCategoria) values (?,?);");
					$stmt->bindValue(1,$model->getId());
					$stmt->bindValue(2,$categoria->getId());
					$resu = $stmt->execute();
				}
			}
			if ($model->getFotos()!=null) {
				foreach ($model->getFotos() as $foto) {
					if ($foto->getAcao()=="1") {
						$stmt = $this->conexao->prepare("insert into tbfoto(tbsucata_idtbSucata,caminho) values (?,?);");
						$stmt->bindValue(1,$model->getId());
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
			$model = null;
			$vetCategoria=null;
			$vetFoto=null;
			$stmt = $this->conexao->query("select * from tbcarro cr inner join tbmodelo mo on (mo.idtbModelo=cr.tbmodelo_idtbModelo) inner join tbmarca ma on(ma.idtbMarca=mo.tbmarca_idtbMarca) inner join tbsucata s on(cr.idtbCarro=s.tbCarro_idtbCarro) left outer join tbfoto f on(s.idtbSucata=f.tbsucata_idtbSucata) left outer join tbsucata_tbcategoria sc on(s.idtbSucata=sc.tbsucata_idtbSucata) left outer join tbcategoria c on(c.idtbCategoria=sc.tbcategoria_idtbCategoria) where s.status=1 and s.idtbSucata=".$id." order by s.idtbSucata;");
			
			$model=null;
			foreach($stmt as $row){
				if ($model==null) {
					$model = new Sucata();
					$model->setId($row["idtbSucata"]);
					$model->setLote($row["lote"]);
					$model->setLeilao($row["leilao"]);
					$model->setDataLeilao(date("d/m/Y",strtotime(str_replace("-","/",$row["dataLeilao"]))));
					$model->setLocalizacao($row["localizacao"]);
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
					$modelCarro->setAno($row["ano"]);
					$modelCarro->setVersao($row["versao"]);
					$model->setCarro($modelCarro);
					if (isset($row["idtbCategoria"])) {
						$modelCategoria = new Categoria();
						$modelCategoria->setId($row["idtbCategoria"]);
						$modelCategoria->setNome($row["nome"]);
						$modelCategoria->setDescricao($row["descricao"]);
						$vetCategoria[]=$modelCategoria;
						$model->setCategorias($vetCategoria);
					}
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
				}else{
					if (isset($row["idtbCategoria"])) {
						$modelCategoria = new Categoria();
						$modelCategoria->setId($row["idtbCategoria"]);
						$modelCategoria->setNome($row["nome"]);
						$modelCategoria->setDescricao($row["descricao"]);
						$vetCategoria[]=$modelCategoria;
						$model->setCategorias($vetCategoria);
					}
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
				}
			}
			
			$this->desconectar();
			return $model;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function consultarPorCompra($compra){
		try{
			$this->conectar();
			$model = null;
			$vetCategoria=null;
			$vetFoto=null;
			$stmt = $this->conexao->query("select * from tbcarro cr inner join tbmodelo mo on (mo.idtbModelo=cr.tbmodelo_idtbModelo) inner join tbmarca ma on(ma.idtbMarca=mo.tbmarca_idtbMarca) inner join tbsucata s on(cr.idtbCarro=s.tbCarro_idtbCarro) left outer join tbfoto f on(s.idtbSucata=f.tbsucata_idtbSucata) left outer join tbsucata_tbcategoria sc on(s.idtbSucata=sc.tbsucata_idtbSucata) left outer join tbcategoria c on(c.idtbCategoria=sc.tbcategoria_idtbCategoria) where s.status=1 and s.tbcompra_idtbCompra=".$compra." order by s.idtbSucata;");			
			$model=null;
			foreach($stmt as $row){
				if ($model==null) {
					$model = new Sucata();
					$model->setId($row["idtbSucata"]);
					$model->setLote($row["lote"]);
					$model->setLeilao($row["leilao"]);
					$model->setDataLeilao($row["dataLeilao"]);
					$model->setLocalizacao($row["localizacao"]);
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
					$modelCarro->setAno($row["ano"]);
					$modelCarro->setVersao($row["versao"]);
					$model->setCarro($modelCarro);
					if (isset($row["idtbCategoria"])) {
						$modelCategoria = new Categoria();
						$modelCategoria->setId($row["idtbCategoria"]);
						$modelCategoria->setNome($row["nome"]);
						$modelCategoria->setDescricao($row["descricao"]);
						$vetCategoria[]=$modelCategoria;
						$model->setCategorias($vetCategoria);
					}
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
				}else{
					if (isset($row["idtbCategoria"])) {
						$categoria = new Categoria();
						$categoria->setId($row["idtbCategoria"]);
						$categoria->setNome($row["nome"]);
						$categoria->setDescricao($row["descricao"]);
						$vetCategoria[]=$categoria;
						$model->setCategorias($vetCategoria);
					}
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
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
			$vetCategoria=null;
			$vetFoto=null;
			$stmt = $this->conexao->query("select * from tbcarro cr inner join tbmodelo mo on (mo.idtbModelo=cr.tbmodelo_idtbModelo) inner join tbmarca ma on(ma.idtbMarca=mo.tbmarca_idtbMarca) inner join tbsucata s on(cr.idtbCarro=s.tbCarro_idtbCarro) left outer join tbfoto f on(s.idtbSucata=f.tbsucata_idtbSucata) left outer join tbsucata_tbcategoria sc on(s.idtbSucata=sc.tbsucata_idtbSucata) left outer join tbcategoria c on(c.idtbCategoria=sc.tbcategoria_idtbCategoria) where s.status=".$tipo." order by s.idtbSucata;");
			foreach($stmt as $row){
				if ($vet==null) {
					$model = new Sucata();
					$model->setId($row["idtbSucata"]);
					$model->setLote($row["lote"]);
					$model->setLeilao($row["leilao"]);
					$model->setDataLeilao($row["dataLeilao"]);
					$model->setLocalizacao($row["localizacao"]);
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
					$model->setCarro($modelCarro);
					if (isset($row["idtbCategoria"])) {
						$modelCategoria = new Categoria();
						$modelCategoria->setId($row["idtbCategoria"]);
						$modelCategoria->setNome($row["nome"]);
						$modelCategoria->setDescricao($row["descricao"]);
						$vetCategoria[]=$modelCategoria;
						$model->setCategorias($vetCategoria);
					}
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
					$vet[] = $model;
				}elseif ($vet[count($vet)-1]->getId()!=$row["idtbSucata"]) {
					$vetCategoria=null;
					$vetFoto=null;
					$model = new Sucata();
					$model->setId($row["idtbSucata"]);
					$model->setLote($row["lote"]);
					$model->setLeilao($row["leilao"]);
					$model->setDataLeilao($row["dataLeilao"]);
					$model->setLocalizacao($row["localizacao"]);
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
					$model->setCarro($modelCarro);
					if (isset($row["idtbCategoria"])) {
						$modelCategoria = new Categoria();
						$modelCategoria->setId($row["idtbCategoria"]);
						$modelCategoria->setNome($row["nome"]);
						$modelCategoria->setDescricao($row["descricao"]);
						$vetCategoria[]=$modelCategoria;
						$model->setCategorias($vetCategoria);
					}
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
					$vet[] = $model;
				}else{
					if (isset($row["idtbCategoria"])) {
						$modelCategoria = new Categoria();
						$modelCategoria->setId($row["idtbCategoria"]);
						$modelCategoria->setNome($row["nome"]);
						$modelCategoria->setDescricao($row["descricao"]);
						$vetCategoria[]=$modelCategoria;
						$vet[count($vet)-1]->setCategorias($vetCategoria);
					}
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$vet[count($vet)-1]->setFotos($vetFoto);
					}
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
			
			$query ="select * from tbcarro cr inner join tbmodelo mo on (mo.idtbModelo=cr.tbmodelo_idtbModelo) inner join tbmarca ma on(ma.idtbMarca=mo.tbmarca_idtbMarca) inner join tbsucata s on(cr.idtbCarro=s.tbCarro_idtbCarro) left outer join tbfoto f on(s.idtbSucata=f.tbsucata_idtbSucata)left  join tbsucata_tbcategoria sc on(s.idtbSucata=sc.tbsucata_idtbSucata)  left join tbcategoria c on(c.idtbCategoria=sc.tbcategoria_idtbCategoria) where ";
			$criterios = 0;
			if($model->getLeilao() != ""){
				$query = $query." s.leilao like ?";
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
			$query=$query." and s.status=".$tipo." order by s.idtbSucata;";
			$vet = null;
			$vetcs = null;
			$pos=0;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			if($model->getLeilao() != ""){
				$pos++;
				$stmt->bindValue($pos,"%".$model->getLeilao()."%");
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
					$model = new Sucata();
					$model->setId($row["idtbSucata"]);
					$model->setLote($row["lote"]);
					$model->setLeilao($row["leilao"]);
					$model->setDataLeilao($row["dataLeilao"]);
					$model->setLocalizacao($row["localizacao"]);
					$modelCarro = new Carro();
					$modelCarro->setVersao($row["versao"]);
					$modelCarro->setId($row["idtbCarro"]);
					$modelModelo= new Modelo();
					$modelMarca = new Marca();
					$modelMarca->setMarca($row["marca"]);
					$modelMarca->setId($row["idtbMarca"]);
					$modelModelo->setMarca($modelMarca);
					$modelModelo->setModelo($row["modelo"]);
					$modelModelo->setId($row["idtbModelo"]);
					$modelCarro->setModelo($modelModelo);
					$modelCarro->setAno($row["ano"]);
					$model->setCarro($modelCarro);
					if (isset($row["idtbCategoria"])) {
						$modelCategoria = new Categoria();
						$modelCategoria->setId($row["idtbCategoria"]);
						$modelCategoria->setNome($row["nome"]);
						$modelCategoria->setDescricao($row["descricao"]);
						$vetCategoria[]=$modelCategoria;
						$model->setCategorias($vetCategoria);
					}
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
					$vet[] = $model;
				}elseif ($vet[count($vet)-1]->getId()!=$row["idtbSucata"]) {
					$vetCategoria=null;
					$vetFoto=null;
					$model = new Sucata();
					$model->setId($row["idtbSucata"]);
					$model->setLote($row["lote"]);
					$model->setLeilao($row["leilao"]);
					$model->setDataLeilao($row["dataLeilao"]);
					$model->setLocalizacao($row["localizacao"]);
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
					$model->setCarro($modelCarro);
					if (isset($row["idtbCategoria"])) {
						$modelCategoria = new Categoria();
						$modelCategoria->setId($row["idtbCategoria"]);
						$modelCategoria->setNome($row["nome"]);
						$modelCategoria->setDescricao($row["descricao"]);
						$vetCategoria[]=$modelCategoria;
						$model->setCategorias($vetCategoria);
					}
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$model->setFotos($vetFoto);
					}
					$vet[] = $model;
				}else{
					if (isset($row["idtbCategoria"])) {
						$modelCategoria = new Categoria();
						$modelCategoria->setId($row["idtbCategoria"]);
						$modelCategoria->setNome($row["nome"]);
						$modelCategoria->setDescricao($row["descricao"]);
						$vetCategoria[]=$modelCategoria;
						$vet[count($vet)-1]->setCategorias($vetCategoria);
					}
					if (isset($row["idtbFoto"])) {
						$modelFoto=new Foto();
						$modelFoto->setId($row["idtbFoto"]);
						$modelFoto->setCaminho($row["caminho"]);
						$vetFoto[]=$modelFoto;
						$vet[count($vet)-1]->setFotos($vetFoto);
					}
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
			$query ="select * from tbsucata where lote=?";
			$vet = null;
			$this->conectar();
			$stmt = $this->conexao->prepare($query);
			$stmt->bindValue(1,$model->getLote());
			$stmt->execute();
			foreach($stmt as $row){
				$model = new Sucata();
				$model->setId($row["idtbSucata"]);
				$model->setLote($row["lote"]);
				$model->setLeilao($row["leilao"]);
				$model->setDataLeilao($row["dataLeilao"]);
				$model->setLocalizacao($row["localizacao"]);
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
			$excluido = $this->conexao->exec("update tbsucata set status=0 where idtbSucata=".$id);
			
			$this->desconectar();
			return $excluido;
		}catch(PDOException $ex){
			echo "Erro: ".$ex->getMessage();  
		}
	 }
	 public function ativar ($id){
		try{
			$this->conectar();
			$excluido = $this->conexao->exec("update tbsucata set status=1 where idtbSucata=".$id);
			
			$this->desconectar();
			return $excluido;
		}catch(PDOException $ex){
			echo "Erro: ".$ex->getMessage();  
		}
	 }
}
?>
