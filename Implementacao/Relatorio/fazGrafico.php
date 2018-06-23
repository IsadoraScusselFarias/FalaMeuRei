<?php
include_once "../Html/app.util/graph/jpgraph.php";
include_once "../Html/app.util/graph/jpgraph_bar.php";
$g= new Grafico();
class Grafico {
    public function __construct() {
        $d= array("vendas"=> array("01/01/2016"=>"0","02/01/2016"=> "0","03/01/2016"=> "0","04/01/2016"=> "0","05/01/2016"=> "0","06/01/2016"=> "0","07/01/2016"=> "0","08/01/2016"=> "0","09/01/2016"=> "0","10/01/2016"=> "0","11/01/2016"=> "0","12/01/2016"=> "0","13/01/2016"=> "0","14/01/2016"=> "0","15/01/2016"=> "0","16/01/2016"=> "0","17/01/2016"=> "10.00","18/01/2016"=> "0","19/01/2016"=> "0","20/01/2016"=> "0","21/01/2016"=> "0","22/01/2016"=> "0","23/01/2016"=> "0","24/01/2016"=> "0","25/01/2016"=> "0","26/01/2016"=> "0","27/01/2016"=> "0","28/01/2016"=> "0","29/01/2016"=> "0","30/01/2016"=> "0","31/01/2016"=> "0"));
        $r= array("01/01/2016","02/01/2016","03/01/2016","04/01/2016","05/01/2016","06/01/2016","07/01/2016","08/01/2016","09/01/2016","10/01/2016","11/01/2016","12/01/2016","13/01/2016","14/01/2016","15/01/2016","16/01/2016","17/01/2016","18/01/2016","19/01/2016","20/01/2016","21/01/2016","22/01/2016","23/01/2016","24/01/2016","25/01/2016","26/01/2016","27/01/2016","28/01/2016","29/01/2016","30/01/2016","31/01/2016");
        $c =  array('blue ');
        $this->fazGrafico($d,$r,$c);
    }
    public function fazGrafico($dadosGrafico,$rotulos,$color){
        var_dump($dadosGrafico);
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
        //$graph->Stroke();
    }       
}
?>