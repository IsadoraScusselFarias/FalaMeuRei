<div class="resultado" >
	<div class="tituloResultado">Itens Encontrados:</div>
	<div class="consulta">
		<table>
		<tr>
			<th>Pessoa</th>
			<th>Documento</th>
			<th>Alterar</th>
			<th>Detalhar</th>
		</tr>
		<?php 
			foreach ($vet as $item) {
				echo "<tr>";
				echo "<td class='email'> ".$item->getNomeCompleto()."<span class='email1'><br>".$item->getEmail()."</span></td>";
				if($item->getCpf()!=null){
					echo "<td>".$item->getCpf()."</td>";
				}else{
					echo "<td>".$item->getCnpj()."</td>";
				}
				echo "<td><a href='ControllerCliente.php?acao=editar&id=".$item->getId()."'><img src='../Image/editar.png' class='iconeEditar'/></a></td>";
				echo "<td><a href='ControllerCliente.php?acao=detalhar&id=".$item->getId()."'><img src='../Image/detalhar.png' class='iconeEditar'/></a></td>";
				echo "</tr>";
			}
		?>
	</table>
</fieldset>
