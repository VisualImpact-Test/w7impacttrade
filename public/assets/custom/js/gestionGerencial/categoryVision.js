var categoryVision = {

	frmRutas: 'frm-categoryVision',
	contentDetalle: 'idContentcategoryVision',
	url : 'gestionGerencial/categoryVision/', 
	urlActivo : 'filtrar',

	load: function(){
		$(document).ready(function (e) {
			categoryVision.urlActivo = $(".card-body > ul > li > .active").data("url");
			categoryVision.contentDetalle = $(".card-body > ul > li > .active").data("contentdetalle");

			$('.flt_grupoCanal').change();
			$("#chk-consolidado1q2q").change();
        });
		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrarcategoryVision').click();
        });
		$(document).on('click','#btn-filtrarcategoryVision', function(e){
			e.preventDefault();
			var control = $(this);
			var config = {
				'idFrm' : 'frm-categoryVision'
				,'url': 'gestionGerencial/categoryVision/filtrar'
				,'contentDetalle': 'idContentcategoryVision'
			}; 
			Fn.loadReporte_new(config);
		});
		$(document).on('click', '.card-body > ul > li > a', function (e) {
			var control = $(this);
            categoryVision.urlActivo = control.data('url');
			categoryVision.contentDetalle = control.data('contentdetalle');
		
        });
		$(document).on('change', '#chk-consolidado1q2q', function (e) {
			var control = $(this);
           
			if(control.prop("checked") == true){
				$(".consolidado1q2q").removeClass("d-none");
				$(".consolidado").addClass("d-none");
				console.log("a");
				$("#chk-consolidado").prop("checked",false)
			}

			if(control.prop("checked") == false){
				$(".consolidado1q2q").addClass("d-none");
				$(".consolidado").removeClass("d-none");
			}
		
        });
		$(document).on('change', '#chk-consolidado', function (e) {
			var control = $(this);
           
			if(control.prop("checked") == true){
				// $(".consolidado1q2q").removeClass("d-none");
				// $(".consolidado").addClass("d-none");

				$("#chk-consolidado1q2q").prop("checked",false)
			}

			if(control.prop("checked") == false){
				// $(".consolidado1q2q").addClass("d-none");
				// $(".consolidado").removeClass("d-none");

			}
		
        });


		$(document).on('click','#btn-categoryVision-pdf', function(e){
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
				var data=Fn.formSerializeObject( categoryVision.frmRutas );
				data['elementos']=elementos;
				var jsonString={ 'data':JSON.stringify( data ) };
				var url = site_url+categoryVision.url+'categoryVision_pdf';
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

categoryVision.load();