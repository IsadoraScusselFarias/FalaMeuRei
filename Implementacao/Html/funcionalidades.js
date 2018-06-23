var acaoPeca=0;
var acaoSucata=0;
var modal=0;
$(function () {
	if (modal==1) {
		$('.popup-modal').magnificPopup({
			type: 'inline',
			preloader: false,
			focus: '#username',
			modal: true
		});
		$(document).on('click', '.popup-modal-dismiss', function (e) {
			e.preventDefault();
			$.magnificPopup.close();
		});
	};
}); 
$(document).ready(function(){
//-----------------------------QuadrinhoClick--------------------------------------------
	d = new Date();
	ano=d.getFullYear();
	for (var i = ano; i >= 2014; i--) {
		$('<option value="'+i+'">'+i+'</option>').appendTo("#ano");
	};
	$(".consultarClick").hide();
	$(".clicaConsulta").click(function(){
		$(".consultarClick").show("slow");
		$(".clicaConsulta").hide("slow");
	}); 
	$(".xis").click(function(){
		$(".consultarClick").hide("slow");
		$(".clicaConsulta").show("slow");
	}); 
	$('#estado').change(function(){
		if( $(this).val() ) {
			$.getJSON('../Cidade/ConsultarCidade.ajax.php?estado=',{estado: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value="">--Selecione--</option>';	
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].idtbCidade + '">' + j[i].cidade + '</option>';
				}	
				$('#cidade').html(options);
			});
		} else {
			$('#cidade').html('<option value="">-- Escolha um estado --</option>');
		}
	});
//----------------------------------------Sucata e Peça Compra---------------------------------
	$("#imgSucataCancel").hide();
		$("#imgPecaCancel").hide();
		$("#formDePeca").hide();
		$("#formDeSucata1").hide();
		$("#formDeSucata2").hide();
		var sp="0";
		var ss="0";
		$("#peca").click(function(){
			if ((sp=="0")&&(ss=="0")) {
				$("#formDePeca").show();
				$("#imgPecaAdd").hide();
				$("#imgPecaCancel").show();
				sp="1";
			}else{
				if (sp=="1") {
					$("#formDePeca").hide();
					$("#imgPecaAdd").show();
					$("#imgPecaCancel").hide();
					sp="0";
				};
			};
		});
		$("#sucata").click(function(){
			if ((sp=="0")&&(ss=="0")) {
				$("#formDeSucata1").show();
				$("#formDeSucata2").show();
				$("#imgSucataAdd").hide();
				$("#imgSucataCancel").show();
				ss="1";
			}else{
				if (ss=="1") {
					$("#formDeSucata1").hide();
					$("#formDeSucata2").hide();
					$("#imgSucataAdd").show();
					$("#imgSucataCancel").hide();
					ss="0";
				};
			};
		});
//---------------------------------------------------------------------------------------------
	statusCompra=0;
	$("#formSucataCompra").hide();
	$("#formPecaCompra").hide();
	$("#upS").hide();
	$("#upP").hide();
	$("#downS").click(function(){
		if (statusCompra==0) {
			$("#formSucataCompra").show("slow");
			$("#upS").show();
			$("#downS").hide();
			statusCompra=1;
		};
	});
	$("#upS").click(function(){
		if (statusCompra==1) {
			$("#formSucataCompra").hide("slow");
			$("#upS").hide();
			$("#downS").show();
			statusCompra=0;
		};
	});
	statusCompraPeca=0;
	$("#downP").click(function(){
		if (statusCompra==0) {
			$("#formPecaCompra").show("slow");
			$("#upP").show();
			$("#downP").hide();
			if (statusCompraPeca==0) {
				$.getJSON('../Peca/ConsultarPeca.ajax.php',{ajax: 'true'}, function(j){
					var options = '<option value="">--Selecione--</option>';	
					for (var i = 0; i < j.length; i++) {
						options += '<option value="' + j[i].idtbPeca + '">' + j[i].nome  +"/"+j[i].carro+ '</option>';
					}	
					$("<tr><td><select name='peca[]'>"+options+"</select></td><td><input type='number' id='quantidade' name='quantidadePeca[]'><input type='hidden' name='quantidadePecaAnterior[]' value='0'></td><td><input type='text' id='valorPeca' name='valorPeca[]'></td><td><img src='../Image/sub.png' class='remove'></td></tr>").appendTo('#tabelaPeca');
				});
				statusCompraPeca=1;
			};
			statusCompra=1;
		};
	});
	$("#upP").click(function(){
		if (statusCompra==1) {
			$("#formPecaCompra").hide("slow");
			$("#upP").hide();
			$("#downP").show();
			statusCompra=0;
		};
	});
//---------------------------------------------------------------------------------------------
	$("#formMarca").hide();
	$("#subMarca").hide();
	$("#formModelo").hide();
	$("#subModelo").hide();
	statusMarca=0;
	statusModelo=0;
	$("#addMarca").click(function(){
		statusMarca=1;
		statusModelo=1;
		$("#formMarca").show();
		$("#subMarca").show();
		$("#addMarca").hide();
		$("#idMarca").hide();
		$("#idMarca").val("");
		$("#idModelo").hide();
		$("#idModelo").val("");
		$("#formModelo").show();
		$("#subModelo").show();
		$("#addModelo").hide();
		$("#errorMarca").text("");
		$("#errotModelo").text("");
	});
	$("#subMarca").click(function(){
		statusMarca=0;
		statusModelo=0;
		$("#formMarca").hide();
		$("#idMarca").show();
		$("#idModelo").show();
		$("#formModelo").hide();
		$("#subMarca").hide();
		$("#addMarca").show();
		$("#subModelo").hide();
		$("#addModelo").show();
		$("#marca").val("");
		$("#modelo").val("");
		$("#errotMarca").text("");
		$("#errotModelo").text("");
	});
	$("#addModelo").click(function(){
		statusModelo=0;
		$("#formModelo").show();
		$("#idModelo").hide();
		$("#idModelo").val("");
		$("#subModelo").show();
		$("#addModelo").hide();
		$("#errorModelo").text("");
	});
	$("#subModelo").click(function(){
		statusModelo=0;
		$("#formModelo").hide();
		$("#subModelo").hide();
		$("#idModelo").show();
		$("#addModelo").show();
		$("#modelo").val("");
		$("#errotModelo").text("");
	});
	$('#idMarca').change(function(){
		if( $(this).val() ) {
			$.getJSON('../Modelo/ConsultarModelo.ajax.php?marca=',{marca: $(this).val(), ajax: 'true'}, function(j){
				var options = '<option value="">--Selecione--</option>';	
				for (var i = 0; i < j.length; i++) {
					options += '<option value="' + j[i].idtbModelo + '">' + j[i].modelo + '</option>';
				}	
				$('#idModelo').html(options);
			});
		} else {
			$('#idModelo').html('<option value="">-- Escolha uma Marca --</option>');
		}
	});




//--------------------------------AdicionarCarro-------------------------------------------
	$("#cadastrarCliente").click(function(){
		//if (validaCliente()) {
			$.getJSON('../Cliente/CadastrarCliente.ajax.php?',{emailCliente:$("#emailCliente").val(),cpf:$("#cpf").val(),cnpjCliente:$("#cnpjCliente").val(),nomeCompleto:$("#nomeCompleto").val(),endereco:$("#endereco").val(),telefone:$("#telefone").val(),cidade:$("#cidade").val(),ajax: 'true'}, function(res){
				console.log(res);
				if (res=="erro") {
					alert("Erro ao cadastrar");
				}else{
					$("<option value="+res.id+" selected >"+res.nome+"-"+res.pessoa+"</option>").appendTo("#idCliente");
					$.magnificPopup.close();
				}
			});
		//}
	});
	$("#cadastrarFornecedor").click(function(){
		//if (validaFornecedor()) {
			$.getJSON('../Fornecedor/CadastrarFornecedor.ajax.php?',{emailFornecedor:$("#emailFornecedor").val(),cnpjFornecedor:$("#cnpjFornecedor").val(),nome:$("#nome").val(),endereco:$("#endereco").val(),telefone:$("#telefone").val(),cidade:$("#cidade").val(),ajax: 'true'}, function(res){
				if (res=="erro") {
					alert("Erro ao cadastrar");
				}else{
					$("<option value="+res.id+" selected >"+res.nome+"-"+res.pessoa+"</option>").appendTo("#idFornecedor");
					$.magnificPopup.close();
				}
			});
		//}
	});
	$("#cadastrarPeca").click(function(){
		//if (validaPeca()) {
			$.getJSON('../Peca/CadastrarPeca.ajax.php?',{nomePeca:$("#nomePeca").val(),preco:$("#preco").val(),carro:$("#carro").val(),descricao:$("#descricao").val(),ajax: 'true'}, function(res){
				if (res=="erro") {
					alert("Erro ao cadastrar");
				}else{
					$.magnificPopup.close();
				}
			});
		//}
	});
	$("#cadastrarCarro").click(function(){
		if (validaCarro()) {
			$.getJSON('../Carro/CadastrarCarro.ajax.php?',{idModelo:$("#idModelo").val(),modelo:$("#modelo").val(),idMarca:$("#idMarca").val(),marca:$("#marca").val(),ano:$("#ano").val(),versao:$("#versao").val(),ajax: 'true'}, function(res){
				if (res=="erro") {
					alert("Erro ao cadastrar");
				}else{
					$("<option value="+res.id+" selected >"+res.modelo+" "+res.versao+"/"+res.marca+"/"+res.ano+"</option>").appendTo("#carro");
					$.magnificPopup.close();
				}
			});
		}
	});
	$("#cadastrarCategoria").click(function(){
		if (validaCategoria()) {
			$.getJSON('../Categoria/CadastrarCategoria.ajax.php?',{nome:$("#nomeCategoria").val(),descricao:$("#descricao").val(),ajax: 'true'}, function(res){
				if (res=="erro") {
					alert("Erro ao cadastrar");
				}else{
					$("<tr><td><input name='categoria[]' type='checkbox' checked value="+res.id+"></td><td>"+res.nome+"</td></tr>").appendTo("#tabelaCategoria");
					$.magnificPopup.close();
				}
			});
		}
	});
	$("#imgAddFoto").click(function(){
		$('<tr><td><input type="file" class="foto" name="foto[]"></td><td><img src="../Image/sub.png" class="iconeExcluir excluirFoto"></td></tr>').appendTo('#tabelaFoto');
		//$('<tr><td><input type="file" class="foto" name="foto[]"><img src="../Image/sub.png" class="iconeExcluir excluirFoto"></td></tr>').appendTo('#tabelaFoto');
	});
	$(".refreshImagem").hide();
	$(".subImagem").click(function(){
		$(this).hide();
		$(this).prev().prev().val("0");
		$(this).prev().show();
	});
	$(".refreshImagem").click(function(){
		$(this).hide();
		$(this).prev().val("1");
		$(this).next().show();
	});
//----------------------------------Pessoa---------------------------------------------------
	$("#cnpjBox").hide();
	$("#cpfBox").hide();
	$("#pessoaF").click(function(){
		$("#cpfBox").show();
		$("#cnpjBox").hide();
		$("#cnpjCliente").val("");
		$("#errorPessoa").val("");
	});
	$("#pessoaJ").click(function(){
		$("#cpfBox").hide();
		$("#cnpjBox").show();
		$("#cpf").val("");
		$("#errorPessoa").val("");
	});
	$("#pessoaFAlt").click(function(){
		$("#cpfBoxAlt").show();
		$("#cnpjBoxAlt").hide();
		$("#cnpjCliente").val("");
		$("#errorPessoa").val("");
	});
	$("#pessoaJAlt").click(function(){
		$("#cpfBoxAlt").hide();
		$("#cnpjBoxAlt").show();
		$("#cpf").val("");
		$("#errorPessoa").val("");
	});
//--------------------------------AdicionarCompra--------------------------------------------
	if (acaoPeca==0) {
		$("#tabelaPeca").hide();
		$("#nomeTabelaPeca").hide();
	}
	if (acaoSucata==0) {
		$("#tabelaSucata").hide();
		$("#nomeTabelaSucata").hide();
	}
	$("#addPecaCompra").click(function(){
		$.getJSON('../Peca/ConsultarPeca.ajax.php',{ajax: 'true'}, function(j){
			var options = '<option value="">--Selecione--</option>';	
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].idtbPeca + '">' + j[i].nome +"/"+j[i].carro+ '</option>';
			}	
			$("<tr><td><select class='selectPeca' name='peca[]'>"+options+"</select></td><td><input type='number' class='quantidade' name='quantidadePeca[]'><input type='hidden' name='quantidadePecaAnterior[]' value='0'></td><td><input type='text' class='valorParcial' name='valorPeca[]'></td><td><img src='../Image/sub.png' class='remove'></td></tr>").appendTo('#tabelaPeca');
		});
	});
	$("#addPeca").click(function(){
		$("#tabelaPeca").show();
		$("#nomeTabelaPeca").show();
		$.getJSON('../Peca/ConsultarPeca.ajax.php',{ajax: 'true'}, function(j){
			var options = '<option value="">--Selecione--</option>';	
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].idtbPeca + '">' + j[i].nome +"/"+j[i].carro+ '</option>';
			}	
			$("<tr class='itemPeca'><td><select class='selectPeca' name='peca[]'>"+options+"</select></td><td class='valorUnitario'></td><td class='quantidadeExistente'></td><td><input type='number' class='quantidade' name='quantidadePeca[]'></td><td><input type='text' class='valorParcial' name='valorPeca[]'></td><td><img src='../Image/sub.png' class='remove'></td><td class='errorItem'></td></tr>").appendTo('#tabelaPeca');
		});
	});
	$("#addSucata").click(function(){
		$("#tabelaSucata").show();
		$("#nomeTabelaSucata").show();
		$.getJSON('../Sucata/ConsultarSucata.ajax.php',{ajax: 'true'}, function(j){
			var options = '<option value="">--Selecione--</option>';	
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].idtbSucata + '">' + j[i].lote+"/"+j[i].carro+ '</option>';
			}	
			$("<tr class='itemSucata'><td><select class='selectSucata'name='sucata[]'>"+options+"</select><span class='verPecasRetiradas'>ver</span></td><td><input type='text' class='pecaSucata' name='pecaSucata[]'/></td><td><input type='number' class='quantidade' name='quantidadeSucata[]'></td><td><input type='text' class='valorParcial' name='valorSucata[]'></td><td><img src='../Image/sub.png' class='remove'></td><td class='errorItem'></td></tr>").appendTo('#tabelaSucata');
		});
	});
	$("table").on("change",".selectPeca", function(){
		selectPeca=$(this);
		if(selectPeca.val()!="") {
			$.getJSON('../Peca/ConsultarPecaPrecoQuantidade.ajax.php',{idPeca: $(this).val(), ajax: 'true'}, function(res){
				$(selectPeca).parent().next().html(res.preco);
				$(selectPeca).parent().next().next().html(res.quantidade);
			});
		} else {
			$(this).parent().next().html("");
			$(this).parent().next().next().html("");
		}		
	});
	$("table").on("click",".verPecasRetiradas",function(){
		$.getJSON('../Sucata/ConsultarPecasRetiradasSucata.ajax.php?',{sucata:$(this).prev().val(),ajax: 'true'}, function(j){
			pecas="";
			if (j=="Nenhuma Peca Retirada") {
				pecas=j;
			}else{
				for (var i = 0; i < j.length; i++) {
					pecas += "<li>"+j[i]+"</li>";
				}
			}	
			$("#pecasRetiradas").html(pecas);	
		});
	});
	$("#imgSucataCancel").hide();
	$("#imgPecaCancel").hide();
	$("#formDePeca").hide();
	$("#formDeSucata1").hide();
	$("#formDeSucata2").hide();
	var sp="0";
	var ss="0";
	$("#peca").click(function(){
		if ((sp=="0")&&(ss=="0")) {
			$("#formDePeca").show();
			$("#imgPecaAdd").hide();
			$("#imgPecaCancel").show();
			sp="1";
		}else{
			if (sp=="1") {
				$("#formDePeca").hide();
				$("#imgPecaAdd").show();
				$("#imgPecaCancel").hide();
				sp="0";
			};
		};
	});
	$("#sucata").click(function(){
		if ((sp=="0")&&(ss=="0")) {
			$("#formDeSucata1").show();
			$("#formDeSucata2").show();
			$("#imgSucataAdd").hide();
			$("#imgSucataCancel").show();
			ss="1";
		}else{
			if (ss=="1") {
				$("#formDeSucata1").hide();
				$("#formDeSucata2").hide();
				$("#imgSucataAdd").show();
				$("#imgSucataCancel").hide();
				ss="0";
			};
		};
	});
	$("#formClienteOrcamento").hide();
	$("#subCliente").hide();
	$(".linhaNovaCliente").hide();
	$("#addCliente").click(function(){
		$("#formClienteOrcamento").show();
		$("#subCliente").show();
		$("#addCliente").hide();
		$("#idCliente").hide();
		$(".linhaNovaCliente").show();
	});
	$("#subCliente").click(function(){
		$("#formClienteOrcamento").hide();
		$("#subCliente").hide();
		$("#addCliente").show();
		$("#idCliente").show();
		$(".linhaNovaCliente").hide();
	});
	$("#tabelaFoto").on("click",".excluirFoto", function(){
    	$(this).closest("tr").remove();
	});
	$("table").on("click",".remove", function(){
    	$(this).closest("tr").remove();
    	qtdP=0;
    	$(".itemPeca").each(function(){
    		qtdP++;
    	});
    	if (qtdP==0) {
    		$("#tabelaPeca").hide();
			$("#nomeTabelaPeca").hide();
    	};
    	qtdS=0;
    	$(".itemSucata").each(function(){
    		qtdS++;
    	});
    	if (qtdS==0) {
    		$("#tabelaSucata").hide();
			$("#nomeTabelaSucata").hide();
    	};
	});
	$("table").on("change",".valorParcial", function(){
		var soma=0;
    	$(".valorParcial").each( function() {
        	soma += Number($(this).val());
    	});
    	$("#valorTotal").val(soma);
    	$("#valorFinal").val(soma);
	});
	$("#descontoPorcentagem").change(function(){
		$("#valorFinal").val($("#valorFinal").val()*(100-$("#descontoPorcentagem").val())/100);
		$("#descontoTotal").text($("#valorTotal").val()-$("#valorFinal").val());
		$("#descontoValor").val($("#valorTotal").val()-$("#valorFinal").val());
	});
	$("#valorFinal").change(function(){
		$("#descontoValor").val($("#valorTotal").val()-$("#valorFinal").val());
	});
	$(".periodicidade").hide();
	$("#periodo").change(function(){
		$(".periodicidade").hide();
		i=1;
		r=$(this).val();
		$(".periodicidade").each(function () {
			if (r==i) {
				$(this).show();
			};
			i++;
		});
	});
	$("#detalhado").hide();
	$("#grafico").hide();
	$(".menu").click(function(){
		$("#padrao").hide();
		$("#detalhado").hide();
		$("#grafico").hide();
		if ($(this).val()=="padrao") {
			$("#padrao").show();
		}else{
			if ($(this).val()=="detalhado") {
				$("#detalhado").show();
			}else{
				$("#grafico").show();
			}
		}
	});
});