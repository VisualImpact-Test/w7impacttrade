var Promociones = {

	frmRutas: 'frm-promociones',
	contentDetalle: 'idContentPromociones',
	url : 'gestionGerencial/promociones/',
	urlActivo: '',

	load: function(){
		$(document).ready(function (e) {
			$('#btn-filtrarVisibfiltrarilidad').click();
			$('.flt_grupoCanal').change();
        });

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
			$('#btn-filtrar').click();
			
		});

		$(document).on('click','#btn-filtrar', function(e){
			e.preventDefault();
			let nav = $(".card-body > ul > li > a[class*='active']");
			var control = $(this);
			var config = {
				'idFrm' : Promociones.frmRutas
				,'url': Promociones.url + nav.data('url')
				,'contentDetalle': nav.attr('href').split('#')[1]
			};

			Promociones.urlActivo = nav.data('url');
			nav.click();

			Fn.loadReporte_validado(config);
		});

		$(document).on('click', '.card-body > ul > li > a', function (e) {
			var control = $(this);
            Promociones.urlActivo = control.data('url');
			Promociones.contentDetalle = control.data('contentdetalle');

			$('.filtros_aje').hide();
			$('.filtros_aje_resumido').hide();
			if(Promociones.urlActivo == 'Filtrar_Aje' || Promociones.urlActivo == 'Filtrar_resumen_aje'){
				$('.filtros_aje').show();
				if(Promociones.urlActivo == 'Filtrar_resumen_aje'){
					$('.filtros_aje_resumido').show();
				}
			}

			if(Promociones.urlActivo == 'Filtrar_Aje'){
				$('#btn-promociones-pdf').show();
			}else{
				$('#btn-promociones-pdf').hide();
			}
        });

		// $(document).on("click",".lk-show-foto",function(){
		// 	var control = $(this);

		// 	var data = { idVisita: control.data('visita'), cliente: control.data('cliente'), usuario: control.data('usuario'), perfil: control.data('perfil') };
		// 	var jsonString = { 'data': JSON.stringify(data) };
		// 	var configAjax = { 'url': Promociones.url + 'mostrarFotos', 'data': jsonString };

		// 	$.when( Fn.ajax(configAjax) ).then( function(a){
		// 		++modalId;
		// 		var fn='Fn.showModal({ id:'+modalId+',show:false });';
		// 		var btn=new Array();
		// 			btn[0]={title:'Cerrar',fn:fn};
		// 		Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn});
		// 	});
		// });

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
				var data=Fn.formSerializeObject( Promociones.frmRutas );
				data['elementos']=elementos;
				var jsonString={ 'data':JSON.stringify( data ) };
				var url = site_url+Promociones.url+'visibilidad_pdf';
				Fn.download(url,jsonString);
			}
		});

		$(document).on('change', '#empresa_filtro', function (e) {
			let idEmpresa = $(this).val();
			$(".categoria_filtro_content").html('<option value=""> -- Categoria --</option>');
			if(idEmpresa != ''){
				let data = { "idEmpresa": idEmpresa };
				let jsonString = { 'data': JSON.stringify(data) };
				let config = { 'url': Promociones.url + 'cargarCategorias', 'data': jsonString };
				$.when(Fn.ajax(config)).then(function (a) {
					$(".categoria_filtro_content").html(a.data.htmlcategorias);
				});
			}
		});
		$(document).on('click','#btn-promociones-pdf', function(e) {
			var data = {};
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': Promociones.url + 'getFormPromocionesPdf', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;

				var fn='Fn.showModal({ id:'+modalId+',show:false });';

				if(a.result == 0 ) var fn1='Fn.showModal({ id:'+modalId+',show:false });';
				if(a.result == 1 ) var fn1='Promociones.verificar_frm_promociones_pdf();';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
					btn[1]={title:'Generar',fn:fn1};
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:a.data,btn:btn});
			});
		});
	},
	verificar_frm_promociones_pdf: function(){

		let cantidadDeClientes = $('#clientes').val().length;
		let topeDeClientes = $('#topClientes').val();
		if(cantidadDeClientes <= topeDeClientes){
			Promociones.generar_pdf_promociones();
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
	generar_pdf_promociones: function(){
		var data=Fn.formSerializeObject( Promociones.frmRutas );
			data.frmPromociones = Fn.formSerializeObject('formPdfPromociones');
		var jsonString={ 'data':JSON.stringify( data ) };
		var url = site_url+Promociones.url+'promociones_pdf';
		
		Fn.download(url,jsonString);
	},
}

Promociones.load();