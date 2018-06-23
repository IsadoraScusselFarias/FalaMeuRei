<?php
class Cidade{
	private $id;
	private $cidade;
	private $estado;
	public function getId(){
		return $this->id;
	}
	public function setId($id){
		$this->id = $id;
	}	
	public function getCidade(){
		return $this->cidade;
	}
	public function setCidade($cidade){
		$this->cidade = $cidade;
	}
	public function getEstado(){
		return $this->estado;
	}
	public function setEstado($estado){
		$this->estado = $estado;
	}
}
?>
