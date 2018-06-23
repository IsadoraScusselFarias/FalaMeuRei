<form action="ControllerOrcamento.php" method="POST">
<div class="quadrinhoClick clicaConsulta"><img src="../Image/lupa.png"/></div>
<fieldset class="quadroLateral consultarClick">
	<legend class="legenda">Consulta:</legend>
	<div><img src="../Image/sub.png" class="xis "/></div>
<div class="corpo">	
	<div class="linhaConsulta">
		<div class="esquerdoConsulta"><label for="cliente">Cliente:</label></div>
		<div class="meioConsulta"><input type="text" name="nomeCliente" id="nomeCliente" value="<?php echo $model->getCliente()->getNomeCompleto() ?>"></div>
	</div>
	<div class="linhaConsulta">
		<div class="esquerdoConsulta"><label for="dataInicial">Data Inicial:</label></div>
		<div class="meioConsulta"><input type="text" name="dataInicial" id="dataInicial" class="dataPeriodo" value="<?php echo $dataInicial;?>" /></div>
	</div>
	<div class="linhaConsulta">
		<div class="esquerdoConsulta"><label for="dataFinal">Data Final:</label></div>
		<div class="meioConsulta"><input type="text" name="dataFinal" id="dataFinal" class="dataPeriodo" value="<?php echo $dataFinal;?>" /></div>
	</div>
	<div class="linhaBotaoConsulta">
		<div class="embaixoBotoesConsulta">
			<input type="submit" value="Consultar">
			<input type="reset" value="Limpar">
			<?php
				if ($model->getStatus()=="0") {
					$tipo="consultarOrcamento";
				}else{
					$tipo="consultarVenda";				
				}
			?>
			<input type="hidden" name="acao" value="<?php echo $tipo; ?>">
			<input type="hidden" name="status" value="<?php echo $model->getStatus(); ?>">
		</div>
	</div>
</div>
</fieldset>
</form>