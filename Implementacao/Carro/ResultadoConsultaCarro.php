
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
				<th>Código</th>
				<th>Modelo</th>
				<th>Marca</th>
				<th>Ano</th>
				<th>Versão</th>
				<th>
				<?php
					echo $coluna;
				 ?>
				 </th>
				<th>Alterar</th>
			</tr>
			<?php
				foreach($vet as $item){
					echo "<tr>";
					echo "<td>".$item->getId() . "</td>";
					echo "<td>".$item->getModelo()->getModelo()."</a></td>";
					echo "<td>".$item->getModelo()->getMarca()->getMarca() . "</td>";
					echo "<td>".$item->getAno() . "</td>";
					echo "<td>".$item->getVersao() . "</td>";
					echo "<td> <a href=\"javascript:confirmarAlterarStatusCarro('". $item->getModelo()->getModelo() . "', ".$item->getId()."," .$tipo.")\">".$acao."</a></td>";
					echo "<td><a href='ControllerCarro.php?acao=editar&id=".$item->getId()."'><img src='../Image/editar.png' class='iconeEditar'/></a></td>";
					echo "</tr>";
				}
			?>
		</table>
	</div>
</div>

