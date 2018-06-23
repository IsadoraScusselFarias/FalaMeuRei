<script src="../Html/funcionalidades.js"></script>
<form action="ControllerCategoria.php" method="POST">
<div class="quadrinhoClick clicaConsulta"><img src="../Image/lupa.png"/></div>
<fieldset class="quadroLateral consultarClick">
	<legend class="legenda">Consulta:</legend>
	<div><img src="../Image/sub.png" class="xis "/></div>
<div class="corpo">	
	<div class="linhaConsulta">
		<div class="esquerdoConsulta"><label for="nome">Nome:</label></div>
		<div class="meioConsulta"><input type="text" name="nome" id="nome" value="<?php if($model->getNome()!=null){echo $model->getNome();}?>" /></div>
	</div>
	<div class="ladoEsquerdoFormularioConsulta">
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