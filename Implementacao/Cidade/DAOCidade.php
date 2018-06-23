<?php
require_once '../Conexao/ControllerConexao.php';
require_once 'Cidade.php';
require_once '../Estado/Estado.php';

class DAOCidade{
	private $conexao;	
	private function conectar(){
		$ccon=new ControllerConexao();
		$this->conexao=$ccon->abreConexao();
	}
	private function desconectar(){
		$this->conexao=null;
	}
	public function consultar($estado){
		try{
			$this->conectar();
			$vet = null;
			$stmt = $this->conexao->query("select * from tbcidade where tbestado_idtbEstado=".$estado);
			foreach ($stmt as $row) {
				$model = new Cidade;
				$model->setId($row["idtbCidade"]);
				$model->setCidade($row["cidade"]);
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
			$model = null;
			$stmt = $this->conexao->query("select * from tbcidade c inner join tbestado e on (c.tbestado_idtbEstado=e.idtbEstado) where idtbCidade=".$id);
			foreach ($stmt as $row) {
				$model = new Cidade;
				$model->setId($row["idtbCidade"]);
				$model->setCidade($row["cidade"]);
				$modele = new Estado();
				$modele->setId($row["idtbEstado"]);
				$modele->setEstado($row["estado"]);
				$model->setEstado($modele);
			}
			$this->desconectar();
			return $model;
		}catch(PDOException $ex){
			echo ("Erro".$ex->getMessage());
		}
	}
}
?>
