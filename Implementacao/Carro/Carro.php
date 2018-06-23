<?php 
class Carro{
	private $id;
	private $modelo;
	private $ano;
	private $versao;
	
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
	public function getAno(){
		return $this->ano;
	}
	public function setAno($ano){
		$this->ano=$ano;
	}
	public function getVersao(){
		return $this->versao;
	}
	public function setVersao($versao){
		$this->versao=$versao;
	}
}
?>