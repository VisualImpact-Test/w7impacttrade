var Iniciativas = {
	
	idFormFiltros: 'formFiltroIniciativas',
	url: 'Iniciativas/',
	contentDetalle: 'contentIniciativas',
	idTableDetalle : 'tb-Iniciativas',
	urlActivo: '',
	
	load: function () {
		$(document).ready(function (e) {
			Iniciativas.urlActivo = $(".card-body > ul > li > .active").data("url");
			Iniciativas.contentDetalle = $(".card-body > ul > li > .active").data("contentdetalle");
			$('.btn-consultar').click();
			$('.flt_grupoCanal').change();
        });

		$('.btn-consultar').on('click', function (e) {
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Iniciativas.idFormFiltros
				,'url': Iniciativas.url + Iniciativas.urlActivo
				,'contentDetalle': Iniciativas.contentDetalle
			}; 
			Fn.loadReporte_new(config);
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('.btn-consultar').click();
        });

		$('.btnReporte').on('click', function(e){
			e.preventDefault();
			var opcion = $(this).attr("data-value");
			$('#idReporte').val(opcion);
			$('.btn-consultar').click();
		});

		$(document).on('click', '.btn-editar-iniciativas', function (e) {
			e.preventDefault();
			
			var idIniciativaDet = $(this).attr('data-id');
			var data ={'idIniciativaDet':idIniciativaDet};

			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Iniciativas.url + 'editar_iniciativas', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				var idModal = ++modalId;
				var btn = new Array();
				btn[0] = { title: 'Cerrar', fn: 'Fn.showModal({ id:' + idModal + ',show:false });' };
				btn[1] = { title: 'Actualizar', fn: 'Iniciativas.Actualizar();' };
				Fn.showModal({ id: idModal, show: true, title:'Editar iniciativas', content: a.data, btn: btn, width: '600px' });
			});
		});
		
		$(document).on('click', '.btn-actualizar-validacion-analista', function (e) {
			e.preventDefault();
			
			var idIniciativaDet = $(this).attr('data-id');
			var data ={'idIniciativaDet':idIniciativaDet};
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Iniciativas.url + 'actualizar_estado_analista', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				if(a.data==1){
					$('#spanValidacion-'+idIniciativaDet).html('HABILITADO');
				}else{
					$('#spanValidacion-'+idIniciativaDet).html('INHABILITADO');
				}
			});
		});
		
		$(document).on('click','.btn-inhabilitar, .btn-habilitar',function(e){
			e.preventDefault();

			var rows = $('#data-table').DataTable().rows({ 'search': 'applied' }).nodes();
			var datos = {};

			let tipoHabilitar = $(this).data('tipohabilitar');

			$.each(rows, function(ir, vr){
			   var input = $(vr).find('input');

			   if( typeof(datos[ir]) == 'undefined' ){
				   datos[ir] = { 'iniciativas': '', 'tipoHabilitar': '' };
			   }

				$.each(input, function(ii, vi){
					if( $(vi).attr('type') == 'checkbox' ){
						if( $(vi).is(':checked') ){
							datos[ir]['iniciativas'] = $(vi).val();
							datos[ir]['tipoHabilitar'] = tipoHabilitar;
						}
					}
				});
			});

			var jsonString = { 'data':JSON.stringify( datos ) };
			var config = {'url':Iniciativas.url+'/inhabilitar_iniciativas','data':jsonString}; 
			$.when( Fn.ajax(config) ).then(function(a){
				++modalId;
				var btn = [];
				var fn = [];

				fn[0] = 'Fn.showModal({ id:'+modalId+',show:false });$(".btn-consultar").click();';
				btn[0] = { title: 'Continuar', fn: fn[0] };

				Fn.showModal({ id: modalId, show: true, title: a.msg.title, content: a.msg.content, btn: btn });
			});
		});
		
		$(document).on('click','.btn-validar',function(e){
			e.preventDefault();

			var rows = $('#data-table').DataTable().rows({ 'search': 'applied' }).nodes();
			var datos = {};

			$.each(rows, function(ir,vr){
			   var input = $(vr).find('input');

			   if( typeof(datos[ir]) == 'undefined' ){
				   datos[ir] = { 'iniciativas': [] };
			   }

				$.each(input, function(ii, vi){
					if( $(vi).attr('type') == 'checkbox' ){
						if( $(vi).is(':checked') ){
							datos[ir]['iniciativas'].push($(vi).val());
						}
					}
				});
			});

			var jsonString={ 'data':JSON.stringify( datos ) };
			var config={'url':Iniciativas.url+'/validar_iniciativas','data':jsonString}; 
			$.when( Fn.ajax(config) ).then(function(a){
				++modalId;
				var btn=[];
				var fn='Fn.showModal({ id:'+modalId+',show:false });$(".btn-consultar").click();';
				btn[0]={title:'Continuar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:'Confirmacion',content:a.data,btn:btn });
			});
		});
		
		$(".btn-pdf").on("click", function(e){
			e.preventDefault();

			Fn.showLoading(true);

			var rows = $('#tb-Iniciativas').DataTable().rows({ 'search': 'applied' }).nodes();
			var datos = {};
			datos['idIniciativaDet'] = [];

			$.each(rows, function(ir,vr){
			var input = $(vr).find('input');
			if( $(input).attr('type') == 'checkbox' ){
					if( $(input).is(':checked') ){
						datos['idIniciativaDet'].push($(input).val());
					}
				}
			});

			var f = $('#txt-fechas').val();
			var fechas = f.split('-');

			datos['fecIni'] = fechas[0];
			datos['fecFin'] = fechas[1];
			var data = { 'data': JSON.stringify({ datos }) };
			var url = Iniciativas.url+'iniciativas_pdf';
			$.when( Fn.download(url,data) ).then(function(){
				// Fn.showLoading(false);
				$('.modal-backdrop').hide();
			});
		});

		$(document).on("change", "#tipoUsuario", function (e) {

			var idTipoUsuario=$("#tipoUsuario").val();
			var data = {'idTipoUsuario': idTipoUsuario};
			
            var jsonString = { 'data': JSON.stringify(data) };
		
            var config = { 'url': Iniciativas.url + "obtener_usuarios", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {
                
                if (a.result == 1){
					var html="<option >--Usuario--</option>";
					if( a.data.usuarios!=null){
						for (var [key, value] of Object.entries(a.data.usuarios)) {
							html+='<option value='+( value['idUsuario'] )+'>'+( value['nombreUsuario'] )+'</option>';
						}
					}
					$("#usuario").html(html);
				}
            });
        });

		$(document).on('click','.checkAll',function(e){
			e.preventDefault();

			var rows = $('#tb-Iniciativas').DataTable().rows({ 'search': 'applied' }).nodes();
			var datos = {};

			$.each(rows, function(ir,vr){
			   	var input = $(vr).find('input');

				if( typeof(datos[ir]) == 'undefined' ){
					datos[ir] = { 'iniciativas': [] };
				}

				$.each(input, function(ii, vi){
					if( $(vi).attr('type') == 'checkbox' ){
						$(vi).click();
					}
				});
			});
		});
	},
	
	Actualizar: function (){
		var data = Fn.formSerializeObject('editarIniciativas');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Iniciativas.url + 'actualizar_iniciativas', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {
			++modalId;
			let btn = [];
			let fn = [];
			fn[0] = 'Fn.showModal({ id:'+modalId+',show:false });';
			btn[0] = { title:'Continuar', fn:fn[0] };
			Fn.showModal({ id:modalId, show:true, title:a.msg.title, content:a.msg.content, btn:btn });
		});
	},
	
	Habilitar_analista: function (){
		var data = Fn.formSerializeObject('editarIniciativas');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Iniciativas.url + 'actualizar_estado_analista', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {
			$('#resultadoIniciativasEditar').html(a.data);
		}); 
	},
}
Iniciativas.load();