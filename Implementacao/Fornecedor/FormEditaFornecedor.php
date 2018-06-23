<form action="ControllerFornecedor.php" method="POST" id="formFornecedor">
<fieldset class="quadro">
	<legend class="legenda">Alteração de Fornecedor</legend>
	<div class="linha">
		<div class="esquerdo"><label for="nome">Nome:</label></div>
		<div class="meio"><input type="text" name="nome" id="nome" class="required" value="<?php echo ($model->getNome());?>"/></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="emailFornecedor">Email:</label></div>
		<div class="meio"><input type="text" name="emailFornecedor" id="emailFornecedor" class="email" value="<?php echo ($model->getEmail());?>"/></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="cnpjFornecedor">CNPJ:</label></div>
		<div class="meio"><input type='text' name='cnpjFornecedor' id='cnpjFornecedor' value='<?php echo $model->getCnpj();?>'></div>
	</div>
	</div>
</div>
	<div class="linha">
		<div class="esquerdo"><label for="estado">Estado:</label></div>
		<div class="meio">
			<select id="estado" name="estado">
				<?php 
					echo "<option value=''>--Selecione--</option>";
					if (isset($vetEstado)) {
						foreach ($vetEstado as $estado) {
							echo "<option value='".$estado->getId()."'";
							if ($estado->getId()==$model->getCidade()->getEstado()->getId()) {
								echo "selected";
							}
							echo ">".$estado->getEstado()."</option>";
						}
					}
				?>
			</select>
		</div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="cidade">Cidade:</label></div>
		<div class="meio">
			<select id="cidade" name="cidade" >
				<?php 
					echo "<option value=''>--Selecione--</option>";
					if (isset($vetCidade)) {
						foreach ($vetCidade as $cidade) {
							echo "<option value='".$cidade->getId()."'";
							if ($cidade->getId()==$model->getCidade()->getId()) {
								echo "selected";
							}
							echo ">".$cidade->getCidade()."</option>";
						}
					}
				?>
			</select>
		</div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="endereco">Endereço:</label></div>
		<div class="meio"><input type="text" name="endereco" id="endereco" value="<?php echo ($model->getEndereco());?>"/></div>
	</div>
		<div class="linha">
		<div class="esquerdo"><label for="telefone">Telefone:</label></div>
		<div class="meio"><input type="text" name="telefone" id="telefone" class="required"value="<?php echo ($model->getTelefone());?>"/></div>
	</div>
	<div class="linhaBotao">
		<div class="embaixoBotoes">
			<input type="submit" value="Alterar">
			<input type="hidden" name="id" value="<?php echo($model->getId());?>">
			<input type="hidden" name="acao" value="atualizar">
		</div>
	</div>
</fieldset>
</form>
