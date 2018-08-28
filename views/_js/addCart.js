// JavaScript Document
$('.btn-addToCart').click(function(event) {
	if($('.bt-login').text() == ""){
		var url = window.location.pathname;
		//Apanha o link do "botão" clicado
		var loginBox = $(this).attr('href');
		url = url.split('/')[2];

		if(url.length <= 0){
			url = "ProjetoFinal/home";
		}

		var h4      = "";
		var product = "";
		var price   = "";
		var seller  = "";
		var img     = "";
		var name    = "";
		var price2  = "";

		if(url == "artigo"){
			 url       = "../"+url;
			 product   = $(this).attr("value");
			 price2     = $('.prd-price-left p').text();
			 price     = price2.slice(0, -2);
			 seller    = $('#seller-name').attr("value");
			 img       = $($('.thumbnails')[0]).find('img').attr('src');
			 loginBox  = '#addCart';
		}else if(url == "produtos-do-utilizador"){
			 url       = "../../pintura/";
			 h4      = $(this).parent().parent().parent().find('.left-div').find('h4');
			 name    = $($(h4)[0]).text();
			 var dad = $(this).parent().parent().parent();
			 var a   = $(".left-div a", dad);
			 product = $($(a)[0]).attr("value");

			 price2   = $(this).parent().parent().find('.rprice').text();
			 price   = price2.slice(0, -2);
			 seller  = $($(h4)[1]).find('.lseller').attr("value");
			 img     = $(this).parent().parent().parent().parent().find('.img-container').find('img').attr('src');
		}else{
			 h4      = $(this).parent().parent().parent().find('.left-div').find('h4');
			 name    = $($(h4)[0]).text();
			 var dad = $(this).parent().parent().parent();
			 var a   = $(".left-div a", dad);
			 product = $($(a)[0]).attr("value");

			 price2   = $(this).parent().parent().find('.rprice').text();
			 price   = price2.slice(0, -2);
			 seller  = $($(h4)[1]).find('.lseller').attr("value");
			 img     = $(this).parent().parent().parent().parent().find('.img-container').find('img').attr('src');
		}

		$.ajax({ 
			url: "../../"+url+"/addToCart",
			method: "POST",
			data: {
				Produto_ProdutoID: product,
				SellerID: seller,
				Preco: price,
				Quantidade:1
			},
			dataType: "json"
		}).done(function(data){
			if(!data[0]){
				alertBox("Ocorreu um erro!","Ocorreu um erro ao adicionar o seu item ao carrinho");
			}else{
				janela(loginBox, name, price2, img);
			}
		});
	}else{
		window.location.href = '/ProjetoFinal/user-register/';
	}
	event.preventDefault();
});

$('.btn-addToCartSearch').click(function(event) {
	var h4      = $(this).parent().parent().parent().find('.left-div').find('h4');
	var product = $($(h4)[0]).text();
	var price   = $(this).parent().parent().find('.rprice').text();
	var seller  = $($(h4)[1]).find('.lseller').text();
	var img     = $(this).parent().parent().parent().parent().find('.img-container').find('img').attr('src');
	
	//Apanha o link do "botão" clicado
	var loginBox = $(this).attr('href');
	
	$.ajax({ 
		url: "../../pesquisa/addToCart",
		method: "POST",
		data: { 
			NomeProduto: product,
			Preco: price.replace(/[^0-9$.,]/g,''),
			Vendedor: seller,
		},
		dataType: "json"
	}).done(function(data){
		if(!data[0]){
			alertBox("Ocorreu um erro!","Ocorreu um erro ao adicionar o seu item ao carrinho");
		}else{
			janela(loginBox, product, price, img);
		}
	});
	
	event.preventDefault();
});

$('input[type="checkbox"]').on('click', function(event){
	if($('.cart-invoice-data').css('display') == 'none'){
		$('.cart-invoice-data').css('display','block');
	}else{
		$('.cart-invoice-data').css('display','none');
	}
});

$('.thumbnails a').on('click', function(event){
	var id = $(this).attr('href');
	$('.main-image img').removeClass('img-active');
	$(id).addClass('img-active');
	event.preventDefault();
});

$('.rd-btn-paypal').on('click',function(){
	$('#btn-patern').css('display',"none");
	$('#paypal-button-container').css('display',"block");
});

$('.rd-btn-mbpay').on('click',function(){
	$('#paypal-button-container').css('display',"none");
	$('#btn-patern').css('display',"block");
});

$('.img-container').hover(function () {
		$('.hover', this).stop(true, true).fadeIn("slow");
	}, function () {
		$('.hover', this).stop(true, true).fadeOut("slow");
});

$('.follow').hover(function(){
	var label  = $(this).attr('title');
	var parent = $(this).parent().parent();

	if($(".follow-label",parent).text() == ""){
		$(".follow-label",parent).text(label);
	}else{
		$(".follow-label",parent).empty();
	}
});

$('.unfollow').hover(function(){
	var label  = $(this).attr('title');
	var parent = $(this).parent().parent();

	if($(".follow-label",parent).text() == ""){
		$(".follow-label",parent).text(label);
	}else{
		$(".follow-label",parent).empty();
	}
});

$('.open-msg').on('click', function(event){
	if($(".mensage-container").is(":hidden")){
		$(".mensage-container").slideDown("slow");
	}else{
		$(".mensage-container").slideUp("slow");
	}
	event.preventDefault();
});

$('.addFav').on('click', function(event){
	var url = window.location.pathname;
	url = url.split('/')[2];
	var max_parent = $(this).parent().parent().parent().parent().parent();
	var prod_id = $(max_parent).find('.text-container').find('#prod-id').attr('value');

	if(url == ""){
		url = "ProjetoFinal/pintura";
	}
	
	$.ajax({ 
		url: "../../"+url+"/addToFav",
		method: "POST",
		data: { 
			Produto_ProdutoID: prod_id,
		},
		dataType: "json"
	}).done(function(data){
		if(!data[0]){
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Ocorreu um erro!","Ocorreu um erro ao adicionar o seu aos favoritos.");
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Adicionado aos favoritos","Artigo foi adicionado aos seus favoritos.");
			} ,3000);
		}
	});
	event.preventDefault();
});

$('.addToFav').on('click', function(event){
	var url = window.location.pathname;
	url = url.split('/')[2];
	var prod_id = $(this).attr("value");
	
	if(url == "artigo"){
		url       = "../"+url;
	}
	
	$.ajax({ 
		url: "../../"+url+"/addToFav",
		method: "POST",
		data: { 
			Produto_ProdutoID: prod_id,
		},
		dataType: "json"
	}).done(function(data){
		if(!data[0]){
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Ocorreu um erro!","Ocorreu um erro ao adicionar o seu aos favoritos.");
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Adicionado aos favoritos","Artigo foi adicionado aos seus favoritos.");
			} ,3000);
		}
	});
	event.preventDefault();
});

$('.follow').on('click', function(event){
	var url = window.location.pathname;	
	url = url.split('/')[2];
	var followed = $(this).attr('value');
	
	if(url == "produtos-do-utilizador"){
		url = "../../../../artigo/addToFollow";
	}else if(url == "pesquisa"){
		url = "../../../artigo/addToFollow";
	}else if(url == ""){
		url = "/ProjetoFinal/artigo/addToFollow";
	}else{ url = "../../artigo/addToFollow"; }
	
	$.ajax({ 
		url: url,
		method: "POST",
		data: { 
			Followed_userID: followed,
		},
		dataType: "json"
	}).done(function(data){
		if(!data[0]){
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Ocorreu um erro!","Ocorreu um erro, não está a seguir este utilizador ainda.");
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Começou a seguir este utilizador.","A partir deste momento segue este utilizador.");
			} ,3000);
		}
	});
	event.preventDefault();
});

$('.unfollow').on('click', function(event){
	var id = $(this).attr('value');
	var url = window.location.pathname;	
	url = url.split('/')[2];
	
	if(url == "produtos-do-utilizador"){
		url = "../../../../artigo/removeFollow";
	}else if(url == "pesquisa"){
		url = "../../../artigo/removeFollow";
	}else if(url == ""){
		url = "/ProjetoFinal/artigo/removeFollow";
	}else{ url = "../../artigo/removeFollow"; }
	
	$.ajax({ 
		url: url,
		method: "POST",
		data: { 
			id: id,
		},
		dataType: "json"
	}).done(function(data){
		if(!data[0]){
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Ocorreu um erro!","Ocorreu um erro, ainda está a seguir este utilizador.");
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Deixou de seguir este utilizador! ","A partir deste momento já não segue este utilizador.");
			} ,3000);
		}
	});
	event.preventDefault();
});

$('.follow-art').on('click', function(event){
	var followed = $(this).attr('value');
	
	$.ajax({ 
		url: "../../../artigo/addToFollow",
		method: "POST",
		data: { 
			Followed_userID: followed,
		},
		dataType: "json"
	}).done(function(data){
		if(!data[0]){
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Ocorreu um erro!","Ocorreu um erro, não está a seguir este utilizador ainda.");
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Começou a seguir este utilizador.","A partir deste momento segue este utilizador.");
			} ,3000);
		}
	});
	event.preventDefault();
});

$('.unfollow-art').on('click', function(event){
	var id = $(this).attr('value');

	$.ajax({ 
		url: "../../../artigo/removeFollow",
		method: "POST",
		data: { 
			id: id,
		},
		dataType: "json"
	}).done(function(data){
		if(!data[0]){
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Ocorreu um erro!","Ocorreu um erro, ainda está a seguir este utilizador.");
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Deixou de seguir este utilizador! ","A partir deste momento já não segue este utilizador.");
			} ,3000);
		}
	});
	event.preventDefault();
});

$('.btn-del').on('click', function(event){
	var idProd = $(this).attr('value');

	$.ajax({
		url: "../../user-config/delProd",
		method: "POST",
		data: { 
			idProduto: idProd,
		}
	}).done(function(data){
		if(!data){
			load("delete","#img-loading");
			setTimeout( function(){ 
			alertBox("Ocorreu um erro!","Ocorreu um erro eliminar o artigo. Tente novamente.");
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Artigo eliminado!","Eliminou o artigo com sucesso!"); 
			} ,3000);
		}
	});
	event.preventDefault();
});

$('.btn-del-add').on('click', function(event){
	var idAdd = $(this).attr('value');

	$.ajax({
		url: "../../user-config/delAdd",
		method: "POST",
		data: { 
			idAdd: idAdd,
		},
		dataType:"json"
	}).done(function(data){
		console.log(data);
		if(data[0] == "principal"){
			load("delete","#img-loading");
			setTimeout( function(){ 
			alertBox("Morada principal!","Está a tentar eliminar a morada principal, não é possivel eliminar a mesma!");
			} ,3000);		
		}else if(data[0] != true && data[1] <= 0){
			load("delete","#img-loading");
			setTimeout( function(){ 
			alertBox("Ocorreu um erro!","Ocorreu um erro eliminar a morada. Tente novamente.");
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Morada eliminada com sucesso!","Eliminou a morada com sucesso!"); 
			} ,3000);
		}
	});
	event.preventDefault();
});

$('.btn-up-add').on('click', function(event){
	var idAdd = $(this).attr('value');

	$.ajax({
		url: "../../user-config/chAdd",
		method: "POST",
		data: { 
			idAdd: idAdd,
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){ 
			alertBox("Ocorreu um erro!","Não foi possivel promover a morada a principal! Tente novamanente.");
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Foi alterada morada principal!","Morada promovida a principal.");
			} ,3000);
		}
	});
	event.preventDefault();
});

$('.ch-pwd-btn').on('click', function(event){
	var dad = $(this).parent();
	var pwd = $('#actualpwd' ,dad).val();
	var n_pwd = $('#password' ,dad).val();
	var nc_pwd = $('#chkpassword' ,dad).val();

	$.ajax({
		url: "../../user-config/chPwd",
		method: "POST",
		data: {
			chpwd: "form",
			atual: pwd,
			n_pwd: n_pwd,
			nc_pwd: nc_pwd
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro!", data[1]);
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Palavra-passe atualizada!","A sua palavra-passe foi atualizada com sucesso.");
			} ,3000);
		}
	});
	event.preventDefault();
});

$('.ch-pwd-usr-btn').on('click', function(event){
	var dad = $(this).parent();
	var id = $('#usr' ,dad).val();
	var pwd = $('#actualpwd' ,dad).val();
	var n_pwd = $('#password' ,dad).val();
	var nc_pwd = $('#chkpassword' ,dad).val();

	$.ajax({
		url: "../../email-ops/chPwd",
		method: "POST",
		data: {
			chpwd: "form",
			id: id,
			atual: pwd,
			n_pwd: n_pwd,
			nc_pwd: nc_pwd
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro!", data[1]);
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Palavra-passe atualizada!","A sua palavra-passe foi atualizada com sucesso.");
			} ,3000);
		}
	});
	event.preventDefault();
});

$('.ch-invoice-btn').on('click', function(event){
	var dad = $(this).parent();
	var adress = $('#inv-add' ,dad).val();
	var name = $('#inv-fullname' ,dad).val();
	var nif = $('#nif' ,dad).val();

	$.ajax({
		url: "../../user-config/chInv",
		method: "POST",
		data: {
			add: adress,
			name: name,
			nif: nif
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro!", data[1]);
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Dados de faturação atualizados!","Os seus dados de faturação foram atualizados com sucesso.");
			} ,3000);
		}
	});
	event.preventDefault();
});

$('#inv-add').on('change', function(event){
	var dad = $(this).parent();
	var adress = $('#inv-add' ,dad).val();

	$.ajax({
		url: "../../user-config/chFullname",
		method: "POST",
		data: {
			add: adress,
		}
	}).done(function(data){
		load("delete","#img-loading");
		setTimeout( function(){
			$(".loading").fadeOut("slow");
			$("#img-loading").fadeOut("slow");
			$('#inv-fullname').val(data);
		} ,1000);
	});
	event.preventDefault();
});

$('.ch-userdata-btn').on('click', function(event){
	var dad   = $(this).parent();
	var fname = $('#firstname' ,dad).val();
	var lname = $('#lastname' ,dad).val();
	var mail  = $('#mail' ,dad).val();
	var cmail = $('#confmail' ,dad).val();
	var phone = $('#phone' ,dad).val();
	var descr = $('#bio' ,dad).val();

	$.ajax({
		url: "../../user-config/chUserdata",
		method: "POST",
		data: {
			fname: fname,
			lname: lname,
			mail: mail,
			cmail: cmail,
			phone: phone,
			descr: descr
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro!", "Não foi possivel atualizar os seus dados. Tente novamente!");
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Dados pessoais atualizados!","Os seus dados pessoais foram atualizados com sucesso.");
			} ,3000);
		}
	});
	event.preventDefault();
});

$('.btn-del-edit').on('click', function(event){
	var pid = $('#ProdutoID').val();//$(this).parent().attr('value');
	var id  = $(this).attr('value');

	$.ajax({
		url: "../../editar-artigo/delImg/"+pid,
		method: "POST",
		data: {
			id: id
		},
		dataType: "json"
	}).done(function(data){
		if(data[1] <= 0){
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro!", "Não foi possivel eliminar a imgem. Tente novamente!");
			} ,3000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Imagem eliminada com sucesso!","A imagem selecionada foi eliminada com sucesso.");
			} ,3000);
		}
	});

	event.preventDefault();
});

$('.btn-readed').on('click', function(event){
	var id = $(this).attr('value');

	$.ajax({
		url: "../../user-config/markAsReaded",
		method: "POST",
		data: { 
			id: id
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Ocorreu um erro, tente novamente!","");
			} ,1000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Marcada como lida.","");
			} ,1000);
		}
	});
	event.preventDefault();
});

$('.btn-del-alert').on('click', function(event){
	var id = $(this).attr('value');
	
	$.ajax({
		url: "../../user-config/deleteAlert",
		method: "POST",
		data: { 
			id: id
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro, tente novamente.","");
			} ,1000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Notificação eliminada.","");
			} ,1000);
		}
	});
	event.preventDefault();
});

$('.btn-del-fav').on('click', function(event){
	var id = $(this).attr('value');

	$.ajax({
		url: "../favoritos/removeFromFav",
		method: "POST",
		data: { 
			id: id
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro, tente novamente.","");
			} ,1000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Favorito eliminado.","");
			} ,1000);
		}
	});
	event.preventDefault();
});

$('.btn-msg-adjust').on('click', function(event){
	var form = $('#msg-form').serializeArray();
	var data = [];
	$.each( form, function( i, field ) {
      data[field.name] = field.value;
    });
	
	$.ajax({
		url: "../../mensagem",
		method: "POST",
		data: { 
			seller: data.seller,
			pid: data.pid,
			Nome: data.Nome,
			Email: data.Email,
			Contacto: data.Contacto,
			msg: data.msg
		},
		dataType: "json"
	}).done(function(data){
		console.log(data);
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro, tente novamente.","");
			} ,1000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Mensagem Enviada","");
			} ,1000);
		}
	});
	event.preventDefault();
});

$('.btn-msg-readed').on('click', function(event){
	var id = $(this).attr('value');

	$.ajax({
		url: "../../user-config/markMSGAsReaded",
		method: "POST",
		data: { 
			id: id
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Ocorreu um erro, tente novamente!","");
			} ,1000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Marcada como lida.","");
			} ,1000);
		}
	});
	event.preventDefault();
});

$('.btn-del-msg').on('click', function(event){
	var id = $(this).attr('value');
	
	$.ajax({
		url: "../../user-config/deleteMSG",
		method: "POST",
		data: { 
			id: id
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro, tente novamente.","");
			} ,1000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Mensagem eliminada.","");
			} ,1000);
		}
	});
	event.preventDefault();
});

$('.btn-msg-filed').on('click', function(event){
	var id = $(this).attr('value');
	
	$.ajax({
		url: "../../user-config/markMSGAsFiled",
		method: "POST",
		data: { 
			id: id
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro, tente novamente.","");
			} ,1000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Mensagem arquivada.","");
			} ,1000);
		}
	});
	event.preventDefault();
});

$('.btn-msg-notFiled').on('click', function(event){
	var id = $(this).attr('value');
	
	$.ajax({
		url: "../../user-config/removeMSGAsFiled",
		method: "POST",
		data: { 
			id: id
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro, tente novamente.","");
			} ,1000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Mensagem foi removida das arquivadas.","");
			} ,1000);
		}
	});
	event.preventDefault();
});

$('.btn-send-msg').on('click', function(event){
	var form = $('#new-msg').serializeArray();
	var data = [];
	
	$.each( form, function( i, field ) {
      data[field.name] = field.value;
    });

	$.ajax({
		url: "../enviarMensagem",
		method: "POST",
		data: {
			msg: data['msg'],
			id: data['id-msg']
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro, tente novamente.","");
			} ,1000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Mensagem Enviada","");
			} ,1000);
		}
	});
	event.preventDefault();
});

$('#send-add').on('change', function(){
	var id = $(this).val();
	
	$.ajax({
		url: "../carrinho/updateAddress",
		method: "POST",
		data: { 
			id: id
		},
		dataType: "json"
	}).done(function(data){
		$('#firstname').val(data[1][0]['fullname']);
		$('#street').val(data[1][0]['street']);
		$('#firstname').val(data[1][0]['fullname']);
		$('#zip').val(data[1][0]['zip']);
		$('#city').val(data[1][0]['city']);
		$('#district').val(data[1][0]['Distrito']);
		
		console.log(data[1]);
	});	
});

$('.btn-del-cart').on('click',function(event){
	var id     = $(this).attr('value');
	var cartId = $('#carid').val();

	$.ajax({
		url: "deleteFromCart",
		method: "POST",
		data: {
			id: id,
			cartID: cartId
		},
		dataType: "json"
	}).done(function(data){
		if(data[0] != true){
			load("delete","#img-loading");
			setTimeout( function(){
				alertBox("Ocorreu um erro, tente novamente.","");
			} ,1000);
		}else{
			load("delete","#img-loading");
			setTimeout( function(){ 
				alertBox("Artigo eliminado do carrinho.","");
			} ,1000);
		}
	});

	event.preventDefault();
});