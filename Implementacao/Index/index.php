<html>
<head>
	<?php
   include_once'../Html/head.html';
   ?>
</head>
<body id="indexColor">
	<header>
		<?php
			include_once '../Html/titulo.html';
		?>	
	</header>
	<nav>
		<?php
			if (isset($_SESSION['usuario'])) {
	        	include_once '../Html/menu.html';
    		}
      	?>
	</nav>	
	<section >
		<p>&nbsp;</p>
		<div class="alinha">
		<?php
			include_once '../Html/conteudo.php';
		?>	
		</div>
		<p>&nbsp;</p>
	</section>
	<footer>
		<?php
			include_once '../Html/rodape.html';
		?>
	</footer>
</body>
</html>
