<form action="ControllerCarro.php" method="POST" id="formCarroCrud" onsubmit="validaCarro()">
<fieldset class="quadro" id="cadastroCarro">
<legend class="legenda">Alteração de Carros</legend>
<div class="corpo">
	<div class="linha">
			<div class="esquerdo"><label for="idMarca">Marca:</label></div>
			<div class="meio">
				<select id="idMarca" name="idMarca">
					<?php 
						echo "<option value=''>--selecione--</option>";
						if (isset($vetMarca)) {
							foreach ($vetMarca as $marca) {
								echo "<option value='".$marca->getId()."'";
								if ($marca->getId()==$model->getModelo()->getMarca()->getId()) {
									echo "selected";
								}
								echo ">".$marca->getMarca()."</option>";
							}
						}
					?>
				</select>
				<div id="formMarca">
					<input type="text" id="marca" name="marca">
				</div>
			</div>
			<div class="direita">
				<img src="../Image/add.png" id="addMarca" class="cadNovo">
				<img src="../Image/sub.png" id="subMarca" class="cadNovo">
			</div>
			<div class="centro" id="errorMarca"></div>
		</div>
		
		<div class="linha">
			<div class="esquerdo"><label for="idModelo">Modelo:</label></div>
			<div class="meio">
				<select id="idModelo" name="idModelo">
					<?php 
						echo "<option value=''>--selecione--</option>";
						if (isset($vetModelo)) {
							foreach ($vetModelo as $modelo) {
								echo "<option value='".$modelo->getId()."'";
								if ($modelo->getId()==$model->getModelo()->getId()) {
									echo "selected";
								}
								echo ">".$modelo->getModelo()."</option>";
							}
						}
					?>
				</select>
				<div id="formModelo">
					<input type="text" id="modelo" name="modelo">
				</div>
			</div>
			<div class="direita">
				<img src="../Image/add.png" id="addModelo" class="cadNovo">
				<img src="../Image/sub.png" id="subModelo" class="cadNovo">
			</div>
			<div class="centro" id="errorModelo"></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="ano">Ano:</label></div>
			<div class="meio"><input type="text" name="ano" id="ano" value="<?php echo($model->getAno());?>" class="required digits"/></div>
			
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="ano">Versão:</label></div>
			<div class="meio"><input type="text" name="versao" id="versao" value="<?php echo($model->getVersao());?>" class="required"/></div>
			
		</div>
		<div>
			<div class="linhaBotao">
				<div class="embaixoBotoes">
					<input type="submit" value="Alterar">
					<input type="reset" value="Desfazer">
					<input type="hidden" name="id" value="<?php echo($model->getId());?>">
					<input type="hidden" name="acao" value="atualizar">
				</div>
			</div>
		</div>
	</div>
</fieldset>
</form>
