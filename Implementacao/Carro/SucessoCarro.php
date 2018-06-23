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
					<div class="meio"><div><?php echo $model->getModelo()->getMarca()->getMarca();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Modelo:</div></div>
					<div class="meio"><div><?php echo $model->getModelo()->getModelo();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Ano:</div></div>
					<div class="meio"><div><?php echo $model->getAno();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Versão:</div></div>
					<div class="meio"><div><?php echo $model->getVersao();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"></div>
					<div class="meio"></div>
				</div>
				<div class="linhaBotao">
					<div class="embaixoBotoes">
						<?php
							if (!$erro) {
								echo '<a href="ControllerCarro.php?acao=editar&id='.$model->getId().'"><div>Alterar</div></a>';
							}
						?>
						<a href="ControllerCarro.php?acao=abrirCadastro"><div>Cadastrar Novo</div></a>
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
