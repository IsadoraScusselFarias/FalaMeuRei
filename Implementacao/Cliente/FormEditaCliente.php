<form action="ControllerCliente.php" method="POST" id="formCliente" onsubmit="validaCliente()">
<fieldset class="quadro">
	<legend class="legenda">Alteração de Cliente</legend>
	<div class="linha">
		<div class="esquerdo"><label for="nomeCompleto">Nome Completo:</label></div>
		<div class="meio"><input type="text" name="nomeCompleto" id="nomeCompleto" class="required" value="<?php echo ($model->getNomeCompleto());?>"/></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="emailCliente">Email:</label></div>
		<div class="meio"><input type="text" name="emailCliente" id="emailCliente" class="required email" value="<?php echo ($model->getEmail());?>"/></div>
	</div>
	<div class="linha">
		<div class="esquerdo">Pessoa:</div>
		<div class="meio">
			<?php
				if($model->getCpf()!=null){
					echo '<script>
                        $(document).ready(function() {
                            $("#cnpj").hide();
                            $("#cnpjBoxAlt").hide();
                        });
                    </script>';
					echo"<input type='radio' name='pessoa' value='fisica'id='pessoaFAlt' checked/>Física<input type='radio' name='pessoa' value='juridica' id='pessoaJAlt'/>Jurídica";
					echo"<div id='cpfBoxAlt' class='campoPessoa'>CPF:<input type='text' name='cpf' id='cpf' value='".$model->getCpf()."'</div>";
					echo"<div id='cnpjBoxAlt' class='campoPessoa'>CNPJ:<input type='text' name='cnpjCliente' id='cnpj'</div>";
					
				}else{
					echo"<input type='radio' name='pessoa' value='fisica'id='pessoaFAlt'/>Física<input type='radio' name='pessoa' value='juridica' id='pessoaJAlt' checked/>Jurídica";
					echo"<div id='cnpjBoxAlt' class='campoPessoa'>CNPJ:<input type='text' name='cnpjCliente' id='cnpj' value='".$model->getCnpj()."'</div>";
					echo"<div id='cpfBoxAlt' class='campoPessoa'>CPF:<input type='text' name='cpf' id='cpf' </div>";
					echo '<script>
                        $(document).ready(function() {
                            $("#cpf").hide();
                            $("#cpfBoxAlt").hide();
                        });
                    </script>';
				}
			?>
		</div>
	</div>
	</div>
</div>
	<div class="linha">
		<div class="esquerdo"><label for="estado">Estado:</label></div>
		<div class="meio">
			<select id="estado" name="estado" class="required" >
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
			<select id="cidade" name="cidade" class="required" >
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
		<div class="meio"><input type="text" name="endereco" id="endereco" class="required"value="<?php echo ($model->getEndereco());?>"/></div>
	</div>
		<div class="linha">
		<div class="esquerdo"><label for="telefone">Telefone:</label></div>
		<div class="meio"><input type="text" name="telefone" id="telefone" class="required"value="<?php echo ($model->getTelefone());?>"/></div>
	</div>
	<div class="linhaBotao">
		<div class="embaixoBotoes">
			<input type="submit" value="Alterar">
			<input type="hidden" name="id" id="id" value="<?php echo($model->getId());?>">
			<input type="hidden" name="acao" value="atualizar">
		</div>
	</div>
</fieldset>
</form>
