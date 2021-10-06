var Basemadre = {

	frmBasemadre: 'frm-basemadre',
	contentGeneral: 'idContentGeneral',
	contentRegional: 'idContentRegional',
	contentCanal: 'idContentCanal',
	contentSegmento: 'idContentSegmento',
	contentDetallado: 'idContentDetallado',
	url : 'basemadre/', 

	generate_map: function (content, data, color){
		anychart.onDocumentReady(function () {
			var map = anychart.map();
				map.title().enabled(false);
				map.geoData(anychart.maps.peru);
				map.interactivity().selectionMode('none');
				
			function createSeries(value, name, data, color) {
				map.choropleth(anychart.data.set(data).mapAs({'value': [value]}))
						.name(name)
						.legendItem({iconFill: color})
						.color(color)
						.stroke('#d8d8d8');
			}

			map.tooltip()
			.useHtml(true)
			.width(250)
			.title({fontColor: '#7c868e'})
			.format(function () {
					return '<span style="color: #545f69; font-size: 12px; font-weight: bold">En Cartera</span><br />'+
					'<span style="color: #545f69; font-size: 10px; font-weight: bold">PDV: '+this.getData('cartera')+'</span><br />'+
					'<span style="color: #545f69; font-size: 10px; font-weight: bold">Ventas: '+this.getData('cartera_monto')+'</span><br />'+
					'<span style="color: #545f69; font-size: 10px; font-weight: bold">Participación: '+this.getData('por_cartera_1')+'</span><br /><br/>'+
					'<span style="color: #545f69; font-size: 12px; font-weight: bold">Fuera de Cartera</span><br />'+
					'<span style="color: #545f69; font-size: 10px; font-weight: bold">PDV: '+this.getData('fcartera')+'</span><br />'+
					'<span style="color: #545f69; font-size: 10px; font-weight: bold">Ventas: '+this.getData('fcartera_monto')+'</span><br />'+
					'<span style="color: #545f69; font-size: 10px; font-weight: bold">Participación: '+this.getData('por_fcartera_1')+'</span><br />'
					;
				});
				
			map.tooltip().background()
			.enabled(true)
			.fill('#fff')
			.stroke('#ccc')
			.corners(3)
			.cornerType('round');
			//
			createSeries('cartera','En Cartera', data[0], color[0]);
			createSeries('fcartera','Fuera de Cartera', data[1], color[1]);
			//
			map.legend().enabled(true).padding([0, 0, 20, 0]);
			map.container(content);
			map.draw();
		});
	},

	load: function(){
		$(document).ready(function (e) {
			$('#btn-filtrarBasemadre').click()
            $(".flt_grupoCanal").change();
        });
		$(document).on('click','#btn-filtrarBasemadre', function(e){
			e.preventDefault();
			
			var control = $(this);
			var data = Fn.formSerializeObject(Basemadre.frmBasemadre);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Basemadre.url + control.data('url'), 'data': jsonString };

			$.when( Fn.ajax_new(config) ).then(function(a){
				if ( a['status'] == null ) {
					return false;
				}
				
				if (a.data.tipoFormato==1) {
					$("#"+Basemadre.contentGeneral).html(a.data.resumen);
					$("#"+Basemadre.contentCanal).html(a.data.canal);
					$("#"+Basemadre.contentRegional).html(a.data.mapa);
					$("#"+Basemadre.contentSegmento).html(a.data.segmento);
					Fn.showLoading(false);
				} else if (a.data.tipoFormato==2) {
					$("#"+Basemadre.contentDetallado).html(a.data.detalle);

					$('#tb-basemadreDetalle').DataTable(
						a.data.configTable
					);
					Fn.showLoading(false);
				}

				if ( a['result']==1 ) {
					var color = "#FFFFFF";
					Basemadre.generate_map('regions-chart', a.data.regiones, color );
				}
				Fn.showLoading(false);
			});
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('#btn-filtrarBasemadre').click();
        });

		$('.btnReporte').on('click', function(e){
			e.preventDefault();

			var opcion  = $(this).attr("data-value");
			$("#tipoFormato").val(opcion);
			if (opcion==1) {
				$('.tipoGrafica').show(500);
				$('.tipoDetallado').hide(500);
				$('input[name=flag_cartera]').val('1');
				$('#filtro_cartera').hide(500);
				$('#idTipoFormato').val(1);
				if($("#"+Basemadre.contentGeneral).find('.noResultado').length > 0 || $("#"+Basemadre.contentCanal).find('.noResultado').length > 0 || $("#"+Basemadre.contentRegional).find('.noResultado').length > 0 || $("#"+Basemadre.contentSegmento).find('.noResultado').length > 0){
					setTimeout(
					function(){
						// $('#btn-filtrarBasemadre').click()
					}
					, 1000);
				}
					
			} else if (opcion==2) {
				$('.tipoGrafica').hide(500);
				$('.tipoDetallado').show(500);
				$('#filtro_cartera').show(500);
				$('#idTipoFormato').val(2);
				if($("#"+Basemadre.contentDetallado).find('.noResultado').length > 0){
					setTimeout(
					function(){
						// $('#btn-filtrarBasemadre').click()
					}
					, 1000);
				}
			} 
		});
		

	}

}

Basemadre.load();