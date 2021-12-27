var Tracking = {

	frmRutas: 'frm-tracking',
	contentDetalle: 'idContentTracking',
	filas : [],
	url : 'tracking/',
	customTable: '',

	load: function(){

		$(document).on('click','#btn-tracking', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Tracking.frmRutas
				,'url': Tracking.url + control.data('url')
				,'contentDetalle': Tracking.contentDetalle
			}; 
			let usuario_filtro = $('.flt_usuario').val(); 
			if( usuario_filtro == '' ){
			msg = Fn.message({ type: 2, message: 'Debe seleccionar por un Usuario para revisar el tracking' });
				++modalId;
				Fn.showModal({
					id: modalId,
					show: true,
					title: 'Alerta',
					frm: msg,
					btn: [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
				});

				return false;
			}

			$.when(Tracking.loadReporte_new(config)).then(function(){
				
			});
		});
		$(document).on('click', '.lk-show-gps1', function(){
			var control =  $(this);
			var latitud = control.data('latitud');
			var longitud = control.data('longitud');
			var latitud_cliente = control.data('latitud-cliente');
			var longitud_cliente = control.data('longitud-cliente');

			var cliente = control.data('cliente');
			var usuario = control.data('usuario');
			var perfil = control.data('perfil');

			var type = control.data('type');

			var data = { type:type, latitud:latitud, longitud:longitud,latitud_cliente:latitud_cliente,longitud_cliente:longitud_cliente, cliente:cliente, usuario:usuario, perfil:perfil };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Tracking.url + 'mostrarMapa', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn, width:"90%" });
			});
		});

		$('.btnReporte').on('click', function (e) {
			e.preventDefault();
			var opcion = $(this).attr("data-value");
			/*
			if (opcion == 1) {

				$('#idTipoFormato').val(1);
				$('.tipoGrafica').hide(500);
				$('.tipoDetallado').show(500);
				if ($(".tipoDetallado").find('.noResultado').length > 0) {
					$('#btn-filtrarRutas').click();
				}

			} else if (opcion == 2) {
				$('#idTipoFormato').val(2);
				$('.tipoGrafica').show(500);
				$('.tipoDetallado').hide(500);
				if ($(".tipoGrafica").find('.noResultado').length > 0) {
					$('#btn-filtrarRutas').click();
				}

			}*/
		});

		$(document).on('dblclick', '.btnReporte', function (e) {
            $('#btn-tracking').click();
        });

		setTimeout(function(){
			$('#btn-tracking').click();
		}, 1000);
	},
	
	loadReporte_new: function( config = {}){
		var data = Fn.formSerializeObject(config.idFrm);
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url': config.url, 'data': jsonString };

		$.when( Fn.ajax_new(configAjax) ).then(function(a){
			if ( a['status'] == null) {
				return false;
			}

			if ( typeof a.data.views !== 'undefined' ) {
				$.each(a.data.views, function(id,value){
					$('#'+id).html('');
					$('#'+id).html(value.html);
					if ( typeof value.datatable !== 'undefined') {
			
					}
				});

				$('#'+config.contentDetalle).html(a.data.html);

			} else {
				$('#'+config.contentDetalle).html(a.data.html);
				if ( a.result==1 ) {
					if ( typeof a.data.datatable !== 'undefined') {
					
						Tracking.customTable = $('#'+a.data.datatable)
						.DataTable(
							{
								data:a.data.data,
								rowCallback: function(row, data, index) {
									// $(row).find('td:gt(27)').addClass('text-center');
									// $(row).find('td:gt(27)').addClass('tdDisabledRuta');
									$.each($(row).find('td'),function(i,v){
										if(($(this).find('p').length) >= 1 ){
											let classtd = ($(this).find('p').attr('class').split(' '));
											let clasessCelda = classtd.join(' ');
	
											$(this).addClass(clasessCelda);
										}
										if(($(this).find('custom').length) >= 1 ){
											let classtd = ($(this).find('custom').data('clases').split(' '));
											let clasessCelda = classtd.join(' ');
	
											$(this).addClass(clasessCelda);
										}
									});
								}
							}
						)
					}
				}
			}

			Fn.showLoading(false);
		});
	},
	/*
	filtrar_leyenda: function(){
		let condiciones = [];
		$('.filtroCondicion').each(function(ev) {
				var control = $(this);
				var opcion = control.val();
				var checked = control.prop('checked');
				
				if (checked == true) {
					let name = opcion;
					condiciones.push(name);
				}
		});
		let str_condiciones = condiciones.join('|');
		if(str_condiciones == ''){
			str_condiciones = "NO CONDICIONES";
		}
		let columnaCondicion = Tracking.customTable.columns('.colCondicion').indexes()[0];
		Tracking.customTable.column(columnaCondicion).search(str_condiciones,true,false).draw();
	},
	*/
}

Tracking.load();