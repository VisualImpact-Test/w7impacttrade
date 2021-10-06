var Fotografico = {

	idFormFiltros: 'formFiltroFotografico',
	url: 'fotografico/',
	idDivContent: 'contentFotografico',
	idTableDetalle : 'tb-Fotografico',

	load: function () {

		$('.btn-consultar').on('click', function (e) {
			e.preventDefault();

			var data = Fn.formSerializeObject(Fotografico.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Fotografico.url + 'lista_fotografico', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
				$('#'+Fotografico.idDivContent).parent().removeClass("hide");
				$('#'+Fotografico.idDivContent).html(a.data);
				var $datatable = $('#data-table');
				
				$datatable.dataTable();
			}); 
		});

		$(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('.btn-consultar').click();
        });
		
		$(document).on('click', '.btn-registrar-auditoria-cartera', function(e){
			e.preventDefault();

			var idVisita = $(this).attr('data-visita');
			var resultado = $("#resultado-visita-"+idVisita).text();
			var rbPrecios = 'marca-precios-'+idVisita;
			var precios = $("input:radio[name="+rbPrecios+"]:checked").val();

			var elementos = new Array();
			$("#tabla-visita-"+idVisita+" tbody>tr").each(function(index, value){
				var idElemento = $(this).attr('data-elemento');
				var pc_valor = $("#pc-elemento-"+idVisita+"-"+idElemento).val();
			    var pl_valor = $("#pl-elemento-"+idVisita+"-"+idElemento).val();
				if((pc_valor=='1')&&(pl_valor=='1')){ var valor = 1; } else { var valor = 0; }
				var elementoConcat = idElemento+'-'+pc_valor+'-'+pl_valor+'-'+valor;
				elementos.push(elementoConcat);
			});

			if(resultado == ""){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				btn[0]={title:'Aceptar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:'ALERTA',content:'Debe completar el resultado de la auditoria para poder guardar',btn:btn });
		    } else {
				$.ajax({
					dataType: 'json',
					type: 'POST',
					url: '../'+Fotografico.url+'procesar_auditoria',
					data: {  idVisita:idVisita, resultado:resultado, elementos:elementos, precios:precios },
					beforeSend: function () {
						var contenido = "<div class='alert alert-success'>Procesando, espere por favor...</div>";
						$("#resultado-auditoria-"+idVisita).html(contenido).fadeIn('selow');
					},
					success: function(result) {
						if(result.cod == 1) { var contenido = "<div class='alert alert-success'>"+result.msg+"</div>"; }
						else if(result.cod == 0) { var contenido = "<div class='alert alert-danger'>"+result.msg+"</div>"; }
						$("#resultado-auditoria-"+idVisita).html(contenido).fadeIn('selow');
					},
					timeout: 180000,
					error: function() {
					   var contenido = "<div class='alert alert-danger'>Ocurrio un error, vuelva a intentarlo.</div>";
					   $("#resultado-auditoria-"+idVisita).html(contenido).fadeIn('selow');
					}
				})
			}
		});
		
		$(document).on('change', '.calcular-valor', function(e){
			e.preventDefault();
			var idVisita = $(this).attr('data-visita');
			var idElemento = $(this).attr('data-elemento');
			var cantidadElementos = $(this).attr('data-cantidad');

			var pc_valor = $("#pc-elemento-"+idVisita+"-"+idElemento).val();
			var pl_valor = $("#pl-elemento-"+idVisita+"-"+idElemento).val();

			if((pc_valor=='1')&&(pl_valor=='1')){ 
			  $("#resultado-elemento-"+idVisita+"-"+idElemento).text('SI CUMPLE'); 
			} else { 
			  $("#resultado-elemento-"+idVisita+"-"+idElemento).text('NO CUMPLE'); 
			}

			var totalElementos = parseInt(cantidadElementos);
			var totalOK = 0;
			$("#tabla-visita-"+idVisita+" tbody>tr").each(function(index, value){
				var idElemento = $(this).attr('data-elemento');
				var pc_valor = $("#pc-elemento-"+idVisita+"-"+idElemento).val();
			    var pl_valor = $("#pl-elemento-"+idVisita+"-"+idElemento).val();
				if((pc_valor=='1')&&(pl_valor=='1')){ totalOK = totalOK + 1; } else { totalOK = totalOK + 0; }
			});

			var resultadoEO = parseFloat(totalOK/totalElementos)*100;
			$("#resultado-visita-"+idVisita).text(Math.round(resultadoEO));
		});

		$(document).on('click','.btn-auditar',function(e){
			e.preventDefault();

			var rows = $('#data-table').DataTable().rows({ 'search': 'applied' }).nodes();
			var datos = {};

			$.each(rows, function(ir,vr){
			   var input = $(vr).find('input');

			   if( typeof(datos[ir]) == 'undefined' ){
				   datos[ir] = { 'idVisita': [] };
			   }

				$.each(input, function(ii, vi){
					if( $(vi).attr('type') == 'checkbox' ){
						if( $(vi).is(':checked') ){
							datos[ir]['idVisita'].push($(vi).val());
						}
					}

				});
			});

			var f = $('#txt-fechas').val();
			var fechas = f.split('-');

			datos['fecIni'] = fechas[0];
			datos['fecFin'] = fechas[1];
			
			var jsonString={ 'data':JSON.stringify( datos ) };
			var config={'url':Fotografico.url+'auditar_Fotografico','data':jsonString}; 
			$.when( Fn.ajax(config) ).then(function(a){
				if(a.result == 1) $('#'+Fotografico.idDivContent).html(a.data);
				if(a.result == 0){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
					btn[0]={title:'Aceptar',fn:fn};
					Fn.showModal({ id:modalId,show:true,title:'Alerta',content:a.data.content,btn:btn });
				}

			});			

		});
		$(document).on('click','.verImagenModal',function(e){
			e.preventDefault();

			var datos = {'url': $(this).attr('href')};
			var jsonString={ 'data':JSON.stringify( datos ) };
			var config={'url':Fotografico.url+'verFotoModal','data':jsonString}; 
			$.when( Fn.ajax(config) ).then(function(a){
				
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:'Foto',content:a.data.content,btn:btn });

			});			

		});
		
		$(".btn-pdf").on("click",function(e){
			e.preventDefault();

			var data = Fn.formSerializeObject(Fotografico.idFormFiltros);
			var jsonString = { 'data': JSON.stringify(data) };
			
			var url = 'fotografico_pdf';
			Fn.download(Fotografico.url+url,jsonString);
		});

		$(document).ready(function () {
			$('.btn-consultar').click();
			$(".flt_grupoCanal").change();
		});
	},
	
	Actualizar: function (){
		var data = Fn.formSerializeObject('editar');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Fotografico.url + 'actualizar_Fotografico', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {
			$('#resultadoFotograficoEditar').html(a.data);
		}); 
	},
	
	Habilitar_analista: function (){
		var data = Fn.formSerializeObject('editar');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Fotografico.url + 'actualizar_estado_analista', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {
			$('#resultadoFotograficoEditar').html(a.data);
		}); 
	},
}
Fotografico.load();