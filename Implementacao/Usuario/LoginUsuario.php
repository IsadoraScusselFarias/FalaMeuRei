<html>
<head>
	<?php
		include_once '../Html/head.html';
	?>
	<style>
		.esquerdo{
			font-family: Montserrat, sans-serif;
    		font-size: 0.8em;
		}
		.legenda{
			font-family: Montserrat, sans-serif;
    		font-size: 0.8em;
		}
	</style>
	 <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <title>Fullscreen Background Image Slideshow with CSS3</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <meta name="description" content="Fullscreen Background Image Slideshow with CSS3 - A Css-only fullscreen background image slideshow" />
    <meta name="keywords" content="css3, css-only, fullscreen, background, slideshow, images, content" />
    <meta name="author" content="Codrops" />
    <link rel="shortcut icon" href="../favicon.ico"> 
    <link rel="stylesheet" type="text/css" href="css/demo.css" />
    <link rel="stylesheet" type="text/css" href="css/style1.css" />
	<script type="text/javascript" src="js/modernizr.custom.86080.js"></script>
</head>
<body id="page">
	 <ul class="cb-slideshow">
        <li><span>Image 01</span><div></div></li>
        <li><span>Image 02</span><div></div></li>
        <li><span>Image 03</span><div></div></li>
        <li><span>Image 04</span><div></div></li>
        <li><span>Image 05</span><div></div></li>
        <li><span>Image 06</span><div></div></li>
    </ul>
      <div class="container">
			<header>
				<?php
					include_once '../Html/titulo.html';
				?>	
			</header>
			<div id="menu" >
			</div>	
			<div id="conteudo" >
				<?php
					include_once 'FormLoginUsuario.php';
				?>
			</div>
		</div>
	<div id="rodape">
		<?php
			include_once '../Html/rodape.html';
		?>
	</div>
</body>
</html>
