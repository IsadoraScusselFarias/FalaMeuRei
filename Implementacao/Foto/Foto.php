<?php 
class Foto{
	private $id;
	private $caminho;
	private $acao;
	public function getId(){
		return $this->id;	
	}
	public function setId($id){
		$this->id=$id;
	}
	public function getCaminho(){
		return $this->caminho;
	}
	public function setCaminho($caminho){
		$this->caminho=$caminho;
	}
	public function getAcao(){
		return $this->acao;
	}
	public function setAcao($acao){
		$this->acao=$acao;
	}
}
?>