var Presellers = {

	idFormFiltros: 'formFiltroPresellers',
	url: 'presellers/',
	idDivContent: 'contentPresellers',
	idTableDetalle : 'tb-presellers',

	load: function () {


		$('.btn-consultar').on('click', function (e) {
			e.preventDefault();
			var ruta = "";

			var idReporte=$('#idReporte').val();
			if(idReporte==1){
				ruta="ventas";
			}else if(idReporte==2){
				ruta="preventas";
			}else if(idReporte==3){
				ruta="adpp";
			}else if(idReporte==4){
				ruta="cobranzas";
			}else if(idReporte==5){
				ruta="lomito";
			}else if(idReporte==6){
				ruta="avance";
			}else if(idReporte==7){
				ruta="summary";
			}

			var data = Fn.formSerializeObject(Presellers.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Presellers.url + ruta, 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				$('#'+Presellers.idDivContent).parent().removeClass("hide");
				$('#'+Presellers.idDivContent).html(a.data);
				var $datatable = $('#data-table');
				
				$datatable.dataTable({
				  "scrollX": true,
				  "ordering": false,
				  lengthMenu: [
						[ 10, 25, 50, 100, 1000 ],
						[ '10 Filas', '25 Filas', '50 Filas', '100 Filas', '1000 Filas' ]
					],
					'iDisplayLength': 10,
					dom: 'Bfrtip',
					buttons: [
						'csv', 'pageLength'
					],
					"language": {
						 buttons: {
							csv: 'Excel'
							, pageLength: { _: "Mostrando %d Filas"}
						}
					}
				});
				$("#data-table_filter").find("input[type=search]").attr("placeholder","ingrese un texto");
				if(ruta=='lomito') $('.lk-export-excel').addClass("hide");
				else $('.lk-export-excel').removeClass("hide");
			}); 
		});

		$('.btnReporte').on('click', function(e){
			e.preventDefault();
			var opcion = $(this).attr("data-value");
			$('#idReporte').val(opcion);
		});

		$(document).on('click', '.btn-getDetalladoModuloSos', function (e) {
			e.preventDefault();

			var data = Fn.formSerializeObject(Presellers.idFormFiltros);
			data['detallados'] = $(this).data('objetodetallados');
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Presellers.url + 'getDetalladoModuloSos', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				if (a['status'] == null) return false;

				if (a.result == 1) {
					var idModal = ++modalId;
					var btn = new Array();
					btn[0] = { title: 'Cerrar', fn: 'Fn.showModal({ id:' + idModal + ',show:false });' };
					Fn.showModal({ id: idModal, show: true, title: a.msg.title, content: a.data.html, btn: btn, width: a.data.width });

				}
			});
		});

		$(document).on('click', '.btn-verFoto', function (e) {
			e.preventDefault();

			var linkFoto = $(this).data('urlfoto');

			var content = '';
			content += '<div class="row">';
				content += '<div class="col-md-12 text-center">';
					content += '<img src="' + linkFoto + '" class="img-fluid">';
				content += '</div>';
			content += '</div>';

			var idModal = ++modalId;
			var btn = new Array();
			btn[0] = { title: 'Cerrar', fn: 'Fn.showModal({ id:' + idModal + ',show:false });' };
			Fn.showModal({ id: idModal, show: true, title: 'Imagen', content: content, btn: btn, width: '40%' });
		});

	},

}
Presellers.load();