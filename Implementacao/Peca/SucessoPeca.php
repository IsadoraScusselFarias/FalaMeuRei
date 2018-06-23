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
					<div class="esquerdo"><div>Descrição:</div></div>
					<div class="meio"><div><?php echo $model->getDescricao();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Quantidade:</div></div>
					<div class="meio"><div><?php echo $model->getQuantidade();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Preço:</div></div>
					<div class="meio"><div><?php echo $model->getPreco();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Fotos:</div></div>
					<div class="meio">
						<?php 
							if ($model->getFotos()!=null) {
								foreach ($model->getFotos() as $foto) {
									if ($foto->getAcao()!="0") {
										echo "<img src='".$foto->getCaminho()."''>";
									}
								}
							}else{
								echo "Nenhuma há fotos cadastradas.";
							}
						?>
					</div>
				</div>
				<div class="linhaBotao">
					<div class="embaixoBotoes">
						<?php
							if (!$erro) {
								echo '<a href="ControllerPeca.php?acao=editar&id='.$model->getId().'"><div class="botSucesso">Alterar</div></a>';
							}
						?>
						<a href="ControllerPeca.php?acao=abrirCadastro"><div class="botSucesso">Cadastrar Novo</div></a>
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
