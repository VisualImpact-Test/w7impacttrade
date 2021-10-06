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
				//map.credits().enabled(false);
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
			//
			map.tooltip()
			.useHtml(true)
			.width(250)
			//.textWrap('byWord')
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
						//<span style="color: #545f69; font-size: 12px; font-weight: bold">En Cartera: ' + this.getData('cartera') + '%</span><br/>' +
						//	'<span style="color: #545f69; font-size: 12px; font-weight: bold">Fuera de Cartera: ' + this.getData('fcartera') + '%</span><br/>'
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
			// set container id for the map
			map.container(content);
			// initiate map drawing
			map.draw();
		});
	},

	load: function(){

		$(document).on('click','#btn-filtrarBasemadre', function(e){
			e.preventDefault();
			
			var control = $(this);
			/*var config = {
				'idFrm': Basemadre.frmBasemadre
				,'url': Basemadre.url + control.data('url')
				,'contenDetalle': Basemadre.contentGeneral
			};

			Fn.loadReporte(config);*/
			var data = Fn.formSerializeObject(Basemadre.frmBasemadre);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Basemadre.url + control.data('url'), 'data': jsonString };

			$.when( Fn.ajax(config) ).then(function(a){
				if ( a['status'] == null ) {
					return false;
				}

				if (a.data.tipoFormato==1) {
					$("#"+Basemadre.contentGeneral).html(a.data.resumen);
					$("#"+Basemadre.contentCanal).html(a.data.canal);
					$("#"+Basemadre.contentRegional).html(a.data.mapa);
					$("#"+Basemadre.contentSegmento).html(a.data.segmento);
				} else if (a.data.tipoFormato==2) {
					$("#"+Basemadre.contentDetallado).html(a.data.detalle);
					$('#tb-basemadreDetalle').DataTable();
				}

				if ( a['result']==1 ) {
					var color = "#FFFFFF";//[colorCuenta,"#bbbbbb"];
					Basemadre.generate_map('regions-chart', a.data.regiones, color );
				}
			});
		});

		$('.btnReporte').on('click', function(e){
			var opcion = $(this).children('input').val();

			if ( opcion==1 ) {
				$('.tipoGrafica').show(1000);
				$('.tipoDetallado').hide(1000);
			} else if ( opcion==2 ) {
				$('.tipoGrafica').hide(1000);
				$('.tipoDetallado').show(1000);
			}
		});

		$('.tipoDetallado').hide();
	}

}

Basemadre.load();