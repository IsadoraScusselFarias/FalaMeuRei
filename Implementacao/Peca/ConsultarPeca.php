<html>
<head>
	<?php
		include_once '../Html/head.html';
	?>
	
</head>
<body>
	<header id="titulo">
		<?php
			include_once '../Html/titulo.html';
		?>		
	</header>
	<nav id="menu" >
		<?php
			include_once '../Html/menu.html';
		?>
	</nav>	
	<section id="conteudo" >
		<?php
			include_once 'FormConsultaPeca.php';
			if($tipoRes == "tabela"){
				include_once "ResultadoConsultaPeca.php";
			}else if($tipoRes == "mensagem"){
				echo '<div class="quadro">
					<div class="erroConsulta">Não foram encontrados resultados que atendam aos critérios de pesquisa.</div>
				</div>';
			}
		?>
	</section>
	<footer id="rodape">
		<?php
			include_once '../Html/rodape.html';
		?>
	</footer>
</body>
</html>
