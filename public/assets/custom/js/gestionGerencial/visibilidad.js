var Visibilidad = {

	frmRutas: 'frm-visibilidad',
	contentDetalle: 'idContentVisibilidad',
	url : 'gestionGerencial/visibilidad/', 
	urlActivo : 'filtrar',

	load: function(){
		$(document).ready(function (e) {
			Visibilidad.urlActivo = $(".card-body > ul > li > .active").data("url");
			Visibilidad.contentDetalle = $(".card-body > ul > li > .active").data("contentdetalle");

			$('.flt_grupoCanal').change();
			$("#chk-consolidado1q2q").change();
			// $('#btn-filtrarVisibilidad').click();
        });
		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrarVisibilidad').click();
        });
		$(document).on('click','#btn-filtrarVisibilidad', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Visibilidad.frmRutas
				,'url': Visibilidad.url + Visibilidad.urlActivo
				,'contentDetalle': Visibilidad.contentDetalle
			}; 
			Fn.loadReporte_new(config);
		});
		$(document).on('click', '.card-body > ul > li > a', function (e) {
			var control = $(this);
            Visibilidad.urlActivo = control.data('url');
			Visibilidad.contentDetalle = control.data('contentdetalle');
		
        });
		$(document).on('change', '#chk-consolidado1q2q', function (e) {
			var control = $(this);
           
			if(control.prop("checked") == true){
				$(".consolidado1q2q").removeClass("d-none");
				$(".consolidado").addClass("d-none");
			}

			if(control.prop("checked") == false){
				$(".consolidado1q2q").addClass("d-none");
				$(".consolidado").removeClass("d-none");
			}
		
        });



		$(document).on('click','#btn-visibilidad-pdf', function(e){
			e.preventDefault();
			//
			var elementos = new Array();
			$("input[name='check[]']:checked").each(function(){ elementos.push($(this).val()); });
			//
			if(elementos == ""){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:'ALERTA',content:'Debe seleccionar por lo menos un registro para poder descargar el PDF',btn:btn });
			} else {
				var data=Fn.formSerializeObject( Visibilidad.frmRutas );
				data['elementos']=elementos;
				var jsonString={ 'data':JSON.stringify( data ) };
				var url = site_url+Visibilidad.url+'visibilidad_pdf';
				Fn.download(url,jsonString);
				
				// var configAjax = { 'url': Visibilidad.url + 'visibilidad_pdf', 'data': jsonString };
				// $.when( Fn.ajax(configAjax) ).then( function(a){

				// });
			}
		});
		
		setTimeout(
					function(){
						$('#btn-filtrar').click();
					}
					, 1000);
	}
}

Visibilidad.load();