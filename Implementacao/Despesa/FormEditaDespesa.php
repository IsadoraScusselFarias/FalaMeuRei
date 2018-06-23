<form action="ControllerDespesa.php" method="POST" id="formDespesa" onsubmit="validaData()">
<fieldset class="quadro">
	<legend class="legenda">Alteração de Despesa</legend>
	<div class="linha">
		<div class="esquerdo"><label for="nome">Nome:</label></div>
		<div class="meio"><input type="text" id="nome" name="nome" class="required" value="<?php echo ($model->getNome());?>"></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="valor">Valor:</label></div>
		<div class="meio"><input type="text" id="valor" name="valor" class="required number" value="<?php echo($model->getValor());?>"></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="data">Data:</label></div>
		<div class="meio"><input type="text" id="data" name="data" class="required" value="<?php echo($model->getData());?>"></div>
		<div id="errorData"></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="observacao">Observação:</label></div>
		<div class="meio"><textarea id="observacao" name="observacao"><?php echo($model->getObservacao());?></textarea></div>
	</div>
	<div class="linhaBotao">
		<div class="embaixoBotoes">
			<input type="submit" value="Alterar">
			<input type="reset" value="Limpar">
			<input type="hidden" name="id" value="<?php echo($model->getId());?>">
			<input type="hidden" name="acao" value="atualizar">
		</div>
	</div>
</fieldset>
</form>
