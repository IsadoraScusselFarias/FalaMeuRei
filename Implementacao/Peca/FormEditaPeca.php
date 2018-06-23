<script>
	var modal=1;
</script>
<form action="../Peca/ControllerPeca.php" method="POST" enctype="multipart/form-data" id="formPeca"	onsubmit="validaFoto()">
<fieldset class="quadro">
	<legend class="legenda">Alteração de Peças</legend>
	<div class="corpo">
		<div class="linha">
			<div class="esquerdo"><label for="nomePeca">Nome:</label></div>
			<div class="meio"><input type="text" name="nomePeca" id="nomePeca" class="required"value="<?php echo($model->getNome());?>"/></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="quantidade">Quantidade:</label></div>
			<div class="meio"><input type="number" name="quantidade"  id="quantidade" class="required digits" value="<?php echo($model->getQuantidade());?>"/></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="preco">Preço:</label></div>
			<div class="meio"><input type="text" name="preco" id="preco" class="required number"value="<?php echo($model->getPreco());?>"/></div>
		</div>
		<div class="linha">
				<div class="esquerdo"><label for="carro">Carro:</label></div>
				<div class="meio">
					<?php 
						echo("<select id='carro' name='carro' class='required'>");
						echo "<option value='' >--selecione--</option>";
						foreach ($vetCarro as $item){
							echo("<option value=" . $item->getId());
							if($item->getId() == $model->getCarro()->getId()){
								echo(" selected");
							}
							echo(">" .$item->getModelo()->getModelo()."/".$item->getAno()."/".$item->getModelo()->getMarca()->getMarca(). "</option>");
						}
						echo("</select>");
					?>
					<div id="popupCarro" class="mfp-hide white-popup-block">
						<div id="formPopup">				
							<div class="fechar"><a class="popup-modal-dismiss" href="#"><img src="../Image/sub.png" id="subCarro"></a></div>				
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
				<div class="direita">
					<a class='popup-modal' href='#popupCarro'><img src="../Image/add.png" id="addCarro"></a>
				</div>
			</div>
		</div>		
		<div class="linha">
			<div class="esquerdo"><label for="descricao">Descricao:</label></div>
			<div class="meio"><textarea name="descricao" id="descricao"><?php echo($model->getDescricao());?></textarea></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="foto">Fotos:</label></div>
			<div class="meio">
				<div class="fotoADD">Fotos:</div>
				<table id="tabelaFoto">
					<?php 
					if ($model->getFotos()!=null) {
						foreach ($model->getFotos() as $foto) {
							echo "<tr><td><img src='".$foto->getCaminho()."'/></td>";
							echo "<td><input type='hidden' class='status' name='statusFotos[]' value='1'><img src='../Image/update.png' class='iconeExcluir refreshImagem'><img src='../Image/sub.png' class='iconeExcluir subImagem'></td></tr>";
						}
					}
					?>
				</table>
			</div>
			<div class="direita">
				<img src="../Image/add.png" id="imgAddFoto">
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
	</div>
</fieldset>
</form>
