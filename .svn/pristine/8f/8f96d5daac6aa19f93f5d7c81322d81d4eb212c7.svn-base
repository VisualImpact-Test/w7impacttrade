var Scorecard = {

	frmScorecard: 'frm-scorecard',
	contentDetalle: 'idContentScorecard',
	url : 'scorecard/',

	load: function(){

		$(document).on('click','#btn-filtrarScorecard', function(){
			var ruta = 'detallado';//$('input:radio[name=tipoReporte]:checked').attr('url');
			var control = $(this);
			var config = {
				'idFrm' : Scorecard.frmScorecard
				,'url': Scorecard.url + ruta
				,'contentDetalle': Scorecard.contentDetalle
			};

			Fn.loadReporte(config);
		});
		
		$(document).on('click','.mostrar-cartera1',function(){
			$('.cartera1').show();
			$('.ocultar-cartera1').show();
			$('.mostrar-cartera1').hide();
		});
		
		$(document).on('click','.ocultar-cartera1',function(){
			$('.cartera1').hide();
			$('.ocultar-cartera1').hide();
			$('.mostrar-cartera1').show();
		});
		
		$(document).on('click','.mostrar-cartera2',function(){
			$('.cartera2').show();
			$('.ocultar-cartera2').show();
			$('.mostrar-cartera2').hide();
		});
		
		$(document).on('click','.ocultar-cartera2',function(){
			$('.cartera2').hide();
			$('.ocultar-cartera2').hide();
			$('.mostrar-cartera2').show();
		});
		
		$(document).on('click','.mostrar-visita1',function(){
			$('.visita1').show();
			$('.ocultar-visita1').show();
			$('.mostrar-visita1').hide();
			$('.visita-cabecera').attr('colspan','8');
		});
		
		$(document).on('click','.ocultar-visita1',function(){
			$('.visita1').hide();
			$('.ocultar-visita1').hide();
			$('.mostrar-visita1').show();
			$('.visita-cabecera').attr('colspan','1');
		});
		
		
		$(document).on('click', '.lk-detalle', function(){
			var control = $(this);
			var idSubCanal = control.data('subcanal');
			var fecIni = control.data('fecini');
			var fecFin = control.data('fecfin');
			var title = control.data('title');
			var ruta = control.data('ruta');
			var tipo = control.data('tipo');
			//
			var data = { idSubCanal:idSubCanal,fecIni:fecIni,fecFin:fecFin,tipo:tipo };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Scorecard.url + ruta, 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var html = '';
					/* html += '<h4><strong>'+cliente+'</strong></h4>';
					html += '<p class="user-name">Perfil: '+perfil+' <br />';
					html += 'Usuario: '+usuario+'</p>';*/
					html += a.data;
				Fn.showModal({ id:modalId,show:true,title:title,content:html,btn:btn, width:"80%"});
			});
		});
		
	}
}

Scorecard.load();