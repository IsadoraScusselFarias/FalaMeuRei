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
					<div class="esquerdo"><div>Nome:</div></div>
					<div class="meio"><div><?php echo $model->getNome();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Observação:</div></div>
					<div class="meio"><div><?php echo $model->getObservacao();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Valor:</div></div>
					<div class="meio"><div><?php echo $model->getValor();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Data:</div></div>
					<div class="meio"><div><?php echo $model->getData();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"></div>
					<div class="meio"></div>
				</div>
				<div class="linhaBotao">
					<div class="embaixoBotoes">
						<?php
							if (!$erro) {
								echo '<a href="../Despesa/ControllerDespesa.php?acao=editar&id='.$model->getId().'"><div>Alterar</div></a>';
							}
						?>
						<a href="../Despesa/CadastrarDespesa.php"><div>Cadastrar Novo</div></a>
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
