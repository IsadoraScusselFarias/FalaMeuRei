<?php 
class Modelo{
	private $id;
	private $modelo;
	private $marca;
	public function getId(){
		return $this->id;	
	}
	public function setId($id){
		$this->id=$id;
	}
	public function getModelo(){
		return $this->modelo;	
	}
	public function setModelo($modelo){
		$this->modelo=$modelo;
	}
	public function getMarca(){
		return $this->marca;
	}
	public function setMarca($marca){
		$this->marca=$marca;
	}
}
?>