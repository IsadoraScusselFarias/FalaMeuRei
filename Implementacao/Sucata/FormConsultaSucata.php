<form action="ControllerSucata.php" method="POST">
<div class="quadrinhoClick clicaConsulta"><img src="../Image/lupa.png"/></div>
<fieldset class="quadroLateral consultarClick">
	<legend class="legenda">Consulta:</legend>
	<div><img src="../Image/sub.png" class="xis "/></div>
<div class="corpo">	
	<div class="linhaConsulta">
		<div class="esquerdoConsulta">Marca:</div>
		<div class="meioConsulta">
			<select id="idMarca" name="idMarca">
				<?php 
					echo "<option value=''>--selecione--</option>";
					if (isset($vetMarca)) {
						foreach ($vetMarca as $marca) {
							echo "<option value='".$marca->getId()."'";
							if ($model->getCarro()->getModelo()->getMarca()->getId()!="") {
								if ($model->getCarro()->getModelo()->getMarca()->getId()==$marca->getId()) {
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
		<div class="esquerdoConsulta">Modelo:</div>
		<div class="meioConsulta">
			<select id="idModelo" name="idModelo">
				<option value="">--Selecione--</option>
				<?php	
					if (isset($vetModelo)) {
						foreach ($vetModelo as $modelo) {
							echo "<option value='".$modelo->getId()."'";
							if ($model->getCarro()->getModelo()->getId()!=null) {
								if ($model->getCarro()->getModelo()->getId()==$modelo->getId()) {
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
	<div class="linhaConsulta">
		<div class="esquerdoConsulta">Leilão:</div>
		<div class="meioConsulta"><input type="text" name="leilao"  id="leilao"/></div>
	</div>
	<div class="linhaBotaoConsulta">
		<div class="embaixoBotoesConsulta">
			<input type="submit" value="Consultar">
			<input type="reset" value="Limpar">
			<input type="hidden" name="acao" value="consultar">
		</div>
	</div>
</fieldset>
</form>