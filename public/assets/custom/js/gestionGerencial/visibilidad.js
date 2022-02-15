var Visibilidad = {

	frmRutas: 'frm-visibilidad',
	contentDetalle: 'idContentVisibilidad',
	url : 'gestionGerencial/visibilidad/', 
	urlActivo : 'filtrar',

	load: function(){
		$(document).ready(function (e) {
			Visibilidad.urlActivo = $(".card-body > ul > li > .active").data("url");
			Visibilidad.contentDetalle = $(".card-body > ul > li > .active").data("contentdetalle");
			$('.card-body > ul > li > .active').click();
			$('.flt_grupoCanal').change();

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

			if(Visibilidad.urlActivo == "filtrarSosCategoria"){
				$(".flt_sos").hide();
				$(".flt_sod").hide();
				$(".flt_soscat").show();
				$("#chk-consolidado").change();
				
			}
			if(Visibilidad.urlActivo == "filtrarSos"){
				$(".flt_sod").hide();
				$(".flt_soscat").hide();
				$(".flt_sos").show();
				$("#chk-consolidado1q2q").change();

			}
			if(Visibilidad.urlActivo == "filtrarSod"){
				$(".flt_soscat").hide();
				$(".flt_sos").hide();
				$(".flt_sod").show();
				$("#chk-consolidado1q2q").change();
				$("#chk-nuevoFormatosod").change();

			}
		
        });
		$(document).on('change', '#chk-consolidado1q2q', function (e) {
			var control = $(this);
           
			if(control.prop("checked") == true){
				$(".consolidado1q2q").removeClass("d-none");
				$(".consolidado").addClass("d-none");
				$("#chk-consolidado").prop("checked",false);
				$("#chk-nuevoFormatosod").prop("checked",false);
				$(".chk_tipoReportecat").removeClass("d-none");

				//Sod
				$(".chk_tipoReporteNuevoSod").addClass("d-none")
				$(".chk_tipoReporteConsolidadoSod").removeClass("d-none");
			}

			if(control.prop("checked") == false){
				$(".consolidado1q2q").addClass("d-none");
				$(".consolidado").removeClass("d-none");

				if($("#chk-consolidado").prop("checked") == false) $(".chk_tipoReportecat").addClass("d-none");
				else $(".chk_tipoReportecat").removeClass("d-none")

				if($("#chk-nuevoFormatosod").prop("checked") == false) $(".chk_tipoReporteNuevoSod").addClass("d-none");
				else $(".chk_tipoReporteNuevoSod").removeClass("d-none");
			}

			
		
        });
		$(document).on('change', '#chk-consolidado', function (e) {
			var control = $(this);
           
			if(control.prop("checked") == true){
				$(".consolidado1q2q").addClass("d-none");
				$(".consolidado").removeClass("d-none");
				$("#chk-consolidado1q2q").prop("checked",false)
				$(".chk_tipoReportecat").removeClass("d-none")

			}

			if(control.prop("checked") == false){
				if($("#chk-consolidado1q2q").prop("checked") == true) $(".consolidado1q2q").removeClass("d-none");
				$(".consolidado").addClass("d-none");
				$(".detallado").removeClass("d-none");

				if($("#chk-consolidado1q2q").prop("checked") == false) $(".chk_tipoReportecat").addClass("d-none");
				else $(".chk_tipoReportecat").removeClass("d-none")
			}

        });
		$(document).on('change', '#chk-nuevoFormatosod', function (e) {
			var control = $(this);
           
			if(control.prop("checked") == true){
				$(".consolidado1q2q").addClass("d-none");
				$(".consolidado").removeClass("d-none");
				$(".chk_tipoReporteNuevoSod").removeClass("d-none");
				$(".chk_tipoReporteConsolidadoSod").addClass("d-none");

				$("#chk-consolidado1q2q").prop("checked",false)
			}

			if(control.prop("checked") == false){
				if($("#chk-consolidado1q2q").prop("checked") == true) $(".consolidado1q2q").removeClass("d-none");
				$(".chk_tipoReporteNuevoSod").addClass("d-none");
				$(".chk_tipoReporteConsolidadoSod").removeClass("d-none");
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