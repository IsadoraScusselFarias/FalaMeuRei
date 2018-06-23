<script type="text/javascript" src="../Html/tablesorter/jquery-latest.js"> </script>
<script type="text/javascript" src="../Html/tablesorter/jquery.tablesorter.js"></script>
<script>
	$(document).ready(function(){
		$("#tabelaRelatorio").tablesorter({ 
			sortList: [[0,0],[1,0]]
		});
		$("#detalhado").hide();
		$("#grafico").hide();
		$(".menu").click(function(){
			$("#padrao").hide();
			$("#detalhado").hide();
			$("#grafico").hide();
			if ($(this).val()=="padrao") {
				$("#padrao").show();
			}else{
				if ($(this).val()=="detalhado") {
					$("#detalhado").show();
				}else{
					$("#grafico").show();
				}
			}
		});
	});
</script>
<div class="resultado" >
	<div class="titulorelatorio"><?php
	switch ($model->getTipo()) {
		case 'compras':
			echo "Relatório de Compras";
			break;
		case 'vendas':
			echo "Relatório de Vendas";
			break;
		case 'despesas':
			echo "Relatório de Despesas";
			break;
		case 'fluxo':
			echo "Fluxo de caixa";
			break;
		
		default:
			break;
	}
	?></div>
	<div>
		<div class="relatorioCabecalho">
			<div class="quadrinhoR">
				<div class="titutoCabe">Período: </div>
				<div>Inicio: <?php echo $model->getDataInicial();?></div>
				<div>Final: <?php echo $model->getDataFinal();?></div>
			</div>
			<?php
				switch ($model->getTipo()) {
					case 'compras':
						echo '<div class="quadrinhoR">
								<div class="titutoCabe">Compras:</div>
								<div> Quantidade:'.$model->getQuantidadeCompras().'</div>
								<div> Valor Total:'.$model->getValorCompras().'</div>
							</div>';
						break;
					case 'vendas':
						echo '<div class="quadrinhoR">
								<div class="titutoCabe">Vendas:</div>								
								<div>Quantidade:'.$model->getQuantidadeVendas().'</div>
								<div>Valor Total:'.$model->getValorVendas().'</div>
							</div>';
						break;
					case 'despesas':
						echo '<div class="quadrinhoR">
								<div class="titutoCabe">Despesas:</div>
								<div> Quantidade:'.$model->getQuantidadeDespesas().'</div>
								<div> Valor Total:'.$model->getValorDespesas().'</div>
							</div>';
						break;
					case 'fluxo':
						echo '<div class="quadrinhoR">
								<div class="titutoCabe">Compras:</div>
								<div> Quantidade:'.$model->getQuantidadeCompras().'</div>
								<div> Valor Total:'.$model->getValorCompras().'</div>
							</div>
							<div class="quadrinhoR">
								<div class="titutoCabe">Despesas:</div>
								<div> Quantidade:'.$model->getQuantidadeDespesas().'</div>
								<div> Valor Total:'.$model->getValorDespesas().'</div>
							</div>
							<div class="quadrinhoR">
								<div class="titutoCabe">Vendas:</div>								
								<div>Quantidade:'.$model->getQuantidadeVendas().'</div>
								<div>Valor Total:'.$model->getValorVendas().'</div>
							</div>
							<div class="quadrinhoR">
								<div class="titutoCabe">Saldo final:</div>
								<div>Valor Total:'.$model->getValorTotal().'</div>
								<div>Final: '.$model->getStatus().'</div>
							</div>';
						break;
					default:
						break;
				}
			?>
	</div>
	<?php
		if ($model->getTipo()=="fluxo" or $model->getGrafico()!="") {
			echo "<div>";
			echo "<input type='radio' value='padrao' name='menu' checked class='menu'>padrao";
			if ($model->getTipo()=="fluxo") {
				echo "<input type='radio' value='detalhado' name='menu' class='menu'>detalhado";
			}
			if ($model->getGrafico()!="") {
				echo "<input type='radio' value='grafico' name='menu' class='menu'>grafico";
			}
			echo "</div>";
		}
		if ($model->getTipo()=="fluxo") {
			echo "<div class='centroRelatorio' id='padrao'>";
			echo "<table id='tabelaRelatorio'>";
			echo "<thead>";
			echo "<tr><th>Data</th><th>Tipo</th><th>Valor</th></tr>";
			echo "</thead>";
			echo "<tbody>";
			foreach ($model->getCompras() as $compra) {
				echo "<tr>";
				echo "<td>".$compra->getData()."</td>";
				echo "<td>Compra</td>";
				echo "<td>".$compra->getValor()."</td>";
				echo "</tr>";
			}
			foreach ($model->getDespesas() as $despesa) {
				echo "<tr>";
				echo "<td>".$despesa->getData()."</td>";
				echo "<td>Despesa</td>";
				echo "<td>".$despesa->getValor()."</td>";
				echo "</tr>";
			}
			foreach ($model->getVendas() as $venda) {
				echo "<tr>";
				echo "<td>".$venda->getDataVenda()."</td>";
				echo "<td>Venda</td>";
				echo "<td>".$venda->getValor()."</td>";
				echo "</tr>";
			}
			echo "</	tbody>";
			echo "</table>";
			echo "</div>";
			echo "<div class='centroRelatorio' id='detalhado'>";
			echo "<table>";
			echo "<tr><th>Data</th><th>Valor</th></tr>";
			foreach ($model->getCompras() as $compra) {
				echo "<tr>";
				echo "<td>".$compra->getData()."</td>";
				echo "<td>".$compra->getValor()."</td>";
				echo "</tr>";
			}
			echo "</table>";
			echo "<table>";
			echo "<tr><th>Data</th><th>Valor</th></tr>";
			foreach ($model->getDespesas() as $despesa) {
				echo "<tr>";
				echo "<td>".$despesa->getData()."</td>";
				echo "<td>".$despesa->getValor()."</td>";
				echo "</tr>";
			}
			echo "</table>";
			echo "<table>";
			echo "<tr><th>Data</th><th>Valor</th></tr>";
			foreach ($model->getVendas() as $venda) {
				echo "<tr>";
				echo "<td>".$venda->getDataVenda()."</td>";
				echo "<td>".$venda->getValor()."</td>";
				echo "</tr>";
			}
			echo "</table>";
			echo "</div>";
		}else{
			echo "<div class='centroRelatorio' id='padrao'>";
			echo "<table>";
			echo "<tr><th>Data</th><th>Valor</th></tr>";
			if ($model->getCompras()!="") {
				foreach ($model->getCompras() as $compra) {
					echo "<tr>";
					echo "<td>".$compra->getData()."</td>";
					echo "<td>".$compra->getValor()."</td>";
					echo "</tr>";
				}
			}
			if ($model->getDespesas()!="") {
				foreach ($model->getDespesas() as $despesa) {
					echo "<tr>";
					echo "<td>".$despesa->getData()."</td>";
					echo "<td>".$despesa->getValor()."</td>";
					echo "</tr>";
				}
			}
			if ($model->getVendas()!="") {
				foreach ($model->getVendas() as $venda) {
					echo "<tr>";
					echo "<td>".$venda->getDataVenda()."</td>";
					echo "<td>".$venda->getValor()."</td>";
					echo "</tr>";
				}
			}
			echo "</table>";
			echo "</div>";
		}
		if ($model->getGrafico()!="") {
			echo "<div class='centroRelatorio' id='grafico'>";
			echo $model->getGrafico()->Stroke();	
			echo "</div>";
		}
	?>
	<div class="linhaBotao">
		<div class="embaixoBotoes">
		</div>
	</div>
</div>

