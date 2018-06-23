<?php 
class Fornecedor{
	private $id;
	private $cnpj;
	private $nome;
	private $endereco;
	private $telefone;
	private $email;
	private $cidade;
	public function getId(){
		return $this->id;	
	}
	public function setId($id){
		$this->id=$id;
	}
	public function getCnpj(){
		return $this->cnpj;
	}
	public function setCnpj($cnpj){
		$this->cnpj=$cnpj;
	}
	public function getNome(){
		return $this->nome;
	}
	public function setNome($nome){
		$this->nome=$nome;
	}
	public function getTelefone(){
		return $this->telefone;
	}
	public function setTelefone($telefone){
		$this->telefone=$telefone;
	}
	public function getEndereco(){
		return $this->endereco;
	}
	public function setEndereco($endereco){
		$this->endereco=$endereco;
	}
	public function getEmail(){
		return $this->email;
	}
	public function setEmail($email){
		$this->email=$email;
	}
	public function getCidade(){
		return $this->cidade;
	}
	public function setCidade($cidade){
		$this->cidade=$cidade;
	}
}
?>