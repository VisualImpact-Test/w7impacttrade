var Storecheck = {

	idFormFiltros: 'formFiltroStorecheck',
	url: 'storecheck/',
	idDivContent: 'contentStorecheck',
	mySwipersH: [],
	mySwipersV: [],

	load: function () {

		$(document).ready(function (e) {
			$('.flt_grupoCanal').change();
        });

		$('.btn-getPuntosDeVenta').on('click', function (e) {
			e.preventDefault();
			var data = Fn.formSerializeObject(Storecheck.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Storecheck.url + 'getPuntosDeVenta', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				if (a.result === 2) return false;
				if (typeof a.data.validaciones !== null) $.mostrarValidaciones("formFiltroStorecheck", a.data.validaciones);

				if (a.result == 0) {
					var idModal = ++modalId;
					var btn = new Array();
					btn[0] = { title: 'Aceptar', fn: 'Fn.showModal({ id:' + idModal + ',show:false });' };
					Fn.showModal({ id: idModal, show: true, title: a.msg.title, content: a.msg.content, btn: btn });
					return false;
				}

				if (a.result == 1) {
					$selectPuntosDeVenta = $('select[name ="idPuntoDeVenta"]');

					selectContent = '<option value="">-- Punto de Venta --</option>';
					$.each(a.data.puntosDeVenta, function (index, value) {
						selectContent += '<option value="' + value['idCliente'] + '">' + value['razonSocial'] + '</option>'
					});

					$selectPuntosDeVenta.html(selectContent);
				}

			});
		});

		$('.btn-consultar').on('click', function (e) {
			e.preventDefault();
			var data = Fn.formSerializeObject(Storecheck.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Storecheck.url + 'getStoreCheck', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				if (a.result === 2) return false;
				if (typeof a.data.validaciones !== null) $.mostrarValidaciones("formFiltroStorecheck", a.data.validaciones);

				if (a.result == 0) {
					var idModal = ++modalId;
					var btn = new Array();
					btn[0] = { title: 'Aceptar', fn: 'Fn.showModal({ id:' + idModal + ',show:false });' };
					Fn.showModal({ id: idModal, show: true, title: a.msg.title, content: a.msg.content, btn: btn });
					return false;
				}

				$("#" + Storecheck.idDivContent).html('');
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionInfoPuntoDeVenta);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionVisitas);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloEncuestasPremio);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloEncuestas);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloIpp);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloPrecios);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloSos);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloFotos);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloSod);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloSeguimientoPlan);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloPromociones);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloIniciativaTrad);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloInteligenciaTrad);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloOrden);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloDespacho);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloVisibilidadTrad);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloCheckList);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloInventario);
				$("#" + Storecheck.idDivContent).append(a.data.html.seccionModuloVisibilidadAuditoria);
				$("#visibilidadAuditoriaObligatorio").html(a.data.html.tablaVisibilidadAuditoriaObligatorio);
				$("#visibilidadAuditoriaIniciativa").html(a.data.html.tablaVisibilidadAuditoriaIniciativa);
				$("#visibilidadAuditoriaAdicional").html(a.data.html.tablaVisibilidadAuditoriaAdicional);

				myVerticalSwiper = new Swiper('.swiper-container-v', {
					nested: true,
					direction: 'vertical',
					mousewheel: true,
					spaceBetween: 50,
					pagination: {
						el: '.swiper-pagination-v',
						clickable: true,
					},
				});

				myHorizontalSwiper = new Swiper('.swiper-container-h', {
					slidesPerView: 'auto',
					slidesPerGroup: 1,
					spaceBetween: 10,
					pagination: {
						el: '.swiper-pagination-h',
						dynamicBullets: true,
						clickable: true,
					},
					navigation: {
						nextEl: '.swiper-button-next',
						prevEl: '.swiper-button-prev',
					},
					nested: true,
					freeMode: true,
					loop: false,
				});

			});
		});

		$(document).on('click', '.btn-getDetalladoModuloSos', function (e) {
			e.preventDefault();

			var data = Fn.formSerializeObject(Storecheck.idFormFiltros);
			data['detallados'] = $(this).data('objetodetallados');
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Storecheck.url + 'getDetalladoModuloSos', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				if (a.result === 2) return false;

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
Storecheck.load();