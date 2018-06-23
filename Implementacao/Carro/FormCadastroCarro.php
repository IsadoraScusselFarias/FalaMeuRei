<form action="ControllerCarro.php" method="POST" id="formCarroCrud" onsubmit="validaCarro()">
<fieldset class="quadro">
	<legend class="legenda">Cadastro de Carros</legend>
	<div class="corpo">
		<div class="linha">
			<div class="esquerdo"><label for="idMarca">Marca:</label></div>
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
				<img src="../Image/add.png" id="addMarca" class="cadNovo">
				<img src="../Image/sub.png" id="subMarca" class="cadNovo">
			</div>
			<div  id="errorMarca"></div>
		</div>
		
		<div class="linha">
			<div class="esquerdo"><label for="idModelo">Modelo:</label></div>
			<div class="meio">
				<select id="idModelo" name="idModelo">
					<option value="">--Selecione--</option>
				</select>
				<div id="formModelo">
					<input type="text" id="modelo" name="modelo">
				</div>
			</div>
			<div class="direita">
				<img src="../Image/add.png" id="addModelo" class="cadNovo">
				<img src="../Image/sub.png" id="subModelo" class="cadNovo">
			</div>
			<div  id="errorModelo"></div>
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="ano">Ano:</label></div>
			<div class="meio"><input type="text" name="ano" id="ano" class="required digits"/></div>
			
		</div>
		<div class="linha">
			<div class="esquerdo"><label for="ano">Versão:</label></div>
			<div class="meio"><input type="text" name="versao" id="versao" class="required"/></div>
			
		</div>
		<div  id="errorCarro"></div>
		<div>
			<div class="linhaBotao">
				<div class="embaixoBotoes">
					<input type="submit" value="Cadastrar">
					<input type="hidden" name="acao" value="cadastrar">
				</div>
			</div>
		</div>
	</div>
</fieldset>
</form>
