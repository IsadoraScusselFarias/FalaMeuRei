<?php 
class Despesa{
	private $id;
	private $nome;
	private $observacao;
	private $valor;
	private $data;
	public function getId(){
		return $this->id;	
	}
	public function setId($id){
		$this->id=$id;
	}
	public function getNome(){
		return $this->nome;
	}
	public function setNome($nome){
		$this->nome=$nome;
	}
	public function getObservacao(){
		return $this->observacao;
	}
	public function setObservacao($observacao){
		$this->observacao=$observacao;
	}
	public function getValor(){
		return $this->valor;
	}
	public function setValor($valor){
		$this->valor=$valor;
	}
	public function getData(){
		return $this->data;
	}
	public function setData($data){
		$this->data=$data;
	}
}
?>