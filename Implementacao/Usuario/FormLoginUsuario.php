<form action="../Usuario/ControllerUsuario.php" method="POST" id="formUsuario">
<fieldset class="quadroLogin">
	<legend class="legenda">Login de Usuário</legend>
	<div class="corpo">
		<div class="linha">
			<div class="esquerdo"><label for="email">Email:</label></div>
			<div class="meio"><input type="text" id="email" name="email" class="required email"></div>
		</div>
		
		<div class="linha">
			<div class="esquerdo"><label for="senha">Senha:</label></div>
			<div class="meio"><input type="password" id="senha" name="senha" class="required"></div>
		</div>
		<div>
			<div class="linhaBotao">
				<div class="embaixoBotoes">
					<input type="submit" value="Logar">
					<input type="hidden" name="acao" value="logar">
				</div>
			</div>
		</div>
	</div>
</fieldset>
</form>
