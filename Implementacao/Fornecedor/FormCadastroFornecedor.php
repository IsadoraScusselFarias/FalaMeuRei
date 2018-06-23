<script>
	classe="Fornecedor";
</script>
<form action="ControllerFornecedor.php" method="POST" id="formFornecedor" onsubmit="validaFornecedor()">
<fieldset class="quadro">
	<legend class="legenda">Cadastro de Fornecedor</legend>
	<div class="linha">
		<div class="esquerdo"><label for="nomeCompleto">Nome:</label></div>
		<div class="meio"><input type="text" name="nome" id="nome" class="required"/></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="emailFornecedor">Email:</label></div>
		<div class="meio"><input type="text" name="emailFornecedor" id="emailFornecedor" class="email"/></div>
		<div  id="errorEmail"></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="cnpjFornecedor">CNPJ:</label></div>
		<div class="meio"><input type="text" name="cnpjFornecedor" id="cnpjFornecedor" class="required" /></div>
		<div  id="errorPessoa"></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="estado">Estado:</label></div>
		<div class="meio">
			<select id="estado" name="estado" >
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
			<select id="cidade" name="cidade" >
				<option value="">--Selecione--</option>
			</select>
		</div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="endereco">Endereço:</label></div>
		<div class="meio"><input type="text" name="endereco" id="endereco"/></div>
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
