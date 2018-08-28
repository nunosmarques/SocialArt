// JavaScript Document
$("#fileUpload").on('change', function () {

     //Conta os ficheiros para limitar
	 //o carregamento do lado do cliente
     var countFiles = $(this)[0].files.length;
	 if(countFiles > 5){ 
		 alert("BUUU");
		 throw new Error("Limite: apenas pode selecionar 5 imagens!");
	 }
     var imgPath = $(this)[0].value;
     var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
     var image_holder = $("#image-holder");
     image_holder.empty();

     if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
         if (typeof (FileReader) != "undefined") {

             //loop para cada imagens adicionada
             for (var i = 0; i < countFiles; i++) {
                 var reader = new FileReader();
                 reader.onload = function (e) {
                     $('<img />', {
                         "src": e.target.result,
                             "class": "thumb-image"
                     }).appendTo(image_holder);
                 };

                 image_holder.show();
                 reader.readAsDataURL($(this)[0].files[i]);
             }

         } else {
             console.log("O navegador não suporta o FileReader");
         }
     } else {
         alert("Só são permitidas imagens!");
     }
 });