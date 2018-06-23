<script>
	var modal=1;
</script>
<form action="ControllerCompra.php" method="POST" enctype="multipart/form-data" id="formCompra" onsubmit="validaFoto();validaData()">
<fieldset class="quadro">
		<legend class="legenda">Cadastro de Compra</legend>
	<div class="linha">
		<div class="esquerdo"><label for="valor">Valor:</label></div>
		<div class="meio"><input type="text" name="valor" id="valor" class="required"/></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="data">Data:</label></div>
		<div class="meio">	<input type="text" name="data" id="data" class="required"/></div>
		<div id="errorData"></div>
	</div>
	<div class="linha">
		<div class="esquerdo"><label for="descricao">Descrição:</label></div>
		<div class="meio"><textarea name="descricao" id="descricao" class="required"></textarea></div>
	</div>
	<div class="linha">
		<div class="esquerdo">Fornecedor:</div>
		<div class="meio">
			<?php 
				echo("<select id='idFornecedor' name='idFornecedor' class='required'>");
				echo "<option value=''>--Selecione--</option>";
				foreach ($vetFornecedor as $item){
					echo "<option value=" . $item->getId().">" . $item->getNome()."-".$item->getCnpj() . "</option>";
				}
				echo("</select>");
			?>
			<div id="popupFornecedor" class="mfp-hide white-popup-block">
				<div id="formPopup">				
					<div class="fechar"><a class="popup-modal-dismiss" href="#"><img src="../Image/subranco.png" class='popxis'id="subFornecedor"></a></div>	
					<div class="conteudopopup">			
						<div class="linhaNovaFornecedor">Cadastro de Fornecedor:</div>
						<form id="formFornecedor">
							<div class="linha">
								<div class="esquerdo"><label for="nomeCompleto">Nome:</label></div>
								<div class="meio"><input type="text" name="nome" id="nome" class="required"/></div>
							</div>
							<div class="linha">
								<div class="esquerdo"><label for="emailFornecedor">Email:</label></div>
								<div class="meio"><input type="text" name="emailFornecedor" id="emailFornecedor" class="email"/></div>
							</div>
							<div class="linha">
								<div class="esquerdo"><label for="cnpj">CNPJ:</label></div>
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
								<div class="centro"><input type="button" id="cadastrarFornecedor" value="Cadastrar"></div>
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
		<div class="centro">
				<span class="iconeEspacamento"><img src="../Image/up.png" id="upS" class="tamanhoIcone"><img src="../Image/down.png"  id="downS" class="tamanhoIcone">Sucata</span>
				<span class="iconeEspacamento"><img src="../Image/up.png" id="upP"class="tamanhoIcone"><img src="../Image/down.png" id="downP" class="tamanhoIcone">Peça</span>
		</div>
		<div class="meio">
			
			<div id="formSucataCompra">

				<div class="linha">
					<div class="esquerdo"><label for="carro">Carro:</label></div>
					<div class="meio">
						<?php
							echo("<select id='carro' name='carro'class='required' >");
								echo "<option value='' >--Selecione--</option>";
								foreach ($vetCarro as $item){
									echo("<option value=".$item->getId().">".$item->getModelo()->getModelo()." ".$item->getVersao()."/".$item->getModelo()->getMarca()->getMarca()."/".$item->getAno()."</option>");
								}
							echo("</select>");
						?>
						<div id="popupCarro" class="mfp-hide white-popup-block">
						<div id="formPopup">				
						<div class="fechar"><a class="popup-modal-dismiss" href="#"><img src="../Image/subranco.png" class='popxis' id="subCarro"></a></div>	
							<div class="conteudopopup">			
								<div class="linhaNovaCarro">Cadastro de Carro:</div>
								<div id="formCarro">
									<div class="linha">
										<div class="esquerdo">Marca:</div>
										<div class="meio">
											<select id="idMarca" name="idMarca">
												<?php 
													echo "<option value=''>--Selecione--</option>";
													if (isset($vetMarca)) {
														foreach ($vetMarca as $marca) {
															echo "<option value='".$marca->getId()."'>".$marca->getMarca()."</option>";
														}
													}
												?>
											</select>
											<div id="formMarca">
												<input type="text" id="marca" name="marca">
											</div>
										</div>
										<div class="direita">
											<img src="../Image/add.png" id="addMarca" >
											<img src="../Image/sub.png" id="subMarca">
										</div>
										<div class="meio" id="errorMarca"></div>
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
										<div class="meio" class="error" id="errorModelo"></div>
									</div>
								
									<div class="linha">
										<div class="esquerdo">Ano:</div>
										<div class="meio"><input type="text" name="ano" id="ano" class="required digits"/></div>
										<div class="meio" class="error" id="errorAno"></div>
									</div>
									<div class="linha">
										<div class="esquerdo">Versão:</div>
										<div class="meio"><input type="text" name="versao" id="versao" class="required"/></div>
										<div class="meio" class="error" id="errorVersao"></div>
									</div>
									<div class="meio" class="error" id="errorCarro"></div>
									<input type="button" id="cadastrarCarro" value='Cadastrar'>
								</div>
							</div>
						</div>
					</div>
				</div>
					<div class="direita">
						<a class='popup-modal' href='#popupCarro'><img src="../Image/add.png" id="addCarro"></a>
					</div>
				</div>

					
				<div class="linha">
					<div class="esquerdo"><label for="lote">Lote Sucata:</label></div>
					<div class="meio"><input type="text" name="lote" id="loteSucata"class="required"/></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><label for="leilao">Leilão Sucata:</label></div>
					<div class="meio"><input type="text" name="leilao"  id="leilaoSucata"class="required"/></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><label for="data">Data do Leilão:</label></div>
					<div class="meio"><input type="text" name="dataLeilao" id="dataLeilao"class="required"/></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><label for="categoria">Categoria:</label></div>
					<div class="meio">
						<?php
							echo "<table id='tabelaCategoria'>";
								if (isset($vetCategoria)) {
									foreach ($vetCategoria as $item){
										echo "<tr><td><input name='categoria[]' type='checkbox' value=".$item->getId()."></td><td>".$item->getNome()."</td></tr>";
									}
								}
							echo "</table>";
						?>
						<div id="popupCategoria" class="mfp-hide white-popup-block">
						<div id="formPopup">				
							<div class="fechar"><a class="popup-modal-dismiss" href="#"><img src="../Image/subranco.png" class="popxis"id="subCategoria"></a></div>	
							<div class='conteudopopup'>			
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
					<a class='popup-modal' href='#popupCategoria'><img src="../Image/add.png" id="addCategoria"></a>
				</div>
					
				</div>
				<div class="linha">
					<div class="esquerdo"><label for="localizacao">Localização da Sucata:</label></div>
					<div class="meio"><input type="text" name="localizacao" id="localizacaoSucata"class="required"/></div>
				</div>
				<div class="linha">
					<div class="esquerdo"><label for="foto">Fotos:</label></div>
					<div class="meio">
						<table id="tabelaFoto">
							<tr><td><input type="file" class="foto"id="foto" name="foto[]"></td></tr>
						</table>
					</div>
					<div class="direita">
						<img src="../Image/add.png" id="imgAddFoto">
					</div>
				</div>
			</div><!-- fecha a form -->
			<div id="formPecaCompra">
				<a class='popup-modal' href='#popupPeca'>Cadastrar Peca</a>
				<script>
					acaoPeca=1;
				</script>
			<div class="fora">
				<table id="tabelaPeca" class="item">
					<tr>
						<th>Peca</th>	
						<th>Quantidade</th>
						<th>Valor Item</th>
						<th>Adicionar</th>
						<th class="cor">Remover</th>
					</tr>
				</table>
			</div>
				<div id="popupPeca" class="mfp-hide white-popup-block">
					<div id="formPopup">				
						<div class="fechar"><a class="popup-modal-dismiss" href="#"><img src="../Image/subranco.png" class='popxis' id="subPeca"></a></div>	
						<div class="conteudopopup">			
							<div class="linhaNovaCarro">Cadastro de Peca:</div>
							<div id="formPeca">
								<div  id="errorPeca"></div>
								<div class="linha">
									<div class="esquerdo"><label for="nomePeca">Nome:</label></div>
									<div class="meio"><input type="text" name="nomePeca" id="nomePeca" class="required"/></div>
								</div>
								<div class="linha">
									<div class="esquerdo"><label for="preco">Preço:</label></div>
									<div class="meio"><input type="text" name="preco" id="preco" class="required"/></div>
								</div>
								<div class="linha">
										<div class="esquerdo"><label for="carro">Carro:</label></div>
										<div class="meio">				
											<?php
												echo("<select id='carro' name='carro'class='required' >");
													echo "<option value='' >--Selecione--</option>";
													foreach ($vetCarro as $item){
														echo("<option value=".$item->getId().">".$item->getModelo()->getModelo()." ".$item->getVersao()."/".$item->getModelo()->getMarca()->getMarca()."/".$item->getAno()."</option>");
													}
												echo("</select>");
											?>
											<div id="popupCarro" class="mfp-hide white-popup-block">
												<div id="formPopup">				
													<div class="fechar"><a class="popup-modal-dismiss" href="#"><img src="../Image/subranco.png" class='popxis'id="subCarro"></a></div>
													<div class='conteudopopup'>				
														<div class="linhaNovaCarro">Cadastro de Carro:</div>
														<div id="formCarro">
															<div class="linha">
																<div class="esquerdo">Marca:</div>
																<div class="meio">
																	<select id="idMarca" name="idMarca" class="dadosDeCarro">
																		<?php 
																			echo "<option value=''>--Selecione--</option>";
																			if (isset($vetMarca)) {
																				foreach ($vetMarca as $marca) {
																					echo "<option value='".$marca->getId()."'>".$marca->getMarca()."</option>";
																				}
																			}
																		?>
																	</select>
																	<div id="formMarca">
																		<input type="text" id="marca" name="marca" class="dadosDeCarro">
																	</div>
																</div>
																<div class="direita">
																	<img src="../Image/add.png" id="addMarca" >
																	<img src="../Image/sub.png" id="subMarca">
																</div>
																<div class="meio" id="errorMarca"></div>
															</div>
														
															<div class="linha">
																<div class="esquerdo">Modelo:</div>
																<div class="meio">
																	<select id="idModelo" name="idModelo" class="dadosDeCarro">
																		<option value="">--Selecione--</option>
																	</select>
																	<div id="formModelo">
																		<input type="text" id="modelo" name="modelo" class="dadosDeCarro">
																	</div>
																</div>
																<div class="direita">
																	<img src="../Image/add.png" id="addModelo">
																	<img src="../Image/sub.png" id="subModelo">
																</div>
																<div class="meio" class="error" id="errorModelo"></div>
															</div>
														
															<div class="linha">
																<div class="esquerdo">Ano:</div>
																<div class="meio"><input type="text" name="ano" id="ano" class="dadosDeCarro"/></div>
																<div class="meio" class="error" id="errorAno"></div>
															</div>
															<div class="linha">
																<div class="esquerdo">Versão:</div>
																<div class="meio"><input type="text" name="versao" id="versao" class="dadosDeCarro"/></div>
																<div class="meio" class="error" id="errorVersao"></div>
															</div>
															<div class="meio" class="error" id="errorCarro"></div>
															<input type="button" id="cadastrarCarro" value='Cadastrar'>
														</div>
													</div>
												</div>
												
											</div>
										</div>
										<div class="direita">
											<a class='popup-modal' href='#popupCarro'><img src="../Image/add.png" id="addCarro"></a>
										</div>
									</div>
								</div>		
								<div class="linha">
									<div class="esquerdo"><label for="descricao">Descricao:</label></div>
									<div class="meio"><textarea name="descricao" id="descricao"></textarea></div>
								</div>
								<input type="button" id="cadastrarPeca" value='Cadastrar'>
							</div>
						</div>
					</div>
			    </div>
		</div><!-- fecha a meio -->
	</div>	
	<div class="linhaBotao">
		<div class="embaixoBotoes">
			<input type="submit" value="Cadastrar">
			<input type="hidden" name="acao" value="cadastrar">
		</div>
	</div>	
</fieldset>
</form>
