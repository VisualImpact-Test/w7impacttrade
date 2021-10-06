$.extend({
	isNull: function(val){
		// console.log(val);
		if( typeof val=='undefined' ) return true;
		//else if( val.length==0) return true;
		else return false
	},

	disable: function (selector, boolean = true) {
		var control = $(selector);
		$.each(control, function (i, v) {
			if (v.tagName === "DIV") {
				if (boolean) {
					$(v).addClass('d-none');
					$(v).find(':input').attr('disabled', true);
					$(v).find('select').attr('disabled', true);
					$(v).find(':submit').attr('disabled', true);
				} else {
					$(v).removeClass('d-none');
					$(v).find(':input').attr('disabled', false);
					$(v).find('select').attr('disabled', false);
					$(v).find(':submit').attr('disabled', false);
				}
			} else {
				if (boolean) {
					$(v).addClass('d-none');
					$(v).attr('disabled', true);
				} else {
					$(v).removeClass('d-none');
					$(v).attr('disabled', false);
				}
			}
		});
		// $('.selectpicker').selectpicker('refresh');
	},

	fechaLimite: function (picker, thisFecha, fechaLimite) {
		var control = $(thisFecha);
		var fechaLimite = $(fechaLimite).val();
		var dateB = moment(picker.startDate.format('YYYY-MM-DD'));
		var dateC = moment(moment(fechaLimite, "DD/MM/YYYY").format('YYYY-MM-DD'));
		var diferencia = dateB.diff(dateC, 'days');
		if (diferencia >= 0) control.val(picker.startDate.format('DD/MM/YYYY'));
		else control.val('');
	},

	replaceAll: function(string,target,replacement){
		return string.split(target).join(replacement);
	}
});

$.ajaxSetup({
	type: "POST",
	global: false,
	cache: false,
	timeout: 1*800*1000,/*1 minuto*/
});

var site_name='impactTrade';
var site_url=$('base').attr('site_url');
var fotos_url='http://movil.visualimpact.com.pe/fotos/impactTrade_Android/';
var modalId=0;
var global_masivo = [];

var spanishDateRangePicker = {
	"format": "DD/MM/YYYY",
	"separator": " - ",
	"applyLabel": "Aplicar",
	"cancelLabel": "Cancelar",
	"fromLabel": "De",
	"toLabel": "A",
	"customRangeLabel": "Custom",
	"weekLabel": "S",
	"daysOfWeek": ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
	"monthNames": ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"],
	"firstDay": 1
}

var singleDatePickerModal = {
	"locale": spanishDateRangePicker,
	"singleDatePicker": true,
	"showWeekNumbers": true,
	"showDropdowns": false,
	"parentEl": "div.modal-content",
}

var _aSelectAll = {
		'cuenta': [
				'proyecto',
				'grupoCanal',
				'canal',
				'subCanal',
				'zona',
				'plaza',
				'distribuidora',
				'distribuidoraSucursal',
				'cadena',
				'banner'
			],
		'proyecto': [
				'grupoCanal',
				'canal',
				'subCanal',
				'zona',
				'plaza',
				'distribuidora',
				'distribuidoraSucursal',
				'cadena',
				'banner',
				'encargado',
				'colaborador'
			],
		'grupoCanal': [
				'canal',
				'subCanal',
				'encargado',
				'colaborador'
			],
		'canal': [
				'subCanal',
				'encargado',
				'colaborador'
			],
		'distribuidora': [
				'distribuidoraSucursal',
				'encargado',
				'colaborador'
			],
		'cadena': [
				'banner',
				'encargado',
				'colaborador'
			],
		'encargado': [
				'colaborador'
			]

	};
var _aSelectGrupoCanal = {
		'all': [
				'zona',
				'plaza',
				'distribuidora',
				'distribuidoraSucursal',
				'cadena',
				'banner'
			],
		1: [ 'zona', 'distribuidora', 'distribuidoraSucursal' ],
		4: [ 'zona', 'distribuidora', 'distribuidoraSucursal' ],
		5: [ 'plaza' ],
		2: [ 'cadena', 'banner' ],
	};

var View={

	load: function(){

        if( typeof($BODY)!='undefined' ) $BODY.toggleClass('nav-md nav-sm');

		$(".arrowLogo").removeClass("arrowLogoHorizontal");
		$(".arrowLogo").addClass("arrowLogoVertical");
		$(".arrowLogo").attr("src","images/visual-logo-vertical.png");

		$(document).on('DOMNodeInserted', '.my_select2', function(){
			$(this).select2();
		});

		$('.my_select2').select2();

		$(document).on('DOMNodeInserted', '.my_select2Full', function(){
			$(this).select2({
				width: '100%'
			});
		});

		$('.my_select2Full').select2({
			width: '100%'
		});

		$(document).on('show.bs.modal','.modal',function(e){
            var zIndex = 1040+(10*$('.modal:visible').length);
            $(this).css('z-index',zIndex);
            setTimeout(function(){
                $('.modal-backdrop').not('.modal-stack').css('z-index',zIndex-1).addClass('modal-stack');
            },0);
        });
		
		/*$(document).on('click','.close-sidebar-btn',function(e){
			if($(this).hasClass('is-active')){
				$('#tb-list').DataTable().columns.adjust();
				//
				$('#tb-list').DataTable().responsive.recalc();
			} else {
				$('.dataTables_scrollHeadInner').css("width", "100%");//DataTable({responsive: true});
				$('.dataTables_scrollHeadInner').find("table").css("width", "100%");
			}
			
		});*/

		$(document).on('click','.a-show-body',function(e){
           	var show = $(this).attr("data-show");
			if( show == 'false' ) {
				$(this).parent().parent().parent().parent().find('tbody').removeClass('hide');
				$(this).html('<i class="fa fa-minus-circle" ></i>');
				$(this).attr("data-show", true);
			} else {
				$(this).parent().parent().parent().parent().find('tbody').addClass('hide');
				$(this).html('<i class="fa fa-plus-circle" ></i>');
				$(this).attr("data-show", false);
			}
        });

		$(document).on('click','.a-href',function(){
			var page=$(this).attr('page');
			if( page.length>0 ) Fn.loadPage(page);
			else return false;
		});

		$(document).on('click','#a-logout',function(){
			++modalId;
			alert();
			var btn=new Array();
			btn[0]={title:'Si',fn:'Fn.showModal({ id:'+modalId+',show:false });Fn.logOut();'};
			btn[1]={title:'No',fn:'Fn.showModal({ id:'+modalId+',show:false });'};
			Fn.showModal({ id:modalId,show:true,title:'Cerrar Sesión',content:'¿Desea salir del sistema?',btn:btn });
		});

		$(document).on('click','#a-changelock',function(){
			++modalId;
			var btn=new Array();
			btn[0]={title:'Aceptar',fn:'Fn.showConfirm({ idForm:"frm-clave",fn:"Fn.clave('+modalId+')",content:"¿Desea registrar los datos?" });'};
			btn[1]={title:'Cerrar',fn:'Fn.showModal({ id:"'+modalId+'",show:false });'};
			Fn.showModal({ id:modalId,show:true,title:'Cambiar Clave',frm:View.frmClave(),btn:btn });
		});

		$(document).on('click', '.lk-export-excel', function() {
			var content = $(this).attr("data-content");
			var title = $(this).attr("data-title");
			if( content != '' ){
				var datos = ExportarExcel.getData( content );
				var reporte = title;
				if(datos) {
					var contenido = ExportarExcel.generateExcel(datos);
					if(contenido) { ExportarExcel.downloadExcel(contenido, reporte); }
				}	
			}
		});

		$(document).on('click','span#img-close',function(e){
			e.preventDefault();

			var span=$(this);
			var view=$('#popover-img');
			var img=$('div.img').find('img');

			if( img.attr('src') || span.addClass('alert-danger') ){
				if( view ){
					view.popover("hide");
					view.removeClass('alert-info pointer').addClass('alert-default');
				}
				if( img ) img.removeAttr('src');

				span.removeClass('alert-danger pointer').addClass('alert-default');
			}
		});

		$('body').on('click', '.lk-show-gps', function () {
			var lati_1 = $(this).attr('data-lati-1');
			var long_1 = $(this).attr('data-long-1'); var lati_2 = $(this).attr('data-lati-2');
			var long_2 = $(this).attr('data-long-2'); var modulo = $(this).attr('data-modulo');
			var data_ = $(this).attr('data-info');

			$.post(site_url + "control/mostrarMaps", { lati_1: lati_1, long_1: long_1, lati_2: lati_2, long_2: long_2, modulo: modulo, data: data_ }, function (data) {
				++modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var btn = new Array();
				btn[0] = { title: 'Cerrar', fn: fn };
				Fn.showModal({ id: modalId, show: true, title: "GOOGLE MAPS", content: data, btn: btn, width: "90%" });
			});
		});

		$(document).on('change','select[name="sl-zona"]',function(){
			var idZona=$(this).val();
			$('select[name="sl-ciudad"]').html(Fn.selectOption('ciudad',[idZona])).selectpicker('refresh');

		});

		/*$(document).on('change','select[name="sl-ciudad"]',function(){
            var cod_ubigeo=$(this).val();
            $('select[name="sl-gtm"]').html(Fn.selectOption('gtm',[cod_ubigeo])).selectpicker('refresh');
        });

		$(document).on('change','select[name="sl-canal"]',function(){
			var idCanal=$(this).val();
			$('select[name="sl-subcanal"]').html(Fn.selectOption('subcanal',[idCanal])).selectpicker('refresh');
		});*/
		
		$(document).on('change','select[name="sl-tipoUsuario"]',function(){
			var idTipoUsuario=$(this).val();
			$('select[name="sl-usuario"]').html(Fn.selectOption('usuarios',[idTipoUsuario])).selectpicker('refresh');
		});
		
		$(document).on('change','select[name="sl-cadena"]',function(){
			var idCadena=$(this).val();
			$('select[name="sl-banner"]').html(Fn.selectOption('banner',[idCadena])).selectpicker('refresh');
		});

		$('input[name="txt-fechas"]').daterangepicker({
			locale: {
				"format": "DD/MM/YYYY",
				"applyLabel": "Aplicar",
				"cancelLabel": "Cerrar",
				"daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
				"monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
				"firstDay": 1
			},
			singleDatePicker: false,
			showDropdowns: false,
			autoApply: true,
		});
		
		$('.rango_fechas').daterangepicker({
			locale: {
				"format": "DD/MM/YYYY",
				"applyLabel": "Aplicar",
				"cancelLabel": "Cerrar",
				"daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
				"monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
				"firstDay": 1
			},
			singleDatePicker: false,
			showDropdowns: false,
			autoApply: true,
		});

		$('input[name="txt-fechas_simple"]').daterangepicker({
			locale: {
				"format": "DD/MM/YYYY",
				"applyLabel": "Aplicar",
				"cancelLabel": "Cerrar",
				"daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
				"monthNames": ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre"],
				"firstDay": 1
			},
			singleDatePicker: true,
			showDropdowns: false,
			autoApply: true,
		});

		/***********EVENTOS ADICIONALES*********/
		$('.collapse-link-header').on('click', function(){
			var icon = $(this).find('i');

			icon.toggleClass('fa-caret-up fa-caret-down');
		});

		//Evento buscado en internet para hacer que un radio con la clase uncheckableRadio se pueda deseleccionar
		$(document).on("click mousedown", ".uncheckableRadio", (function () {
			//Capture radio button status within its handler scope,
			//so we do not use any global vars and every radio button keeps its own status.
			//This required to uncheck them later.
			//We need to store status separately as browser updates checked status before click handler called,
			//so radio button will always be checked.
			var isChecked;
			return function (event) {
				//console.log(event.type + ": " + this.checked);
				if (event.type == 'click') {
					//console.log(isChecked);
					if (isChecked) {
						//Uncheck and update status
						isChecked = this.checked = false;
					} else {
						//Update status
						//Browser will check the button by itself
						isChecked = true;

						//Do something else if radio button selected
						/*
						if(this.value == 'somevalue') {
							doSomething();
						} else {
							doSomethingElse();
						}
						*/
					}
				} else {
					//Get the right status before browser sets it
					//We need to use onmousedown event here, as it is the only cross-browser compatible event for radio buttons
					isChecked = this.checked;
				}
			}
		})());

		$(document).on("click", "table thead th .btn-AgregarElemento", function (e) {
			e.preventDefault();
			
			var tabla = $(this).closest('table');
			var tbody = $(tabla).find('tbody');
			var lastFila = $(tabla).find('tbody tr.trHijo:last').data('fila');
			var nextFila = (typeof lastFila !== 'undefined') ? lastFila + 1: 1; 
			var trPadre = $(tabla).find('tbody .trPadre').clone(true);
			var select2Clase = $(trPadre).data('select2');
			var modalClase = $(trPadre).data('classmodal');
			$(trPadre).addClass('trHijo');
			$(trPadre).removeClass('trPadre');
			$(trPadre).removeClass('d-none');
			$(trPadre).data('fila', nextFila);

			var tdsInputs = $(trPadre).find('td[data-name]');

			$.each(tdsInputs, function (i, v) { 
				var tdName = $(this).data('name');
				var inputText = $(this).find('input[type="text"]');
				var select = $(this).find('select');
				var checkBox = $(this).find('input[type="checkbox"]');
				var radio = $(this).find('input[type="radio"]');

				if(inputText.length !== 0) {
					$(inputText[0]).attr('name', tdName + '-' + nextFila);
					$(inputText[0]).attr('id', tdName + '-' + nextFila);
				}

				if(select.length !== 0) {
					$(select[0]).attr('name', tdName + '-' + nextFila);
					$(select[0]).attr('id', tdName + '-' + nextFila);
					$(select[0]).addClass(select2Clase);
				}

				if(checkBox.length !== 0) {
					$.each(checkBox, function (i, v) { 
						$(this).attr('name', tdName + '-' + nextFila);
					});
					// $(checkBox[0].parent()).attr('id', tdName + '-' + nextFila);
					$(checkBox[0]).parent().attr('id', tdName + '-' + nextFila);
				}

				if(radio.length !== 0) {
					$.each(radio, function (i, v) { 
						$(this).attr('name', tdName + '-' + nextFila);
					});
					// $(radio[0].parent()).attr('id', tdName + '-' + nextFila);
					$(radio[0]).parent().attr('id', tdName + '-' + nextFila);

				}
			});

			$(tbody).append(trPadre);

			$('.' + select2Clase).select2({
				dropdownParent: $("div.modal-content-" + modalClase),
				width: '100%'
			});
		});
		
		$(document).on("click", ".btn-MostrarClave", function (e) {
			e.preventDefault();
			var claveInput = $(this).parents('.input-group').find('input:first');
			var tipo = $(claveInput).attr('type');

			if (tipo === "password") {
				$(claveInput).attr("type", "text");
			} else {
				$(claveInput).attr("type", "password");
			}
		});

		$(document).on("click", ".btn-GenerarClave", function (e) {
			e.preventDefault();
			var claveInput = $(this).parents('.input-group').find('input:first');
			var length = 8,
				charset = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789",
				retVal = "";
			for (var i = 0, n = charset.length; i < length; ++i) {
				retVal += charset.charAt(Math.floor(Math.random() * n));
			}
			claveInput.val(retVal);
		});

		$(document).on("click", "table .trHijo .btn-BorrarElemento", function (e) {
			e.preventDefault();
			var tr = $(this).closest('tr');
			var table = $(this).closest('table');
			var lastTh = $(table).find('thead tr:first th:last');

			var idEliminado = $(tr).find("input[name|='id']").val();
			if (typeof idEliminado !== 'undefined') {
				inputHtml = "<input class='d-none' type='text' name='elementosEliminados' value='" + idEliminado + "'>";
				lastTh.append(inputHtml);
			}
			tr.remove();
		});

		$(document).on("change", "table .trHijo .chk-ActualizarElemento", function (e) {
			e.preventDefault();

			var valorCheck = $(this).prop('checked');
			var tr = $(this).closest('tr');
			var inputs = $(tr).find(':input');
			var chkActualizarElemento = $(tr).find('.chk-ActualizarElemento');

			$.each(inputs, function (i, v) {
				$(this).attr('disabled', !valorCheck);
			});

			valorCheck ? $(tr).removeClass('table-secondary') : $(tr).addClass('table-secondary');

			$(chkActualizarElemento).attr('disabled', false);
		});
		
		$(document).on("change", "input[type='checkbox'][class*='checkPadre']", function () {
            var dataCheckHijo = $(this).data('checkhijo');
            var checkHijos = $("input[type='checkbox'][class*='checkHijo'][data-checkhijo='" + dataCheckHijo + "']");
            if (this.checked) {
                $.each(checkHijos, function (i, v) {
                    $(this).prop('checked', true);
                });
            } else {
                $.each(checkHijos, function (i, v) {
                    $(this).prop('checked', false);
                });
            }
        });

		// COMBOS AUTOMATICOS
		$(document).on('change', '.flt_cuenta', function(e){
			var control = $(this);
			var cbx_proyecto = $('.flt_proyecto');

			var aCombos = _aSelectAll['cuenta'].slice(0);
				$.each(aCombos, function(i,v){
					if( $('.flt_' + v).length > 0 ){
						$('.flt_' + v).find('option').not(':first').remove();
						$('.flt_' + v).val('').change();
					}
				});

			var idCuenta = control.val();
			if( idCuenta.length == 0 ){
				return false;
			}

			var data = { 'data': JSON.stringify({ 'idCuenta': idCuenta }) };
			var url = 'control/get_proyecto';

			$.when( Fn.ajax({ 'data': data, 'url': url }) ).then(function(a){
				if( a['result'] == null ){
					return false;
				}

				$.each(a['data'], function(i, v){
					var options = '<option value="' + v['id'] + '">' + v['nombre'] + '</option>';
					cbx_proyecto.append(options);
				});
			});
		});

		$(document).on('change', '.flt_proyecto', function(e){
			var control = $(this);

			var aCombos = _aSelectAll['proyecto'].slice(0);
			var aCombosHead = [ 'grupoCanal', 'zona', 'plaza', 'distribuidora', 'cadena', 'encargado' ];
			var aCombosExist = {};
				$.each(aCombos, function(i,v){
					if( $('.flt_' + v).length > 0 ){
						$('.flt_' + v).find('option').not(':first').remove();
						$('.flt_' + v).val('').change();

						if( $.inArray(v, aCombosHead) != -1 ){
							aCombosExist[v] = 1;
						}
					}
				});

			var idProyecto = control.val();
				if( idProyecto.length == 0 ){
					return false;
				}

			var data = { 'data': JSON.stringify({ 'idProyecto': idProyecto, 'combos': aCombosExist }) };
			var url = 'control/get_combos';

			$.when( Fn.ajax({ 'data': data, 'url': url }) ).then(function(a){
				if( a['result'] == null ){
					return false;
				}

				$.each(aCombosExist, function(i_cbx, v_cbx){
					if( typeof(a['data'][i_cbx]) == 'object' ){
						$.each(a['data'][i_cbx], function(i, v){
							var options = '<option value="' + v['id'] + '">' + v['nombre'] + '</option>';
							$('.flt_' + i_cbx).append(options);
						});
					}
				})
			});

		});

		$(document).on('change', '.flt_grupoCanal', function(e){
			var control = $(this);
			var aCombos = _aSelectAll['grupoCanal'].slice(0);

			var aCombosHead = [ 'canal', 'encargado' ];
			var aCombosExist = {};
			$.each(aCombos, function(i,v){
				if( $('.flt_' + v).length > 0 ){
					$('.flt_' + v).find('option').not(':first').remove();
					$('.flt_' + v).val('').change();

					if( $.inArray(v, aCombosHead) != -1 ){
						aCombosExist[v] = 1;
					}
				}
			});

			var idProyecto = $('.flt_proyecto').val() ? $('.flt_proyecto').val() : 0;
			var idGrupoCanal = control.val();

			View.filtrosGrupoCanal();

			if( idGrupoCanal.length == 0 ){
				return false;
			}

			var data = { 'data': JSON.stringify({ 'idProyecto': idProyecto, 'idGrupoCanal': idGrupoCanal, 'combos': aCombosExist }) };
			var url = 'control/get_combos';

			$.when( Fn.ajax({ 'data': data, 'url': url }) ).then(function(a){
				if( a['result'] == null ){
					return false;
				}

				$.each(aCombosExist, function(i_cbx, v_cbx){
					if( typeof(a['data'][i_cbx]) == 'object' ){
						$.each(a['data'][i_cbx], function(i, v){
							var options = '<option value="' + v['id'] + '">' + v['nombre'] + '</option>';
							$('.flt_' + i_cbx).append(options);
						});
					}
				})
			});
		});

		$(document).on('change', '.flt_canal', function(e){
			var control = $(this);
			var aCombos = _aSelectAll['canal'];

			var aCombosHead = [ 'subCanal', 'encargado' ];
			var aCombosExist = {};
			$.each(aCombos, function(i,v){
				if( $('.flt_' + v).length > 0 ){
					$('.flt_' + v).find('option').not(':first').remove();
					$('.flt_' + v).val('').change();

					if( $.inArray(v, aCombosHead) != -1 ){
						aCombosExist[v] = 1;
					}
				}
			});

			var idProyecto = $('.flt_proyecto').val() ? $('.flt_proyecto').val() : 0;
			var idCanal = control.val();

			if( idCanal.length == 0 ){
				return false;
			}

			var data = { 'data': JSON.stringify({ 'idProyecto': idProyecto, 'idCanal': idCanal, 'combos': aCombosExist }) };
			var url = 'control/get_combos';

			$.when( Fn.ajax({ 'data': data, 'url': url }) ).then(function(a){
				if( a['result'] == null ){
					return false;
				}

				$.each(aCombosExist, function(i_cbx, v_cbx){
					if( typeof(a['data'][i_cbx]) == 'object' ){
						$.each(a['data'][i_cbx], function(i, v){
							var options = '<option value="' + v['id'] + '">' + v['nombre'] + '</option>';
							$('.flt_' + i_cbx).append(options);
						});
					}
				})
			});
		});

		$(document).on('change', '.flt_distribuidora', function(e){
			var control = $(this);
			var aCombos = _aSelectAll['distribuidora'];

			var aCombosHead = [ 'distribuidoraSucursal', 'encargado' ];
			var aCombosExist = {};
			$.each(aCombos, function(i,v){
				if( $('.flt_' + v).length > 0 ){
					$('.flt_' + v).find('option').not(':first').remove();
					$('.flt_' + v).val('').change();

					if( $.inArray(v, aCombosHead) != -1 ){
						aCombosExist[v] = 1;
					}
				}
			});

			var idProyecto = $('.flt_proyecto').val() ? $('.flt_proyecto').val() : 0;
			var idDistribuidora = control.val();

			if( idDistribuidora.length == 0 ){
				return false;
			}

			var data = { 'data': JSON.stringify({ 'idProyecto': idProyecto, 'idDistribuidora': idDistribuidora, 'combos': aCombosExist }) };
			var url = 'control/get_combos';

			$.when( Fn.ajax({ 'data': data, 'url': url }) ).then(function(a){
				if( a['result'] == null ){
					return false;
				}

				$.each(aCombosExist, function(i_cbx, v_cbx){
					if( typeof(a['data'][i_cbx]) == 'object' ){
						$.each(a['data'][i_cbx], function(i, v){
							var options = '<option value="' + v['id'] + '">' + v['nombre'] + '</option>';
							$('.flt_' + i_cbx).append(options);
						});
					}
				})
			});

		});

		$(document).on('change', '.flt_cadena', function(e){
			var control = $(this);
			var aCombos = _aSelectAll['cadena'];

			var aCombosHead = [ 'banner', 'encargado' ];
			var aCombosExist = {};
			$.each(aCombos, function(i,v){
				if( $('.flt_' + v).length > 0 ){
					$('.flt_' + v).find('option').not(':first').remove();
					$('.flt_' + v).val('').change();

					if( $.inArray(v, aCombosHead) != -1 ){
						aCombosExist[v] = 1;
					}
				}
			});

			var idProyecto = $('.flt_proyecto').val() ? $('.flt_proyecto').val() : 0;
			var idCadena = control.val();

			if( idCadena.length == 0 ){
				return false;
			}

			var data = { 'data': JSON.stringify({ 'idProyecto': idProyecto, 'idCadena': idCadena, 'combos': aCombosExist }) };
			var url = 'control/get_combos';

			$.when( Fn.ajax({ 'data': data, 'url': url }) ).then(function(a){
				if( a['result'] == null ){
					return false;
				}

				$.each(aCombosExist, function(i_cbx, v_cbx){
					if( typeof(a['data'][i_cbx]) == 'object' ){
						$.each(a['data'][i_cbx], function(i, v){
							var options = '<option value="' + v['id'] + '">' + v['nombre'] + '</option>';
							$('.flt_' + i_cbx).append(options);
						});
					}
				})
			});

		});

		$(document).on('change', '.flt_encargado', function(e){
			var control = $(this);
			var aCombos = _aSelectAll['encargado'];

			var aCombosHead = [ 'colaborador' ];
			var aCombosExist = {};
			$.each(aCombos, function(i,v){
				if( $('.flt_' + v).length > 0 ){
					$('.flt_' + v).find('option').not(':first').remove();
					$('.flt_' + v).val('').change();

					if( $.inArray(v, aCombosHead) != -1 ){
						aCombosExist[v] = 1;
					}
				}
			});

			var idProyecto = $('.flt_proyecto').val() ? $('.flt_proyecto').val() : 0;
			var idEncargado = $('.flt_encargado').val() ? $('.flt_encargado').val() : 0;
			if( idProyecto == 0 || idEncargado == 0 ){
				return false;
			}

			var filtros = {
					'idProyecto': idProyecto,
					'idGrupoCanal': $('.flt_grupoCanal').val() ? $('.flt_grupoCanal').val() : 0,
					'idCanal': $('.flt_canal').val() ? $('.flt_canal').val() : 0,
					'idSubCanal': $('.flt_subCanal').val() ? $('.flt_subCanal').val() : 0,
					'idZona': $('.flt_zona').val() ? $('.flt_zona').val() : 0,
					'idPlaza': $('.flt_plaza').val() ? $('.flt_plaza').val() : 0,
					'idDistribuidora': $('.flt_distribuidora').val() ? $('.flt_distribuidora').val() : 0,
					'idDistribuidoraSucursal': $('.flt_distribuidoraSucursal').val() ? $('.flt_distribuidoraSucursal').val() : 0,
					'idCadena': $('.flt_cadena').val() ? $('.flt_cadena').val() : 0,
					'idBanner': $('.flt_banner').val() ? $('.flt_banner').val() : 0,
					'idEncargado': idEncargado,
					'combos': aCombosExist
				}

			var data = { 'data': JSON.stringify(filtros) };
			var url = 'control/get_combos';

			$.when( Fn.ajax({ 'data': data, 'url': url }) ).then(function(a){
				if( a['result'] == null ){
					return false;
				}

				$.each(aCombosExist, function(i_cbx, v_cbx){
					if( typeof(a['data'][i_cbx]) == 'object' ){
						$.each(a['data'][i_cbx], function(i, v){
							var options = '<option value="' + v['id'] + '">' + v['nombre'] + '</option>';
							$('.flt_' + i_cbx).append(options);
						});
					}
				})
			});
		});

		// MOSTRANDO FILTROS POR CANAL GRUPO
		View.filtrosGrupoCanal();

		//MOSTRAR FOTO EN UN MODAL
		$(document).on("click",".lk-foto-1",function(){
			var control = $(this);
			var img = control.data('content');
			var fotoUrl = $('#'+img).attr("src");
			var img='<img src="'+fotoUrl+'" class="img-responsive center-block img-thumbnail" />';
			var html = img;
			
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:"ZOOM FOTO",content:html,btn:btn});
		});
	},

	filtrosGrupoCanal: function(){
		if( $('.flt_grupoCanal ').length == 0  ){
			return false;
		}

		var idGrupoCanal = $('.flt_grupoCanal ').val();
		if( idGrupoCanal.length == 0 ){
			$.each(_aSelectGrupoCanal['all'], function(i, v){
				if( $('.flt_' + v).length > 0 ){
					$('.flt_' + v).hide();
				}
			});
		}
		else{
			var aSelectAll = _aSelectGrupoCanal['all'].slice(0);
			if( typeof(_aSelectGrupoCanal[idGrupoCanal]) == 'object' ){
				$.each(_aSelectGrupoCanal[idGrupoCanal], function(i, v){
					if( $('.flt_' + v).length > 0 ){
						$('.flt_' + v).show();
					}

					var idx = $.inArray(v, aSelectAll);
					if( idx > -1 ){
						aSelectAll.splice(idx, 1);
					}
				});

				$.each(aSelectAll, function(i, v){
					if( $('.flt_' + v).length > 0 ){
						$('.flt_' + v).hide();
					}
				});
			}
		}
	},

	frmClave: function(){
		var html='';
		html+="<form id='frm-clave' class='form-horizontal' role='form' action='control/clave'>";
			html+="<div class='row'>";
				html+="<div class='col-sm-12 col-md-10  col-md-offset-1'>";
					html+="<div class='form-group'>";
						html+="<label class='col-lg-5 control-label'>Clave Actual</label>";
						html+="<div class='input-group col-lg-5'>";
							html+="<span class='input-group-addon'>";
								html+="<i class='glyphicon glyphicon-lock'></i>";
							html+="</span>";
							html+="<input type='password' name='clave_old' class='form-control' patron='requerido'>";
						html+="</div>";
					html+="</div>";
					html+="<div class='form-group'>";
						html+="<label class='col-lg-5 control-label'>Clave Nueva</label>";
						html+="<div class='input-group col-lg-5'>";
							html+="<span class='input-group-addon'>";
								html+="<i class='glyphicon glyphicon-lock'></i>";
							html+="</span>";
							html+="<input type='password' name='clave_new' class='form-control' patron='requerido'>";
						html+="</div>";
					html+="</div>";
					html+="<div class='form-group'>";
						html+="<label class='col-lg-5 control-label'>*Confirmar Clave Nueva</label>";
						html+="<div class='input-group col-lg-5'>";
							html+="<span class='input-group-addon'>";
								html+="<i class='glyphicon glyphicon-lock'></i>";
							html+="</span>";
							html+="<input type='password' name='clave_repeat' class='form-control' patron='requerido,identico[clave_new]'>";
						html+="</div>";
					html+="</div>";
				html+="</div>";
			html+="</div>";
		html+="</form>";

		return html;
	},

    showTable: function(){
		if( $(".table").height() >= 500 ){ $(".table-content").css("overflow-y","scroll");}
		$("#lb-num-rows").html( 'Resultados: ' + $('.table >tbody >tr').length);
	},
}
View.load()

var Global={
	fechaHoraString: function(){
        var dt=new Date();
        var day=dt.getDate();
        var month=dt.getMonth()+1;
        var year=dt.getFullYear();
        var hour=dt.getHours();
        var minute=dt.getMinutes();
        var second=dt.getSeconds();

		var day=day.toString();
		var month=month.toString();
		var year=year.toString();
		var hour=hour.toString();
		var minute=minute.toString();
		var second=second.toString();

		if( day.length==1 ) var day="0"+day;
		if( month.length==1 ) var month="0"+month;
		if( hour.length==1 ) var hour="0"+hour;
		if( minute.length==1 ) var minute="0"+minute;
		if( second.length==1 ) var second="0"+second;

        return year+month+day+"_"+hour+minute+second;
	},
	
	dateTime: function(){
        var dt=new Date();
        var day=dt.getDate();
        var month=dt.getMonth()+1;
        var year=dt.getFullYear();
        var hour=dt.getHours();
        var minute=dt.getMinutes();
        var second=dt.getSeconds();

		var day=day.toString();
		var month=month.toString();
		var year=year.toString();
		var hour=hour.toString();
		var minute=minute.toString();
		var second=second.toString();

		if( day.length==1 ) var day="0"+day;
		if( month.length==1 ) var month="0"+month;
		if( hour.length==1 ) var hour="0"+hour;
		if( minute.length==1 ) var minute="0"+minute;
		if( second.length==1 ) var second="0"+second;

        return year+'/'+month+'/'+day+" "+hour+':'+minute+':'+second;
	},
	
	fechaActual: function() {
		var d   = new Date();
		var mes =  ( (d.getMonth()+1) > 9)?(d.getMonth()+1):'0'+(d.getMonth()+1);
		var dia =  ( d.getDate() > 9)?d.getDate():'0'+d.getDate();
		return dia+'/'+mes+'/'+d.getFullYear();
	},
	
	fechaActual_: function() {
		var d   = new Date();
		var mes =  ( (d.getMonth()+1) > 9)?(d.getMonth()+1):'0'+(d.getMonth()+1);
		var dia =  ( d.getDate() > 9)?d.getDate():'0'+d.getDate();
		return d.getFullYear()+'-'+mes+'-'+dia;
	},
	
	horaActual: function() {
		var d = new Date();
		var hora    =  ( d.getHours() > 9)?d.getHours():'0'+d.getHours();
		var minuto  =  ( d.getMinutes() > 9)?d.getMinutes():'0'+d.getMinutes();
		var segundo =  ( d.getSeconds() > 9)?d.getSeconds():'0'+d.getSeconds();
		return hora+':'+minuto+':'+segundo;
	},
	
	formatDate: function(date) {
		var arr_date = date.split("-");
		return  arr_date[2]+ '/' + arr_date[1] + '/' + arr_date[0];
	}
}


var ExportarExcel = {
	
	getData: function( contenedor ) {
		var html = "";
		var css = $("#css-excel").html();
		var contenido = $( "#"+contenedor ).html();
		html += '<html>';
		html += '<head>';
			html += '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
			html += '<style type="text/css">';
				html += css;
			html += '</style>';
		html += '</head>';
		html += '<body>';
			html += contenido;
		html += '</body>';
		html += '</html>';
		
		html=html.replace(/<a[^>]*>|<\/a>/g,"");//remove if u want links in your table
		html=html.replace(/<A[^>]*>|<\/A>/g,"");//remove if u want links in your table
		html=html.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
		html=html.replace(/<IMG[^>]*>/gi,""); // remove if u want images in your table
		html=html.replace(/<input[^>]*>|<\/input>/gi,""); // remove input params
		html=html.replace(/<INPUT[^>]*>|<\/INPUT>/gi,""); // remove input params
			
		return { html: html };
	},
	
	generateExcel: function(datos) {
		var contenidoArchivo = [];
		contenidoArchivo.push(datos.html);
		return new Blob(contenidoArchivo, {
			type: 'application/vnd.ms-excel'
		});
	},
	
	downloadExcel: function(contenidoEnBlob, nombreArchivo) {
		//Compatibilidad
		window.URL = window.URL || window.webkitURL;
		//Usaremos un link para iniciar la descarga
		var save = document.createElement('a');
		save.target = '_blank';
		save.download = nombreArchivo;
		//Identifica el navegador
		var nav = navigator.userAgent.toLowerCase();
		//console.log(nav);
		//Internet Explorer
		if((nav.indexOf("msie") != -1)||(nav.indexOf(".net4") != -1)){
			window.navigator.msSaveBlob(contenidoEnBlob, nombreArchivo);
		}
		//Chrome
		if(nav.indexOf("chrome") != -1){
			var url = window.URL.createObjectURL(contenidoEnBlob);
			save.href = url;
			if (document.createEvent) {
				var event = document.createEvent("MouseEvents");
				event.initEvent("click", true, true);
				save.dispatchEvent(event);
			} else if (save.click) {
				save.click();
			}
			window.URL.revokeObjectURL(save.href);
		}
		//Firefox
		if(nav.indexOf("firefox") != -1){
			var reader = new FileReader();
			reader.onload = function (event) {
				save.href = event.target.result;
				if (document.createEvent) {
					var event = document.createEvent("MouseEvents");
					event.initEvent("click", true, true);
					save.dispatchEvent(event);
				} else if (save.click) {
					save.click();
				}
				window.URL.revokeObjectURL(save.href);
			};
			reader.readAsDataURL(contenidoEnBlob);
		}
	}
}

var Imagen = {

	show: function ( e, content, input, flControl ) {
		var files = e.target.files || e.dataTransfer.files;
        file = files[0];
		var content = $("#"+ content);
		var reader = new FileReader();
		reader.onload = function (e) {
			content.attr("src",e.target.result)
			$("#"+input).val( content.attr("src") );
			$("#"+input+'_show').val( $(flControl).val() );
		};
		reader.readAsDataURL(file);
		
	}
	
}


var File = {

	data: [],
	
	encode_utf8: function(s) {
	  return unescape(encodeURIComponent(s));
	},

	decode_utf8: function(s) {
	  return decodeURIComponent(escape(s));
	},

	format_col: function (value, format){
		var msg = '';
		if ( format == 'entero' ) {
            expr = /^\d+$/;
			msg = 'Solo números.';
        }
		if ( format == 'decimal' ) {
            expr = /^-?[0-9]+([.])?([0-9]+)?$/;
			msg = 'Solo números.';
        }
		if ( format == 'porcentaje' ) {
            expr = /^([0]{1}.[0-9]{1}|[0]{1}.[0-9]{2}|[1]{1})$/;
			msg = 'Solo porcentajes (0.00 a 1).';
        }
		if ( format == 'texto') {
            expr = /([^\s])/;
			msg = 'Mínimo una palabra.';
        }
		if ( format == 'bit') {
            expr =  /[SI-NO]/;
			value  = value.toUpperCase();
			msg = 'Solo SI/NO.';
        }
		var array_result = {result: true, msg : ''};
		//console.log(value + '-' + format);
		var result = !expr.test(value);
		if(result){
			array_result = {result: false, msg : '('+ value + ')' +msg};
		} 
		return array_result;
	},
	
	load: function ( e, content, input, flControl, valFormat ) {
		var files = e.target.files || e.dataTransfer.files;
		Fn.showLoading( true, 'Procesando...' );
		$("#data-content-grid").html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size: 1em" aria-hidden="true"></i> Procesando...' );
        file = files[0];
		var content = $("#"+ content);
		var reader = new FileReader();
		File.data = [];
		reader.onload = function (e) {
			content.attr("src",e.target.result)
			//$("#"+input).val( content.attr("src") );
			$("#"+input+'_show').val( $(flControl).val() );
			
			//
			Papa.parse(file,{
				delimiter: "",	// auto-detect
				newline: "",	// auto-detect
				quoteChar: '"',
				escapeChar: '"',
				header: false,
				trimHeaders: false,
				//dynamicTyping: false,
				preview: 0,
				dynamicTyping: true,
				encoding: "",
				worker: true,
				step: undefined,
				error: function(){
					Fn.showLoading(false);
					++modalId;
					var btn=[];
					var fn='Fn.showModal({ id:'+modalId+',show:false });';

					btn[0]={title:'Continuar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:'Archivo',content:"Error al procesar el archivo intentelo nuevamente.",btn:btn });
					$("#data-content-grid").html('' );
				},
				download: false,
				skipEmptyLines: false,
				chunk: undefined,
				fastMode: undefined,
				beforeFirstChunk: undefined,
				withCredentials: undefined,
				transform: undefined,
				complete: function(results) {
				
					File.data = results.data;
					console.log(File.data)
					//
					var idEncuesta = $('#'+Procesar.idFormEdit+' select[name=idEncuesta_]').val();
					var select_='<option  value="" >-- Ninguno --</option>';
					if( typeof(pregunta_select[idEncuesta])=='object'){
						$.each(pregunta_select[idEncuesta],function(i,v){
							select_+='<option value="'+i+'">'+v+'</option>';
						});
					}
					console.log(select_)
					//
					var html = '';
					var arrayVal = [];
					
					console.log(File.data[0].length);
					var array_error = [], array_ = [];
					var array_head = [];
					if(File.data.length < 2) html = '<div class="alert alert-danger" ><i class="fa fa-exclamation-circle" ></i> No se encontraron filas en el archivo procesado</div>'; 
					else {
						//
						html = '';
						var numReg = 0;
						var numError = 0;
						var html = '<table class="table" >'
						$.each(File.data,function(ix,value){ 
							if(ix == 0){
								html += '<thead>';
									html += '<tr>';
										console.log(value[0])
										var head = value[0].split(',');
										$.each(head,function(ix_,value_){ 
											html += '<td><select class="form-control input-xs" name="sl_pregunta_'+ix_+'" title="-- Ninguno --" data-actions-box="true" data-live-search="true" patron="requerido"  >'+select_+'</select ></td>';
										});
									html += '</tr>';
									html += '<tr>';
										console.log(value[0])
										var head = value[0].split(',');
										$.each(head,function(ix_,value_){ 
											html += '<th>'+value_+'</th>';
										});
									html += '</tr>';
								html += '</thead><tbody>';
							} else {
								html += '<tr>';
									//console.log(value[0])
									if($.isArray(value)){
										var row = value;
										if(value.length == 1){
											var json = JSON.stringify(value[0]);
											var string = json.substr(1,json.length - 2)
											console.log(string.split(/([^,]+)/g));
											if(value[0] != 'null' && value[0] != null  && value[0] != 'NULL' ) var row = value[0].split(',');
											else row = [];
										}
									} 
									
									$.each(row,function(ix_,value_){ 
										html += '<td>'+value_+'</td>';
									});
								html += '</tr>';
							}
						});
						html += '</tbody></table>'
						$("#btn-procesar").removeClass("disabled");
					}
					
					$("#dv-preview").html(html);
					$(".selectpicker").selectpicker('refresh');
					Fn.showLoading(false);
				}
			});
			
			//
			
		};
		reader.readAsDataURL(file);
		
	}
}

var AnyChartCustom = {

	pieCharts: [],
	columnCharts: [],
	barCharts: [],

	setPieCharts: function (graficosPieAC) {
		$.each(graficosPieAC, function (indice, value) {
			AnyChartCustom.pieCharts[indice] = anychart.pie(value.data);
			AnyChartCustom.pieCharts[indice].animation(true);
			AnyChartCustom.pieCharts[indice].title("<strong>" + value.title + "</strong>");
			AnyChartCustom.pieCharts[indice].title().fontSize(12);
			AnyChartCustom.pieCharts[indice].title().fontColor('#000');
			AnyChartCustom.pieCharts[indice].title().useHtml(true);

			AnyChartCustom.pieCharts[indice].legend(true);
			AnyChartCustom.pieCharts[indice].legend().title(false);
			AnyChartCustom.pieCharts[indice].legend().fontColor('#000');
			AnyChartCustom.pieCharts[indice].legend().fontSize(10);
			AnyChartCustom.pieCharts[indice].legend().title().padding([0, 0, 10, 0]);
			AnyChartCustom.pieCharts[indice].legend().position('bottom');
			AnyChartCustom.pieCharts[indice].legend().itemsLayout('horizontal');
			AnyChartCustom.pieCharts[indice].legend().align('center');

			AnyChartCustom.pieCharts[indice].labels()
				.fontSize(10)
				.fontColor('#000');
			AnyChartCustom.pieCharts[indice].labels().position("outside");
			AnyChartCustom.pieCharts[indice].connectorStroke({ color: "#595959", thickness: 1, dash: "1 1" });

			AnyChartCustom.pieCharts[indice].tooltip()
				.useHtml(true)
				.width(300)
				.title({ fontColor: '#FFFFFF' })
				.format(function () {
					return eval(value.tooltipHtml);
				});
			AnyChartCustom.pieCharts[indice].tooltip().background()
				.enabled(true)
				.fill('#FFFFFF')
				.stroke('#ccc')
				.corners(3)
				.cornerType('round');

			AnyChartCustom.pieCharts[indice].container("containerPie" + indice);
			AnyChartCustom.pieCharts[indice].draw();
		});
	},

	setColumnCharts: function (graficosColumnAC) {
		$.each(graficosColumnAC, function (indice, value) {
			AnyChartCustom.columnCharts[indice] = anychart.column();
			AnyChartCustom.columnCharts[indice].animation(true);

			AnyChartCustom.columnCharts[indice].title("<strong>" + value.title + "</strong>");
			AnyChartCustom.columnCharts[indice].title().fontSize(12);
			AnyChartCustom.columnCharts[indice].title().fontColor('#000');
			AnyChartCustom.columnCharts[indice].title().useHtml(true);

			AnyChartCustom.columnCharts[indice].column(value.data);

			AnyChartCustom.columnCharts[indice].labels()
				.enabled(true)
				.fontSize(10)
				.fontColor('#000');

			AnyChartCustom.columnCharts[indice].tooltip()
				.useHtml(true)
				.width(250)
				.title({ fontColor: '#7c868e' })
				.format(function () {
					return eval(value.tooltipHtml);
				});

			// AnyChartCustom.columnCharts[indice].xAxis().labels().rotation(-60);
			AnyChartCustom.columnCharts[indice].xAxis()
				.labels()
				.width(45)
				.height(50)
				.fontSize(10)
				.fontColor('#000').textOverflow("...");
 
			AnyChartCustom.columnCharts[indice].tooltip().background()
				.enabled(true)
				.fill('#fff')
				.stroke('#ccc')
				.corners(3)
				.cornerType('round');
			AnyChartCustom.columnCharts[indice].container("containerColumn" + indice);
			AnyChartCustom.columnCharts[indice].legend(false);
			AnyChartCustom.columnCharts[indice].draw();
		});
	},

	setBarCharts: function (graficosBarAC) {

		$.each(graficosBarAC, function (indice, value) {
			AnyChartCustom.barCharts[indice] = anychart.bar();
			AnyChartCustom.barCharts[indice].animation(true);
			AnyChartCustom.barCharts[indice].padding([10, 40, 5, 20]);

			AnyChartCustom.barCharts[indice].title("<strong>" + value.title + "</strong>");
			AnyChartCustom.barCharts[indice].title().fontSize(12);
			AnyChartCustom.barCharts[indice].title().fontColor('#000');
			AnyChartCustom.barCharts[indice].title().useHtml(true);	

			AnyChartCustom.barCharts[indice].bar(value.data);

			AnyChartCustom.barCharts[indice]
				.tooltip()
				.useHtml(true)
				.position('right')
				.anchor('left-center')
				.offsetX(5)
				.offsetY(0)
				.titleFormat('{%X}')
				.format(function () {
					return eval(value.tooltipHtml);
				});

			// set yAxis labels formatter
			AnyChartCustom.barCharts[indice].yAxis().labels().format('{%Value}{groupsSeparator: }');
			// set titles for axises
			// AnyChartCustom.barCharts[indice].xAxis().title('Products by Revenue');
			AnyChartCustom.barCharts[indice].yAxis().title('Porcentaje');
			AnyChartCustom.barCharts[indice].interactivity().hoverMode('by-x');
			AnyChartCustom.barCharts[indice].tooltip().positionMode('point');
			// set scale minimum
			AnyChartCustom.barCharts[indice].yScale().minimum(0);

			AnyChartCustom.barCharts[indice].container('containerBar' + indice);
			AnyChartCustom.barCharts[indice].draw();
		});
	}
}

var HTCustom = {

	HTObjectsFeatures: [],
	HTObjects: [],
	HTNombres: [],
	HTHojasInvalidas: [],
	HTHooks: { 'afterChange': [], 'afterPaste': [] },
	HTHojaActiva: 0,

	validateHojas: function () {
		HTCustom.HTHojasInvalidas = [];
		HTCustom.HTObjects.forEach(function (value, i) {
			value.validateCells((valid) => {
				if (!valid){
					HTCustom.HTHojasInvalidas.push(HTCustom.HTNombres[i]);
				} 
			})
		});
	},

	myGetDataAtCell: function (HTObjectId, row, col) {
		var valueCell = HTCustom.HTObjects[HTObjectId].getDataAtCell(row, HTCustom.HTObjects[HTObjectId].propToCol(col));
		return valueCell;
	},

	mySetDataAtCell: function (HTObjectId, row, col, value) {
		HTCustom.HTObjects[HTObjectId].setDataAtCell(row, HTCustom.HTObjects[HTObjectId].propToCol(col), value);
	},

	mySetDataAtCellSource: function (HTObjectId, row, col, value, source) {
		HTCustom.HTObjects[HTObjectId].setDataAtCell(row, HTCustom.HTObjects[HTObjectId].propToCol(col), value, source);
	},

	mySetCellSource: function (HTObjectId, row, col, newSource) {
		if (typeof newSource === "undefined") {
			HTCustom.HTObjects[HTObjectId].setCellMeta(row, col, 'source', [' ']);
		} else {
			HTCustom.HTObjects[HTObjectId].setCellMeta(row, col, 'source', newSource);
		}
	},

	load: function () {
		Handsontable.renderers.registerRenderer('myButtonRenderer', HTCustom.myButtonRenderer);
		Handsontable.renderers.registerRenderer('myDropdownRenderer', HTCustom.myDropdownRenderer);
		Handsontable.renderers.registerRenderer('myDateRenderer', HTCustom.myDateRenderer);

		Handsontable.validators.registerValidator('myUniqueValidator', HTCustom.myUniqueValidator);
		Handsontable.validators.registerValidator('myDropdownUniqueValidator', HTCustom.myDropdownUniqueValidator);

		Handsontable.cellTypes.registerCellType('myButton', {
			renderer: Handsontable.renderers.getRenderer('myButtonRenderer'),
			editor: Handsontable.editors.TextEditor,
			btnClass: 'myBtn',
			btnIcon: 'fas fa-circle',
			btnText: 'Mi botón',
			btnData: {},
		});

		Handsontable.cellTypes.registerCellType('myDate', {
			// renderer: Handsontable.renderers.DateRenderer,
			renderer: Handsontable.renderers.getRenderer('myDateRenderer'),
			editor: Handsontable.editors.DateEditor,
			validator: Handsontable.validators.DateValidator,
			dateFormat: 'DD/MM/YYYY',
			correctFormat: true,
			placeholder: moment().format('DD/MM/YYYY'),
			defaultDate: moment().toDate(),
			datePickerConfig: {
				firstDay: 1,
				showWeekNumber: true,
				numberOfMonths: 1,
				i18n: {
					previousMonth: 'Anterior',
					nextMonth: 'Siguiente',
					months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
					weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
					weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sáb']
				},

				// // Opcion para desactivar días
				// disableDayFn: function (date) {
				// 	return date.getDay() === 0 || date.getDay() === 6;
				// }
			}
		});

		Handsontable.cellTypes.registerCellType('myDropdown', {
			renderer: Handsontable.renderers.getRenderer('myDropdownRenderer'),
			editor: Handsontable.editors.DropdownEditor,
			validator: Handsontable.validators.DropdownValidator,
			source: [' '],
			dpdColumns: [],
			dpdData: [],
		});
	},

	myButtonRenderer: function (instance, td, row, col, prop, value, cellProperties) {
		var btnClass = cellProperties.btnClass;
		var btnIcon = cellProperties.btnIcon;
		var btnText = cellProperties.btnText;
		var btnData = cellProperties.btnData;
		var HTObjectId = 0;

		if (HTCustom.HTObjects.length !== 0) {
			$.each(HTCustom.HTObjects, function (i, v) {
				if (instance == v) HTObjectId = i;
			});
		}

		var boton = '<a type="submit" data-htobjectid="' + HTObjectId + '" data-row="' + row + '" data-col="' + col + '" ';

		if (Object.keys(btnData).length !== 0) {
			$.each(btnData, function (i, v) {
				boton += 'data-' + i + '="' + v + '" ';
			});
		}

		boton += 'class="btn btn-primary btn-sm btn-block rounded-0 m-0 p-0 ' + btnClass;
		boton += '"><i class="' + btnIcon + '"></i> ' + btnText + '</a>';

		td.innerHTML = boton;
		cellProperties.editor = false;
		td.className = "text-center align-middle p-0";
		return td;
	},

	myDateRenderer: function (instance, td, row, col, prop, value, cellProperties) {
		Handsontable.renderers.DateRenderer.apply(this, arguments);
	},

	myDropdownRenderer: function (instance, td, row, col, prop, value, cellProperties) {
		Handsontable.renderers.DropdownRenderer.apply(this, arguments);
	},

	myUniqueValidator: function (value, callback) {
		var data = this.instance.getDataAtCol(this.col);
		var index = data.indexOf(value);
		var uniqueValue = true;
		if (index > -1 && this.row !== index) {
			uniqueValue = false;
		}
		return callback(uniqueValue);
	},

	myDropdownUniqueValidator: function (value, callback) {

		// unique validator logic
		var data = this.instance.getDataAtCol(this.col);
		var index = data.indexOf(value);
		var uniqueValue = true;
		if (index > -1 && this.row !== index) {
			uniqueValue = false;
		}

		// dropdown validator logic
		let valueToValidate = value;

		if (valueToValidate === null || valueToValidate === void 0) {
			valueToValidate = '';
		}

		if (this.allowEmpty && valueToValidate === '') {
			callback(true);

			return;
		}

		if (this.strict && this.source) {
			if (typeof this.source === 'function') {
				this.source(valueToValidate, HTCustom.process(valueToValidate, callback, uniqueValue));
			} else {
				HTCustom.process(valueToValidate, callback, uniqueValue)(this.source);
			}
		} else {
			callback(true);
		}
	},

	process: function (value, callback, uniqueValue) {
		const originalVal = value;

		return function (source) {
			let found = false;

			for (let s = 0, slen = source.length; s < slen; s++) {
				if (originalVal === source[s]) {
					found = true; // perfect match
					break;
				}
			}
			callback(found && uniqueValue);
		};
	},

	cleanHooks: function () {
		HTCustom.HTHooks = { 'afterChange': [], 'afterPaste': [] }
	},

	llenarHTObjectsFeatures: function (ht) {

		HTCustom.HTObjects = [];
		HTCustom.HTNombres = [];
		HTCustom.HTObjectsFeatures = [];

		ht.forEach(function (value, index) {
			var features = {
				columns: value.columns,
				data: value.data,
				idDiv: 'divHT' + index,
				minSpareRows: 1,
				maxCols: Object.keys(value.data[0]).length,
				rowHeaders: true,
				colHeaders: value.headers,
				filters: false,
				dropdownMenu: false,
				allowInvalid: true,
				licenseKey: 'non-commercial-and-evaluation',
				contextMenu: ['copy', 'cut', '---------', 'row_above', 'row_below', 'remove_row', '---------', 'undo', 'alignment'],
				width: '100%',
				height: 320,
				language: 'es-MX',
				allowInvalid: true,
				manualColumnMove: false,
				manualRowResize: false,
				rowHeights: 24,
				autoRowSize: false,
				viewportRowRenderingOffset: 1,
				viewportColumnRenderingOffset: 1
			};

			if (typeof value.colWidths === 'object' || typeof value.colWidths === 'number' || typeof value.colWidths === 'string') {
				features.colWidths = value.colWidths;
			}

			HTCustom.HTObjectsFeatures[index] = features;
			HTCustom.HTNombres[index] = value.nombre;
		});
	},

	crearHTObjects: function (HTOF) {
		$.each(HTOF, function (index, value) {
			var divHT = document.getElementById(value.idDiv);
			HTCustom.cleanHTDiv(divHT);
			HTCustom.HTObjects[index] = new Handsontable(divHT, value);

			if (typeof HTCustom.HTHooks['afterChange'][index] !== 'undefined') {
				HTCustom.HTObjects[index].addHook('afterChange', HTCustom.HTHooks['afterChange'][index]);
			}

			if (typeof HTCustom.HTHooks['afterPaste'][index] !== 'undefined') {
				HTCustom.HTObjects[index].addHook('afterPaste', HTCustom.HTHooks['afterPaste'][index]);
			}

		});
	},

	cleanHTDiv: function (divHT) {
		divHT.innerHTML = "";
		divHT.removeAttribute("class");
		divHT.removeAttribute("style");
		divHT.removeAttribute("data-initialstyle");
		divHT.removeAttribute("data-originalstyle");
	}
};

var GoogleMap = {

	geocoder: '',
	map: '',
	markers: [],
	inputLongitud: '',
	inputLatitud: '',
	inputDireccion: '',
	longitud: '-77.00403850525618',
	latitud: '-12.10094258730438',

	load: function (params = {}) {

		GoogleMap.inputLongitud = params.inputLongitud;
		GoogleMap.inputLatitud = params.inputLatitud;
		GoogleMap.inputDireccion = params.inputDireccion;
		GoogleMap.initialize(params);
	},

	setMapOnAll: function (map) {
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(map);
		}
	},

	clearMarkers: function () {
		GoogleMap.setMapOnAll(null);
	},

	openInfoWindow: function (marker) {
		var markerLatLng = marker.getPosition();

		GoogleMap.latitud = markerLatLng.lat();
		GoogleMap.longitud = markerLatLng.lng();
		GoogleMap.inputLatitud.val(markerLatLng.lat());
		GoogleMap.inputLongitud.val(markerLatLng.lng());
		//alert(results[0].formatted_address);
	},

	initialize: function (params = {}) {

		var longitud = (typeof params.longitud !== "undefined") ? params.longitud : GoogleMap.longitud;
		var latitud = (typeof params.latitud !== "undefined") ? params.latitud : GoogleMap.latitud;

		GoogleMap.geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(latitud, longitud);
		var mapOptions = {
			zoom: 20,
			center: latlng
		}
		GoogleMap.map = new google.maps.Map(document.getElementById(params.idDivMap), mapOptions);

		// var input = document.getElementById('pac-input');
		// var searchBox = new google.maps.places.SearchBox(input);
		// map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

		google.maps.event.addListenerOnce(GoogleMap.map, 'idle', function () {
			var currentCenter = GoogleMap.map.getCenter();
			google.maps.event.trigger(GoogleMap.map, 'resize');
			GoogleMap.map.setCenter(currentCenter);
			GoogleMap.map.setZoom(15);
			var marker = new google.maps.Marker({
				map: GoogleMap.map,
				draggable: true,
				position: currentCenter
			});
			GoogleMap.markers.push(marker);
			// console.log(GoogleMap.geocoder);
			// console.log(currentCenter);
			//var address = marker.formatted_address;	

			google.maps.event.addListener(marker, 'dragend', function () {
				GoogleMap.openInfoWindow(marker);
				GoogleMap.codeLatLng();
			});
			google.maps.event.addListener(marker, 'click', function () {
				GoogleMap.openInfoWindow(marker);
				GoogleMap.codeLatLng();
			});
		});
	},

	codeLatLng: function () {
		var latitud = GoogleMap.inputLatitud.val();
		var longitud = GoogleMap.inputLongitud.val();

		var lat = parseFloat(latitud);
		var lng = parseFloat(longitud);

		var latlng = new google.maps.LatLng(lat, lng);

		GoogleMap.geocoder.geocode({
			'latLng': latlng
		}, function (results, status) {
			// console.log(results[0]);
			if (status == 'OK') {
				if (results[0]) {

					GoogleMap.inputDireccion.val(results[0].formatted_address);

				} else {
					// alert('No results found');
				}
			} else {
				// alert('Geocoder failed due to: ' + status);
			}
		});
	},

	codeAddress: function () {
		var dep = $('#departamento option:selected').text();
		var pro = $('#provincia option:selected').text();
		var dis = $('#distrito option:selected').text();
		var address = document.getElementById('direccion').value;
		var dir = dep + '-' + pro + '-' + dis + '-' + address;
		GoogleMap.geocoder.geocode({
			'address': dir
		}, function (results, status) {
			if (status == 'OK') {
				GoogleMap.clearMarkers();
				GoogleMap.map.setCenter(results[0].geometry.location);
				var marker = new google.maps.Marker({
					map: GoogleMap.map,
					draggable: true,
					position: results[0].geometry.location
				});
				markers.push(marker);
				GoogleMap.inputLatitud.val(results[0].geometry.location.lat());
				GoogleMap.inputLongitud.val(results[0].geometry.location.lng());
				//var address = results[0].formatted_address;		
				google.maps.event.addListener(marker, 'dragend', function () {
					GoogleMap.openInfoWindow(marker);
					GoogleMap.codeLatLng();
				});
				google.maps.event.addListener(marker, 'click', function () {
					GoogleMap.openInfoWindow(marker);
					GoogleMap.codeLatLng();
				});


			} else {
				//alert('Geocode was not successful for the following reason: ' + status);
			}
		});
	}
}