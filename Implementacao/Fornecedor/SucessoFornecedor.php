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
	<section class="tudo">
		<div class="quadro">
			<div class="tituloResultado"><?php echo $resposta;?></div>
			<div class="alinhaSucesso">
				<div class="linha">
					<div class="esquerdo"><div>Nome:</div></div>
					<div class="meio"><div><?php echo $model->getNome();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Email:</div></div>
					<div class="meio"><div><?php echo $model->getEmail();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Telefone:</div></div>
					<div class="meio"><div><?php echo $model->getTelefone();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Endereço:</div></div>
					<div class="meio"><div><?php echo $model->getEndereco();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Documento:</div></div>
					<div class="meio"><div><?php echo $model->getCnpj();?></div></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><div>Cidade:</div></div>
					<div class="meio"><div><?php echo $model->getCidade()->getCidade()."	- ".$model->getCidade()->getEstado()->getEstado();?></div></div>
				</div>
				<div class="linhaBotao">
					<div class="embaixoBotoes">
						<?php
							if (!$erro) {
							 	echo '<a href="ControllerFornecedor.php?acao=editar&id='.$model->getId().'"><div class="botSucesso">Alterar</div></a>';
							 } 
						?>
						<a href="ControllerFornecedor.php?acao=abrirCadastro"><div class="botSucesso">Cadastrar Novo</div></a>
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
