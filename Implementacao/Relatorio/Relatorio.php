<?php
class Relatorio{
	private $tipo;
	private $periodo;
	private $valorTotal;
	private $status;
	private $dataInicial;
	private $dataFinal;
	private $compras;
	private $quantidadeCompras;
	private $valorCompras;
	private $despesas;
	private $quantidadeDespesas;
	private $valorDespesas;
	private $vendas;
	private $quantidadeVendas;
	private $valorVendas;
	private $grafico;
	public function getTipo(){
		return $this->tipo;
	}
	public function setTipo($tipo){
		$this->tipo=$tipo;
	}
	public function getPeriodo(){
		return $this->periodo;
	}
	public function setPeriodo($periodo){
		$this->periodo=$periodo;
	}
	public function getValorTotal(){
		return $this->valorTotal;
	}
	public function setValorTotal($valorTotal){
		$this->valorTotal=$valorTotal;
	}
	public function getStatus(){
		return $this->status;
	}
	public function setStatus($status){
		$this->status=$status;
	}
	public function getDataInicial(){
		return $this->dataInicial;
	}
	public function setDataInicial($dataInicial){
		$this->dataInicial=$dataInicial;
	}
	public function getDataFinal(){
		return $this->dataFinal;
	}
	public function setDataFinal($dataFinal){
		$this->dataFinal=$dataFinal;
	}
	public function getCompras(){
		return $this->compras;
	}
	public function setCompras($compras){
		$this->compras=$compras;
	}
	public function getQuantidadeCompras(){
		return $this->quantidadeCompras;
	}
	public function setQuantidadeCompras($quantidadeCompras){
		$this->quantidadeCompras=$quantidadeCompras;
	}
	public function getValorCompras(){
		return $this->valorCompras;
	}
	public function setValorCompras($valorCompras){
		$this->valorCompras=$valorCompras;
	}
	public function getDespesas(){
		return $this->despesas;
	}
	public function setDespesas($despesas){
		$this->despesas=$despesas;
	}
	public function getQuantidadeDespesas(){
		return $this->quantidadeDespesas;
	}
	public function setQuantidadeDespesas($quantidadeDespesas){
		$this->quantidadeDespesas=$quantidadeDespesas;
	}
	public function getValorDespesas(){
		return $this->valorDespesas;
	}
	public function setValorDespesas($valorDespesas){
		$this->valorDespesas=$valorDespesas;
	}
	public function getVendas(){
		return $this->vendas;
	}
	public function setVendas($vendas){
		$this->vendas=$vendas;
	}
	public function getQuantidadeVendas(){
		return $this->quantidadeVendas;
	}
	public function setQuantidadeVendas($quantidadeVendas){
		$this->quantidadeVendas=$quantidadeVendas;
	}
	public function getValorVendas(){
		return $this->valorVendas;
	}
	public function setValorVendas($valorVendas){
		$this->valorVendas=$valorVendas;
	}
	public function getGrafico(){
		return $this->grafico;
	}
	public function setGrafico($grafico){
		$this->grafico=$grafico;
	}
}
?>