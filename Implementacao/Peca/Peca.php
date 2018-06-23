<?php 
class Peca{
	private $id;
	private $nome;
	private $descricao;
	private $quantidade;
	private $preco;
	private $carro;
	private $fotos;
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
	public function getDescricao(){
		return $this->descricao;
	}
	public function setDescricao($descricao){
		$this->descricao=$descricao;
	}
	public function getQuantidade(){
		return $this->quantidade;
	}
	public function setQuantidade($quantidade){
		$this->quantidade=$quantidade;
	}
	public function getPreco(){
		return $this->preco;
	}
	public function setPreco($preco){
		$this->preco=$preco;
	}
	public function getCarro(){
		return $this->carro;
	}
	public function setCarro($carro){
		$this->carro=$carro;
	}
	public function getFotos(){
		return $this->fotos;
	}
	public function setFotos($fotos){
		$this->fotos=$fotos;
	}
}
?>