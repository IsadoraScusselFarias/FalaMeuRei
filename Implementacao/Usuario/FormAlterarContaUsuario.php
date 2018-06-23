<form action="ControllerUsuario.php" method="POST" id="formUsuario">
<fieldset class="quadro">
	<legend class="legenda">Alterar Conta de Usuário</legend>
	<div class="corpo">
		<div class="linha">
			<div class="esquerdo"><label for="emailUsuario">Email:</label></div>
			<div class="meio"><input type="text" id="emailUsuario" name="emailUsuario" class="required email" value="<?php echo $model->getEmail() ;?>"></div>
			<div  id="errorEmail"></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="senhaAtual">Senha Atual:</label></div>
			<div class="meio"><input type="password" id="senhaAtual" name="senhaAtual" class="required"></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="senha">Senha Nova:</label></div>
			<div class="meio"><input type="password" id="senha" name="senha" class="required"></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="confirmarSenha">Confirmar Senha Nova:</label></div>
			<div class="meio"><input type="password" name="confirmarSenha" id="confirmarSenha" class="required"/></div>			
		</div>
		<div class="linha">
			<div class="esquerdo"><label>Tipo:</label></div>
			<div class="meio">
				<input type="radio" name="tipo" class="required" value="1"
				<?php
					if($model->getTipo()=="1"){
						echo "checked";
					}
				?>
				/>Administrador<br>
				<input type="radio" name="tipo" class="required" value="0" 
				<?php
					if($model->getTipo()=="0"){
						echo "checked";
					}
				?>
				/>Funcionário
			</div>			
		</div>
		<div>
			<div class="linhaBotao">
				<div class="embaixoBotoes">
					<input type="submit" value="Cadastrar">
					<input type="hidden" name="acao" value="alterarConta">
					<input type="hidden" name="id" id="id" value="<?php echo $model->getId();?>">
				</div>
			</div>
		</div>
	</div>
</fieldset>
</form>
