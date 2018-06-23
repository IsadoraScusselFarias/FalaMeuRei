<?php 
class ItemCompra{
	private $id;
	private $valorTotal;
	private $peca;
	private $quantidade;
	private $quantidadeParaPeca;
	public function getId(){
		return $this->id;	
	}
	public function setId($id){
		$this->id=$id;
	}
	public function getValorTotal(){
		return $this->valorTotal;
	}
	public function setValorTotal($valorTotal){
		$this->valorTotal=$valorTotal;
	}
	public function getPeca(){
		return $this->peca;
	}
	public function setPeca($peca){
		$this->peca=$peca;
	}
	public function getQuantidade(){
		return $this->quantidade;
	}
	public function setQuantidade($quantidade){
		$this->quantidade=$quantidade;
	}
	public function getQuantidadeParaPeca(){
		return $this->quantidadeParaPeca;
	}
	public function setQuantidadeParaPeca($quantidadeParaPeca){
		$this->quantidadeParaPeca=$quantidadeParaPeca;
	}
}
?>