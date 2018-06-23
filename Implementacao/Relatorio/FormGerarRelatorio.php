<form action="ControllerRelatorio.php" method="POST" onsubmit="validaRelatorio()">
<fieldset class="quadro">
	<legend class="legenda">Gerar Relatórios</legend>
	<div class="corpo">
		<div class="linha">
			<div class="centro">Selecione o período e o tipo de relatório:</div>
		</div>
		<div class="linha">
			<div class="esquerdo">Tipo:</div>
			<div class="meio">
				<select name="tipoRelatorio" >
					<option>--Selecione--</option>
					<option value="compras">Compras</option>
					<option value="vendas">Vendas</option>
					<option value="despesas">Despesas</option>
					<option value="fluxo">Fluxo de Caixa</option>
				</select>
			</div>
		</div>
		<div class="linha">
			<div class="esquerdo">Período:</div>
			<div class="meio">
				<select id="periodo" name="periodo">
					<option value="">--Selecione--</option>
					<option value="1">Diário</option>
					<option value="2">Mensal</option>
					<option value="3">Por período</option>
				</select>
			</div>
		</div>
		<div id="periodoDiario" class="periodicidade">
			<div class="linha">
				<div class="esquerdo">Dia:</div>
				<div class="meio"><input type="text" id="data" class="data" name="dia"	/></div>
				<div id="errorData"></div>
			</div>
		</div>
		<div id="periodoMensal" class="periodicidade">
			<div class="linha">
				<div class="esquerdo">Ano:</div>
				<div class="meio">
				<select name="ano" id="ano">
					<option value="">Selecione o Ano</option>
				</select>
				</div>
			</div>
			<div class="linha">
				<div class="esquerdo">Mês:</div>
				<div class="meio">
					<select name="mes" id="mes">
						<option value="">Selecione o Mês</option>
						<option value="1">Janeiro</option>
						<option value="2">Fevereiro</option>
						<option value="3">Março</option>
						<option value="4">Abril</option>
						<option value="5">Maio</option>
						<option value="6">Junho</option>
						<option value="7">Julho</option>
						<option value="8">Agosto</option>
						<option value="9">Setembro</option>
						<option value="10">Outubro</option>
						<option value="11">Novembro</option>
						<option value="12">Dezembro</option>
					</select>
				</div>
			</div>
			<div id="errorAnoMes"></div>
		</div>
		<div id="periodoNaoDefinido" class="periodicidade">
			<div class="linha">
				<div class="esquerdo">Data inicial:</div>
				<div class="meio"><input type="text" id="dataInicial" class="dataPeriodo" name="dataInicial"/></div>
			</div>
			<div class="linha">
				<div class="esquerdo">Data final:</div>
				<div class="meio"><input type="text" id="dataFinal" class="dataPeriodo" name="dataFinal"/></div>
			</div>
		</div>
		<div class="linhaBotao">
			<div class="embaixoBotoes">
				<input type="submit" value="Gerar">
				<input type="hidden" name="acao" value="gerar">
			</div>
		</div>
	</div>
</fieldset>
</form>

