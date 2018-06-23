<form action="ControllerDespesa.php" method="POST" id="formDespesa" onsubmit="validaData()">
<fieldset class="quadro">
	<legend class="legenda">Cadastro de Despesa</legend>
	<div class="linha">
		<div class="esquerdo"><label for="nome">Nome:</label></div>
		<div class="meio"><input type="text" name="nome" id="nome" class="required"/></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="valor">Valor:</label></div>
		<div class="meio"><input type="text" name="valor" id="valor" class="required number"/></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="data">Data:</label></div>
		<div class="meio"><input type="text" name="data" id="data" class="required"/></div>
		<div id="errorData"></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="observacao">Observação:</label></div>
		<div class="meio"><textarea name="observacao" id="observacao"></textarea></div>
	</div>
	<div class="linhaBotao">
		<div class="embaixoBotoes">
			<input type="submit" value="Cadastrar">
			<input type="reset" value="Limpar">
			<input type="hidden" name="acao" value="cadastrar">
		</div>
	</div>
</fieldset>
</form>
