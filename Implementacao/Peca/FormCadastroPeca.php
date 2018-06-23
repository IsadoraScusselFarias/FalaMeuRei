<script>
	var modal=1;
</script>
<form action="../Peca/ControllerPeca.php" method="POST" enctype="multipart/form-data" id="formPeca" onsubmit="validaFoto();validaPeca()">
<fieldset class="quadro">
	<legend class="legenda">Cadastro de Peças</legend>
	<div class="corpo">
		<div  id="errorPeca"></div>
		<div class="linha">
			<div class="esquerdo"><label for="nomePeca">Nome:</label></div>
			<div class="meio"><input type="text" name="nomePeca" id="nomePeca" class="required"/></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="quantidade">Quantidade:</label></div>
			<div class="meio"><input type="number" name="quantidade" id="quantidade" class="required"/></div>
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
