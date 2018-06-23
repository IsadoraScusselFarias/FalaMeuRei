var sucataAprovado;
var clientePessoaAprovado=true;
var clienteEmailAprovado=true;
function validaCarro(){
	$("#errorMarca").text("");
	$("#errorModelo").text("");
	$("#errorAno").text("");
	$("#errorVersao").text("");
	var modelo= true;
	var marca = true;
	var versao= true;
	var ano=true;
	var carroAprovado=true;
	$.getJSON('../Carro/VerificaCarro.ajax.php',{idModelo:$("#idModelo").val(),modelo:$("#modelo").val(),idMarca:$("#idMarca").val(),marca:$("#marca").val(),ano:$("#ano").val(),versao:$("#versao").val(),ajax: 'true'}, function(res){
		if (!res) {
			carroAprovado=false;
			console.log("Carro"+carroAprovado);
			$("#errorCarro").text("Carro já cadastrado");
		};
	});
	alert("oi");
	if(statusMarca==1){
        if($("#marca").val()==""){
            $("#errorMarca").text("É necessário a entrada de uma Marca.");
            if($("#modelo").val()==""){
                $("#errorModelo").text("É necessário a entrada de um Modelo.");
                modelo = false;
            }
            marca = false;
        }else{
        	marca= marcaAprovada;
        	modelo=modeloAprovado;
        }
    }else{
        if($("#idMarca").val()==""){
            $("#errorMarca").text("É necessário a seleção de uma Marca.");
            if((statusModelo==0)&&($("#idModelo").val()=="")){
                $("#errorModelo").text("É necessário a seleção de um Modelo.");
                modelo = false;
            }else{
            	if($("#modelo").val()==""){
               		$("#errorModelo").text("É necessário a entrada de um Modelo.");
                	modelo = false;
            	}else{
            		modelo= modeloAprovado;
            	}
            }
            modelo = false;
        }else{
        	if((statusModelo==0)&&($("#idModelo").val()=="")){
                $("#errorModelo").text("É necessário a seleção de um Modelo.");
                modelo = false;
            }
        }
    }
    if($("#ano").val()=="") {
		$("#errorAno").text("É necessário a entrada de um Ano válido.");
		ano = false;
    };
    if($("#versao").val()=="") {
		$("#errorVersao").text("É necessário a entrada de uma Versão.");
		versao = false;
    }; 
	if(!(modelo&&marca&&ano&&versao&&carroAprovado)){
		alert("não pode enviar")
	};
    return modelo&&marca&&ano&&versao&&carroAprovado;
}
function validaCategoria(){
	nome= true;
	$("#errorNomeCategoria").text("");
    if($("#nomeCategoria").val()=="") {
		$("#errorNomeCategoria").text("É necessário a entrada de um Nome.");
		var nome = false;
    }
    if(!(nome&&categoriaAprovada)){
		alert("não pode enviar")
	};
    return nome&&categoriaAprovada;
}
function validaCliente(){
	alert("sdafsd");
	alert(clienteEmailAprovado);
	alert(clientePessoaAprovado);
	if(!(clienteEmailAprovado&&clientePessoaAprovado)){
		alert("não pode enviar")
	};
	return clienteEmailAprovado&&clientePessoaAprovado;
}
function validaUsuario(){
	if(!usuarioAprovado){
		alert("não pode enviar")
	};
	return usuarioAprovado;
}
function validaFornecedor(){
	if(!(fornecedorCnpjAprovado&&fornecedorEmailAprovado)){
		alert("não pode enviar")
	};
	return fornecedorCnpjAprovado&&fornecedorEmailAprovado;
}
function validaPeca(){
	if(!pecaAprovada){
		alert("não pode enviar")
	};
	return pecaAprovada;
}
function validaSucata(){
	if(!sucataAprovado){
		alert("não pode enviar")
	};
	return sucataAprovado;
}
function validaFoto(){
	$(".foto").each(function(){
		if($(this).val()== ""){
			$(this).parent().parent().remove();
		}else{
			ext = $(this).val().split(".")[1].toLowerCase();
			if ((ext!="png")&&(ext!="jpg")&&(ext!="jpeg")&&(ext!="gif")) {
				$(this).parent().parent().remove();
			}
		}
	});
}
function validaItens(){
	verifica=true;
	cont=0;
	qtdP=0;
	$(".itemPeca").each(function(){
		itemPeca=$(this);
		if((itemPeca.find(".selectPeca").val()=="")&&(itemPeca.find(".quantidade").val()<1)&&(itemPeca.find(".valorParcial").val()<1)){
			$(this).remove();
		}else{
			qtdP++;
			cont++;
			if ((itemPeca.find(".selectPeca").val()=="")||(itemPeca.find(".quantidade").val()<1)||(itemPeca.find(".quantidade").val()<itemPeca.find(".quantidadeExistente").text())||(itemPeca.find(".valorParcial").val()<1)) {
				itemPeca.find(".errorItem").text("Item incompleto ou preencido de forma errada");
				verifica=verifica&&false;
			}else{
				itemPeca.find(".errorItem").text("");
			}
		}
	});
	if (qtdP==0) {
		$("#tabelaPeca").hide();
		$("#nomeTabelaPeca").hide();
	};
	qtdS=0;
	$(".itemSucata").each(function(){
		itemSucata=$(this);
		if((itemSucata.find(".selectSucata").val()=="")&&(itemSucata.find(".pecaSucata").val()=="")&&(itemSucata.find(".quantidade").val()=="")&&(itemSucata.find(".valorParcial").val()=="")){
			$(itemSucata).remove();
		}else{
			cont++;
			qtdS++;
			if ((itemSucata.find(".selectSucata").val()=="")||(itemSucata.find(".pecaSucata").val()=="")||(itemSucata.find(".quantidade").val()<1)||(itemSucata.find(".valorParcial").val()<1)) {
				itemSucata.find(".errorItem").text("Item incompleto ou preencido de forma errada");
				verifica=verifica&&false;
			}
		}
	});
	if (qtdS==0) {
		$("#tabelaSucata").hide();
		$("#nomeTabelaSucata").hide();
	};
	if (cont==0) {
		$("#errorItemGeral").text("Entre com um item");
		verifica=verifica&&false;
	}else{
		$("#errorItemGeral").text("");
	}
	if(!verifica){
		alert("não pode enviar")
	};
	return verifica;
}
function validaData(){
	data = $("#data").val().split("/");
	d = new Date();
	var res = true;
	if (data[2]>d.getFullYear()) {
		$("#errorData").text("Entre com uma data valida");
		res = false;
	}else{
		if (data[2]==d.getFullYear()) {
			if (data[1]>(d.getMonth()+1)) {
				$("#errorData").text("Entre com uma data valida");
				res = false;
			}else{
				if (data[1]==(d.getMonth()+1)) {
					if (data[0]<d.getDate()) {
						$("#errorData").text("Entre com uma data valida");
						res = false;
					}
				};
			}
		};
	}
	if(!res){
		alert("não pode enviar");
	};
}
function validaRelatorio(){
	res = true;
	d = new Date();
	if ($("#periodo").val()=="1") {
		res = validaData();
	}else{
		if ($("#periodo").val()=="2") {
			if (($("#ano").val()==d.getFullYear())&&($("#mes").val()>(d.getMonth()+1))) {
				$("errorAnoMes").text("Entre com um mes até o corrente");
				res = false;
			}
		}else{
			dataI=$("#dataInicial").val().split("/");
			dataF=$("#dataFinal").val().split("/");
			if ((dataF[0]>d.getFullYear())||(dataI[0]>dataF[0])) {
				$("#errorData").text("Entre com uma data valida");
				res = false;
			}else{
				if ((dataF[0]==d.getFullYear())||(dataI[0]==dataF[0])) {
					if ((dataF[1]>(d.getMonth()+1))||(dataI[1]>dataF[1])) {
						$("#errorData").text("Entre com uma data valida");
						res = false;
					}else{
						if ((dataF[1]==(d.getMonth()+1))||(dataI[1]==dataF[1])) {
							if ((dataF[2]>d.getDate())||(dataI[2]>dataF[2])) {
								$("#errorData").text("Entre com uma data valida");
								res = false;
							}
						};
					}
				};
			}	
		}
	}
	if(!res){
		alert("não pode enviar");
	};
}
$(document).ready(function(){
	$("#telefone").mask("(99)9999-9999");
    $("#cpf").mask("999.999.999-99");
    $("#cnpjCliente").mask("99.999.999/9999-99");
    $("#cnpjFornecedor").mask("99.999.999/9999-99");
	$("#formUsuario").validate({
		rules:{
			senha:{
				minlength:8
			},
			confirmarSenha:{
				equalTo:"#senha"
			}
		}
	});
	$("#formCategoria").validate({
		rules:{
			nome:{
				maxlength:45
			}
		}
	});
	$("#formCarroCrud").validate({
			rules:{
			ano:{
				min:1900
			},
			versao:{
				maxlength:45
			}
		}
  	});
	$("#formCliente").validate({
		rules: {
		    email:{
		    	maxlength:45
		    },
		    nomeCompleto:{
		    	maxlength:45
		    },
		    endereco:{
		    	maxlength:45
		    },
		    telefone:{
		    	maxlength:15
		    },
		    cpf:{
		    	maxlength:15
		    },
		    cnpj:{
		    	maxlength:20
		    }
		}
	});
	$("#formFornecedor").validate({
		rules: {
		    email:{
		    	maxlength:45
		    },
		    nome:{
		    	maxlength:45
		    },
		    endereco:{
		    	maxlength:45
		    },
		    telefone:{
		    	maxlength:15
		    },
		    cnpj:{
		    	maxlength:20
		    }
		}
	});
	$("#formDespesa").validate({
  		rules:{
			nome:{
				maxlength:45
			}
		}
  	});
  	$("#formPeca").validate({
  		rules:{
			nome:{
				maxlength:45
			},
			quantidade:{
				min:0
			},
			valor:{
				min:0
			}
		}
  	});
  	$("#formSucata").validate({
  		rules:{
			lote:{
				maxlength:45
			},
			leilao:{
				maxlength:45
			}
		}
  	});
  	$("#formCompra").validate({
  		rules:{
			valor:{
				min:0
			}
		}
  	});
  	$("#formOrcamento").validate({
  		rules:{
			valorTotal:{
				min:0
			}
		}
  	});
	$("#formPeca").submit(function(){
        if($("#idCarro")==""){
            $("#errorCarro").text("É necessário a seleção de um Carro.");
            return false;
        }
	});
	$("#formPeca").submit(function(){
        if($("#idCarro")==""){
            $("#errorCarro").text("É necessário a seleção de um Carro.");
            return false;
        }
	});
	$("#formOrcamento").submit(function(){
	    rules:{
			valorTotal:{
				min:0
			}
		}
	});
	$('#cpf').change(function(){
		$("#errorPessoa").text("");
		if($(this).val()){
			$.getJSON('../Cliente/VerificaCliente.ajax.php?',{cpf: $(this).val(), cnpj : "",email:"", ajax: 'true'}, function(res){
				clientePessoaAprovado = res;
				if (!res) {
					$("#errorPessoa").text("CPF já cadastrado");
				};
			});
		}
	});
	$('#cnpjCliente').change(function(){
		$("#errorPessoa").text("");
		if($(this).val()) {
			$.getJSON('../Cliente/VerificaCliente.ajax.php?',{email:"", cpf : "",cnpj:$(this).val(),id:"", ajax: 'true'}, function(res){
				clientePessoaAprovado = res;
				if (!res) {
					$("#errorPessoa").text("CNPJ já cadastrado");
				};
			});
		}	
	});
	$('#cnpjFornecedor').change(function(){
		$("#errorPessoa").text("");
		if($(this).val()) {
			$.getJSON('../Fornecedor/VerificaFornecedor.ajax.php?',{email:"",cnpj:$(this).val(), ajax: 'true'}, function(res){
				fornecedorCnpjAprovado = res;
				if (!res) {
					$("#errorPessoa").text("CNPJ já cadastrado");
				};
			});
		}
	});
	$('#emailFornecedor').change(function(){
		$("#errorEmail").text("");
		if($(this).val()){
			$.getJSON('../Fornecedor/VerificaFornecedor.ajax.php?',{email: $(this).val(),cnpj:"", ajax: 'true'}, function(res){
				fornecedorEmailAprovado = res;
				if (!res) {
					$("#errorEmail").text("Email já cadastrado");
				};
			});
		}
	});
	$('#emailCliente').change(function(){
		$("#errorEmail").text("");
		if($(this).val()){
			$.getJSON('../Cliente/VerificaCliente.ajax.php?',{email: $(this).val(), cpf : "",cnpj:"", id:"", ajax: 'true'}, function(res){
				clienteEmailAprovado = res;
				if (!res) {
					$("#errorEmail").text("Email já cadastrado");
				};
			});
		}
	});
	$('#emailUsuario').change(function(){
		$("#errorEmail").text("");
		if($(this).val()){
			var i="";
			if ($("#id")) {
				i=$("#id").val();
			}
			$.getJSON('../Usuario/VerificaUsuario.ajax.php?',{email: $(this).val(), id: i ,ajax: 'true'}, function(res){
				usuarioAprovado = res;
				if (!res) {
					$("#errorEmail").text("Email já cadastrado");
				};
			});
		}
	});
	$('#loteSucata').change(function(){
		$("#errorLote").text("");
		if($(this).val()){
			$.getJSON('../Sucata/VerificaSucata.ajax.php?',{lote: $(this).val(), ajax: 'true'}, function(res){
				sucataAprovado = res;
				if (!res) {
					$("#errorLote").text("Lote já cadastrado");
				};
			});
		}
	});
	$('#nomeCategoria').change(function(){
		$("#errorNomeCategoria").text("");
		if($(this).val()){
			$.getJSON('../Categoria/VerificaCategoria.ajax.php?',{nome: $(this).val(), ajax: 'true'}, function(res){
				categoriaAprovada = res;
				if (!res) {
					$("#errorNomeCategoria").text("Nome já cadastrado");
				};
			});
		};
	});
	$('#nomePeca').change(function(){
		$("#errorPeca").text("");
		if($(this).val()){
			if (($(this).val()!="")&&($("#carro").val()!="")) {
				$.getJSON('../Peca/VerificaPeca.ajax.php?',{nome: $(this).val(),carro:$("#carro").val(), ajax: 'true'}, function(res){
					pecaAprovada = res;
					if (!res) {
						$("#errorPeca").text("Peca já cadastrada");
					};
				});
			}
		};
	});
	$('#carro').change(function(){
		if (classe="Peca") {
			if (($(this).val()!="")&&($("#nome").val()!="")) {
				$.getJSON('../Peca/VerificaPeca.ajax.php?',{carro: $(this).val(),nome:$("#nomePeca").val(), ajax: 'true'}, function(res){
					pecaAprovada = res;
					if (!res) {
						$("#errorPeca").text("Peca já cadastrada");
					};
				});
			}
		}
	});
	$('#marca').change(function(){
		$("#errorMarca").text("");
		if($(this).val()){
			if ($("#idMarcaOriginal")) {
				id=$("#idMarcaOriginal").val();
			}else{
				id="";
			}
			$.getJSON('../Marca/VerificaMarca.ajax.php?',{marca: $(this).val(),id:id, ajax: 'true'}, function(res){
				marcaAprovada = res;
				if (!res) {
					$("#errorMarca").text("Marca já cadastrado");
				};
			});
		};
	});
	$('#modelo').change(function(){
		$("#errorModelo").text("");
		if($(this).val()){
			var i="";
			if ($("#idModeloOriginal")) {
				id=$("#idModeloOriginal").val();
			}
			$.getJSON('../Modelo/VerificaModelo.ajax.php?',{modelo: $(this).val(),id:id, ajax: 'true'}, function(res){
				modeloAprovado = res;
				if (!res) {
					$("#errorModelo").text("Modelo já cadastrado");
				};
			});
		};
	});
});
