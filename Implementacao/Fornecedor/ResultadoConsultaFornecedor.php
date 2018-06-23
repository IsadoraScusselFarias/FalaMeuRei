<div class="resultado" >
	<div class="tituloResultado">Itens Encontrados:</div>
	<div class="consulta">
		<table>
		<tr>
			<th>Codigo</th>
			<th>Pessoa</th>
			<th>CNPJ</th>
			<th>Estado</th>
			<th>Cidade</th>
			<th>Endereço</th>
			<th>Telefone</th>
			<th>Alterar</th>
		</tr>
		<?php 
			foreach ($vet as $item) {
				echo "<tr>";
				echo "<td>".$item->getId()."</td>";
				echo "<td class='email'> ".$item->getNome()."<span class='email1'><br>".$item->getEmail()."</span></td>";
				echo "<td>".$item->getCnpj()."</td>";
				echo "<td>".$item->getCidade()->getEstado()->getEstado()."</td>";
				echo "<td>".$item->getCidade()->getCidade()."</td>";
				echo "<td>".$item->getEndereco()."</td>";
				echo "<td>".$item->getTelefone()."</td>";
				echo "<td><a href='ControllerFornecedor.php?acao=editar&id=".$item->getId()."'><img src='../Image/editar.png' class='iconeEditar'/></a></td>";
				echo "</tr>";
			}
		?>
	</table>
</fieldset>
