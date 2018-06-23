
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
			<th>Fotos</th>
			<th>Sucata</th>
			<th>Categorias</th>
			<th>
			<?php
				echo $coluna;
			 ?>
			 </th>
			<th>Alterar</th>
			<th>Detalhar</th>
		</tr>
		<?php
			foreach($vet as $item){
				echo "<tr>";
				echo "<td>"; 
				
				if ($item->getFotos()!=null) {
					foreach ($item->getFotos() as $foto) {
						echo "<img src='".$foto->getCaminho()."''>";
					}
				}else{
					echo "Nenhuma há fotos cadastradas.";
				}
				
				echo "</td>";
				echo  "</td>";
				echo "<td>".$item->getCarro()->getModelo()->getModelo()." ".$item->getCarro()->getVersao()."/".$item->getCarro()->getAno()."/".$item->getCarro()->getModelo()->getMarca()->getMarca()."</td>";	
				echo "<td>"; 
				if ($item->getCategorias()!=null) {
					echo "<ul>";
					foreach ($item->getCategorias() as $cat) {
						echo "<li>".$cat->getNome()."</li>";
					}
					echo"</ul>";
				}else{
					echo "Não há categorias cadastradas.";
				}
				echo  "</td>";		
				echo "<td> <a href=\"javascript:confirmarAlterarStatusSucata('" . $item->getLote() . "', " . $item->getId() .",'" .$tipo."')\">".$acao."</a></td>";
				echo "<td><a href='ControllerSucata.php?acao=editar&id=".$item->getId()."'><img src='../Image/editar.png' class='iconeEditar'/></a></td>";
				echo "<td><a href='ControllerSucata.php?acao=detalhar&id=".$item->getId()."'><img src='../Image/detalhar.png' class='iconeEditar'/></a></td>";
				echo "</tr>";

			}
		?>
		
	</table>
</div>
</div>

