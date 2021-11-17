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

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrarScorecard').click();
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
		
		$(document).on('click', '#btn-descargarExcel', function () {
			let fechas = $('#txt-fechas').val();
			fechas = fechas.replace(/\//g, '');
			fechas = fechas.replace(/\ /g, '');

			Fn.exportarTablaAExcelXLSX('tb-scorecard', 'Scorecard '+fechas, 'Scorecard')
		});
		
		$(document).on('click', '.lk-detalle', function(){
			var control = $(this);
			var idSubCanal = control.data('subcanal');
			var fecIni = control.data('fecini');
			var fecFin = control.data('fecfin');
			var title = control.data('title');
			var ruta = control.data('ruta');
			var tipo = control.data('tipo');
			var str_clientes = control.data('codClientes');
			var str_visitas = control.data('codVisitas');
			var grupoCanal = control.data('grupoCanal');
			var canal = control.data('canal');
			var flagTotal = control.data('flagTotal');
			//
			var data = { 'idSubCanal':idSubCanal,'fecIni':fecIni,'fecFin':fecFin,'tipo':tipo,'str_clientes':str_clientes,'grupoCanal':grupoCanal ,'canal':canal, 'str_visitas': str_visitas, 'flagTotal':flagTotal};
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Scorecard.url + ruta, 'data': jsonString };

			
			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var html = '';
					html += a.data;
				Fn.showModal({ id:modalId,show:true,title:title,content:html,btn:btn, width:"80%"});
			});
		});
		$(document).on('click', '.lk-show-gps1', function(){
			var control =  $(this);
			var latitud = control.data('latitud');
		    var longitud = control.data('longitud');
		    var latitud_cliente = control.data('latitud-cliente');
		    var longitud_cliente = control.data('longitud-cliente');
			//
			var cliente = control.data('cliente');
			var usuario = control.data('usuario');
			var perfil = control.data('perfil');
			//
		    var type = control.data('type');

		    var data = { type:type, latitud:latitud, longitud:longitud,latitud_cliente:latitud_cliente,longitud_cliente:longitud_cliente, cliente:cliente, usuario:usuario, perfil:perfil };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Scorecard.url + 'mostrarMapa', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn, width:"90%" });
			});
		});

		$(document).ready(function () {
			$("#btn-filtrarScorecard").click();
		});
	}
}

Scorecard.load();