<form action="ControllerCategoria.php" method="POST" id="formCategoria" onsubmit="validaCategoria()">
	<fieldset class="quadro">
	<legend class="legenda">Alteração de Categoria de Dano:</legend>
	<div class="linha">
		<div class="esquerdo"><label for="nomeCategoria">Nome:</label></div>
		<div class="meio"><input type="text" name="nomeCategoria" id="nomeCategoria" value="<?php echo ($model->getNome());?>" class="required"/></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="descricao">Descrição:</label></div>
		<div class="meio"><textarea name="descricao" id="descricao"><?php echo$model->getDescricao();?></textarea></div>
	</div>
	<div>
		<div class="embaixoBotoes">
			<input type="submit" value="Alterar">
			<input type="reset" value="Limpar">
			<input type="hidden" name="id" value="<?php echo($model->getId());?>">
			<input type="hidden" name="acao" value="atualizar">
		</div>
	</div>
</fieldset>
</form>
