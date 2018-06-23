<?php 
class Sucata{
	private $id;
	private $localizacao;
	private $lote;
	private $pecasRetiradas;
	private $leilao;
	private $dataLeilao;
	private $fotos;
	private $carro;
	private $categorias;
	public function getId(){
		return $this->id;	
	}
	public function setId($id){
		$this->id=$id;
	}
	public function getLocalizacao(){
		return $this->localizacao;
	}
	public function setLocalizacao($localizacao){
		$this->localizacao=$localizacao;
	}
	public function getLote(){
		return $this->lote;
	}
	public function setLote($lote){
		$this->lote=$lote;
	}
	public function getPecasRetiradas(){
		return $this->pecasRetiradas;
	}
	public function setPecasRetiradas($pecasRetiradas){
		$this->pecasRetiradas=$pecasRetiradas;
	}
	public function getLeilao(){
		return $this->leilao;
	}
	public function setLeilao($leilao){
		$this->leilao=$leilao;
	}
	public function getDataLeilao(){
		return $this->dataLeilao;
	}
	public function setDataLeilao($dataLeilao){
		$this->dataLeilao=$dataLeilao;
	}
	public function getFotos(){
		return $this->fotos;
	}
	public function setFotos($fotos){
		$this->fotos=$fotos;
	}
	public function getCarro(){
		return $this->carro;
	}
	public function setCarro($carro){
		$this->carro=$carro;
	}
	public function getCategorias(){
		return $this->categorias;
	}
	public function setCategorias($categorias){
		$this->categorias=$categorias;
	}
}
?>