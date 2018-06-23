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
	<section>
		<div class="quadro">
			<div class="tituloResultado"><?php echo $resposta;?></div>
			<div class="alinhaSucesso">
				<div class="linha">
					<div class="esquerdo"><div>Marca:</div></div>
					<div class="meio"><div><?php echo $model->getCarro()->getModelo()->getMarca()->getMarca();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Modelo:</div></div>
					<div class="meio"><div><?php echo $model->getCarro()->getModelo()->getModelo();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Ano:</div></div>
					<div class="meio"><div><?php echo $model->getCarro()->getAno();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Versão:</div></div>
					<div class="meio"><div><?php echo $model->getCarro()->getVersao();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Lote:</div></div>
					<div class="meio"><div><?php echo $model->getLote();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Leilão:</div></div>
					<div class="meio"><div><?php echo $model->getLeilao();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Data Leilão:</div></div>
					<div class="meio"><div><?php echo $model->getDataLeilao();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Localização:</div></div>
					<div class="meio"><div><?php echo $model->getLocalizacao();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Categorias:</div></div>
					<div class="meio"><div><?php 
						if ($model->getCategorias()!=null) {
							foreach ($model->getCategorias() as $cat) {
								echo "<li>".$cat->getNome()."</li>";
							}
							echo"</ul>";
						}else{
							echo "Não há categorias cadastradas.";
						}
					?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Fotos:</div></div>
					<div class="meio"><div><?php 
						if ($model->getFotos()!=null) {
							foreach ($model->getFotos() as $foto) {
								if ($foto->getAcao()!="0") {
									echo "<img src='".$foto->getCaminho()."''>";
								}
							}
						}else{
							echo "Nenhuma há fotos cadastradas.";
						}
					?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo">Peças Retiradas</div>
					<div class="meio">
						<?php		
							if ($model->getPecasRetiradas()!=null) {
								echo "<table>";
								echo "<tr><th>Quantidade</th><th>Peça</th></tr>";
								foreach ($model->getPecasRetiradas() as $pecaRetirada) {
									echo "<tr><td>".$pecaRetirada->getQuantidade()."</td><td>".$pecaRetirada->getNomePeca()."</td></tr>";
								}
								echo "</table>";
							}else{
								echo "Nenhuma peça retirada";
							}
						?>
					</div>
				</div>
				<div class="linhaBotao">
					<div class="embaixoBotoes">
						<?php
							if (!$erro) {
								echo '<a href="../Sucata/ControllerSucata.php?acao=editar&id='.$model->getId().'"><div>Alterar</div></a>';
							}
						?>
						<a href="../Sucata/ControllerSucata.php?acao=abrirCadastro"><div>Cadastrar Novo</div></a>
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
