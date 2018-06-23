<form action="ControllerCategoria.php" method="POST" id="formCategoria" onsubmit="validaCategoria()">
<fieldset class="quadro">
	<legend class="legenda">Cadastro de Categoria de Dano</legend>
	<div class="linha">
		<div class="esquerdo"><label for="nomeCategoria">Nome:</label></div>
		<div class="meio"><input type="text" name="nomeCategoria" id="nomeCategoria" class="required"/></div>
		<div  id="errorNomeCategoria"></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="nome">Descrição:</label></div>
		<div class="meio"><textarea name="descricao" id="descricao"></textarea></div>
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
