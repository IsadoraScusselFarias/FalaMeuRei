<?php 
class Compra{
	private $id;
	private $data;
	private $valor;
	private $descricao;
	private $itemCompra;
	private $sucata;
	private $fornecedor;
	public function getId(){
		return $this->id;	
	}
	public function setId($id){
		$this->id=$id;
	}
	public function getData(){
		return $this->data;
	}
	public function setData($data){
		$this->data=$data;
	}
	public function getValor(){
		return $this->valor;
	}
	public function setvalor($valor){
		$this->valor=$valor;
	}
	public function getDescricao(){
		return $this->descricao;
	}
	public function setDescricao($descricao){
		$this->descricao=$descricao;
	}
	public function getItemCompra(){
		return $this->itemCompra;
	}
	public function setItemCompra($itemCompra){
		$this->itemCompra=$itemCompra;
	}
	public function getSucata(){
		return $this->sucata;
	}
	public function setSucata($sucata){
		$this->sucata=$sucata;
	}
	public function getFornecedor(){
		return $this->fornecedor;
	}
	public function setFornecedor($fornecedor){
		$this->fornecedor=$fornecedor;
	}
}
?>