var CheckProductos = {

	frmRutas: 'frm-checklistproductos',
	contentDetalle: 'idContentChecklistProductos',
	url : 'gestionGerencial/checkProductos/',
	urlActivo : 'filtrar',
	datatable: {},

	load: function(){
		$( document ).ready(function() {

			
			$(".flt_grupoCanal").change();
			$('.chk_quiebres').hide();
			$('.chk_fifo').hide();

			$('#btn-filtrarVisibilidad').click();
			
			$('#cb-tipoResumen').select2({
				width: '100%',
				dropdownParent: $(".dv-tipoReporte"),
				theme: "classic",
			});
			$('#cb-tipoReporte-resumen').select2({
				width: '100%',
				dropdownParent: $(".dv-tipoReporte-resumen"),
				theme: "classic",
			});

			$('input[name="txt-fechas-resumen"]').daterangepicker({
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

			if($("#proyecto_filtro").val() == '14'){
				
				$.when(CheckProductos.mostrarDetalladoResumen()).then(function(){
					$.when(CheckProductos.mostrarTopCadenasPresencia()).then(function(){
						CheckProductos.mostrarTopProductosPresencia();
					})
				})
			}
		});
		$(document).on('click', '.card-body > ul > li > a', function (e) {
			var control = $(this);
            CheckProductos.urlActivo = control.data('url');
			CheckProductos.contentDetalle = control.data('contentdetalle');
			$('.dv_tipoUsuario').show();
			$('.dv_usuario').show();
			
			if(CheckProductos.urlActivo == 'obtenerResumen'){
				$('#dv-leyenda').hide();
			}else{
				$('#dv-leyenda').show();
			}

			if(CheckProductos.urlActivo == 'filtrar_quiebres'){
				$('.filtros_secundarios').show();
				$('.chk_quiebres').show();
				$('.dv_usuario').hide();
				$('.dv_tipoUsuario').hide();
			}else{
				$('.chk_quiebres').hide();
			}

			if(CheckProductos.urlActivo == 'filtrar_fifo'){
				$('.filtros_secundarios').show();
				$('.chk_fifo').show();
				$('.chk_quiebres').hide();
				$('.dv_usuario').hide();
				$('.dv_tipoUsuario').hide();
				$('#dv-leyenda').hide();
			}else{
				$('.chk_fifo').hide();
			}

		
        });

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrarVisibilidad').click();
        });

		$(document).on('click','#btn-filtrarVisibilidad', function(e){
			e.preventDefault();

		
				var config = {
					'idFrm' : CheckProductos.frmRutas
					,'url': CheckProductos.url + CheckProductos.urlActivo
					,'contentDetalle': CheckProductos.contentDetalle
				};
	
				Fn.loadReporte_validado(config);
		
		});

		$(document).on("click",".lk-show-foto",function(){
			var control = $(this);

			var data = { idVisita: control.data('visita'), cliente: control.data('cliente'), usuario: control.data('usuario'), perfil: control.data('perfil') };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': checkProductos.url + 'mostrarFotos', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn});
			});
		});

		$(document).on("click",".lk-foto",function(){
			var control = $(this);
			var fotoUrl = control.data('fotourl');
			var img='<img src="'+fotoUrl+'" class="img-responsive center-block img-thumbnail" />';
			var html = img;
			
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:"ZOOM FOTO",content:html,btn:btn});
		});

		$(document).on('click','#btn-visibilidad-pdf', function(e){
			e.preventDefault();

			var elementos = new Array();
			$("input[name='check[]']:checked").each(function(){ elementos.push($(this).val()); });

			if(elementos == ""){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:'ALERTA',content:'Debe seleccionar por lo menos un registro para poder descargar el PDF',btn:btn });
			} else {
				var data=Fn.formSerializeObject( checkProductos.frmRutas );
				data['elementos']=elementos;
				var jsonString={ 'data':JSON.stringify( data ) };
				var url = site_url+checkProductos.url+'visibilidad_pdf';
				Fn.download(url,jsonString);
			}
		});

		$(document).on('click','.filtroCondicion', function(e) {
			CheckProductos.filtrar_leyenda();
		});
		$(document).on('click','#btn-quiebres-pdf', function(e) {
			var data = {};
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': CheckProductos.url + 'getFormQuiebresPdf', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;

				var fn='Fn.showModal({ id:'+modalId+',show:false });';

				if(a.result == 0 ) var fn1='Fn.showModal({ id:'+modalId+',show:false });';
				if(a.result == 1 ) var fn1='CheckProductos.verificar_frm_quiebres();';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
					btn[1]={title:'Generar',fn:fn1};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn});
			});
		});
		$(document).on('click','#btn-filtrar-resumen', function(e) {
			$.when(CheckProductos.mostrarDetalladoResumen()).then(function(){
				$.when(CheckProductos.mostrarTopCadenasPresencia()).then(function(){
					CheckProductos.mostrarTopProductosPresencia();
				})
			})
		});
		$(document).on('change','#cb-tipoResumen', function(e) {
			CheckProductos.mostrarDetalladoResumen();
		});

		$(document).on('click', '.lk-detalle', function(){
			var control = $(this);
			var idProducto = control.data('producto');
			var idTipoResumen = control.data('idTipoReporte');
			var tipo = control.data('tipo');
			var banner = control.data('banner');
			var fecha = control.data('fecha');
			//
			var data = { 'idTipoResumen':idTipoResumen,'tipo': tipo,'idBanner':banner,'fecha':fecha,'idProducto':idProducto};
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': CheckProductos.url + 'getDetalleResumen', 'data': jsonString };

			
			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:a.data.title,content:a.data.html,btn:btn, width:"80%"});
			});
		});
	},

	filtrar_leyenda: function(){
		$('.filtroCondicion').each(function(ev) {
			var control = $(this);
			var checked = control.prop('checked');
			let tipo = (control.data('tipo'));
			let tabla = $('#tb-checkproductos').DataTable();

			if (checked == true) {
				tabla.columns('.' + tipo).visible(true);
			}else{
				tabla.columns('.' + tipo).visible(false);
			}

			tabla.draw();
		});	
	},

	verificar_frm_quiebres: function(){

		let cantidadDeClientes = $('#clientes').val().length;
		let topeDeClientes = $('#topClientes').val();
		if(cantidadDeClientes <= topeDeClientes){
			CheckProductos.generar_pdf_quiebres();
		}else{
			modalId++
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var title = 'Alerta';
			var content = Fn.message({'type':2,'message':`Solo puede seleccionar un máximo de ${topeDeClientes} clientes`});
			var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:title,content:content,btn:btn});

		}
	},
	generar_pdf_quiebres: function(){
		var data=Fn.formSerializeObject( CheckProductos.frmRutas );
			data.frmQuiebres = Fn.formSerializeObject('formPdfQuiebres');
		var jsonString={ 'data':JSON.stringify( data ) };
		var url = site_url+CheckProductos.url+'quiebres_pdf';
		
		Fn.download(url,jsonString);
	},
	mostrarDetalladoResumen:function(){
		$('.botonesTable').html('');
		$('.vista-resumen-detallado').html('<i class="fas fa-spinner-third fa-spin icon-load"></i>');
		var ad = $.Deferred();
		var data = {};
		data['txt-fechas'] = $("#txt-fechas-resumen").val();
		data['tipoResumen'] = $("#cb-tipoReporte-resumen").val();

		data.tipoReporte = $('#cb-tipoResumen').val();
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': CheckProductos.url + 'getDetalladoResumen', 'data': jsonString };
		
		$.when(Fn.ajaxNoLoad(config)).then(function(a){
			$('.vista-resumen-detallado').fadeOut(500, function() {
				$('.vista-resumen-detallado').html(a.data.html).fadeIn(500);
				if(a.result == 1){
					$('.botonesTable').append(`<input id="customInputFilterResumen" placeholder="Buscar en los resultados" class="form-control form-control-sm" style="width: 60%!important;"/>`);
				}

			});
			$('.txt-tiendasVisitadas').fadeOut(500, function() {
				$('.txt-tiendasVisitadas').html(`<h5 class="card-title"> ${a.data.tiendasVisitadas} </h5>`).fadeIn(500);
			});
			
			
			ad.resolve(true);
		});
		
		return ad.promise();
	},
	mostrarTopCadenasPresencia:function(){
		$('.top-cadenas-presencia').html('<i class="fas fa-spinner-third fa-spin icon-load"></i>');
		var ad = $.Deferred();
		var data = {};
		data['txt-fechas'] = $("#txt-fechas-resumen").val();
		data['tipoResumen'] = $("#cb-tipoReporte-resumen").val();
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': CheckProductos.url + 'getCadenasPresencia', 'data': jsonString };

		$.when(Fn.ajaxNoLoad(config)).then(function(a){
			$('.top-cadenas-presencia').fadeOut(500, function() {
				if(a.result == 1) $('.top-cadenas-presencia').html(a.data.html).fadeIn(500);
			});
		
			ad.resolve(true);
		});

		return ad.promise();
	},
	mostrarTopProductosPresencia:function(){
		$('.top-productos-mas-presencia').html('<i class="fas fa-spinner-third fa-spin icon-load"></i>');
		$('.top-productos-menos-presencia').html('<i class="fas fa-spinner-third fa-spin icon-load"></i>');

		var ad = $.Deferred();
		var data = {};
		data['txt-fechas'] = $("#txt-fechas-resumen").val();
		data['tipoResumen'] = $("#cb-tipoReporte-resumen").val();

		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': CheckProductos.url + 'getProductosPresencia', 'data': jsonString };

		$.when(Fn.ajaxNoLoad(config)).then(function(a){
			$('.top-productos-mas-presencia').fadeOut(500, function() {
				if(a.result == 1) $('.top-productos-mas-presencia').html(a.data.htmlmasPresencia).fadeIn(500);
			});
			$('.top-productos-menos-presencia').fadeOut(500, function() {
				if(a.result == 1) $('.top-productos-menos-presencia').html(a.data.htmlmenosPresencia).fadeIn(500);
			});
		
			ad.resolve(true);
		});

		return ad.promise();
	},
}

CheckProductos.load();