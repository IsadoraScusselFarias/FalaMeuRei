<?php 
class Marca{
	private $id;
	private $marca;
	public function getId(){
		return $this->id;	
	}
	public function setId($id){
		$this->id=$id;
	}
	public function getMarca(){
		return $this->marca;
	}
	public function setMarca($marca){
		$this->marca=$marca;
	}
}
?>