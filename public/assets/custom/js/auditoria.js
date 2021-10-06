var Auditoria = {

	frmAuditoria: 'frm-auditoria',
	contentDetalle: '#idContentAuditoria',
	idTableDetalle: 'tb-auditoria',
	url: 'auditoria/',
	reporte: 'visibilidad/',

	load: function () {

		$(document).ready(function (e) {
			$('#btn-filtrarAuditoria').click();
			$(".flt_grupoCanal").change();
		});

		$(document).on('click', '#btn-filtrarAuditoria', function (e) {
			e.preventDefault();
			Auditoria.reporte = $('.btnReporte a.active').attr('url');
			Auditoria.contentDetalle = $('.btnReporte a.active').attr('href');

			var data = Fn.formSerializeObject(Auditoria.frmAuditoria);
			var ruta = Auditoria.reporte;
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Auditoria.url + ruta, 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				$(Auditoria.contentDetalle).html(a.data.html);
				if (a.result == 1) {
					$('#' + a.data.table).DataTable(a.data.configTable);
				}
				$("#data-table_filter").find("input[type=search]").attr("placeholder", "ingrese un texto");
			});
		});
		
		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrarAuditoria').click();
		});

		$(document).on("click", ".lk-row-1", function (e) {
			var indicador = $(this).attr("data-indicador");
			var show = $(this).attr("data-show");
			if (show == "false") {
				$(this).html('<i class="fa fa-minus-circle" ></i>');
				$(this).attr("data-show", "true");

				$(".row-2-" + indicador).removeClass("hide");
			} else {
				$(this).html('<i class="fa fa-plus-circle" ></i>');
				$(this).attr("data-show", "false");

				$(".lk-row21-" + indicador).attr("data-show", "false");
				$(".lk-row21-" + indicador).html('<i class="fa fa-plus-circle" ></i>');

				$(".row-2-" + indicador).addClass("hide");
				$(".row-21-" + indicador).addClass("hide");
			}
		});

		$(document).on("change","#canal_filtro",function(e){
				
		});

		$(document).on('click', '.btnReporte', function(){
			var control = $(this);
			if( control.find('a').attr('url') == 'visibilidad' )
			{$('.content-visib').removeClass('hide');}
			else
			{$('.content-visib').addClass('hide');}

			if( control.find('a').attr('url') == 'resumen' )
			{
				$('.dv_frecuencia').addClass('hide');
				$('.dv_tipoCliente').addClass('hide');
				$('.dv_tipoUsuario').addClass('hide');
				$('.dv_usuario').removeClass('hide');
			}else if(control.find('a').attr('url') == 'cobertura'){
				$('.dv_frecuencia').addClass('hide');
				$('.dv_tipoCliente').addClass('hide');
				$('.dv_tipoUsuario').addClass('hide');
				$('.dv_usuario').addClass('hide');
			}
			else
			{		
				$('.dv_frecuencia').removeClass('hide');
				$('.dv_tipoCliente').removeClass('hide');
				$('.dv_tipoUsuario').removeClass('hide');
				$('.dv_usuario').removeClass('hide');

			}

		});

		$(document).on('click', '.verDetalleClientes', function (e) {
			e.preventDefault();

			var data = Fn.formSerializeObject(Auditoria.frmAuditoria);
			data.tipo = $(this).data('tipo');
			data.distSucursal = $(this).data('distsucursal');
			data.canal = $(this).data('canal');
			var ruta = 'cobertura_detalle';
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Auditoria.url + ruta, 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				let btn = [];
				let fn = [];

				++modalId;
				fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';
				btn[0] = { title: 'Cerrar', fn: fn[0] };

				Fn.showModal({ id: modalId, title: 'Cobertura Clientes', content: a.data.html, btn: btn, show: true, width: '60%' });
			});
		});
	}
}

Auditoria.load();