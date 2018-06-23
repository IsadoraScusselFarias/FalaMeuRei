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
					<div class="esquerdo"><div>Email:</div></div>
					<div class="meio"><div><?php echo $model->getEmail();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Tipo:</div></div>
					<div class="meio"><div>
					<?php 
						if ($model->getTipo()=="1") {
							echo "Administrador";
						}else{
							echo "Funcionario";
						}
					?></div></div>
				</div>
				<div class="linhaBotao">
					<div class="embaixoBotoes">
						<?php
							if (!$erro) {
								echo '<a href="../Usuario/ControllerUsuario.php?acao=abrirAlterarConta"><div>Alterar</div></a>';
							}
						?>
						<a href="../Usuario/ControllerUsuario.php?acao=abrirCadastro"><div>Cadastrar Novo</div></a>
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
