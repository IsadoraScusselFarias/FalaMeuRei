<div class="resultado" >
	<?php
		 $titulo="Itens Existentes:";
	?>
	<div class="tituloResultado"><?php echo $titulo; ?></div>
	<div class="consulta">
	<table>
		<tr>
			<th>Data do Orcamento</th>
			<th>Status</th>
			<th>Data Venda</th>
			<th>Valor</th>
			<th>Cliente</th>
			<th>Detalhar</th>
			<?php
				if ($model->getStatus()=="0") {
					echo "<th>Alterar</th>";
					echo "<th>Gerar Venda</th>";
				}	
			?>
		</tr>
		<?php 
			foreach ($vet as $item) {
				echo "<tr>";
				echo "<td>".$item->getDataOrcamento()."</td>";
				if ($item->getStatus()=="1") {
					echo "<td>Venda</td>";
					echo "<td>".$item->getDataVenda()."</td>";
				}else{
					echo "<td>Orcamento</td>";
					echo "<td>--</td>";
				}
				echo "<td> R$".($item->getValor()-$item->getDesconto())."</td>";
				echo "<td>".$item->getCliente()->getNomeCompleto()." - ".$item->getCliente()->getCpf().$item->getCliente()->getCnpj()."</td>";
				echo "<td><a href='ControllerOrcamento.php?acao=detalhar&id=".$item->getId()."'class='links'><img src='../Image/detalhar.png' class='iconeEditar'/></a></td>";
				if ($model->getStatus()=="0") {
					echo "<td><a href='ControllerOrcamento.php?acao=editar&id=".$item->getId()."'><img src='../Image/editar.png' class='iconeEditar'/></a></td>";
					echo "<td><a href='ControllerOrcamento.php?acao=vender&status=0&id=".$item->getId()."'><img src='../Image/money.jpg' class='iconeEditar'></a></td>";
				}
				echo "</tr>";
			}
		?>
	</table>
</div>
