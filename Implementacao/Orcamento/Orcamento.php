	<?php 
class Orcamento{
	private $id;
	private $valor;
	private $desconto;
	private $dataOrcamento;
	private $dataVenda;
	private $status;
	private $itemVendaPeca;
	private $itemVendaSucata;
	private $cliente;
	private $vendaAprovada;
	public function getId(){
		return $this->id;	
	}
	public function setId($id){
		$this->id=$id;
	}
	public function getValor(){
		return $this->valor;
	}
	public function setValor($valor){
		$this->valor=$valor;
	}
	public function getDesconto(){
		return $this->desconto;
	}
	public function setDesconto($desconto){
		$this->desconto=$desconto;
	}
	public function getDataOrcamento(){
		return $this->dataOrcamento;
	}
	public function setDataOrcamento($dataOrcamento){
		$this->dataOrcamento=$dataOrcamento;
	}
	public function getDataVenda(){
		return $this->dataVenda;
	}
	public function setDataVenda($dataVenda){
		$this->dataVenda=$dataVenda;
	}
	public function getStatus(){
		return $this->status;
	}
	public function setStatus($status){
		$this->status=$status;
	}
	public function getItemVendaPeca(){
		return $this->itemVendaPeca;
	}
	public function setItemVendaPeca($itemVendaPeca){
		$this->itemVendaPeca=$itemVendaPeca;
	}
	public function getItemVendaSucata(){
		return $this->itemVendaSucata;
	}
	public function setItemVendaSucata($itemVendaSucata){
		$this->itemVendaSucata=$itemVendaSucata;
	}
	public function getCliente(){
		return $this->cliente;
	}
	public function setCliente($cliente){
		$this->cliente=$cliente;
	}
	public function getVendaAprovada(){
		return $this->vendaAprovada;
	}
	public function setVendaAprovada($vendaAprovada){
		$this->vendaAprovada=$vendaAprovada;
	}
}
?>