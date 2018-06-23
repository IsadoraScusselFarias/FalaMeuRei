<?php 
class ItemVendaSucata{
	private $id;
	private $valorTotal;
	private $nomePeca;
	private $sucata;
	private $quantidade;
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
	public function getNomePeca(){
		return $this->nomePeca;
	}
	public function setNomePeca($nomePeca){
		$this->nomePeca=$nomePeca;
	}
	public function getSucata(){
		return $this->sucata;
	}
	public function setSucata($sucata){
		$this->sucata=$sucata;
	}
	public function getQuantidade(){
		return $this->quantidade;
	}
	public function setQuantidade($quantidade){
		$this->quantidade=$quantidade;
	}
}
?>