<form action="ControllerCarro.php" method="POST">
<div class="quadrinhoClick clicaConsulta"><img src="../Image/lupa.png"/></div>
<fieldset class="quadroLateral consultarClick">
	<legend class="legenda">Consulta:</legend>
	<div><img src="../Image/sub.png" class="xis "/></div>
<div class="corpo">	
	<div class="linhaConsulta">
		<div class="esquerdoConsulta"><label for="idMarca">Marca:</label></div>
		<div class="meioConsulta">
			<select id="idMarca" name="idMarca">
			<?php 
				echo "<option value=''>--Selecione--</option>";
				if (isset($vetMarca)) {
					foreach ($vetMarca as $marca) {
						echo "<option value='".$marca->getId()."'";
						if ($model->getModelo()->getMarca()->getId()!="") {
							if ($model->getModelo()->getMarca()->getId()==$marca->getId()) {
								echo "selected";
							}
						}
						echo ">".$marca->getMarca()."</option>";
					}
				}
			?>
		</select>
		</div>
	</div>
	<div class="linhaConsulta">
		<div class="esquerdoConsulta"><label for="idModelo">Modelo:</label></div>
		<div class="meioConsulta">
			<select id="idModelo" name="idModelo">
				<option value="">
				<?php	
					echo "--Selecione--</option>";
					if (isset($vetModelo)) {
						foreach ($vetModelo as $modelo) {
							echo "<option value='".$modelo->getId()."'";
							if ($model->getModelo()->getId()!=null) {
								if ($model->getModelo()->getId()==$modelo->getId()) {
									echo "selected";
								}
							}
							echo ">".$modelo->getModelo()."</option>";
						}
					}
				?>
			</select>
		</div>
	</div>
	<div class="linhaBotaoConsulta">
		<div class="embaixoBotoesConsulta">
			<input type="submit" value="Consultar">
			<input type="reset" value="Limpar">
			<input type="hidden" name="acao" value="consultar">
		</div>
	</div>
</div>
</fieldset>
</form>

