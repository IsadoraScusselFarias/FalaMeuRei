<html>
<head>
	<?php
		include_once '../Html/head.html';
	?>
</head>
<body>
	<header>
		<?php
			include_once '../Html/titulo.html';
		?>	
	</header>
	<nav>
		<?php
			include_once '../Html/menu.html';
		?>
	</nav>	
	<section>
	<div class="quadro">
		<div class="alinhaSucesso">
			<div class="tituloResultado"><?php echo $resposta; ?></div>
			<div class="linha">
				<?php
					echo"<div class='esquerdo'>Nome:</div><div class='meio'>".$model->getCliente()->getNomeCompleto()."</div>";
				?>
			</div>
			<div class="linha">
				<?php 
				if($model->getCliente()->getCpf()!=null){
						echo"<div class='esquerdo'>CPF:</div><div class='meio'>";
						echo $model->getCliente()->getCpf();
					}else{
						echo"<div class='esquerdo'>CNPJ:</div><div class='meio'>";
						echo $model->getCliente()->getCnpj();
					}
					echo"</div>";
				?>
			</div>
			<div class="linha">
				<div class="esquerdo">Data Orcamento:</div>
				<div class="meio">
					<?php echo $model->getDataOrcamento();?>
					
				</div>
			</div>
			<?php
				if($model->getDataVenda()!=null){
					echo"<div class='linha'>
						<div class='esquerdo'>Data Venda:</div>
						<div class='meio'>".$model->getDataVenda()."</div>
					</div>";
				}
			?>
			<div class="linha">
				<div class="esquerdo">Valor Total:</div>
				<div class="meio"><?php echo $model->getValor()-$model->getDesconto();?></div>
			</div>
			<div class="linha">
				<div class="esquerdo">Itens:</div>
			</div>
				<div class="linha">
					<?php
						if ($model->getItemVendaPeca()!=null) {
							echo"<div class='legenda'>Peças</div>";
							echo"<table class='itemCompraTabela'>";
							echo'<tr><th>Peça</th><th>Quantidade</th><th>Valor do Item</th>';
							if ($model->getVendaAprovada()=="0") {
								echo '<th>Itens Pendentes</th>';
							}
							echo '</tr>';
							foreach ($model->getItemVendaPeca() as $itemVendaPeca) {
								echo '<tr><td>'.$itemVendaPeca->getPeca()->getNome().'</td>';
								echo '<td>'. $itemVendaPeca->getQuantidade().'</td>';
								echo '<td>'.$itemVendaPeca->getValorTotal().'</td>';
								if ($model->getVendaAprovada()=="0") {
									if ($itemVendaPeca->getQuantidadePendente()>0) {
										echo '<td>'. $itemVendaPeca->getQuantidadePendente().'</td>';
									}else{
										echo '<td> - </td>';
									}
								}
								echo '</tr>';
							}
							echo'</table>';
						}
						if ($model->getItemVendaSucata()!=null) {
							echo"<div class='legenda'>Sucatas</div>";
							echo"<table class='itemCompraTabela'>";
							echo'<th>Sucata</th><th>Peça</th><th>Quantidade</th><th>Valor do Item</th>';
							foreach ($model->getItemVendaSucata() as $itemVendaSucata) {
								echo "<tr><td>".$itemVendaSucata->getSucata()->getLote()."/".$itemVendaSucata->getSucata()->getCarro()->getModelo()->getModelo()." ".$itemVendaSucata->getSucata()->getCarro()->getVersao()."/".$itemVendaSucata->getSucata()->getCarro()->getModelo()->getMarca()->getMarca()."/".$itemVendaSucata->getSucata()->getCarro()->getAno()."</td>";
								echo "<td>".$itemVendaSucata->getNomePeca()."</td>";
								echo "<td>".$itemVendaSucata->getQuantidade()."</td>";
								echo "<td>".$itemVendaSucata->getValorTotal()."</td>";
							}
							echo'</table>';
						}
					?>
				</div>
			</div>
			<div class="linhaBotao">
				<div class="embaixoBotoes">
					<?php
					if ($model->getVendaAprovada()=="0") {
						echo '<a href="ControllerOrcamento.php?acao=vender&status=2&id='.$model->getId().'"><div>Vender Todos os Itens</div></a>';
						echo '<a href="ControllerOrcamento.php?acao=vender&status=1&id='.$model->getId().'"><div>Vender os Itens em Estoque</div></a>';
						echo '<a href="../Index/ControllerIndex.php?acao=abrirIndex"><div>Cancelar Venda</div></a>';
					}else{
						echo '<a href="ControllerOrcamento.php?acao=abrirCadastro"><div>Cadastrar Novo</div></a>';
						if ($model->getStatus()!="1") {
							echo '<a href="ControllerOrcamento.php?acao=vender&status=0&id='.$model->getId().'"><div>Vender</div></a>';
						}
						if (!$erro) {
							echo '<a href="ControllerOrcamento.php?acao=editar&id="'.$model->getId().'"><div>Alterar</div></a>';
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
	</section>
	<footer>
		<?php
			include_once '../Html/rodape.html';
		?>
	</footer>
</body>
</html>
