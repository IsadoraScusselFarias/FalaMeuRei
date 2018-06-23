<?php
require_once '../Conexao/ControllerConexao.php';
require_once 'Estado.php';

class DAOEstado{
	private $conexao;	
	private function conectar(){
		$ccon=new ControllerConexao();
		$this->conexao=$ccon->abreConexao();
	}
	private function desconectar(){
		$this->conexao=null;
	}
	public function consultar(){
		try{
			$this->conectar();
			$vet = null;
			$stmt = $this->conexao->query("select * from tbestado");
			foreach ($stmt as $row) {
				$model = new Estado;
				$model->setId($row["idtbEstado"]);
				$model->setEstado($row["estado"]);
				$model->setUf($row["uf"]);
				$vet[] = $model;
			}
			$this->desconectar();
			return $vet;
		}catch(PDOException $ex){
			echo ("Erro".$ex->getMessage());
		}
	}
}
?>
