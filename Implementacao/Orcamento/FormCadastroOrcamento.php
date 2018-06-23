<script>
	var acaoPeca=0;
	var acaoSucata=0;
	var modal=1;	
</script>
<form action="ControllerOrcamento.php" method="POST" id="formOrcamento" onsubmit="validaItens()">
<fieldset class="quadro">
	<legend class="legenda">Cadastro de Orcamento</legend>
	<div class="linha">
		<div class="esquerdo">Cliente:</div>
		<div class="meio">
			<?php 
				echo("<select id='idCliente' name='idCliente' class='required'>");
					echo "<option value=''>--Selecione--</option>";
				foreach ($vetCliente as $item){
					echo "<option value=" . $item->getId().">" . $item->getNomeCompleto() . "</option>";
				}
				echo("</select>");
			?>
			<div id="popupCliente" class="mfp-hide white-popup-block">
					<div id="formPopup">		
						<div class="fechar"><a class="popup-modal-dismiss" href="#"><img src="../Image/subranco.png" class='popxis'id="subCliente"></a></div>				
						<div class='conteudopopup'>			
							<div class="linhaNovaCliente">Cadastro de Cliente:</div>
							<div id="formCliente">
								<div class="linha">
									<div class="esquerdo"><label for="nomeCompleto">Nome Completo:</label></div>
									<div class="meio"><input type="text" name="nomeCompleto" id="nomeCompleto" class="required"/></div>
								</div>
								<div class="linha">
									<div class="esquerdo"><label for="emailCliente">Email:</label></div>
									<div class="meio"><input type="text" name="emailCliente" id="emailCliente" class="required email"/></div>
									<div id="errorEmail"></div>
								</div>
								<div class="linha">
									<div class="esquerdo">Pessoa:</div>
									<div class="meio">
										<input type="radio" name="pessoa" value="fisica"id="pessoaF"/>Física<input type="radio" name="pessoa" value="juridica" id="pessoaJ"/>Jurídica
										<div id="cpfBox" class="campoPessoa">CPF:<input type="text" name="cpf" id="cpf"/></div>
										<div id="cnpjBox" class="campoPessoa">CNPJ:<input type="text" name="cnpjCliente" id="cnpjCliente"/></div>
									</div>
									<div id="errorPessoa"></div>
								</div>
								<div class="linha">
									<div class="esquerdo"><label for="estado">Estado:</label></div>
									<div class="meio">
										<select id="estado" name="estado">
											<?php 
												echo "<option value=''>--selecione--</option>";
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
										<select id="cidade" name="cidade">
											<option value="">--selecione o estado--</option>
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
								<div class="linha">
									<div class="centro">
										<input type="button" id="cadastrarCliente" value='Cadastrar'>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="direita">
				<a class='popup-modal' href='#popupCliente'><img src="../Image/add.png" id="addCliente"></a>
			</div>
	</div>
	<div class="linha">
		<div class="centro">
				<span class="iconeEspacamento"><img src="../Image/add.png" class="tamanhoIcone"id="addPeca">Peça</span>
				<span class="iconeEspacamento"><img src="../Image/add.png"  class="tamanhoIcone"id="addSucata">Sucata</span>
		</div>
	</div>
		<div class="parteTabelas">
			<div id="errorOrcamento"></div>
			<div class="tabelaCompra">
				<div id="nomeTabelaSucata" class="cabecalhoItem">Sucata</div>
				<table id="tabelaSucata" class="item">
					<tr>
						<th>Sucata</th>
						<th>Peca</th>
						<th>Quantidade</th>
						<th>Valor Item</th>
						<td><img src="../Image/excluir.png"></td>
					</tr>
				</table>
				<div id="nomeTabelaPeca" class="cabecalhoItem">Peça</div>
				<table id="tabelaPeca" class="item">
					<tr>
						<th>Peça</th>
						<th>Valor Unitário</th>
						<th>Quantidade Disponível</th>
						<th>Quantidade</th>
						<th>Valor Item</th>
						<td><img src="../Image/excluir.png"></td>
					</tr>
				</table>
				<div id="errorItemGeral"></div>
				<div>Valor Final do Orçamento:<br>
					<span class="juntoInput">
						Desconto em %:<input type="text" id="descontoPorcentagem">
						<input type="hidden" id="descontoValor" name="descontoValor"><br>
						Desconto em R$:<div id="descontoTotal"></div>
						Valor Final com o desconto:<input type="text" id="valorFinal" name="valorFinal" value="" class="required">
						<input type="hidden" id="valorTotal" name="valorTotal" value="" class="required">
					</span>
				</div>
			</div>
			
		</div>
	
	<div id="popupPecasRetiradas" class="mfp-hide white-popup-block">
		<div id="formPopup">
			<div id="pecasRetiradas"></div>
			<p class="fechar"><a class="popup-modal-dismiss" href="#">Fechar</a></p>
		</div>
    </div>
    <a class='popup-modal' href='#popupPecasRetiradas'>Ver</a>
	<div class="linhaBotao">
		<div class="embaixoBotoes">
			<input type="submit" value="Cadastrar">
			<input type="hidden" name="acao" value="cadastrar">
		</div>
	</div>
</fieldset>
</form>
