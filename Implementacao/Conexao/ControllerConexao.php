<?php 
class ControllerConexao
{
	private $con=null;
	private $dbType="mysql";
	private $host = "localhost";
	private $user = "root";
	private $senha = "";
	private $db = "autopecas";
	public function abreConexao()	{
		try{
			$this->con=new PDO($this->dbType.":host=".$this->host.";dbname=".$this->db,$this->user,$this->senha);
			return $this->con;
		}catch(PDOExcepion $ex){
			echo "Erro".$ex->getMessage();
		}
	}
}
?>
