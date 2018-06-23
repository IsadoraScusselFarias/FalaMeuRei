<?php
include_once "Relatorio.php";
include_once "DAORelatorio.php";
include_once "../Compra/DAOCompra.php";
include_once "../Despesa/DAODespesa.php";
include_once "../Orcamento/DAOOrcamento.php";
include_once "../Html/app.util/graph/jpgraph.php";
include_once "../Html/app.util/graph/jpgraph_bar.php";
$cr = new ControllerRelatorio();
class ControllerRelatorio{
	function __construct(){
		if(isset($_POST["acao"])){
			$acao = $_POST["acao"];
		}else{
			$acao = $_GET["acao"];
		}
		if (isset($acao)) {
			$this->processarAcao($acao);
		}
	}
	public function processarAcao($acao){
		session_start();
		if (isset($_SESSION['usuario'])) {
			if($acao=='abrirCadastro'){
				$this->abrirCadastro();
			}elseif($acao == "gerar"){
				$this->gerar($acao);
			}
		}else{
			include_once"../Usuario/LoginUsuario.php";
		}
	}
	private function abrirCadastro(){
		include_once"GerarRelatorio.php";
	}
	public function gerar(){
		$model = new Relatorio();
		$model->setTipo($_POST["tipoRelatorio"]);
		$model->setPeriodo($_POST["periodo"]);
		$dao= new DAORelatorio();
		$daoCompra= new DAOCompra();
		$daoOrcamento=new DAOOrcamento();
		$daoDespesa= new DAODespesa();
		switch ($model->getPeriodo()) {
			case '1':
				$model->setDataInicial($_POST["dia"]);
				$model->setDataFinal($_POST["dia"]);
				break;
			case '2':
				$model->setDataInicial(date("d/m/Y",strtotime(str_replace("/","-","01/".$_POST["mes"]."/".$_POST["ano"]))));
				$data=date("d/m/Y",strtotime(str_replace("/","-","01/".($_POST["mes"]+1)."/".$_POST["ano"])));
				$model->setDataFinal(date("d/m/Y",strtotime(str_replace("/","-", $data)."-1 days")));
				break;
			case '3':
				$model->setDataInicial($_POST["dataInicial"]);
				$model->setDataFinal($_POST["dataFinal"]);
				break;
			
			default:
				break;
		}
		switch ($model->getTipo()) {
			case 'compras':
				$model->setCompras($daoCompra->consultarComFiltro("",$model->getDataInicial(),$model->getDataFinal()));
				$dao->consultarPorCompras($model);
				break;
			case 'vendas':
				$model->setVendas($daoOrcamento->consultarComFiltro("",$model->getDataInicial(),$model->getDataFinal()));
				$dao->consultarPorVendas($model);
				break;
			case 'despesas':
				$model->setDespesas($daoDespesa->consultarComFiltro("",$model->getDataInicial(),$model->getDataFinal()));
				$dao->consultarPorDespesas($model);
				break;
			case 'fluxo':
				$model->setVendas($daoOrcamento->consultarComFiltro("",$model->getDataInicial(),$model->getDataFinal()));
				$model->setCompras($daoCompra->consultarComFiltro("",$model->getDataInicial(),$model->getDataFinal()));
				$model->setDespesas($daoDespesa->consultarComFiltro("",$model->getDataInicial(),$model->getDataFinal()));
				$dao->consultarPorCompras($model);
				$dao->consultarPorVendas($model);
				$dao->consultarPorDespesas($model);
				$model->setValorTotal($model->getValorVendas()-($model->getValorCompras()+$model->getValorDespesas()));
				if ($model->getValorTotal()>0) {
					$model->setStatus("superavit");
				}else{
					$model->setStatus("deficit");
				}
				break;
			default:
				break;
		}
		if ($model->getPeriodo()!="1") {
			try{
				$dadosGrafico;
				$rotulos;
				switch ($model->getTipo()) {
					case 'compras':
						$titulo="Compras";
						for ($data=$model->getDataInicial(); strtotime(str_replace("/","-", $model->getDataFinal())) >= strtotime(str_replace("/","-", $data)) ; $data = date("d/m/Y",strtotime(str_replace("/","-", $data)."1 days"))) { 
							$rotulos[]=$data;
							$color  = array('red');
							$m= new Relatorio();
							$m->setDataInicial($data);
							$m->setDataFinal($data);
							$dao->consultarPorCompras($m);
							$dadosGrafico["compras"][$data]=$m->getValorCompras();
						}
						break;
					case 'vendas':
						$titulo="Vendas";
						for ($data=$model->getDataInicial(); strtotime(str_replace("/","-", $model->getDataFinal())) >= strtotime(str_replace("/","-", $data)) ; $data = date("d/m/Y",strtotime(str_replace("/","-", $data)."1 days"))) { 
							$rotulos[]=$data;
							$color  = array('black');
							$m= new Relatorio();
							$m->setDataInicial($data);
							$m->setDataFinal($data);
							$dao->consultarPorVendas($m);
							$dadosGrafico["vendas"][$data]=$m->getValorVendas();
						}					
						break;
					case 'despesas':
						$titulo="Despesas";
						for ($data=$model->getDataInicial(); strtotime(str_replace("/","-", $model->getDataFinal())) >= strtotime(str_replace("/","-", $data)) ; $data = date("d/m/Y",strtotime(str_replace("/","-", $data)."1 days"))) { 
							$rotulos[]=$data;
							$color  = array('gray');
							$m= new Relatorio();
							$m->setDataInicial($data);
							$m->setDataFinal($data);
							$dao->consultarPorDespesas($m);
							$dadosGrafico["despesas"][$data]=$m->getValorDespesas();
						}
						break;
					case 'fluxo':
						$titulo="Fluxo de Caixa";
						for ($data=$model->getDataInicial(); strtotime(str_replace("/","-", $model->getDataFinal())) >= strtotime(str_replace("/","-", $data)) ; $data = date("d/m/Y",strtotime(str_replace("/","-", $data)."1 days"))) { 
							$rotulos[]=$data;
							$color  = array('red','black','gray');
							$m= new Relatorio();
							$m->setDataInicial($data);
							$m->setDataFinal($data);
							$dao->consultarPorCompras($m);
							$dao->consultarPorVendas($m);
							$dao->consultarPorDespesas($m);
							$dadosGrafico["compras"][$data]=$m->getValorCompras();
							$dadosGrafico["vendas"][$data]=$m->getValorVendas();
							$dadosGrafico["despesas"][$data]=$m->getValorDespesas();
						}
						break;
					default:
						break;
				}
				$graph = new Graph(1000,1000);
				$graph->SetScale("textlin");
				$graph->SetShadow();
				$graph->SetMargin(70,20,40,40);
				$graph->title->Set("Grafico do Relatótio de Vendas");
				$graph->xaxis->title->Set('Data');
				$graph->yaxis->title->Set('Valor (R$)');
				$graph->yaxis->SetTitleMargin(55);
				$graph->xaxis->SetTickLabels($rotulos);
				$graph->yaxis->scale->SetGrace(40);
				$barplots = array();
				$i = 0;
				foreach ($dadosGrafico as $coluna => $dados){
					$plotdata = array();
					foreach ($rotulos as $data) {
						$plotdata[] = $dados[$data];
					}               
					$barplot = new BarPlot($plotdata);
					$barplot->SetFillColor($color[$i]);
					$barplot->value->Show(); 
					$barplot->SetLegend($coluna);
					$barplot->SetShadow();
					$barplots[] = $barplot;
					$i ++;
				}
				$grupobarplot = new GroupBarPlot($barplots);
				$grupobarplot->SetWidth(0.1);
				$graph->Add($grupobarplot);
				$model->setGrafico($graph);
			}catch (Exception $e){ 
				echo $e->getMessage();
			} 
		}
		include_once"ResultadoGerarRelatorio.php";
	}
}
?>


