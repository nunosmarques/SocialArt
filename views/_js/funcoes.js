// JavaScript Document

function alertBox( title, msg){
	var tmp_url = window.location.pathname;
	var url = tmp_url.split('/')[2];
	if(url == "pintura" || url == "fotografia" || url == "pesquisa" ||
	   url == "escultura" || url == "artesanato" || url == "estilo-livre" || 
	   url == "user-config" || url == "editar-artigo" || url == "gerir-morada" ||
	   url == "artigo" || url == "mensagem" || url.length <= 0 ){
		url = tmp_url;
	}else if(url == "user-register" || url == "carrinho" || url == "produtos-do-utilizador" || 
			 url == "email-ops"){
		url = "/ProjetoFinal/";
	}else{
		url = "/ProjetoFinal/"+url+"/";
	}
	
	$("#alertBox").fadeIn(300);

	//Alinhamento da janela popup
	var popMargTop = ($("#alertBox").height() + 24) / 2; 
	var popMargLeft = ($("#alertBox").width() + 24) / 2; 
	$(".alertTitle").html(title);
	$(".alertMsg").html(msg);
	
	$("#alertBox").css({ 
		'margin-top' : -popMargTop,
		'margin-left' : -popMargLeft,
		'display' : 'flex'
	});

	//Adicionar uma marcara para escurecer ligeiramente o fundo
	$('body').append('<div class="bg-alert"></div>');
	$('.bg-alert').fadeIn(300);

	//Fecha ao clicar na máscara, ou seja no espaço vazio em redor da janela
	$('body').on('click', '.bg-alert', function() {
		$("#alertBox").fadeOut(300 , function(){
			$('.bg-alert').fadeOut(300 , function() {
			 $('.bg-alert').remove();  
			}); 	
		});
	});

	$('body').on('click', '#btn_close', function() {
		window.location.href = url;
		$("#alertBox").fadeOut(300 , function(){
			$('.bg-alert').fadeOut(300 , function() {
			 $('.bg-alert').remove();  
			});
		});
	});
	
	$('body').on('click', '#btn_ok', function() {
		window.location.href = url;
		$("#alertBox").fadeOut(300 , function(){
			$('.bg-alert').fadeOut(300 , function() {
			 $('.bg-alert').remove();
			});
		});
	});
	
}

function tabs(href,pos){

	$(".myaccount-container ul li").removeClass("activeLi");
	$($("#ipessoais header ul li")[0]).addClass("activeLi");
	$($("#mensagens header ul li")[0]).addClass("activeLi");
	$($('.myaccount-container ul li')[pos]).addClass("activeLi");

	$(".myaccount-container div").removeClass("ativaTabs");
	$($("#ipessoais div")[0]).addClass("ativaTabs");
	$($("#mensagens div")[0]).addClass("ativaTabs");
	$(href).addClass("ativaTabs");
}

function subMenus(where, pos){
	var aux = pos;
	if(pos == 26){ aux = 1; }
	
	$("#"+where+" header ul li").removeClass("activeLi");
	$($("#"+where+" header ul li")[aux]).addClass("activeLi");


	$("#"+where+" div").removeClass("ativaTabs");
	$($("#"+where+" div")[pos]).addClass("ativaTabs");
}

function menu_switch(pos){
	$($('.menu ul li')[pos]).css({ "background":"#ddd", "font-weight":"bold"});
	$($('.menu ul li')[pos]).find("a").css("color","#4CAF50");
}

function pagination_switch(pos){
	$($(".page-num")[pos]).css({"background":"#ddd","color":"#4CAF50"});
}

function janela(loginBox, product, price, img){
	var url = window.location.pathname;
	
	if(loginBox == "#addCart"){
		var data = $('.addcart-details').find('p');
		$($(data)[0]).text(product);
		$($(data)[1]).text(price);
		
		$('.addcart-img').find('img').attr('src',img);
		
		$('body').on('click', '.rbtn', function() {
			window.location.href = url;
			$(loginBox).fadeOut(300 , function(){
				$('.blur').fadeOut(300 , function() {
				 $('.blur').remove();  
				}); 	
		});
	}); 
		
	}
	
	if(loginBox == "#repor-password"){
		$('#addCart').fadeOut(300 , function(){
		});
	}
	
	//Faz fade in da janela Popup
	$(loginBox).fadeIn(300);
		
	//Alinhamento da janela popup
	var popMargTop = ($(loginBox).height() + 24) / 2; 
	var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
	$(loginBox).css({ 
		'margin-top' : -popMargTop,
		'margin-left' : -popMargLeft,
		'display' : 'flex'
	});
	 	
	//Adicionar uma marcara para escurecer ligeiramente o fundo
	$('body').append('<div class="blur"></div>');
	$('.blur').fadeIn(300);
	
	//Fecha ao clicar na máscara, ou seja no espaço vazio em redor da janela
	$('body').on('click', '.blur', function() {
		window.location.href = url;
		$(loginBox).fadeOut(300 , function(){
			$('.blur').fadeOut(300 , function() {
		 	 $('.blur').remove();  
			}); 	
		});
	});
	
	$('body').on('click', '#btn_close', function() {
		window.location.href = url;
		$(loginBox).fadeOut(300 , function(){
			$('.blur').fadeOut(300 , function() {
		 	 $('.blur').remove();  
			}); 	
		});
	}); 
}

function load( el , wd){
	if(el == "login"){
		$('#login').fadeOut(300 , function(){
			$('.blur').fadeOut(300 , function() {
				$('.blur').remove();  
			}); 	
		});
	}
	
	//Faz fade in da janela Popup
	$(wd).fadeIn(300);
		
	//Alinhamento da janela popup
	var popMargTop = ($(wd).height() + 24) / 2; 
	var popMargLeft = ($(wd).width() + 24) / 2; 
		
	$(wd).css({ 
		'margin-top' : -popMargTop,
		'margin-left' : -popMargLeft,
		'display' : 'flex'
	});
	 	
	//Adicionar uma marcara para escurecer ligeiramente o fundo
	$('body').append('<div class="loading"></div>');
	$('.loading').fadeIn(300);
}

function loadWaitGo(title, msg, param){
	load(param,"#img-loading");
	setTimeout( function(){ 
		alertBox(title, msg); 
	} ,3000);
}