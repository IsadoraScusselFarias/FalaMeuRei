<script>
	acaoPeca=1;
</script>
<form action="ControllerCompra.php" method="POST" enctype="multipart/form-data" id="formCompra" onsubmit="validaFoto()">
<fieldset class="quadro">
		<legend class="legenda">Alteração de Compra</legend>
		<div class="linha">
			<div class="esquerdo"><label for="valor">Valor:</label></div>
			<div class="meio"><input type="text" name="valor" id="valor" value="<?php echo ($model->getValor());?>" class="required"/></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="data">Data:</label></div>
			<div class="meio"><input type="text" name="data" id="data" value="<?php echo ($model->getData());?>" class="required" /></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="descricao">Descrição:</label></div>
			<div class="meio"><textarea name="descricao" id="descricao" class="required"><?php echo($model->getDescricao());?></textarea></div>
		</div>
		<div class="linha">
		<div class="esquerdo">Fornecedor:</div>
		<div class="meio">
			<?php 
				echo("<select id='idFornecedor' name='idFornecedor' class='required'>");
					echo "<option value=''>--selecione--</option>";
				foreach ($vetFornecedor as $item){
					echo "<option value='" . $item->getId()."'";
					if ($item->getId()==$model->getFornecedor()->getId()) {
						echo "selected";
					}
					echo ">" . $item->getNome()."-".$item->getCnpj() . "</option>";
				}
				echo("</select>");
			?>
		<div id="popupFornecedor" class="mfp-hide white-popup-block">
				<div id="formPopup">				
					<div class="fechar"><a class="popup-modal-dismiss" href="#"><img src="../Image/subranco.png" class='popxis'id="subFornecedor"></a></div>	
					<div class="conteudopopup">			
						<div class="linhaNovaFornecedor">Cadastro de Fornecedor:</div>
						<form id="formFornecedor" onsubmit="console.log('oi')">
							<div class="linha">
								<div class="esquerdo"><label for="nomeCompleto">Nome:</label></div>
								<div class="meio"><input type="text" name="nome" id="nome" class="required"/></div>
							</div>
							<div class="linha">
								<div class="esquerdo"><label for="emailFornecedor">Email:</label></div>
								<div class="meio"><input type="text" name="emailFornecedor" id="emailFornecedor" class="email"/></div>
							</div>
							<div class="linha">
								<div class="esquerdo"><label for="cnpjFornecedor">CNPJ:</label></div>
								<div class="meio"><input type="text" name="cnpjFornecedor" id="cnpjFornecedor"/></div>
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
							<div class='linha'>
								<div class="centro"><input type="button" id="cadastrarFornecedor" value="cadastrar"></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="direita">
			<a class='popup-modal' href='#popupFornecedor'><img src="../Image/add.png" id="addFornecedor"></a>
		</div>
	</div>
		<div class="linha">
			<div class="meio">
				<table id="tabela" class="item">
					<?php
						if ($model->getItemCompra()==null&&$model->getSucata()==null) {
							echo "<input type='hidden' name='status' value='2'";
						}
						if ($model->getItemCompra()!=null) {
							echo "<input type='hidden' name='status' value='0'";
							echo"<div class='legenda'>Peças</div>";
							echo"<table class='itemCompraTabela' id='tabelaPeca'>";
							echo'<th>Peça</th><th>Quantidade</th><th>Valor do Item</th><th><img src="../Image/excluir.png" class="iconeExcluir"></th><th class="cor"><img src="../Image/add.png" id="addPecaCompra" class="iconeExcluir"></th></tr>';
							foreach ($model->getItemCompra() as $itemCompra) {
								echo "<tr>";
								echo "<td>";
								echo "<select name='peca[]'>";
								foreach ($vetPeca as $peca) {
									echo "<option value='".$peca->getId()."'";
									if ($peca->getId()==$itemCompra->getPeca()->getId()) {
										echo "selected";
									}
									echo ">".$peca->getNome()."</option>";
								}
								echo "</select>";	
								echo "</td>";
								echo "<td><input type='number'  name='quantidadePeca[]' value='".$itemCompra->getQuantidade()."'><input type='hidden' name='quantidadePecaAnterior[]' value='".$itemCompra->getQuantidade()."'></td>";
								echo "<td><input type='text' name='valorPeca[]' value='".$itemCompra->getValorTotal()."'></td><td><img src='../Image/sub.png' class='remove'></td>";
								echo "</tr>";
							}
							echo'</table>';
						}
						if ($model->getSucata()!=null) {
							echo "<input type='hidden' name='status' value='1'";
					echo '<div class="linha">
							<div class="linha">
								<div class="esquerdo"><label for="carro">Sucata:</label></div>
								<div class="meio">
									<select id="carro" name="carro"class="required" >
										<option value="" >--Selecione--</option>';
										foreach ($vetCarro as $item){
											echo("<option value='".$item->getId()."'");
											if ($item->getId()==$model->getSucata()->getCarro()->getId()) {
												echo "selected";
											}
											echo (">".$item->getModelo()->getModelo()." ".$item->getVersao()."/".$item->getModelo()->getMarca()->getMarca()."/".$item->getAno()."</option>");
										}
									echo '</select>
									<div class="linhaNovaCarro">Cadastro de Carro:</div>
									<div id="formCarro">
										<div class="linha">
											<div class="esquerdo">Marca:</div>
											<div class="meio">
												<select id="idMarca" name="idMarca">
													<option value="">--Selecione--</option>';
														if (isset($vetMarca)) {
															foreach ($vetMarca as $marca) {
																echo "<option value='".$marca->getId()."'>".$marca->getMarca()."</option>";
															}
														}
											echo '</select>
												<div id="formMarca">
													<input type="text" id="marca" name="marca">
												</div>
											</div>
											<div class="direita">
												<img src="../Image/add.png" id="addMarca" >
												<img src="../Image/sub.png" id="subMarca">
										</div>
									</div>
									<div class="linha">
										<div class="esquerdo">Modelo:</div>
										<div class="meio">
											<select id="idModelo" name="idModelo">
												<option value="">--Selecione--</option>
											</select>
											<div id="formModelo">
												<input type="text" id="modelo" name="modelo">
											</div>
										</div>
										<div class="direita">
											<img src="../Image/add.png" id="addModelo">
											<img src="../Image/sub.png" id="subModelo">
										</div>
									</div>
								
									<div class="linha">
										<div class="esquerdo">Ano:</div>
										<div class="meio"><input type="text" name="ano" id="ano" class="required digits"/></div>
									</div>
									<div class="linha">
										<div class="esquerdo">Versão:</div>
										<div class="meio"><input type="text" name="versao" id="versao" class="required"/></div>
									</div>
									</div>
								</div>
								<div class="direita">
									<img src="../Image/add.png" id="addCarro">
									<img src="../Image/sub.png" id="subCarro">
								</div>
							</div>	
							<div class="linha">
								<div class="esquerdo"><label for="lote">Lote Sucata:</label></div>
								<div class="meio"><input type="text" name="lote" id="lote" class="required"value="'.$model->getSucata()->getLote().'"/></div>
							</div>
							<div class="linha">
								<div class="esquerdo"><label for="leilao">Leilão Sucata:</label></div>
								<div class="meio"><input type="text" name="leilao"  id="leilao" class="required"value="'.$model->getSucata()->getLeilao().'"/></div>
							</div>
							<div class="linha">
								<div class="esquerdo"><label for="data">Data do Leilão:</label></div>
								<div class="meio"><input type="text" name="data" id="data"class="required" value="'.$model->getSucata()->getDataLeilao().'"/></div>
							</div>
							<div class="linha">
								<div class="esquerdo"><label for="categoria">Categoria:</label></div>
								<div class="meio">
										<table class="tabelaCategoria">';
											if (isset($vetCategoria)) {
												foreach ($vetCategoria as $item){
													echo "<tr><td><input name='categoria[]' type='checkbox' value='".$item->getId()."'";
													if ($model->getSucata()->getCategorias()!=null) {
														foreach ($model->getSucata()->getCategorias() as $categoria) {
															if ($item->getId()==$categoria->getId()) {
																echo "checked";
															}
														}
													}
													echo "></td><td>".$item->getNome()."</td></tr>";
												}
											}
									echo '</table>
								<div id="popupCategoria" class="mfp-hide white-popup-block">
									<div id="formPopup">				
										<div class="fechar"><a class="popup-modal-dismiss" href="#"><img src="../Image/subranco.png" class="popxis"id="subCategoria"></a></div>	
										<div class="conteudopopup">			
											<div class="linhaNovaCategoria">Cadastro de Categoria:</div>
											<div id="formCategoria">
												<div class="linha">
													<div class="esquerdo">Nome:</div>
													<div class="meio"><input type="text" name="nomeCategoria" id="nomeCategoria"/></div>
													<div class="meio" class="error" id="errorNomeCategoria"></div>
												</div>
												<div class="linha">
													<div class="esquerdo">Descrição:</div>
													<div class="meio"><input type="text" name="descricao" id="descricao" class="required"/></div>
													<div class="meio" class="error" id="errorDescricao"></div>
												</div>
												<div class="linha">
													<div class="centro"><input type="button" id="cadastrarCategoria" value="Cadastrar"></div>
												</div>
												
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="direita">
								<a class="popup-modal" href="#popupCategoria"><img src="../Image/add.png" id="addCategoria"></a>
							</div>
						
							<div class="linha">
								<div class="esquerdo"><label for="localizacao">Localização da Sucata:</label></div>
								<div class="meio"><input type="text" name="localizacao" id="localizacao"class="required" value="'.$model->getSucata()->getLocalizacao().'"/></div>
							</div>
							<div class="linha">
								<div class="esquerdo"><label for="foto">Fotos:</label></div>
								<div class="meio">';
									echo'	<div class="fotoADD">Fotos:</div>
										<table id="tabelaFoto">';
										 
												if ($model->getSucata()->getFotos()) {
													foreach ($model->getSucata()->getFotos() as $foto) {
														echo "<tr><td><img src='".$foto->getCaminho()."'/></td>";
														echo "<td><input type='checkbox' name='fotosApagadas[]' value='".$foto->getId()."' ></td>";
														echo "<td><img src='../Image/excluir.png' class='iconeExcluir'></td></tr>";
													}
												}else{
													echo"<tr><td><input type='file' id='foto' name='foto[]'></td></tr>";
												}
										
									echo'	</table>';
								echo '</div>
								<div class="direita">
									<img src="../Image/add.png" id="imgAddFoto">
								</div>
							</div>
							<input type="hidden" name="idSucata" value="'.$model->getSucata()->getId().'">';
							echo'</div>';
							}
						?>
				</table>	
			</div>
		</div>
		<div class="linhaBotao">
			<div class="embaixoBotoes">
				<input type="submit" value="Alterar">
				<input type="reset" value="Limpar">
				<input type="hidden" name="id" value="<?php echo($model->getId());?>">
				<input type="hidden" name="acao" value="atualizar">
			</div>
		</div>	
</fieldset>
</form>
