<?php
class Estado{
	private $id;
	private $uf;
	private $estado;
	public function getId(){
		return $this->id;
	}
	public function setId($id){
		$this->id = $id;
	}	
	public function getUf(){
		return $this->uf;
	}
	public function setUf($uf){
		$this->uf = $uf;
	}
	public function getEstado(){
		return $this->estado;
	}
	public function setEstado($estado){
		$this->estado = $estado;
	}
}
?>
