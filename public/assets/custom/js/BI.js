function showLoading(show,msg){
		var modal='';
		if( show ){
			modal+="<div id='modal-loading' class='modal modal-temp fade' tabindex='-1' role='dialog' data-backdrop='static' data-keyboard='false'>";
				modal+="<div class='modal-dialog' >";
					modal+="<div class='modal-content'>";
						modal+="<div class='modal-body'>";
							modal+="<div class='text-center'>"+(($.isNull(msg))?'Cargando':msg)+" <img src='assets/images/load.gif' /></div>";
						modal+="</div>";
					modal+="</div>";
				modal+="</div>";
			modal+="</div>";

			$("body").append(modal);


			$("#lk-modal").attr("data-target","#modal-loading");
			$("#lk-modal").click();
			
		}
		else{
			$("#modal-loading").modal('hide');
			$('#modal-loading').next('.modal-backdrop').remove();
			$("#modal-loading").remove();

			$("#lk-modal").attr("data-target","");
			Fn.modalVisible();
		}

		$(".navbar").removeAttr("style");
	}



$('#validar').click(function(e){
	e.preventDefault();
	var site_url=$('base').attr('site_url');
	var data = {'token':$('#token').val()};
	var url = site_url+'bi/validarToken';
	$.ajax({
	  type: "POST",
	  dataType: "json",
	  url: url,
	  data: data,
	  beforeSend: function(){ showLoading(true) },
	  success: function(a){
		  if(a.result!=1){
			  $('#mensaje').html(a.html);
		  }else if(a.result==1){
			   location.href =site_url+'bi/reportes';
		  }
	  },
	  dataType: 'json'
	});
});


$('#salir').click(function(e){
	e.preventDefault();
		 location.href =site_url+'bi';
});
$('#ver').click(function(e){
	e.preventDefault();
		var url = $('#reporte').val();
		$('#contenido').html('<iframe width="100%" height="500" src="'+url+'" frameborder="0" allowfullscreen></iframe>');
})

$('#ver').click();