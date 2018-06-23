<div class="centralIndex">
		<div >
			<a href="#">
			<img id="engrenagem" src="../Image/roda.png" alt="engrenagem">
			<img id="texto" src="../Image/auto.png" alt="autoPecas">
			<div class="letra">Fala, Meu Rei!</div>
			</a>
		</div>
		<hr>
		<div class="testeFonte">Tudo para seu carro.</div>
		<?php
			if (!isset($_SESSION['usuario'])) {
				echo '<div class="botoesLogin">
					<div class="bot"><a href="../Usuario/LoginUsuario.php">Entrar</a></div>
				</div>';
			}
		?>
</div>
