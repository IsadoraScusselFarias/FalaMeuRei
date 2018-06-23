function confirmarAlterarStatusCarro(nome,id,tipo) {
	if (tipo=="1") {
		acao="inativar"
	}else{
		acao="restaurar"
	}
	if (confirm("Deseja "+acao+" o carro "+nome+"?")) {
		window.location.href="../Carro/ControllerCarro.php?acao=alterarStatus&id="+id+"&tipo="+tipo;
	};
}
function confirmarAlterarStatusCategoria(nome,id,tipo) {
	if (tipo=="1") {
		acao="inativar"
	}else{
		acao="restaurar"
	}
	if (confirm("Deseja "+acao+" a categoria "+nome+"?")) {
		window.location.href="../Categoria/ControllerCategoria.php?acao=alterarStatus&id="+id+"&tipo="+tipo;
	};
}
function confirmarAlterarStatusDespesa(nome,id,tipo) {
	if (tipo=="1") {
		acao="inativar"
	}else{
		acao="restaurar"
	}
	if (confirm("Deseja "+acao+" a despesa "+nome+"?")) {
		window.location.href="../Despesa/ControllerDespesa.php?acao=alterarStatus&id="+id+"&tipo="+tipo;
	};
}
function confirmarExclusaoDespesaMensal(nome,id) {
	if (confirm("Deseja inativar a despesa mensal "+nome+"?")) {
		window.location.href="../DespesaMensal/ControllerDespesaMensal.php?acao=excluir&id="+id;
	};
}
function confirmarExclusaoPedido(nome,id) {
	if (confirm("Deseja inativar o pedido"+nome+"?")) {
		window.location.href="../Pedido/ControllerPedido.php?acao=excluir&id="+id;
	};
}

function confirmarAlterarStatusPeca(nome,id,tipo) {
	if (tipo=="1") {
		acao="inativar"
	}else{
		acao="restaurar"
	}
	if (confirm("Deseja "+acao+" a peca "+nome+"?")) {
		window.location.href="../Peca/ControllerPeca.php?acao=alterarStatus&id="+id+"&tipo="+tipo;
	};
}
function confirmarAlterarStatusSucata(nome,id,tipo) {
	if (tipo=="1") {
		acao="inativar"
	}else{
		acao="restaurar"
	}
	if (confirm("Deseja "+acao+" a sucata "+nome+"?")) {
		window.location.href="../Sucata/ControllerSucata.php?acao=alterarStatus&id="+id+"&tipo="+tipo;
	};
}
