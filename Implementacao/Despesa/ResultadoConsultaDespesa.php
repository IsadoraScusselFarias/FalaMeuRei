
<div class="resultado" >
	<div class="tituloResultado">Itens Existentes</div>
	<div class="consulta">
		<table>
			<tr>
				<th>Codigo</th>
				<th>Nome</th>
				<th>Observação</th>
				<th>Valor</th>
				<th>Data</th>
				<th>Alterar</th>
			</tr>
			<?php
				foreach ($vet as $item) {
					echo "<tr>";
					echo "<td>".$item->getId()."</td>";
					echo "<td>".$item->getNome()."</td>";
					echo "<td>".$item->getObservacao()."</td>";
					echo "<td>".$item->getValor()."</td>";
					echo "<td>".$item->getData()."</td>";
					echo "<td><a href='ControllerDespesa.php?acao=editar&id=".$item->getId()."'><img src='../Image/editar.png' class='iconeEditar'/></a></td>";
					echo "</tr>";
				}
			?>
		</table>
</div>