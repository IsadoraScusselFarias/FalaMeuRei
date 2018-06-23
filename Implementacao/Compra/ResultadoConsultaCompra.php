<div class="resultado" >
	<?php
		 $titulo="Itens Existentes:";
	?>
	<div class="tituloResultado"><?php echo $titulo; ?></div>
	<div class="consulta">
		<table>
		<tr>
			<th>Codigo</th>
			<th>Data</th>
			<th>Valor</th>
			<th>Descrição</th>
			<th>Fornecedor</th>
			<th>Alterar</th>
			<th>Detalhar</th>
		</tr>
		<?php 
			foreach ($vet as $item) {
				echo "<tr>";
				echo "<td>".$item->getId()."</td>";
				echo "<td>".$item->getData()."</td>";
				echo "<td>".$item->getValor()."</td>";
				echo "<td>".$item->getDescricao()."</td>";
				echo "<td>".$item->getFornecedor()->getNome()." - ".$item->getFornecedor()->getCnpj()."</td>";
				echo "<td><a href='ControllerCompra.php?acao=editar&id=".$item->getId()."'><img src='../Image/editar.png' class='iconeEditar'/></a></td>";
				echo "<td><a href='ControllerCompra.php?acao=detalhar&id=".$item->getId()."' class='links'><img src='../Image/detalhar.png' class='iconeEditar'/></a></td>";
				echo "</tr>";
			}
		?>
	</table>
</div>
