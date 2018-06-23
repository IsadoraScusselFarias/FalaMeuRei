<form action="ControllerCliente.php" method="POST" id="formCliente" onsubmit="validaCliente()">
<fieldset class="quadro">
	<legend class="legenda">Cadastro de Cliente</legend>
	<div class="linha">
		<div class="esquerdo"><label for="nomeCompleto">Nome Completo:</label></div>
		<div class="meio"><input type="text" name="nomeCompleto" id="nomeCompleto" class="required"/></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="emailCliente">Email:</label></div>
		<div class="meio"><input type="text" name="emailCliente" id="emailCliente" class="required email"/></div>
		<div  id="errorEmail"></div>
	</div>
	<div class="linha">
		<div class="esquerdo">Pessoa:</div>
		<div class="meio">
			<input type="radio" name="pessoa" value="fisica"id="pessoaF"/>Física<input type="radio" name="pessoa" value="juridica" id="pessoaJ"/>Jurídica
			<div id="cpfBox" class="campoPessoa">CPF:<input type="text" name="cpf" id="cpf"/></div>
			<div id="cnpjBox" class="campoPessoa">CNPJ:<input type="text" name="cnpjCliente" id="cnpjCliente"/></div>
			<div  id="errorPessoa"></div>
		</div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="estado">Estado:</label></div>
		<div class="meio">
			<select id="estado" name="estado" class="required" >
				<?php 
					echo "<option value=''>--Selecione--</option>";
					foreach ($vetEstado as $estado) {
						echo "<option value='".$estado->getId()."'>".$estado->getEstado()."</option>";
					}
				?>
			</select>
		</div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="cidade">Cidade:</label></div>
		<div class="meio">
			<select id="cidade" name="cidade" class="required" >
				<option value="">--Selecione--</option>
			</select>
		</div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="endereco">Endereço:</label></div>
		<div class="meio"><input type="text" name="endereco" id="endereco" class="required"/></div>
	</div>
		<div class="linha">
		<div class="esquerdo"><label for="telefone">Telefone:</label></div>
		<div class="meio"><input type="text" name="telefone" id="telefone" class="required"/></div>
	</div>
	<div class="linhaBotao">
		<div class="embaixoBotoes">
			<input type="submit" value="Cadastrar">
			<input type="hidden" name="acao" value="cadastrar">
		</div>
	</div>
</fieldset>
</form>
