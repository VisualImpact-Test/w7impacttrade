var MantenimientoCliente = {

	frmMantenimientoCliente: 'frm-mantenimientoCliente',
	contentDetalle: 'idContentMantenimientoCliente',
	url : 'gestionGerencial/mantenimientoCliente/', 
	idModal:null,

	load: function(){

		$(document).on('click','#btn-filtrarMantenimientoCliente', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : MantenimientoCliente.frmMantenimientoCliente
				,'url': MantenimientoCliente.url + control.data('url')
				,'contentDetalle': MantenimientoCliente.contentDetalle
			}; 
			Fn.loadReporte_new(config);
		});

		$(document).on('click', '.card-body > ul > li > a', function (e) {
            $('#btn-filtrarMantenimientoCliente').click();
        });

		$(document).ready(function () {
			$('#btn-filtrarMantenimientoCliente').click();
		});

		$(document).on("click", ".btn-Validar", function (e) {
			e.preventDefault();
			var idVisita=$(this).data("id");

			var data=new FormData();
			data['idVisita']=idVisita;

			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': MantenimientoCliente.url + 'getFormValidar', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				MantenimientoCliente.idModal=modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var fn1 = 'Fn.showConfirm({ fn:"MantenimientoCliente.validar_mantenimiento_cliente()",content:"¿Esta seguro de actualizar los datos?" });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Actualizar', fn: fn1 };
				Fn.showModal({ id: modalId, show: true, title: "VALIDAR MANTENIMIENTO CLIENTE", frm: a.data.html, btn: btn,large:true });
			});
		});
	},

	validar_mantenimiento_cliente(){
		var data=Fn.formSerializeObject( 'formValidar' );
		var jsonString={ 'data':JSON.stringify( data ) };
		var config = { 'url': MantenimientoCliente.url + 'validar_mantenimiento_cliente', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {

			if (a.result === 2) return false;
			++modalId;
			var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Fn.showModal({ id:' + MantenimientoCliente.idModal + ',show:false });$("#btn-filtrarMantenimientoCliente").click();';

			var btn = [];
			btn[0] = { title: 'Cerrar', fn: fn };
			Fn.showModal({ id: modalId, show: true, title: "VALIDAR MANTENIMIENTO CLIENTE", frm: a.msg.content, btn: btn,large:true });
		});
	}
}

MantenimientoCliente.load();