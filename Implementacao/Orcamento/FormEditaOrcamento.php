<script>
	var acaoPeca=<?php 
		if ($model->getItemVendaPeca()!=null) {
			echo "1";
		}else{
			echo "0";
		}
	?>;
	var acaoSucata=<?php 
		if ($model->getItemVendaSucata()!=null) {
			echo "1";
		}else{
			echo "0";
		}
	?>;
	var modal=1;
</script>
<form action="ControllerOrcamento.php" method="POST" id="formOrcamento">
<fieldset class="quadro">
	<legend class="legenda">Alteração de Orcamento</legend>
	<div class="linha">
		<div class="esquerdo">Cliente:</div>
		<div class="meio">
			<?php 
				echo("<select id='idCliente' name='idCliente' class='required'>");
					echo "<option value=''>--selecione--</option>";
				foreach ($vetCliente as $item){
					echo "<option value='" . $item->getId()."'";
					if ($item->getId()==$model->getCliente()->getId()) {
						echo "selected";
					}
					echo ">" . $item->getNomeCompleto() . "</option>";
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
								</div>
								<div class="linha">
									<div class="esquerdo">Pessoa:</div>
									<div class="meio">
										<input type="radio" name="pessoa" value="fisica"id="pessoaF"/>Física<input type="radio" name="pessoa" value="juridica" id="pessoaJ"/>Jurídica
										<div id="cpfBox" class="campoPessoa">CPF:<input type="text" name="cpf" id="cpf"/></div>
										<div id="cnpjBox" class="campoPessoa">CNPJ:<input type="text" name="cnpjCliente" id="cnpjCliente"/></div>
									</div>
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
								<input type="button" id="cadastrarCliente" value='Cadastrar'>
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
		<div class="meio">
			<div class="tabelaCompra">
				<div id="nomeTabelaSucata" >Sucata</div>
				<table id="tabelaSucata" class="item">
					<tr>
						<th>Sucata</th>
						<th>Peca</th>
						<th>Quantidade</th>
						<th>Valor Item</th>
						<th><img src="../Image/excluir.png"></th>
					</tr>
				<?php
					if ($model->getItemVendaSucata()!=null) {
						foreach ($model->getItemVendaSucata() as $itemVendaSucata) {
								echo "<tr>";
								echo "<td>";
								echo "<select name='sucata[]'>";
								foreach ($vetSucata as $sucata) {
									echo "<option value='".$sucata->getId()."' ";
									if ($sucata->getId()==$itemVendaSucata->getSucata()->getId()) {
										echo " selected ";
									}
									echo ">".$sucata->getLote()."/".$sucata->getCarro()->getModelo()->getModelo()." ".$sucata->getCarro()->getVersao()."/".$sucata->getCarro()->getModelo()->getMarca()->getMarca()."/".$sucata->getCarro()->getAno()."</option>";
								}
								echo "</select>";						
								echo "</td>";
								echo "<td><input type='text' name='pecaSucata[]' value='".$itemVendaSucata->getNomePeca()."'></td>";
								echo "<td><input type='number' name='quantidadeSucata[]' value='".$itemVendaSucata->getQuantidade()."'></td>";
								echo "<td><input type='text' id='valorPeca' name='valorSucata[]' value='".$itemVendaSucata->getValorTotal()."'></td>";
								echo "</tr>";
							}	
					}	
					?>
				</table>
				<div id="nomeTabelaPeca" >Peça</div>
				<table id="tabelaPeca" class="item">
					<tr>
						<th>Peça</th>
						<th>Valor Unitário</th>
						<th>Quantidade Disponível</th>
						<th>Quantidade</th>
						<th>Valor Item</th>
						<th><img src="../Image/excluir.png"></th>
					</tr>
						<?php
							if ($model->getItemVendaPeca()!=null) {
								foreach ($model->getItemVendaPeca() as $itemVendaPeca) {
										echo "<tr>";
										echo "<td>";
										echo "<select name='peca[]'>";
										foreach ($vetPeca as $peca) {
											echo "<option value='".$peca->getId()."'";
											if ($peca->getId()==$itemVendaPeca->getPeca()->getId()) {
												echo "selected";
											}
											echo ">".$peca->getNome()."</option>";
										}
										echo "</select>";						
										echo "</td>";
										echo "<td class='valorUnitario'>".$itemVendaPeca->getPeca()->getPreco()."</td>";
										echo "<td class='quantidadeExistente'>".$itemVendaPeca->getPeca()->getQuantidade()."</td>";
										echo "<td><input type='number'  name='quantidadePeca[]' value='".$itemVendaPeca->getQuantidade()."'></td>";
										echo "<td><input type='text' name='valorPeca[]' value='".$itemVendaPeca->getValorTotal()."'></td>";
										echo "</tr>";
									}	
							}
						?>
				</table>
				<div>Valor Final do Orçamento:<span class="juntoInput"><input type="text" id="valorTotal" name="valorTotal" class="required" value="<?php echo $model->getValor(); ?>"></span></div>
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
			<input type="submit" value="Alterar">
			<input type="hidden" name="acao" value="atualizar">
			<input type="hidden" name="idOrcamento" value="<?php echo $model->getId(); ?>">
		</div>
	</div>
</fieldset>
</form>
