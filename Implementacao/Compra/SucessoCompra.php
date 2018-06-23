<html>
<head>
	<?php
		include_once '../Html/head.html';
	?>
</head>
<body>
	<header>
		<?php
			include_once '../Html/titulo.html';
		?>	
	</header>
	<nav>
		<?php
			include_once '../Html/menu.html';
		?>
	</nav>	
	<section >
		<div class="quadro">
			<div class="tituloResultado"><?php echo $resposta;?></div>
			<div class="alinhaSucesso">
			<div class="linha">
				<div class="esquerdo">Data:</div>
				<div class="meio"><div><?php echo $model->getData();?></div></div>
			</div>
			<div class="linha">
				<div class="esquerdo">Valor:</div>
				<div class="meio"><div><?php echo $model->getValor();?></div></div>
			</div>
			<div class="linha">
				<div class="esquerdo">Descricao:</div>
				<div class="meio"><div><?php echo $model->getDescricao();?></div></div>
			</div>
			<?php
				if(($model->getItemCompra()!=null)or($model->getSucata()!=null)){
				echo'
					<div class="linha">
					<div class="esquerdo">Itens:</div>
				</div>
				';
				}
			?>
			
			
			<div class="linha">
				<div >
					<?php
						if ($model->getItemCompra()!=null) {
							echo"<div class='legenda'>Peças</div>";
							echo"<table class='itemCompraTabela'>";
							echo'<th>Peça</th><th>Quantidade</th><th>Valor do Item</th>';
							foreach ($model->getItemCompra() as $itemCompra) {
								echo '<tr><td>'.$itemCompra->getPeca()->getNome().'</td>';
								echo '<td>'.$itemCompra->getQuantidade().'</td>';
								echo '<td>'.$itemCompra->getValorTotal().'</td></tr>';
							}
							echo'</table>';
						}
						if ($model->getSucata()!=null) {
							echo"<div class='itemCompraTabela'>";
							echo"<div class='legenda'>Sucatas</div>";
							echo "<div class='linha'><div class='esquerdo'>Carro:</div><div class='meio'> ".$model->getSucata()->getCarro()->getModelo()->getModelo()." ".$model->getSucata()->getCarro()->getVersao()."/".$model->getSucata()->getCarro()->getAno()."/".$model->getSucata()->getCarro()->getModelo()->getMarca()->getMarca()."</div></div>";
							echo "<div class='linha'><div class='esquerdo'>Lote:</div><div class='meio'> ".$model->getSucata()->getLote()."</div></div>";
							echo "<div class='linha'><div class='esquerdo'>Leilão:</div><div class='meio'> ".$model->getSucata()->getLeilao()."</div></div>";
							echo "<div class='linha'><div class='esquerdo'>Data do Leilão:</div><div class='meio'> ".$model->getSucata()->getDataLeilao()."</div></div>";
							echo "<div class='linha'><div class='esquerdo'>Localização:</div><div class='meio'> ".$model->getSucata()->getLocalizacao()."</div></div>";
							echo"<div class='linha'><div class='esquerdo'>Categoria:</div><div class='meio'>";
							if ($model->getSucata()->getCategorias()!=null) {
								echo"<ul>";
								foreach ($model->getSucata()->getCategorias() as $cat) {
									echo "<li>".$cat->getNome()."</li>";
								}
								echo"</ul>";
							}else{
								echo "Não há categorias cadastradas.";
							}
							echo"</div></div>";
							echo"<div class='linha'><div class='esquerdo'>Fotos:</div><div class='meio'>";
							if ($model->getSucata()->getFotos()!=null) {
								foreach ($model->getSucata()->getFotos() as $foto) {
									echo "<img src='".$foto->getCaminho()."''>";
								}
							}else{
								echo "Nenhuma há fotos cadastradas.";
							}
							echo"</div></div>";
							echo'</div>';
						}
					?>
					
				</div>
			</div>
			<div class="linhaBotao">
				<div class="embaixoBotoes">
					<?php
						if (!$erro) {
							echo '<a href="ControllerCompra.php?acao=editar&id='.$model->getId().'"><div>Alterar</div></a>';
						}
					?>
					<a href="ControllerCompra.php?acao=abrirCadastro"><div>Cadastrar Nova</div></a>
				</div>
			</div>
		</div>	
	</div>
	</section>
	<footer>
		<?php
			include_once '../Html/rodape.html';
		?>
	</footer>
</body>
</html>
