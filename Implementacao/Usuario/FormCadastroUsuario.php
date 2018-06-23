<form action="ControllerUsuario.php" method="POST" id="formUsuario" onsubmit="validaUsuario()">
<fieldset class="quadro">
	<legend class="legenda">Cadastro de Usuário</legend>
	<div class="corpo">
		<div class="linha">
			<div class="esquerdo"><label for="emailUsuario">Email:</label></div>
			<div class="meio"><input type="text" id="emailUsuario" name="emailUsuario" class="required email"></div>
			<div  id="errorEmail"></div>
		</div>
		
		<div class="linha">
			<div class="esquerdo"><label for="senha">Senha:</label></div>
			<div class="meio"><input type="password" id="senha" name="senha" class="required"></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="confirmarSenha">Confirmar Senha:</label></div>
			<div class="meio"><input type="password" name="confirmarSenha" id="confirmarSenha" class="required"/></div>			
		</div>
		<div class="linha">
			<div class="esquerdo"><label>Tipo:</label></div>
			<div class="meio">
				<input type="radio" name="tipo" class="required" value="1" />Administrador<br>
				<input type="radio" name="tipo" class="required" value="0" />Funcionário
			</div>			
		</div>
		<div>
			<div class="linhaBotao">
				<div class="embaixoBotoes">
					<input type="submit" value="Cadastrar">
					<input type="hidden" name="acao" value="cadastrar">
				</div>
			</div>
		</div>
	</div>
</fieldset>
</form>
