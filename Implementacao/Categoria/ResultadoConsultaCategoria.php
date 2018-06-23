<div class="resultado" >
	<?php
		if ($tipo=="1") {
		 	$acao="<img src='../Image/excluir.png' class='iconeExcluir'/>";
		 	$titulo="Itens Existentes:";
		 	$coluna="Inativar";
		}else {
			$acao="<img src='../Image/update.png' class='iconeExcluir'/>";
		 	$titulo="Itens Excluidos:";
		 	$coluna="Restaurar";
		} 
	?>
	<div class="tituloResultado"><?php echo $titulo; ?></div>
	<div class="consulta">
		<?php
			if (isset($resposta)) {
				echo "<div class='sucessoAcao'>".$resposta."</div>";
			}
		?>
		<table>
			<tr>
				<th>Codigo</th>
				<th>Nome</th>
				<th>Descrição</th>
				<th>
					<?php
						echo $coluna;
					 ?>
					 </th>
					<th>Alterar</th>
				</tr>
			<?php 
				foreach ($vet as $item) {
					echo "<tr>";
					echo "<td>".$item->getId()."</td>";
					echo "<td>".$item->getNome()."</td>";
					echo "<td>".$item->getDescricao()."</td>";
					echo "<td> <a href=\"javascript:confirmarAlterarStatusCategoria('" . $item->getNome() . "', " . $item->getId() .",'" .$tipo."')\">".$acao."</a></td>";
					echo "<td><a href='ControllerCategoria.php?acao=editar&id=".$item->getId()."'><img src='../Image/editar.png' class='iconeEditar'/></a></td>";
					echo "</tr>";
				}
			?>
		</table>
	</div>
</div>
