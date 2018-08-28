// JavaScript Document
$('.bt-login').click(function(event) {
	//Apanha o link do "botão" clicado
	var loginBox = $(this).attr('href');
	janela(loginBox);
	event.preventDefault();
});

$('body').on('click', '#bt-lg', function(evt) { 
	var url = window.location.pathname;
	console.log(url);
	
	var form = $('#lg').serialize();
	
	$.ajax({
		url: "/ProjetoFinal/user-config/login",
		method: "POST",
		data: form,
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("login","#img-loading");
			setTimeout( function(){ 
				alertBox("FAIL!","");
			} ,5000);
		}else{
			load("login","#img-loading");
			setTimeout( function(){
				alertBox("Bem Vindo(a) "+data[1],"");
			} ,5000);
		}
	});
	evt.preventDefault();
});

$('body').on('click', '#logout', function() { 
	load('logout','#img-loading');
});

$('.login-href').click(function(event) {
	//Apanha o link do "botão" clicado
	var loginBox = $(this).attr('href');
	janela(loginBox);
	event.preventDefault();
});

$('.forgot-pwd').on('click', function(event){
	//Apanha o link do "botão" clicado
	var loginBox = $(this).attr('href');
	janela(loginBox);
	event.preventDefault();
});

$('.ask-pwd-ch').on('click',function(event){
	//pedidoDeAlteracao
	var usr = $('#dados').val();

	$.ajax({
		url: "/ProjetoFinal/email-ops/pedidoDeAlteracao/",
		method: "POST",
		data: { 
			usr: usr
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro, tente novamente.","");
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Pedido enviado.","Verifique o seu email para concluir o processo.");
			} ,3000);
		}
	});
	
	event.preventDefault();
});