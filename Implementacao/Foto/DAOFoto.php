<?php
	require_once '../Conexao/ControllerConexao.php';
	require_once 'Foto.php';	
class DAOFoto{
	private $conexao;
	
	private function conectar(){
		$ccon=new ControllerConexao();
		$this->conexao = $ccon->abreConexao();
	}
	
	private function desconectar(){
		$ccon=new ControllerConexao();
		$this->conexao = null;
	}
	public function consultarPorPeca($idtbPeca){
		try{
			$this->conectar();
			$vetFoto=null;
			$stmt = $this->conexao->query("select * from tbfoto where tbpeca_idtbPeca= ".$idtbPeca);
			foreach($stmt as $row){
				$foto=new Foto();
				$foto->setId($row["idtbFoto"]);
				$foto->setCaminho($row["caminho"]);
				$vetFoto[]=$foto;
			}
			
			$this->desconectar();
			return $vetFoto;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
	public function consultarPorSucata($idtbSucata){
		try{
			$this->conectar();
			$vetFoto=null;
			$stmt = $this->conexao->query("select * from tbfoto where tbsucata_idtbSucata= ".$idtbSucata);
			foreach($stmt as $row){
				$foto=new Foto();
				$foto->setId($row["idtbFoto"]);
				$foto->setCaminho($row["caminho"]);
				$vetFoto[]=$foto;
			}
			
			$this->desconectar();
			return $vetFoto;
		}catch(PDOException $ex){
			echo ("Erro: " . $ex->getMessage());
		}
	}
}
?>
