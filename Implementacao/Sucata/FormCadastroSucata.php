<script>
	var modal=1;
</script>
<form action="ControllerSucata.php" method="POST" id="formSucata"enctype="multipart/form-data" onsubmit="validaFoto();validaSucata();validaData()">
<fieldset class="quadro" id="cadastroSucata">
	<legend class="legenda">Cadastro de Sucata</legend>
	<div class="linha">
				<div class="esquerdo"><label for="carro">Sucata:</label></div>
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
		</div>		
		<div class="linha">
			<div class="esquerdo"><label for="lote">Lote Sucata:</label></div>
			<div class="meio"><input type="text" name="lote" id="loteSucata"class="required"/></div>
			<div  id="errorLote"	></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="leilao">Leilão Sucata:</label></div>
			<div class="meio"><input type="text" name="leilao"  id="leilaoSucata"class="required"/></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="data">Data do Leilão:</label></div>
			<div class="meio"><input type="text" name="data" id="data" class="required"/></div>
			<div id="errorData"></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="categoria">Categoria de Dano:</label></div>
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
							<div class="fechar"><a class="popup-modal-dismiss" href="#"><img src="../Image/subranco.png" class='popxis' id="subCategoria"></a></div>
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
										<div class='centro'>
											<input type="button" id="cadastrarCategoria" value="Cadastrar">
										</div>
										
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

		</div>
		<div class="linha">
			<div class="esquerdo"><label for="localizacao">Localização da Sucata:</label></div>
			<div class="meio"><input type="text" name="localizacao" id="localizacaoSucata"class="required"/></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="foto">Fotos:</label></div>
			<div class="meio">
				<table id="tabelaFoto">
					<tr><td><input type="file" class="foto" name="foto[]"></td><td><img src="../Image/add.png" id="imgAddFoto"></td></tr>
				</table>
			</div>
		</div>
		<div class="linhaBotao">
			<div class="embaixoBotoes">
				<input type="submit" value="Cadastrar">
				<input type="reset" value="Limpar">
				<input type="hidden" name="acao" value="cadastrar">
			</div>
		</div>
	</div>
</fieldset>
</form>
