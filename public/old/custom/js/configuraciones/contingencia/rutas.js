var ContingenciaRutas = {

	frmRutas: 'frm-contingenciaRutas',
	contentDetalle: 'idDetalleContingenciaRutas',
	idTableDetalle : 'tb-contingenciaRutasDetalle',
	url : 'configuraciones/contingencia/rutas/',
	idModal: 0,

	dataListaTipoPromociones : [],
	dataListaEncartesCategorias : [],
	dataListaRegiones : [],
	dataListaCategoriaCompetencia : [],
	dataListaTipoCompetencia : [],
	dataListaElementosVisibilidadTrad: [],
	dataListaEstadoElementosTrad: [],
	dataListaTipoFoto: [],

	load: function(){

		$('.tipoDetalladoSupervisor').hide();

		$('.btnReporte').on('click', function(e){
			var opcion = $(this).children('input').val();

			if ( opcion==1 ) {
				$('.tipoDetalladoSupervisor').hide(1000);
				$('.tipoDetalladoGtm').show(1000);
			} else if ( opcion==2 ) {
				$('.tipoDetalladoSupervisor').show(1000);
				$('.tipoDetalladoGtm').hide(1000);
			}
		});

		$(document).on('click','#btn-filtrarContingenciaRutas', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : ContingenciaRutas.frmRutas
				,'url': ContingenciaRutas.url + control.data('url')
				,'contentDetalle': ContingenciaRutas.contentDetalle
			};

			Fn.loadReporte(config);
		});

		/**************HORARIOS***********/
		$(document).on('click','.saveHorarioVisita', function(e){
			e.preventDefault();

			var control = $(this);
			var visita = control.data('visita');

			var horaInicio = $('#horaInicio-'+visita).val();
			if ( typeof horaInicio === 'undefined' || horaInicio=='') {
				horaInicio = null;
			}
			var horaFin = $('#horaFin-'+visita).val();
			if ( typeof horaFin === 'undefined' || horaFin=='') {
				horaFin = null;
			}

			if ( horaInicio==null && horaFin==null) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha registrado ningún cambio en la información de los horarios' });
				Fn.showModal({ id:modalId,title:'HORARIOS',content:message,btn:btn,show:true});
			} else {
				var horarios = { 'visita':visita, 'horaInicio': horaInicio, 'horaFin':horaFin };
				++modalId;
				var fn1='ContingenciaRutas.actualizarHorarios('+JSON.stringify(horarios)+');Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		});

		/**************INCIDENCIA VISITA****************/
		$(document).on('click','.incidenciaVisita', function(){
			var control = $(this);
			var visita = control.data('visita');
			var estado = 0;
			var cliente = control.data('cliente');
			var widthModal = control.data('width'); 

			estado = control.is(':checked') ? 1 : 0;

			var data={ visita:visita, estado:estado };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': ContingenciaRutas.url + 'visitaIncidencia', 'data': jsonString };
			
			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });ContingenciaRutas.verificarIncidenciaEstado('+JSON.stringify(data)+')';
				var btn=new Array();
					btn[0]={title:'Guardar',fn:a.data.htmlGuardar};
					btn[1]={title:'Cerrar',fn:fn};
				var html='';
					html+='<h4><strong>'+cliente+'</strong></h4>';
					html+= a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:html,btn:btn, width:widthModal});
				ContingenciaRutas.idModal = modalId;
			});
		});

		$(document).on('change','#tipoIncidencia', function(e){
			var text = $('#tipoIncidencia option:selected').text();
			$('#nombreIncidencia').val(text);
		});

		/*****************MODULOS VISITA********************/
		$(document).on('click', '.visitaModulo', function(e){
			e.preventDefault();

			var control = $(this);
			var title = control.data('title');
			var modulo = control.data('modulo');
			var visita = control.data('visita');
			var lista = control.data('lista');
			var columna = control.data('columna');
			var widthModal = control.data('width');

			var cliente = control.data('cliente');

			var data={ modulo:modulo, visita:visita, lista:lista, columna:columna };
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': ContingenciaRutas.url + 'visitaModulos', 'data': jsonString };

			$.when( Fn.ajax(configAjax) ).then( function(a){
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					if (a.data.htmlButtons==1) {
						btn[0]={title:'Cerrar',fn:fn};
					} else if (a.data.htmlButtons==2) {
						btn[0]={title:'Guardar',fn:a.data.htmlGuardar};
						btn[1]={title:'Cerrar',fn:fn};
					} else{
						btn[0]={title:'Cerrar',fn:fn};
					}
				
				var html = '';
					html += '<h4><strong>'+cliente+'</strong></h4>';
					//html += '<p class="user-name">Perfil: '+perfil+' <br />';
					//html += 'Usuario: '+usuario+'</p>';
					html += a.data.html;
				Fn.showModal({ id:modalId,show:true,title:title,content:html,btn:btn, width:widthModal});
			});
		});

		$(document).on("click",".lk-foto",function(){
			var control = $(this);
			var fotoUrl = control.data('fotourl');
			//var hora=control.data('hora');
			//var html_content = control.data('html');
			var img='<img src="'+fotoUrl+'" class="img-responsive center-block img-thumbnail" />';
			var html = img;
			
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:"ZOOM FOTO",content:html,btn:btn});
		});

		$(document).on('click','.btn-file', function(e){
			e.preventDefault();
			var file = $(this).attr("data-file");
			$('#'+file).click();
		});

		$(document).on("change", ".fl-control", function(file_) {
			var content = $(this).attr("data-content");
			var file = file_.target.files[0];
			var foto_content = $(this).attr("data-foto-content");

			if(file.size>=2*1024*1024) {
				++modalId;
				var btn=[];
				var fn='Functions.showModal({ id:'+modalId+',show:false });';

				btn[0]={title:'Continuar',fn:fn};
				Functions.showModal({ id:modalId,show:true,title:'Archivo',content:"El tamaño del archivo seleccionado excede al permitido (2MB)",btn:btn });
				return;
			}
			Imagen.show( file_, foto_content, content, this );
        });

        /***************VISITA PRODUCTOS - PRECIOS******************/
        $(document).on('click','a[data-toggle="tab"]', function(e){
        	
			$('#tb-productos-0').DataTable().columns.adjust();
			$('#tb-productos-1').DataTable().columns.adjust();
			$('#tb-precios-0').DataTable().columns.adjust();
			$('#tb-precios-1').DataTable().columns.adjust();
		});

        /***************VISITA PROMOCIONES***************/
        $(document).on('click','#btn-addRowPromociones', function(e){
        	e.preventDefault();

        	var cont = parseInt($('#contNumberPromociones').val())+1;
        	var prefijo = "AD"+cont;
        	var listaTipoPromociones = ContingenciaRutas.dataListaTipoPromociones;

        	var fila = '';
        		fila+='<tr class="tr-promociones-ad tr-promociones-adicionales" data-visitaPromociones="0" data-visitaPromocionesDet="'+prefijo+'" data-promocion="0">';
        			fila+='<td class="text-center">';
        				fila+='<button type="button" class="btn-deleteRowPromociones btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				//fila+='<input class="form-control ipWidth" type="text" placeholder="Tipo Promoción" id="tipoPromocion-'+prefijo+'"  name="tipoPromocion-'+prefijo+'" value="">';
        				fila+='<select class="form-control slWidth" name="tipoPromocion-'+prefijo+'" id="tipoPromocion-'+prefijo+'">';
							fila+='<option value="">Tipo de Promoción</option>';
							$.each(listaTipoPromociones, function(index,value){
								fila+='<option value="'+value.idTipoPromocion+'">'+value.tipoPromociones+'</option>';
							});
						fila+='</select>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<input class="form-control ipWidth" type="text" placeholder="Nombre Promoción" id="nombrePromocion-'+prefijo+'"  name="nombrePromocion-'+prefijo+'" value="">';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<div class="custom-checkbox custom-control">';
							fila+='<input class="custom-control-input" type="checkbox" id="presencia-'+prefijo+'"  name="presencia-'+prefijo+'" value="1" >';
							fila+='<label class="custom-control-label" for="presencia-'+prefijo+'"></label>';
						fila+='</div>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<div class="row" id="foto-'+prefijo+'">';
							fila+='<div class="col">';
								fila+='<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-'+prefijo+'">';
									fila+='<img class="fotoMiniatura foto" name="img-fotoprincipal-'+prefijo+'" id="img-fotoprincipal-'+prefijo+'" src="" alt="">';
								fila+='</a>';
							fila+='</div>';
							fila+='<div class="col">';
								fila+='<div class="content-input-file">';
									fila+='<input type="text" readonly="readonly" id="txt-fotoprincipal-'+prefijo+'" name="fotoprincipal-'+prefijo+'" class="hide" >';
									fila+='<input type="text" readonly="readonly" id="txt-fotoprincipal-'+prefijo+'_show" class="text-file" placeholder="Solo .jpg" >';
									fila+='<span class="btn-file btnFoto" data-file="fl-fotoprincipal-'+prefijo+'"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>';
									fila+='<input type="file" id="fl-fotoprincipal-'+prefijo+'" class="fl-control hide" name="filefotoprincipal-'+prefijo+'" data-content="txt-fotoprincipal-'+prefijo+'"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-'+prefijo+'" >';
								fila+='</div>';
							fila+='</div>';
						fila+='</div>';
        			fila+='</td>';
        		fila+='</tr>';

        	$('#tb-promociones tbody.tb-promocion').append(fila).trigger("create");
        	$('#contNumberPromociones').val(cont);
        	$('#tipoPromocion-'+prefijo).focus();
        });

        $(document).on('click','.btn-deleteRowPromociones', function(e){
        	e.preventDefault();

        	var control = $(this);
        	control.parents('tr').remove();
        });

        /**************VISITA SOS*************************/
        $(document).on('change','.marcasCm', function(e){
        	e.preventDefault();

        	var control = $(this);
        	var categoria = control.data('categoria');

        	var sumaCategoria=0;
        	$('.marca-cm-'+categoria).each( function(e){
        		var eThis = $(this);
        		//if ( !isNaN(eThis.val()) ) {
        		if ( eThis.val() !== "" ){
        			sumaCategoria = parseFloat(sumaCategoria + parseFloat(eThis.val()));
        		}
        	});

        	$('#categoria-cm-'+categoria).val(sumaCategoria);
        });

        $(document).on('change','.marcasFrentes', function(e){
        	e.preventDefault();

        	var control = $(this);
        	var categoria = control.data('categoria');

        	var sumaCategoria=0;
        	$('.marca-frentes-'+categoria).each( function(e){
        		var eThis = $(this);
        		//if ( !isNaN(eThis.val()) ) {
        		if ( eThis.val() !== "" ){
        			sumaCategoria = parseFloat(sumaCategoria + parseFloat(eThis.val()));
        		}
        	});

        	$('#categoria-frentes-'+categoria).val(sumaCategoria);
        });
        /*****************/

        /**********VISITA SOD****************/
        $(document).on('click','.btn-sod-fotos', function(e){
        	e.preventDefault();

        	var control = $(this);
        	var categoria = control.data('categoria');
        	var marca = control.data('marca');
        	var elementoVisibilidad = control.data('elementovisibilidad');
        	var idVisita = $("#idVisita").val();

        	var data = {'idVisita': idVisita, 'categoria': categoria, 'marca':marca, 'elementoVisibilidad':elementoVisibilidad };
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url':ContingenciaRutas.url+'verFotosSod', 'data': jsonString };

			$.when( Fn.ajax(config) ).then( function(a){
				++modalId;
				var fn1='ContingenciaRutas.guardarSodFotos();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Guardar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
			});
        });

        $(document).on('click','#btn-addRowSodFoto', function(e){
        	e.preventDefault();
        	var control = $(this);
        	var visita = control.data('visita');
        	var categoria = control.data('categoria');
        	var marca = control.data('marca');
        	var tipoElementoVisibilidad = control.data('tipoelemento');

        	var cont = parseInt($('#contNumberSodFotos').val())+1;
        	var prefijo = "ADF"+cont;
        	
        	var fila='';
        		fila+='<tr class="tr-sodFotos-adicional" data-indice="'+prefijo+'" data-visita="'+visita+'" data-categoria="'+categoria+'" data-marca="'+marca+'" data-tipoElementoVisibilidad="'+tipoElementoVisibilidad+'">';
        			fila+='<td class="text-center">';
        				fila+='<button type="button" class="btn-deleteRowFotosSod btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button>';
        			fila+='</td>';
        			fila+='<td>';
        				fila+='<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-'+prefijo+'">';
							fila+='<img class="imgNormal foto" name="img-fotoprincipal-'+prefijo+'" id="img-fotoprincipal-'+prefijo+'" src="" alt="">';
						fila+='</a>';
        			fila+='</td>'
        			fila+='<td>';
        				fila+='<div>';
        					fila+='<div class="content-input-file">';
								fila+='<input type="text" readonly="readonly" id="txt-fotoprincipal-'+prefijo+'" name="fotoprincipal-'+prefijo+'" class="hide" >';
								fila+='<input type="text" readonly="readonly" id="txt-fotoprincipal-'+prefijo+'_show" class="text-file" placeholder="Solo .jpg" >';
								fila+='<span class="btn-file btnFoto" data-file="fl-fotoprincipal-'+prefijo+'"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>';
								fila+='<input type="file" id="fl-fotoprincipal-'+prefijo+'" class="fl-control hide" name="filefotoprincipal-'+prefijo+'" data-content="txt-fotoprincipal-'+prefijo+'"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-'+prefijo+'" >';
							fila+='</div>';
        				fila+='</div>';
        			fila+='</td>'
        		fila+='</tr>';

        	$('#tb-sod-fotos tbody.tb-sod-foto').append(fila).trigger("create");
        	$('#contNumberSodFotos').val(cont);
        });

        $(document).on('click','.btn-deleteRowFotosSod', function(e){
        	e.preventDefault();

        	var control = $(this);
        	control.parents('tr').remove();
        });

        $(document).on('change','.ipCantidadMarcaElemento', function(e){
        	e.preventDefault();

        	var control = $(this);
        	var categoria = control.data('categoria');
        	var marca = control.data('marca');
        	var elementovisibilidad = control.data('elementovisibilidad');

        	var sumaCategoria=0;
        	$('.cantidad-'+categoria+'-'+elementovisibilidad).each( function(e){
        		var eThis = $(this);
        		if ( eThis.val() !== "" ){
        			sumaCategoria = parseFloat(sumaCategoria + parseFloat(eThis.val()));
        		}
        	});

        	$('#cantidadEleVisibilidad-'+categoria+'-'+elementovisibilidad).val(sumaCategoria);
        });

        /**************VISITA ENCARTES***********/
        $(document).on('click','#btn-addRowPromociones', function(e){
        	e.preventDefault();

        	var cont = parseInt($('#contNumberEncartes').val())+1;
        	var prefijo = "AD"+cont;
        	var listaCategorias = ContingenciaRutas.dataListaEncartesCategorias;

        	var fila = '';
        		fila+='<tr class="tr-encartes tr-encartes-adicionales" data-visitaEncartes="0" data-visitaEncartesDet="'+prefijo+'" >';
        			fila+='<td class="text-center">';
        				fila+='<button type="button" class="btn-deleteRowEncartes btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<select class="form-control slWidth" name="categoria-'+prefijo+'" id="categoria-'+prefijo+'">';
							fila+='<option value="">Lista Categoria</option>';
							$.each(listaCategorias, function(index,value){
								fila+='<option value="'+value.idCategoria+'">'+value.categoria+'</option>';
							});
						fila+='</select>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<div class="row" id="foto-'+prefijo+'">';
							fila+='<div class="col">';
								fila+='<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-'+prefijo+'">';
									fila+='<img class="fotoMiniatura foto" name="img-fotoprincipal-'+prefijo+'" id="img-fotoprincipal-'+prefijo+'" src="" alt="">';
								fila+='</a>';
							fila+='</div>';
							fila+='<div class="col">';
								fila+='<div class="content-input-file">';
									fila+='<input type="text" readonly="readonly" id="txt-fotoprincipal-'+prefijo+'" name="fotoprincipal-'+prefijo+'" class="hide" >';
									fila+='<input type="text" readonly="readonly" id="txt-fotoprincipal-'+prefijo+'_show" class="text-file" placeholder="Solo .jpg" >';
									fila+='<span class="btn-file btnFoto" data-file="fl-fotoprincipal-'+prefijo+'"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>';
									fila+='<input type="file" id="fl-fotoprincipal-'+prefijo+'" class="fl-control hide" name="filefotoprincipal-'+prefijo+'" data-content="txt-fotoprincipal-'+prefijo+'"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-'+prefijo+'" >';
								fila+='</div>';
							fila+='</div>';
						fila+='</div>';
        			fila+='</td>';
        		fila+='</tr>';

        	$('#tb-encartes tbody.tb-encarte').append(fila).trigger("create");
        	$('#contNumberEncartes').val(cont);
        });

        $(document).on('click','.btn-deleteRowEncartes', function(e){
        	e.preventDefault();
        	var control = $(this);
        	control.parents('tr').remove();
        });
        /****************************/

        /*************VISITA FOTOS***************/
        $(document).on('click','.btn-deleteRowModuloFoto',function(e){
        	e.preventDefault();
        	var control = $(this);
        	var visitaModuloFoto = control.data('visitamodulofoto');

        	++modalId;
			var fn1='ContingenciaRutas.guardarFotoEstado('+visitaModuloFoto+');Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Confirmar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea eliminar la foto capturada?' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
        })

        $(document).on('click','#btn-addRowFoto', function(e){
        	e.preventDefault();

        	var cont = parseInt($('#contNumberFotos').val())+1;
        	var prefijo = "AD"+cont;
        	var listaTipoFoto = ContingenciaRutas.dataListaTipoFoto;

        	var fila = '';
        		fila+='<tr class="tr-moduloFoto tr-moduloFoto-adicionales" data-visitaModuloFoto="'+prefijo+'" >';
        			fila+='<td class="text-center">'+cont+'</td>';
        			fila+='<td class="text-center">';
        				fila+='<select class="form-control slWidth" name="tipoFoto-'+prefijo+'" id="tipoFoto-'+prefijo+'">';
							fila+='<option value="">Tipo de Foto</option>';
							$.each(listaTipoFoto, function(index,value){
								fila+='<option value="'+value.idTipoFoto+'">'+value.tipoFoto+'</option>';
							});
						fila+='</select>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<div class="row" id="foto-'+prefijo+'">';
							fila+='<div class="col">';
								fila+='<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-'+prefijo+'">';
									fila+='<img class="imgNormal foto" name="img-fotoprincipal-'+prefijo+'" id="img-fotoprincipal-'+prefijo+'" src="" alt="">';
								fila+='</a>';
							fila+='</div>';
							fila+='<div class="col">';
								fila+='<div class="content-input-file">';
									fila+='<input type="text" readonly="readonly" id="txt-fotoprincipal-'+prefijo+'" name="fotoprincipal-'+prefijo+'" class="hide" >';
									fila+='<input type="text" readonly="readonly" id="txt-fotoprincipal-'+prefijo+'_show" class="text-file" placeholder="Solo .jpg" >';
									fila+='<span class="btn-file btnFoto" data-file="fl-fotoprincipal-'+prefijo+'"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>';
									fila+='<input type="file" id="fl-fotoprincipal-'+prefijo+'" class="fl-control hide" name="filefotoprincipal-'+prefijo+'" data-content="txt-fotoprincipal-'+prefijo+'"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-'+prefijo+'" >';
								fila+='</div>';
							fila+='</div>';
						fila+='</div>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<input class="form-control ipWidth" type="text" placeholder="Comentario" id="comentario-'+prefijo+'"  name="comentario-'+prefijo+'" value="">';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<button type="button" class="btn-deleteRowFotosAdicionales btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button>';
        			fila+='</td>';
        		fila+='</tr>';

        	$('#tb-fotos tbody.tb-foto').append(fila).trigger("create");
        	$('#contNumberFotos').val(cont);
        	$('#tipoFoto-'+prefijo).focus();
        });

        $(document).on('click','.btn-deleteRowFotosAdicionales', function(e){
        	e.preventDefault();

        	var control = $(this);
        	control.parents('tr').remove();
        });
        /****************************/

        /*************VISITA INVENTARIO***************/
        $(document).on('change','.stockInventario', function(e){
        	e.preventDefault();
        	var input = $(this);
        	var producto = input.data('producto');
        	var stockInicial = $('#stockInicial-'+producto).val();
        	var sellin = $('#sellin-'+producto).val();
        	var stock = input.val();
        	var sellOut = '';
        	var obs = '';

           	if(stock.length>0){
        		if(stockInicial.length>0){
        			sellOut = ( parseFloat(stockInicial) + parseFloat(sellin) ) - parseFloat(stock);
					obs = (sellOut==0) ? 'VENTA CERO' : (sellOut>0) ? 'OK':'NEGATIVA';
        		} else {
        			sellOut = 0 - parseFloat(stock);
        		    obs = 'NEGATIVA';
        		}
        	}

        	$('#validacion-'+producto).val(sellOut.toFixed(2));
            $('#obs-'+producto).val(obs);
        });
        /****************************/

        /*************VISITA MANTENIMIENTO***************/
        $(document).on('change','#cod_departamento', function(){
        	var control = $(this);
        	var cod_departamento = control.val();

        	var option='';
        	option +='<option value="">-- Provincias --</option>';
        	$.each(ContingenciaRutas.dataListaRegiones[cod_departamento]['listaProvincias'], function(ix,val){
        		option +='<option value="'+val.cod_provincia+'">'+val.provincia+'</option>';
        	});

        	$('#cod_provincia option').remove();
        	$('#cod_provincia').append(option).trigger("create");
        	$('#cod_distrito option').remove();
        	$('#cod_distrito').append('<option value="">-- Distritos --</option>').trigger("create");
        	$('#cod_ubigeo').val('');
        });

        $(document).on('change','#cod_provincia', function(){
        	var control = $(this);
        	var cod_departamento = $('#cod_departamento').val();
        	var cod_provincia = control.val();

        	var option='';
        	option +='<option value="">-- Distritos --</option>';
        	$.each(ContingenciaRutas.dataListaRegiones[cod_departamento]['listaProvincias'][cod_provincia]['listaDistritos'], function(ix,val){
        		option +='<option value="'+val.cod_distrito+'" data-ubigeo="'+val.cod_ubigeo+'">'+val.distrito+'</option>';
        	});

        	$('#cod_distrito option').remove();
        	$('#cod_distrito').append(option).trigger("create");
        	$('#cod_ubigeo').val('');
        });

        $(document).on('change','#cod_distrito', function(){
        	var control = $('#cod_distrito option:selected');
        	var cod_ubigeo = control.data('ubigeo');

        	$('#cod_ubigeo').val(cod_ubigeo);
        });
        /****************************/

		/*************VISITA VISIBILIDAD***************/
		$(document).on('click','#btn-addRowVisibilidadTrad', function(e){
			e.preventDefault();

        	var cont = parseInt($('#contNumberVisibilidadTrad').val())+1;
        	var prefijo = "AD"+cont;
        	var listaElementosVisibilidad = ContingenciaRutas.dataListaElementosVisibilidadTrad;
        	var listaEstadoElementos = ContingenciaRutas.dataListaEstadoElementosTrad;

        	var fila='';
        		fila+='<tr class="tr-visibilidadTrad tr-visibilidadTrad-adicionales" data-visitaVisibilidad="0" data-visitaVisibilidadDet="'+prefijo+'">';
        			fila+='<td class="text-center">';
        				fila+='<button type="button" class="btn-deleteRowVisibilidadTrad btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<select class="form-control slWidth" name="elementoVisibilidad-'+prefijo+'" id="elementoVisibilidad-'+prefijo+'" patron="requerido">';
							fila+='<option value="">-- Lista Elementos --</option>';
							$.each(listaElementosVisibilidad, function(index,value){
								fila+='<option value="'+value.idElementoVis+'">'+value.elementoVisibilidad+'</option>';
							});
						fila+='</select>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<select class="form-control slWidth condicionElemento" name="condicion-'+prefijo+'" id="condicion-'+prefijo+'" data-visitaVisibilidadDet="'+prefijo+'" >';
							fila+='<option value="">--- Condición ---</option>';
							fila+='<option value="0">MODULADOS</option>';
							fila+='<option value="1">NO MODULADOS</option>';
						fila+='</select>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
						fila+='<div class="custom-checkbox custom-control">';
							fila+='<input class="custom-control-input" type="checkbox" id="presencia-'+prefijo+'"  name="presencia-'+prefijo+'" value="1" >';
							fila+='<label class="custom-control-label" for="presencia-'+prefijo+'"></label>';
						fila+='</div>';
					fila+='</td>';
					fila+='<td class="text-center">';
						fila+='<input type="text" class="form-control ipWidth" placeholder="Cantidad" id="cantidad-'+prefijo+'"  name="cantidad-'+prefijo+'" value="">';
					fila+='</td>';
					fila+='<td class="text-center">';
						fila+='<select class="form-control slWidth" name="estadoElemento-'+prefijo+'" id="estadoElemento-'+prefijo+'">';
							fila+='<option value="">--- Estado ---</option>';
							$.each(listaEstadoElementos, function(index,value){
								fila+='<option value="'+value.idEstadoElemento+'">'+value.estadoElemento+'</option>';
							});
						fila+='</select>';
					fila+='</td>';
					fila+='<td class="text-center">';
						fila+='<div class="row" id="foto-'+prefijo+'">';
							fila+='<div class="col">';
								fila+='<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-'+prefijo+'">';
									fila+='<img class="fotoMiniatura foto" name="img-fotoprincipal-'+prefijo+'" id="img-fotoprincipal-'+prefijo+'" src="" alt="">';
								fila+='</a>';
							fila+='</div>';
							fila+='<div class="col">';
								fila+='<div class="content-input-file">';
									fila+='<input type="text" readonly="readonly" id="txt-fotoprincipal-'+prefijo+'" name="fotoprincipal-'+prefijo+'" class="hide" >';
									fila+='<input type="text" readonly="readonly" id="txt-fotoprincipal-'+prefijo+'_show" class="text-file" placeholder="Solo .jpg" >';
									fila+='<span class="btn-file btnFoto" data-file="fl-fotoprincipal-'+prefijo+'"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>';
									fila+='<input type="file" id="fl-fotoprincipal-'+prefijo+'" class="fl-control hide" name="filefotoprincipal-'+prefijo+'" data-content="txt-fotoprincipal-'+prefijo+'"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-'+prefijo+'" >';
								fila+='</div>';
							fila+='</div>';
						fila+='</div>';
					fila+='</td>';
        		fila+='</tr>';

        	$('#tb-visibilidadTrad tbody.tb-visibilidadTrad').append(fila).trigger("create");
        	$('#contNumberVisibilidadTrad').val(cont);
		});

		$(document).on('click','.btn-deleteRowVisibilidadTrad', function(e){
        	e.preventDefault();
        	var control = $(this);
        	control.parents('tr').remove();
        });

        $(document).on('change','.condicionElemento', function(e){
        	e.preventDefault();
        	var select = $(this);
        	var indice = select.data('visitavisibilidaddet');

        	if (select.val()==1) {
        		$('#presencia-'+indice).prop('checked',false);
        		$('#presencia-'+indice).prop('disabled',true);
        		$('#cantidad-'+indice).val('').prop('disabled',true);
        		$('#estadoElemento-'+indice).val('').prop('disabled',true);
        	} else {
        		$('#presencia-'+indice).prop('disabled',false);
        		$('#cantidad-'+indice).prop('disabled',false);
        		$('#estadoElemento-'+indice).prop('disabled',false);
        	}
        });
		/****************************/

        /*************VISITA INTELIGENCIA***************/
        $(document).on('click','#btn-addRowInteligencia', function(e){
        	e.preventDefault();

        	var cont = parseInt($('#contNumberCompetencias').val())+1;
        	var prefijo = "AD"+cont;
        	var listaCategorias = ContingenciaRutas.dataListaCategoriaCompetencia;
        	var listaTipoCompetencias = ContingenciaRutas.dataListaTipoCompetencia;

        	var fila='';
        		fila+='<tr class="tr-competencias tr-competencias-adicionales" data-visitaInteligencia="0" data-visitaInteligenciaCompetitiva="'+prefijo+'">';
        			fila+='<td class="text-center">';
        				fila+='<button type="button" class="btn-deleteRowCompetencias btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<select class="form-control slWidth categoriaCompetencias" name="categoria-'+prefijo+'" id="categoria-'+prefijo+'" data-prefijo="'+prefijo+'">';
							fila+='<option value="">-- Lista Categorias --</option>';
							$.each(listaCategorias, function(index,value){
								fila+='<option value="'+value.idCategoria+'">'+value.categoria+'</option>';
							});
						fila+='</select>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<select class="form-control slWidth marcaCompetencias" name="marca-'+prefijo+'" id="marca-'+prefijo+'">';
        					fila+='<option value="">-- Lista Marcas --</option>';
        				fila+='</select>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<select class="form-control slWidth" name="competencia-'+prefijo+'" id="competencia-'+prefijo+'">';
        					fila+='<option value="">-- Tipo Competencia --</option>';
        					$.each(listaTipoCompetencias, function(index,value){
								fila+='<option value="'+value.idTipoCompetencia+'">'+value.tipoCompetencia+'</option>';
							});
        				fila+='</select>';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<input type="text" class="form-control ipWidth" placeholder="Comentario" id="comentario-'+prefijo+'"  name="comentario-'+prefijo+'" value="">';
        			fila+='</td>';
        			fila+='<td class="text-center">';
        				fila+='<div class="row" id="foto-'+prefijo+'">';
							fila+='<div class="col">';
								fila+='<a href="javascript:;" class="lk-foto-1" data-content="img-fotoprincipal-'+prefijo+'">';
									fila+='<img class="fotoMiniatura foto" name="img-fotoprincipal-'+prefijo+'" id="img-fotoprincipal-'+prefijo+'" src="" alt="">';
								fila+='</a>';
							fila+='</div>';
							fila+='<div class="col">';
								fila+='<div class="content-input-file">';
									fila+='<input type="text" readonly="readonly" id="txt-fotoprincipal-'+prefijo+'" name="fotoprincipal-'+prefijo+'" class="hide" >';
									fila+='<input type="text" readonly="readonly" id="txt-fotoprincipal-'+prefijo+'_show" class="text-file" placeholder="Solo .jpg" >';
									fila+='<span class="btn-file btnFoto" data-file="fl-fotoprincipal-'+prefijo+'"><i class="fa fa-file-image" aria-hidden="true"></i> Buscar</span>';
									fila+='<input type="file" id="fl-fotoprincipal-'+prefijo+'" class="fl-control hide" name="filefotoprincipal-'+prefijo+'" data-content="txt-fotoprincipal-'+prefijo+'"  accept="image/jpeg" data-previa="true" data-foto-content="img-fotoprincipal-'+prefijo+'" >';
								fila+='</div>';
							fila+='</div>';
						fila+='</div>';
        			fila+='</td>';
        		fila+='</tr>';

        	$('#tb-competencias tbody.tb-competencia').append(fila).trigger("create");
        	$('#contNumberCompetencias').val(cont);
        });

        $(document).on('change','.categoriaCompetencias', function(){
        	var control = $(this);
        	var prefijo = control.data('prefijo');
        	var categoria = control.val();
        	var listaMarcas = ContingenciaRutas.dataListaCategoriaCompetencia[categoria]['listaMarcas'];

        	var option='';
        		option+='<option value="">-- Lista Marcas --</option>';
        		$.each( listaMarcas, function(ix,val){
        			option +='<option value="'+val.idMarca+'">'+val.marca+'</option>';
        		});

        	$('#marca-'+prefijo+' option').remove();
        	$('#marca-'+prefijo).append(option).trigger("create");
        });

        $(document).on('click','.btn-deleteRowCompetencias', function(e){
        	e.preventDefault();
        	var control = $(this);
        	control.parents('tr').remove();
        });
        /****************************/
        
        /**************VISITA ORDEN DE TRABAJO**************/
        $(document).on('click','#otro', function(){
        	var input= $(this);
        	if (input.is(':checked')) {
        		$('#tipoOrden').val('').prop('disabled',true);
        	} else {
        		$('#tipoOrden').prop('disabled',false);
        	}
        })
		/****************************/
		



		

		/**************CARGAR DATA****************/
		$(document).on("change", "#btnFileBackup", function(e) {
			var files = e.target.files || e.dataTransfer.files;
			file = files[0];
			var content = $(this);
			var reader = new FileReader();
			reader.onload = function (e) {
				content.attr("data-file",e.target.result)
			};
			reader.readAsDataURL(file);
        });

		$(document).on('click','.opcionCargarData', function(){

			var data={ };
			data['codUsuario']=$(this).attr('data-codUsuario');
			data['usuario']=$(this).attr('data-usuario');
			data['idVisita']=$(this).attr('data-idVisita');
			data['pdv']=$(this).attr('data-pdv');
			data['fecha']=$('#txt-fechas_simple').val();

			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': ContingenciaRutas.url + 'cargarData', 'data': jsonString };
			
			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='ContingenciaRutas.guardarCargaData('+modalId+');';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Guardar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				Fn.showModal({ id:modalId,title:a.msg.title,content:a.data.html,btn:btn,show:true,width:'90%'});
			});
		});

		$(document).on("change", ".check_visita", function(e) {
			var b=$(this).prop('checked');
			if(b==true){
				$(this).parent("td").parent("tr").find( "input[type='checkbox']" ).prop('checked','checked');
			}else{
				$(this).parent("td").parent("tr").find( "input[type='checkbox']" ).prop('checked', false);
			}
		});

		$(document).on("change", ".check_carga", function(e) {
			var b=$(this).prop('checked');
			var idVisita=$(this).attr('data-idVisita');
			var modulo=$(this).attr('data-modulo');
			if(b==true){
				if(arr_fotos!=null){
						arr_fotos[modulo][idVisita]['estado']= true; 

						if(modulo=="visita_encuesta"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/encuestas/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_encuesta_det'][idVisita]['estado']= true;
							arr_fotos["visita_encuesta_det"][idVisita]['ruta']='fotos/impactTrade_Android/encuestas/';
							arr_fotos["visita_encuesta_det"][idVisita]['sufijo']= "visita_encuesta_det"; 

						}else if(modulo=="visita_ipp"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/ipp/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_ipp_det'][idVisita]['estado']= true;
							arr_fotos["visita_ipp_det"][idVisita]['ruta']='fotos/impactTrade_Android/ipp/';
							arr_fotos["visita_ipp_det"][idVisita]['sufijo']= "visita_ipp_det"; 
						}else if(modulo=="visita_producto"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/checklist/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_producto_det'][idVisita]['estado']= true;
							arr_fotos["visita_producto_det"][idVisita]['ruta']='fotos/impactTrade_Android/checklist/';
							arr_fotos["visita_producto_det"][idVisita]['sufijo']= "visita_producto_det"; 
						}else if(modulo=="visita_promocion"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/promociones/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_promocion_det'][idVisita]['estado']= true;
							arr_fotos["visita_promocion_det"][idVisita]['ruta']='fotos/impactTrade_Android/promociones/';
							arr_fotos["visita_promocion_det"][idVisita]['sufijo']= "visita_promocion_det"; 
						}else if(modulo=="visita_sod"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/sod/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_sod_det'][idVisita]['estado']= true;
							arr_fotos["visita_sod_det"][idVisita]['ruta']='fotos/impactTrade_Android/sod/';
							arr_fotos["visita_sod_det"][idVisita]['sufijo']= "visita_sod_det"; 
						}else if(modulo=="visita_encarte"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/encartes/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_encarte_det'][idVisita]['estado']= true;
							arr_fotos["visita_encarte_det"][idVisita]['ruta']='fotos/impactTrade_Android/encartes/';
							arr_fotos["visita_encarte_det"][idVisita]['sufijo']= "visita_encarte_det"; 
						}else if(modulo=="visita_seguimiento_plan"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/seguimientoPlan/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_seguimiento_plan_det'][idVisita]['estado']= true;
							arr_fotos["visita_seguimiento_plan_det"][idVisita]['ruta']='fotos/impactTrade_Android/seguimientoPlan/';
							arr_fotos["visita_seguimiento_plan_det"][idVisita]['sufijo']= "visita_seguimiento_plan_det"; 
						}else if(modulo=="visita_foto"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/moduloFotos/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 
 
						}else if(modulo=="visita_visibilidad_trad"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/visibilidad/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_visibilidad_trad_det'][idVisita]['estado']= true;
							arr_fotos["visita_visibilidad_trad_det"][idVisita]['ruta']='fotos/impactTrade_Android/visibilidad/';
							arr_fotos["visita_visibilidad_trad_det"][idVisita]['sufijo']= "visita_visibilidad_trad_det"; 
						}else if(modulo=="visita_iniciativa"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/iniciativa/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_iniciativa_det'][idVisita]['estado']= true;
							arr_fotos["visita_iniciativa_det"][idVisita]['ruta']='fotos/impactTrade_Android/iniciativa/';
							arr_fotos["visita_iniciativa_det"][idVisita]['sufijo']= "visita_iniciativa_det"; 
						}else if(modulo=="visita_inteligencia"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/inteligencia/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_inteligencia_det'][idVisita]['estado']= true;
							arr_fotos["visita_inteligencia_det"][idVisita]['ruta']='fotos/impactTrade_Android/inteligencia/';
							arr_fotos["visita_inteligencia_det"][idVisita]['sufijo']= "visita_inteligencia_det"; 
						}
						else if(modulo=="visita_orden"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/orden/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 
						}else if(modulo=="visita_visibilidad_obligatorio"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/visibilidadAuditoria/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_visibilidad_obligatorio_det'][idVisita]['estado']= true;
							arr_fotos["visita_visibilidad_obligatorio_det"][idVisita]['ruta']='fotos/impactTrade_Android/visibilidadAuditoria/';
							arr_fotos["visita_visibilidad_obligatorio_det"][idVisita]['sufijo']= "visita_visibilidad_obligatorio_det"; 
						}else if(modulo=="visita_visibilidad_iniciativa"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/visibilidadAuditoria/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_visibilidad_iniciativa_det'][idVisita]['estado']= true;
							arr_fotos["visita_visibilidad_iniciativa_det"][idVisita]['ruta']='fotos/impactTrade_Android/visibilidadAuditoria/';
							arr_fotos["visita_visibilidad_iniciativa_det"][idVisita]['sufijo']= "visita_visibilidad_iniciativa_det"; 
						}else if(modulo=="visita_visibilidad_adicional"){
							arr_fotos[modulo][idVisita]['ruta']='fotos/impactTrade_Android/visibilidadAuditoria/';
							arr_fotos[modulo][idVisita]['sufijo']= modulo; 

							arr_fotos['visita_visibilidad_adicional_det'][idVisita]['estado']= true;
							arr_fotos["visita_visibilidad_adicional_det"][idVisita]['ruta']='fotos/impactTrade_Android/visibilidadAuditoria/';
							arr_fotos["visita_visibilidad_adicional_det"][idVisita]['sufijo']= "visita_visibilidad_adicional_det"; 
						}

				}
			}else{
				if(arr_fotos!=null){
						arr_fotos[modulo][idVisita]['estado']= false; 

						if(modulo=="visita_encuesta"){
							arr_fotos['visita_encuesta_det'][idVisita]['estado']= false;
						}else if(modulo=="visita_ipp"){
							arr_fotos['visita_ipp_det'][idVisita]['estado']= false;
						}else if(modulo=="visita_producto"){
							arr_fotos['visita_producto_det'][idVisita]['estado']= false;
						}else if(modulo=="visita_promocion"){
							arr_fotos['visita_promocion_det'][idVisita]['estado']= false;
						}else if(modulo=="visita_sod"){
							arr_fotos['visita_sod_det'][idVisita]['estado']= false;
						}else if(modulo=="visita_encarte"){
							arr_fotos['visita_encarte_det'][idVisita]['estado']= false;
						}else if(modulo=="visita_seguimiento_plan"){
							arr_fotos['visita_seguimiento_plan_det'][idVisita]['estado']= false;
						}else if(modulo=="visita_foto"){
 
						}else if(modulo=="visita_visibilidad_trad"){
							arr_fotos['visita_visibilidad_trad_det'][idVisita]['estado']= false;
						}else if(modulo=="visita_iniciativa"){
							arr_fotos['visita_iniciativa_det'][idVisita]['estado']= false;
						}else if(modulo=="visita_inteligencia"){
							arr_fotos['visita_inteligencia_det'][idVisita]['estado']= false;
						}
						else if(modulo=="visita_orden"){
						}else if(modulo=="visita_visibilidad_obligatorio"){
							arr_fotos['visita_visibilidad_obligatorio_det'][idVisita]['estado']= false;
						}else if(modulo=="visita_visibilidad_iniciativa"){
							arr_fotos['visita_visibilidad_iniciativa_det'][idVisita]['estado']= false;
						}else if(modulo=="visita_visibilidad_adicional"){
							arr_fotos['visita_visibilidad_adicional_det'][idVisita]['estado']= false;
						}
				}
			}
		});
		

		/**************CARGAR DATA CONSULTAR****************/
		$(document).on('click','#btn-consultarArchivo', function(){
 
			var data={ };
			data['idUsuario']=$('#codUsuarioSeleccionado').val();
			data['archivoData']=$('#btnFileBackup').attr('data-file');
			data['fecha']=$('#txt-fechas_simple').val();
			data['idVisita']=$('#idVisitaSel').val();
			
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': ContingenciaRutas.url + 'cargarDataTabla', 'data': jsonString };
			
			$.when( Fn.simpleAjax(configAjax)).then( function(a){
				$('#cargarDataContent').html(a.data.html);
				
			}); 
		});

		/****************************/
	},

	actualizarHorarios: function(horarios){
		var data = horarios;
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':ContingenciaRutas.url+'actualizarHorarios', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.data.html;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});

			if (a.result==1) {
				$("#btn-filtrarContingenciaRutas").click();
			}
		});
	},

	verificarIncidenciaEstado: function(config){
		var visita = config.visita;
		var estado = config.estado;

		if ( estado==1 ) {
			$('#incidenciaVisita-'+visita).prop('checked',false);
		} else {
			$('#incidenciaVisita-'+visita).prop('checked',true);
		}
	},

	guardarIncidencia: function(){
		var arrayFoto =[];
		var dataIncidenciaFotos = [];
		var idVisita = $('#idVisita').val();
		var cont=0;

		var foto='';
		foto = $('#img-fotoprincipal').attr('src');
		if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/incidencias') || foto=='') {
			foto = null;
		}

		//INSERTAMOS FOTOS
		if ( foto !== null ) {
			var sufijo = 'CONTI'+idVisita;
			var index = 0;
			arrayFoto = {
				'idVisita':idVisita
				,'contenido':foto
				,'ruta': 'fotos/impactTrade_Android/incidencias/'
				,'sufijo':sufijo
				,'columna':'index'
				,'index': index
			};
			dataIncidenciaFotos.push(arrayFoto);
		}

		$.when( Fn.enviarFotos(dataIncidenciaFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = { 'dataIncidencia': Fn.formSerializeObject('frm-visitaIncidencia'),'dataIncidenciaFotos':af};
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarIncidencia', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});

					if (a.result==1) {
						Fn.showModal({ id:ContingenciaRutas.idModal,show:false });
						$("#btn-filtrarContingenciaRutas").click();
					}
				});
			}
		})
	},

	actualizarIncidencia: function(){
		var data = Fn.formSerializeObject('frm-visitaIncidencia');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':ContingenciaRutas.url+'actualizarIncidencia', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.data.html;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});

			if (a.result==1) {
				Fn.showModal({ id:ContingenciaRutas.idModal,show:false });
				$("#btn-filtrarContingenciaRutas").click();
			}
		});
	},

	verificarFormulario: function( idForm, funcion){
		var idFrm = idForm;
		var funcionGuardar = funcion;

		$.when( Fn.validateForm({ 'id':idFrm }) ).then( function(a){
			if ( !a ) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;

			} else {
				++modalId;
				var fn1='ContingenciaRutas.'+funcionGuardar+'();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		});
	},

	mostrarMensajeFotos: function(){
		++modalId;
		var fn='Fn.showModal({ id:'+modalId+',show:false });';
		var btn=new Array();
			btn[0]={title:'Cerrar',fn:fn};
		var message = Fn.message({ 'type': 2, 'message': 'Se encontró inconvenientes al momento de proceder con el almacenamiento de las fotos' });
		Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
	},

	guardarEncuestas: function(){
		var dataEncuestas = [];
		var arrayEncuesta = [];
		var dataEncuestasPreguntas =[];
		var arrayEncuestasPreguntas=[];
		var dataEncuestaFoto = [];
		var arrayFoto = [];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.encuestas').each( function(ix,val){
			var control = $(this);
			var encuesta = control.val();
			var visitaEncuesta= control.data('visitaencuesta');
			var fotoEncuesta= control.data('fotoencuesta');
			var foto = '';

			if (fotoEncuesta==1) {
				foto = $('#img-fotoprincipal-'+encuesta).attr('src');
				if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/encuestas') || foto=='') {
					foto = null;
				};

				//INSERTAMOS FOTOS
				if ( foto !== null ) {
					var sufijo = 'CONTI'+encuesta;
					arrayFoto = {
						'idVisita':idVisita
						,'contenido':foto
						,'ruta': 'fotos/impactTrade_Android/encuestas/'
						,'sufijo':sufijo
						,'columna':'encuesta'
						,'encuesta':encuesta
					};
					dataEncuestaFoto.push(arrayFoto);
				}
			}

			//PREGUNTAS - ALTERNATIVAS
			dataEncuestasPreguntas=[];
			arrayEncuestasPreguntas=[];

			$('.inputEncuestaRespuesta-'+encuesta).each(function(ix,val){
				var input = $(this);
				var pregunta = input.data('pregunta');
				var tipoPregunta = input.data('tipopregunta');
				var alternativaFoto = input.data('alternativafoto');
				var visitaFoto = input.data('visitafoto');
				var respuesta = '';
				var alternativa = '';
				var indexFoto = '';
				var foto='';

				if (tipoPregunta==1) {
					respuesta = input.val();
					indexFoto = '01';
				} else if(tipoPregunta==2 || tipoPregunta==3){
					if ( input.is(':checked') ) {
						alternativa = input.val();
						indexFoto = alternativa
					}
				}

				if (alternativaFoto==1) {
					foto = $('#img-fotoprincipal-'+encuesta+'-'+pregunta+'-'+indexFoto).attr('src');
					if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/encuestas') || foto=='') {
						foto = null;
					};

					//INSERTAMOS FOTOS
					if ( foto !== null ) {
						var sufijo = 'CONTI'+encuesta+'-'+pregunta+'-'+indexFoto;
						var indice = encuesta+'-'+pregunta+'-'+indexFoto;
						arrayFoto = {
							'idVisita':idVisita
							,'contenido':foto
							,'ruta': 'fotos/impactTrade_Android/encuestas/'
							,'sufijo':sufijo
							,'columna':'indice'
							,'indice':indice
						};
						dataEncuestaFoto.push(arrayFoto);
					}
				}

				if ( respuesta!=="" || alternativa!=="") {
					//INSERTAMOS EN EL ARREGLO
					arrayEncuestasPreguntas = {
						'pregunta' : pregunta
						,'tipoPregunta': tipoPregunta
						,'alternativaFoto': alternativaFoto
						,'respuesta' : respuesta
						,'alternativa' : alternativa
						,'indexFoto': indexFoto
						,'visitaFoto': visitaFoto
					};
					dataEncuestasPreguntas.push(arrayEncuestasPreguntas);
					cont++;
				}
			});

			//INSERTAMOS EN EL ARREGLO
			arrayEncuesta = {
				'encuesta': encuesta
				,'visitaEncuesta': visitaEncuesta
				,'fotoEncuesta': fotoEncuesta
				,'dataEncuestasPreguntas':dataEncuestasPreguntas
			};
			dataEncuestas.push(arrayEncuesta);
			cont++;

		});

		$.when( Fn.enviarFotos(dataEncuestaFoto) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'visita':idVisita,'dataEncuestas':dataEncuestas,'dataEncuestaFoto':af};
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarEncuestas', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarEncuestas_v1: function(){
		var dataFotosEncuesta = [];
		var arrayFoto = [];
		var idVisita = $("#idVisita").val();

		$('.fotoEncuesta').each( function(ix,val){
			var img = $(this);
			var foto = img.attr('src');
			var encuesta =  img.data('encuesta');

			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/encuestas') || foto=='') {
				foto = null;
			}
			
			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+encuesta;
				var index = 'ECS-'+encuesta;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/encuestas/'
					,'sufijo':sufijo
					,'columna':'index'
					,'index':index
				};
				dataFotosEncuesta.push(arrayFoto);
			}
		});

		$('.fotoPregunta').each( function(ix,val){
			var img = $(this);
			var foto = img.attr('src');
			var encuesta = img.data('encuesta');
			var pregunta = img.data('pregunta');

			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/encuestas') || foto=='') {
				foto = null;
			}

			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+encuesta;
				var index = 'ECS-'+encuesta+'-PG-'+pregunta;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/encuestas/'
					,'sufijo':sufijo
					,'columna':'index'
					,'index':index
				};
				dataFotosEncuesta.push(arrayFoto);
			}
		})

		$.when( Fn.enviarFotos(dataFotosEncuesta) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'data':Fn.formSerializeObject('frm-visitaEncuesta'),'dataFotosEncuesta':af};
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarEncuestas', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarIpp: function(){
		var dataIpp = [];
		var dataIppFoto = [];
		var arrayFoto = [];
		var idVisita = $("#idVisita").val();
		//
		$(".fotoIpp").each( function(ix,val){
			var img = $(this);
			var foto = img.attr('src');
			var ipp =  img.data('ipp');

			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/ipp') || foto=='') {
				foto = null;
			}
			
			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+ipp;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/ipp/'
					,'sufijo':sufijo
					,'columna':'ipp'
					,'ipp':ipp
				};
				dataIppFoto.push(arrayFoto);
			}
		});

		$(".dataIpp").each( function(ix,row){
			var control = $(row);
			var ipp = control.data('ipp');
			var criterio = control.data('criterio');
			var tipoPregunta = control.data('tipopregunta');
			var pregunta = control.data('pregunta');
			var input = '';
			var opcion = '';
			var alternativa='';
			var puntaje='';
			var visitaIpp='';
			var visitaIppDet='';
			//
			if ( tipoPregunta==1) {

			} else if ( tipoPregunta==2 ) {
				input = $('input[name=alternativa-tp2-'+ipp+'-'+criterio+'-'+pregunta+']:checked');
				alternativa = input.val();
				puntaje = input.data('puntaje');
				visitaIpp = input.data('visitaipp');
				visitaIppDet = input.data('visitaippdet');
				if ( typeof alternativa!=='undefined' ){
					dataIpp.push({'ipp':ipp, 'criterio':criterio, 'tipoPregunta':tipoPregunta, 'pregunta':pregunta, 'alternativa':alternativa, 'puntaje':puntaje, 'visitaIpp':visitaIpp, 'visitaIppDet':visitaIppDet})	
				}				
			} else if ( tipoPregunta==3 ) {
				input = $('input[name=alternativa-tp3-'+ipp+'-'+criterio+'-'+pregunta+']');
				$(input).each( function(i,v){
					if ( $(v).is(':checked') ) {
						opcion = $(v);
						alternativa = opcion.val();
						puntaje = opcion.data('puntaje');
						visitaIpp = opcion.data('visitaipp');
						visitaIppDet = opcion.data('visitaippdet');
						dataIpp.push({'ipp':ipp, 'criterio':criterio, 'tipoPregunta':tipoPregunta, 'pregunta':pregunta, 'alternativa':alternativa, 'puntaje':puntaje, 'visitaIpp':visitaIpp, 'visitaIppDet':visitaIppDet})
					}
				})
			}
		});

		$.when( Fn.enviarFotos(dataIppFoto) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataIpp': dataIpp,'dataIppFoto':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarIpp', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarProductos: function(){
		var dataProductos = [];
		var arrayProducto = [];
		var arrayFoto =[];
		var dataProductosFotos = [];
		var idVisita = $("#idVisita").val();
		var cont=0;
		//
		$('.tb-competencia').each( function(ix,val){
			tbCompetencia = $(val).data('tbcompetencia');
		
			$('#tb-productos-'+tbCompetencia).DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
				var data = this.node();
				var tr = $(data);
				var competencia = tr.data('competencia');
				var categoria = tr.data('categoria');
				var marca = tr.data('marca');
				var producto = tr.data('producto');
				var visitaProducto = tr.data('visitaproducto');
				var visitaProductoDet = tr.data('visitaproductodet');
				var presencia = '';
				var quiebre = '';

				if ( tr.find("#presencia-"+competencia+"-"+categoria+"-"+marca+"-"+producto).is(':checked') ) {
					presencia = tr.find("#presencia-"+competencia+"-"+categoria+"-"+marca+"-"+producto).val();
				}
				if ( tr.find("#quiebre-"+competencia+"-"+categoria+"-"+marca+"-"+producto).is(':checked') ) {
					quiebre = tr.find("#quiebre-"+competencia+"-"+categoria+"-"+marca+"-"+producto).val();
				}
				
				var stock = tr.find("#stock-"+competencia+"-"+categoria+"-"+marca+"-"+producto).val();
				var unidadMedida = tr.find("#unidadMedida-"+competencia+"-"+categoria+"-"+marca+"-"+producto).val();
				var precio = tr.find("#precio-"+competencia+"-"+categoria+"-"+marca+"-"+producto).val();
				var motivo = tr.find("#motivo-"+competencia+"-"+categoria+"-"+marca+"-"+producto).val();
				var foto = tr.find("#img-fotoprincipal-"+competencia+"-"+producto).attr('src');
				if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/checklist') || foto=='') {
					foto = null;
				}
				var d = new Date(); var hora = d.getHours()+':'+d.getMinutes()+':'+d.getSeconds()+':'+cont;

				//INSERTAMOS FOTOS
				if ( foto !== null ) {
					var sufijo = 'CONTI'+producto;
					arrayFoto = {
						'idVisita':idVisita
						,'contenido':foto
						,'ruta': 'fotos/impactTrade_Android/checklist/'
						,'sufijo':sufijo
						,'columna':'producto'
						,'producto':producto
					};
					dataProductosFotos.push(arrayFoto);
				}

				//INSERTAMOS VALORES
				arrayProducto={
					'competencia': competencia
					,'categoria':categoria
					,'marca': marca
					,'producto':producto
					,'visitaproducto':visitaProducto
					,'visitaproductodet':visitaProductoDet
					,'presencia':presencia
					,'quiebre':quiebre
					,'stock':stock
					,'unidadMedida':unidadMedida
					,'precio':precio
					,'motivo':motivo
					,'foto':foto
				};
				dataProductos.push(arrayProducto);
				cont++;
			});
		});

		$.when( Fn.enviarFotos(dataProductosFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataProductos': dataProductos, 'dataProductosFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarProductos', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		})
	},

	guardarPrecios: function(){
		var dataPrecios = [];
		var arrayPrecio = [];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.tb-competencia').each( function(ix,val){
			tbCompetencia = $(val).data('tbcompetencia');

			$('#tb-precios-'+tbCompetencia).DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
				var data = this.node();
				var tr = $(data);
				var competencia = tr.data('competencia');
				var categoria = tr.data('categoria');
				var marca = tr.data('marca');
				var producto = tr.data('producto');
				var visitaPrecios = tr.data('visitaprecios');
				var visitaPreciosDet = tr.data('visitapreciosdet');
				var precio='';
				var precioRegular='';
				var precioOferta='';
				var precioProm1='';
				var precioProm2='';
				var precioProm3='';

				precio = tr.find("#precio-"+competencia+"-"+categoria+"-"+marca+"-"+producto).val();
				precioRegular = tr.find("#precioRegular-"+competencia+"-"+categoria+"-"+marca+"-"+producto).val();
				precioOferta = tr.find("#precioOferta-"+competencia+"-"+categoria+"-"+marca+"-"+producto).val();
				precioProm1 = tr.find("#precioProm1-"+competencia+"-"+categoria+"-"+marca+"-"+producto).val();
				precioProm2 = tr.find("#precioProm2-"+competencia+"-"+categoria+"-"+marca+"-"+producto).val();
				precioProm3 = tr.find("#precioProm3-"+competencia+"-"+categoria+"-"+marca+"-"+producto).val();

				//INSERTAMOS VALORES
				arrayPrecio={
					'competencia': competencia
					,'categoria':categoria
					,'marca': marca
					,'producto':producto
					,'visitaPrecios':visitaPrecios
					,'visitaPreciosDet':visitaPreciosDet
					,'precio' : precio
					,'precioRegular' : precioRegular
					,'precioOferta' : precioOferta
					,'precioProm1' : precioProm1
					,'precioProm2' : precioProm2
					,'precioProm3' : precioProm3
				};
				dataPrecios.push(arrayPrecio);
				cont++;
			});
		});

		var data = {'idVisita': idVisita, 'dataPrecios': dataPrecios };
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':ContingenciaRutas.url+'guardarPrecios', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.data.html;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
		});
	},

	guardarPromociones: function(){
		var dataPromociones = [];
		var arrayPromocion = [];
		var arrayFoto = [];
		var dataPromocionesFotos = [];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.tr-promociones').each(function(row){
			var tr = $(this);
			var visitaPromociones = tr.data('visitapromociones');
			var visitaPromocionesDet = tr.data('visitapromocionesdet');
			var promocion = tr.data('promocion');

			var tipoPromocion = '';
			var nombrePromocion = '';
			var presencia = '';
			var foto='';

			tipoPromocion = tr.find('input[name="tipoPromocion-'+visitaPromocionesDet+'"]').val();
			nombrePromocion = tr.find('input[name="nombrePromocion-'+visitaPromocionesDet+'"]').val();
			if ( tr.find('input[name="presencia-'+visitaPromocionesDet+'"]').is(':checked') ) {
				presencia = tr.find('input[name="presencia-'+visitaPromocionesDet+'"]').val();
			}
			foto = tr.find('img[name="img-fotoprincipal-'+visitaPromocionesDet+'"]').attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/promociones') || foto=='') {
				foto = null;
			};

			//INSERTAMOS LAS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+visitaPromocionesDet;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/promociones/'
					,'sufijo':sufijo
					,'columna':'visitaPromocionesDet'
					,'visitaPromocionesDet':visitaPromocionesDet
				};
				dataPromocionesFotos.push(arrayFoto);
			}

			//INSERTAMOS EN EL ARREGLO PROMOCION
			arrayPromocion = {
				'visitaPromociones':visitaPromociones
				,'visitaPromocionesDet':visitaPromocionesDet
				,'promocion': promocion
				,'tipoPromocion': tipoPromocion
				,'nombrePromocion': nombrePromocion
				,'presencia': presencia
				,'foto': foto
			};
			dataPromociones.push(arrayPromocion);
			cont++;
		});

		$('.tr-promociones-adicionales').each(function(row){
			var tr = $(this);
			var visitaPromociones = tr.data('visitapromociones');
			var visitaPromocionesDet = tr.data('visitapromocionesdet');
			var promocion = tr.data('promocion');

			var tipoPromocion = '';
			var nombrePromocion = '';
			var presencia = '';
			var foto='';

			tipoPromocion = $('#tipoPromocion-'+visitaPromocionesDet).val();
			nombrePromocion = $('#nombrePromocion-'+visitaPromocionesDet).val();
			if ( $('#presencia-'+visitaPromocionesDet).is(':checked') ) {
				presencia = $('#presencia-'+visitaPromocionesDet).val();
			}
			foto = $('#img-fotoprincipal-'+visitaPromocionesDet).attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/promociones') || foto=='') {
				foto = null;
			};

			//INSERTAMOS LAS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+visitaPromocionesDet;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/promociones/'
					,'sufijo':sufijo
					,'columna':'visitaPromocionesDet'
					,'visitaPromocionesDet':visitaPromocionesDet
				};
				dataPromocionesFotos.push(arrayFoto);
			}

			//INSERTAMOS EN EL ARREGLO
			arrayPromocion = {
				'visitaPromociones':visitaPromociones
				,'visitaPromocionesDet':visitaPromocionesDet
				,'promocion': promocion
				,'tipoPromocion': tipoPromocion
				,'nombrePromocion': nombrePromocion
				,'presencia': presencia
				,'foto': foto
			};
			dataPromociones.push(arrayPromocion);
			cont++;
		});

		$.when( Fn.enviarFotos(dataPromocionesFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataPromociones': dataPromociones, 'dataPromocionesFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarPromociones', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarSos: function(){
		var dataSos = [];
		var arrayCategoria = [];
		var arrayMarca = [];
		var arrayFoto =[];
		var dataCategoriaFotos = [];
		var idVisita = $('#idVisita').val();
		var cont=0;

		$('.tr-categoria').each( function(e){
			var control = $(this);
			var categoria = control.data('categoria');
			var visitaSos = control.data('visitasos');
			var categoriaCm = control.find('input[name="categoria-cm-'+categoria+'"]').val();
			var categoriaFrentes = control.find('input[name="categoria-frentes-'+categoria+'"]').val();
			var foto = control.find('img[name="img-fotoprincipal-'+categoria+'"]').attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/sos') || foto=='') {
				foto = null;
			}

			/**DETALLE DE LAS MARCAS POR LA CATEGORIA**/
			var dataMarcas = [];
			$('.tr-marca-'+categoria).each(function(e){
				var controlMarca = $(this);

				var marca = controlMarca.data('marca');
				var visitaSosDet = controlMarca.data('visitasosdet');
				var flagCompetencia = controlMarca.data('flagcompetencia');
				var marcaCm = controlMarca.find('input[name="marca-cm-'+categoria+'-'+marca+'"]').val();
				var marcaFrentes = controlMarca.find('input[name="marca-frentes-'+categoria+'-'+marca+'"]').val();

				if( marcaCm!=="" || marcaFrentes!=="" ){
					arrayMarca = {
						'marca': marca
						,'visitaSosDet': visitaSosDet
						,'marcaCm': marcaCm
						,'marcaFrentes': marcaFrentes
						,'flagCompetencia': flagCompetencia
					};
					dataMarcas.push(arrayMarca);
				}
			});
			/****************/

			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+categoria;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/sos/'
					,'sufijo':sufijo
					,'columna':'categoria'
					,'categoria':categoria
				};
				dataCategoriaFotos.push(arrayFoto);
			}

			//INSERTAMOS VALORES EN LA CABECERA
			if (categoriaCm>0 || categoriaFrentes>0 ){
				arrayCategoria = {
					'categoria': categoria
					,'visitaSos': visitaSos
					,'categoriaCm': categoriaCm
					,'categoriaFrentes': categoriaFrentes
					,'foto': foto
					,'listaMarcas': dataMarcas
				};

				dataSos.push(arrayCategoria);
				cont++;
			}
		});

		$.when( Fn.enviarFotos(dataCategoriaFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataSos': dataSos, 'dataCategoriaFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarSos', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarSod: function(){
		var arrayCategoria=[];
		var dataCategorias = [];
		var arrayMarcaElementos=[];
		var dataMarcaElementos=[];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.categorias').each( function(row){
			var control = $(this);
			var categoria = control.val();
			var categoriaCantidad = 0;

			arrayMarcaElementos=[];
			dataMarcaElementos=[];

			$('.inputCategoria-'+categoria).each( function(ix,val){
				var input = $(this);
				var value = input.val();
				
				if ( value.length > 0 ) {
					if ( input.val() !== "" || input.val() !== 0 ){
        				categoriaCantidad = parseFloat(categoriaCantidad + parseFloat(input.val()));
        			}
        		};
        		var marcaCategoria = input.data('categoria');
        		var marcaMarca = input.data('marca');
        		var marcaElementoVisbilidad = input.data('elementovisibilidad');
        		var marcaCantidad = input.val();

        		arrayMarcaElementos = {
					'marcaCategoria': marcaCategoria
					,'marcaMarca': marcaMarca
					,'marcaElementoVisbilidad': marcaElementoVisbilidad
					,'marcaCantidad': marcaCantidad
				};

				dataMarcaElementos.push(arrayMarcaElementos);
			});

			//INSERTAMOS EN EL ARREGLO
			arrayCategoria = {
				'categoria':categoria
				,'categoriaCantidad':categoriaCantidad
				,'listaMarcaElementos': dataMarcaElementos
			};
			dataCategorias.push(arrayCategoria);
			cont++;
		});

		var data = {'idVisita': idVisita, 'dataCategorias': dataCategorias, 'dataMarcaElementos':dataMarcaElementos };
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':ContingenciaRutas.url+'guardarSod', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.data.html;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
		});
	},

	guardarSodFotos: function(){
		var dataSodFotos = [];
		var arraySodFoto =[];
		var dataFotos = [];
		var arrayFoto = [];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.tr-sodFotos-adicional').each( function(row){
			var tr = $(this);
			var indice = tr.data('indice');
			var visita = tr.data('visita');
			var categoria = tr.data('categoria');
			var marca = tr.data('marca');
			var tipoElementoVisibilidad = tr.data('tipoelementovisibilidad');
			var foto ='';

			foto = tr.find('img[name="img-fotoprincipal-'+indice+'"]').attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/sod') || foto=='') {
				foto = null;
			}

			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+indice;
				arrayFoto = {
					'idVisita':visita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/sod/'
					,'sufijo':sufijo
					,'columna':'indice'
					,'indice':indice
				};
				dataFotos.push(arrayFoto);

				//INSERTAMOS EN EL ARREGLO
				arraySodFoto = {
					'indice' : indice
					,'visita': visita
					,'categoria': categoria
					,'marca': marca
					,'tipoElementoVisibilidad': tipoElementoVisibilidad
					,'foto': foto
				};
				dataSodFotos.push(arraySodFoto);
				cont++;
			}
		});

		$.when( Fn.enviarFotos(dataFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita':idVisita,'dataSodFotos': dataSodFotos, 'dataFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarSodFotos', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarEncartes: function(){
		var dataEncartes = [];
		var arrayEncarte = [];
		var arrayFoto = [];
		var dataEncartesFotos = [];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.tr-encartes').each( function(row){
			var tr = $(this);
			var visitaEncartes = tr.data('visitaencartes');
			var visitaEncartesDet = tr.data('visitaencartesdet');

			var categoria='';
			var foto='';

			//categoria = tr.find('input[name="categoria-'+visitaEncartesDet+'"]').val();
			categoria = tr.find('#categoria-'+visitaEncartesDet).val();
			foto = tr.find('img[name="img-fotoprincipal-'+visitaEncartesDet+'"]').attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/encartes') || foto=='') {
				foto = null;
			}

			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+visitaEncartesDet;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/encartes/'
					,'sufijo':sufijo
					,'columna':'visitaEncartesDet'
					,'visitaEncartesDet':visitaEncartesDet
				};
				dataEncartesFotos.push(arrayFoto);
			}

			//INSERTAMOS EN EL ARREGLO
			arrayEncarte = {
				'visitaEncartes' : visitaEncartes
				,'visitaEncartesDet': visitaEncartesDet
				,'categoria': categoria
				,'foto': foto
			};
			dataEncartes.push(arrayEncarte);
			cont++;
		});

		$.when( Fn.enviarFotos(dataEncartesFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataEncartes': dataEncartes, 'dataEncartesFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarEncartes', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarSeguimientoPlan: function(){
		var dataSegPlan = [];
		var arraySegPlan = [];
		var arrayFoto = [];
		var dataSegPlanFotos = [];
		var idVisita = $("#idVisita").val();
		var cont=0;
		//
		$('.tr-seguimientoPlan').each( function(ix,val){
			var tr = $(this);
			var segPlan = tr.data('segplan');
			var elementoVisibilidad = tr.data('elementovis');
			var visitaSegPlan = tr.data('visitasegplan');
			var visitaSegPlanDet = tr.data('visitasegplandet');
			var presencia = '';
			var armado = '';
			var revestido = '';
			var motivo = '';
			var comentario = '';
			var marca = '';
			var foto = '';

			if ( tr.find($("#presencia-"+segPlan+"-"+elementoVisibilidad)).is(':checked') ) {
				presencia = tr.find($("#presencia-"+segPlan+"-"+elementoVisibilidad)).val();
			}
			armado = tr.find('#armado-'+segPlan+'-'+elementoVisibilidad).val();
			revestido = tr.find('#revestido-'+segPlan+'-'+elementoVisibilidad).val();
			motivo = tr.find('#motivo-'+segPlan+'-'+elementoVisibilidad).val();
			comentario = tr.find('#comentario-'+segPlan+'-'+elementoVisibilidad).val();
			marca = tr.find('#marca-'+segPlan+'-'+elementoVisibilidad).val();
			foto = tr.find('#img-fotoprincipal-'+segPlan+'-'+elementoVisibilidad).attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/seguimientoPlan') || foto=='') {
				foto = null;
			}

			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var index = segPlan+'-'+elementoVisibilidad;
				var sufijo = 'CONTI'+index;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/seguimientoPlan/'
					,'sufijo':sufijo
					,'columna':'index'
					,'index':index
				};
				dataSegPlanFotos.push(arrayFoto);
			}

			//INSERTAMOS VALORES
			arraySegPlan={
				'segPlan': segPlan
				,'elementoVisibilidad': elementoVisibilidad
				,'visitaSegPlan': visitaSegPlan
				,'visitaSegPlanDet': visitaSegPlanDet
				,'presencia': presencia
				,'armado': armado
				,'revestido': revestido
				,'motivo': motivo
				,'comentario': comentario
				,'marca': marca
				,'foto': foto
			};
			dataSegPlan.push(arraySegPlan);
			cont++;
		});

		$.when( Fn.enviarFotos(dataSegPlanFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataSegPlan': dataSegPlan, 'dataSegPlanFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarSeguimientoPlan', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarDespachos: function(){
		var data = Fn.formSerializeObject('frm-visitaDespachos');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':ContingenciaRutas.url+'guardarDespachos', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.data.html;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
		});
	},

	guardarFotoEstado: function(visitaFoto){
		var data = {'visitaModuloFoto':visitaFoto};
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':ContingenciaRutas.url+'guardarFotoEstado', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.data.html;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});

			if (a.result==1) {
				$('#visitaFoto-'+visitaFoto).parents('tr').remove();
			}
		});
	},

	guardarFotos: function(){
		var dataModuloFotos = [];
		var arrayModuloFotos = [];
		var arrayFoto = [];
		var dataFotosFotos = [];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.tr-moduloFoto-adicionales').each( function(ix,val){
			var tr = $(this);
			var visitaModuloFoto = tr.data('visitamodulofoto');

			var tipoFoto = '';
			var tipoFotoText = '';
			var comentario = '';
			var foto='';

			tipoFoto = tr.find('#tipoFoto-'+visitaModuloFoto).val();
			tipoFotoText = tr.find('#tipoFoto-'+visitaModuloFoto+' option:selected').text();
			nombrePromocion = tr.find('#comentario-'+visitaModuloFoto).val();
			foto = tr.find('#img-fotoprincipal-'+visitaModuloFoto).attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/moduloFotos') || foto=='') {
				foto = null;
			};

			//INSERTAMOS LAS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+visitaModuloFoto;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/moduloFotos/'
					,'sufijo':sufijo
					,'columna':'visitaModuloFoto'
					,'visitaModuloFoto':visitaModuloFoto
				};
				dataFotosFotos.push(arrayFoto);
			}

			//INSERTAMOS EN EL ARREGLO
			arrayModuloFotos = {
				'visitaModuloFoto':visitaModuloFoto
				,'tipoFoto':tipoFoto
				,'tipoFotoText':tipoFotoText
				,'comentario': comentario
				,'foto': foto
			};
			dataModuloFotos.push(arrayModuloFotos);
			cont++;
		});

		$.when( Fn.enviarFotos(dataFotosFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataModuloFotos': dataModuloFotos, 'dataFotosFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarFotos', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarInventario: function(){
		var dataInventario = [];
		var arrayInventario = [];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('#tb-inventario').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
			var data = this.node();
			var tr = $(data);

			var producto = tr.data('producto');
			var visitaInventario = tr.data('visitainventario');
			var visitaInventarioDet = tr.data('visitainventariodet');
			var stockInicial = tr.find('#stockInicial-'+producto).val();
			var sellin = tr.find('#sellin-'+producto).val();
			var stock = tr.find('#stock-'+producto).val();
			var validacion = tr.find('#validacion-'+producto).val();
			var obs = tr.find('#obs-'+producto).val();
			var comentario = tr.find('#comentario-'+producto).val();
			var fecVenc = tr.find('#fecVenc-'+producto).val();

			//INSERTAMOS VALORES
			arrayInventario={
				'visitaInventario' : visitaInventario
				,'visitaInventarioDet' : visitaInventarioDet
				,'producto' : producto
				,'stockInicial' : stockInicial
				,'sellin' : sellin
				,'stock' : stock
				,'validacion' : validacion
				,'obs' : obs
				,'comentario' : comentario
				,'fecVenc' : fecVenc
			};
			dataInventario.push(arrayInventario);
			cont++;
		});

		var data = {'idVisita': idVisita, 'dataInventario': dataInventario };
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':ContingenciaRutas.url+'guardarInventario', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.data.html;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
		});
	},

	guardarVisibilidad: function(){
		var dataVisibilidadTrad = [];
		var arrayElemento = [];
		var arrayFoto = [];
		var dataVisibilidadTradFotos =[];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.tr-visibilidadTrad').each(function(row){
			var tr = $(this);
			var visitaVisibilidad = tr.data('visitavisibilidad');
			var visitaVisibilidadDet = tr.data('visitavisibilidaddet');
			var elementoVisibilidad='';
			var condicion='';
			var presencia='';
			var cantidad='';
			var estadoElemento='';
			var foto='';

			elementoVisibilidad = tr.find('#elementoVisibilidad-'+visitaVisibilidadDet).val();
			condicion = tr.find('#condicion-'+visitaVisibilidadDet).val();
			if ( tr.find('#presencia-'+visitaVisibilidadDet).is(':checked') ) {
				presencia = tr.find('#presencia-'+visitaVisibilidadDet).val();
			}
			cantidad = tr.find('#cantidad-'+visitaVisibilidadDet).val();
			estadoElemento = tr.find('#estadoElemento-'+visitaVisibilidadDet).val();
			foto = tr.find('#img-fotoprincipal-'+visitaVisibilidadDet).attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/visibilidad') || foto=='') {
				foto = null;
			};

			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+visitaVisibilidadDet;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/visibilidad/'
					,'sufijo':sufijo
					,'columna':'visitaVisibilidadDet'
					,'visitaVisibilidadDet':visitaVisibilidadDet
				};
				dataVisibilidadTradFotos.push(arrayFoto);
			}

			//INSERTAMOS EN EL ARREGLO
			arrayElemento = {
				'visitaVisibilidad':visitaVisibilidad
				,'visitaVisibilidadDet':visitaVisibilidadDet
				,'elementoVisibilidad': elementoVisibilidad
				,'condicion': condicion
				,'presencia': presencia
				,'cantidad': cantidad
				,'estadoElemento': estadoElemento
				,'foto': foto
			};
			dataVisibilidadTrad.push(arrayElemento);
			cont++;

		});

		$.when( Fn.enviarFotos(dataVisibilidadTradFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataVisibilidadTrad': dataVisibilidadTrad, 'dataVisibilidadTradFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarVisibilidad', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarMantenimiento: function(){
		var data = Fn.formSerializeObject('frm-visitaMantenimiento');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':ContingenciaRutas.url+'guardarMantenimiento', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.data.html;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
		});
	},

	guardarInteligencia: function(){
		var dataCompetencias = [];
		var arrayCompetencia = [];
		var arrayFoto = [];
		var dataCompetenciaFotos = [];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.tr-competencias').each(function(row){
			var tr = $(this);
			var visitaInteligencia = tr.data('visitainteligencia');
			var visitaInteligenciaCompetitiva = tr.data('visitainteligenciacompetitiva');
			var categoria='';
			var marca='';
			var tipoCompetencia='';
			var comentario='';
			var foto='';

			categoria = tr.find('#categoria-'+visitaInteligenciaCompetitiva).val();
			marca = tr.find('#marca-'+visitaInteligenciaCompetitiva).val();
			tipoCompetencia = tr.find('#competencia-'+visitaInteligenciaCompetitiva).val();
			comentario = tr.find('#comentario-'+visitaInteligenciaCompetitiva).val();
			foto = tr.find('#img-fotoprincipal-'+visitaInteligenciaCompetitiva).attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/inteligencia') || foto=='') {
				foto = null;
			};

			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+visitaInteligenciaCompetitiva;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/inteligencia/'
					,'sufijo':sufijo
					,'columna':'visitaInteligenciaCompetitiva'
					,'visitaInteligenciaCompetitiva':visitaInteligenciaCompetitiva
				};
				dataCompetenciaFotos.push(arrayFoto);
			}

			//INSERTAMOS EN EL ARREGLO
			arrayCompetencia = {
				'visitaInteligencia':visitaInteligencia
				,'visitaInteligenciaCompetitiva':visitaInteligenciaCompetitiva
				,'categoria': categoria
				,'marca': marca
				,'tipoCompetencia': tipoCompetencia
				,'comentario': comentario
				,'foto': foto
			};
			dataCompetencias.push(arrayCompetencia);
			cont++;

		});

		$.when( Fn.enviarFotos(dataCompetenciaFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataCompetencias': dataCompetencias, 'dataCompetenciaFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarCompetencias', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		})
	},

	guardarOrdenes: function(){
		var idVisita = $("#idVisita").val();
		var arrayFoto = [];
		var dataOrdenFotos = [];
		var foto = $("#img-fotoprincipal").attr('src');
		if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/orden') || foto=='') {
			foto = null;
		}

		//INSERTAMOS LA ÚNICA FOTO
		if ( foto !== null ) {
			var sufijo = 'CONTI';
			var index = 1;
			arrayFoto = {
				'idVisita':idVisita
				,'contenido':foto
				,'ruta': 'fotos/impactTrade_Android/orden/'
				,'sufijo':sufijo
				,'columna':'index'
				,'index':index
			};
			dataOrdenFotos.push(arrayFoto);
		}

		$.when( Fn.enviarFotos(dataOrdenFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita':idVisita, 'dataOrden':Fn.formSerializeObject('frm-visitaOrden'), 'dataOrdenFotos':af};
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarOrdenes', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarIniciativaTrad: function(){
		var dataIniciativas = [];
		var arrayIniciativa = [];
		var arrayFoto = [];
		var dataIniciativaTradFotos = [];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.tr-iniciativas').each(function(row){
			var tr = $(this);
			var visitaIniciativaTrad = tr.data('visitainiciativatrad');
			var visitaIniciativaTradDet = tr.data('visitainiciativatraddet');
			var iniciativa = tr.data('iniciativa');
			var elementoIniciativa = tr.data('elementoiniciativa');
			var presencia='';
			var cantidad='';
			var estadoIniciativa='';
			var producto='';
			var foto='';

			if ( tr.find('#presencia-'+iniciativa+'-'+elementoIniciativa).is(':checked') ) {
				presencia = tr.find('#presencia-'+iniciativa+'-'+elementoIniciativa).val();
			}
			cantidad = tr.find('#cantidad-'+iniciativa+'-'+elementoIniciativa).val();
			estadoIniciativa = tr.find('#estadoIniciativa-'+iniciativa+'-'+elementoIniciativa).val();
			if ( tr.find('#producto-'+iniciativa+'-'+elementoIniciativa).is(':checked') ) {
				producto = tr.find('#producto-'+iniciativa+'-'+elementoIniciativa).val();		
			}
			foto = tr.find('#img-fotoprincipal-'+iniciativa+'-'+elementoIniciativa).attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/iniciativa') || foto=='') {
				foto = null;
			};

			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var index = iniciativa+'-'+elementoIniciativa;
				var sufijo = 'CONTI'+index;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/iniciativa/'
					,'sufijo':sufijo
					,'columna':'index'
					,'index':index
				};
				dataIniciativaTradFotos.push(arrayFoto);
			}

			//INSERTAMOS EN EL ARREGLO
			arrayIniciativa = {
				'visitaIniciativaTrad':visitaIniciativaTrad
				,'visitaIniciativaTradDet':visitaIniciativaTradDet
				,'iniciativa': iniciativa
				,'elementoIniciativa': elementoIniciativa
				,'presencia': presencia
				,'cantidad': cantidad
				,'estadoIniciativa': estadoIniciativa
				,'producto': producto
				,'foto': foto
			};
			dataIniciativas.push(arrayIniciativa);
			cont++;

		});

		$.when( Fn.enviarFotos(dataIniciativaTradFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataIniciativas': dataIniciativas, 'dataIniciativaTradFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarIniciativaTrad', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarVisibilidadAuditoriaObligatoria: function(){
		var dataVisibilidadObligatoria = [];
		var arrayVisibilidadObligatoria = [];
		var dataVisibilidadObligatoriaFotos = [];
		var arrayFoto = [];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.tr-visibilidadObligatoria-variables').each(function(row){
			var td = $(this);
			var visitaVisibilidad = td.data('visitavisibilidad');
			var visitaVisibilidadDet = td.data('visitavisibilidaddet');
			var elementoVisibilidad = td.data('elementovisibilidad');
			var variable = td.data('variable');
			
			var cantidad='';
			var presencia='';
			var observacion='';
			var comentario='';
			var foto='';

			cantidad = $('#cantidad-'+elementoVisibilidad).val();
			if ( $('#presencia-'+elementoVisibilidad+'-'+variable).is(':checked') ) {
				presencia = $('#presencia-'+elementoVisibilidad+'-'+variable).val();
			}
			observacion = $('#observacion-'+elementoVisibilidad+'-'+variable).val();
			comentario = $('#comentario-'+elementoVisibilidad+'-'+variable).val();
			foto = $('#img-fotoprincipal-'+elementoVisibilidad+'-'+variable).attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/visibilidadAuditoria') || foto=='') {
				foto = null;
			}

			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+idVisita+'-'+elementoVisibilidad+'-'+variable;
				var index = elementoVisibilidad+'-'+variable;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/visibilidadAuditoria/'
					,'sufijo':sufijo
					,'columna':'index'
					,'index': index
				};
				dataVisibilidadObligatoriaFotos.push(arrayFoto);
			}
			//

			//INSERTAMOS EN EL ARREGLO
			arrayVisibilidadObligatoria = {
				'visitaVisibilidad':visitaVisibilidad
				,'visitaVisibilidadDet':visitaVisibilidadDet
				,'elementoVisibilidad': elementoVisibilidad
				,'variable': variable
				,'cantidad': cantidad
				,'presencia': presencia
				,'observacion': observacion
				,'comentario': comentario
			};
			dataVisibilidadObligatoria.push(arrayVisibilidadObligatoria);
			cont++;

		});

		$.when( Fn.enviarFotos(dataVisibilidadObligatoriaFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataVisibilidadObligatoria': dataVisibilidadObligatoria,'dataVisibilidadObligatoriaFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarVisibilidadAuditoriaObligatoria', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		})
	},

	guardarVisibilidadAuditoriaIniciativa: function(){
		var dataVisibilidadIniciativa = [];
		var arrayVisibilidadIniciativa = [];
		var dataVisibilidadIniciativaFotos = [];
		var arrayFoto = [];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.tr-visibilidadIniciativa').each(function(row){
			var tr = $(this);
			var visitaVisibilidad = tr.data('visitavisibilidad');
			var visitaVisibilidadDet = tr.data('visitavisibilidaddet');
			var elementoVisibilidad = tr.data('elementovisibilidad');
			
			var presencia='';
			var comentario='';
			var observacion='';
			var foto='';

			if ( tr.find('#presencia-'+elementoVisibilidad).is(':checked') ) {
				presencia = tr.find('#presencia-'+elementoVisibilidad).val();
			}
			observacion = tr.find('#observacion-'+elementoVisibilidad).val();
			comentario = tr.find('#comentario-'+elementoVisibilidad).val();
			foto = tr.find('#img-fotoprincipal-'+elementoVisibilidad).attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/visibilidadAuditoria') || foto=='') {
				foto = null;
			}

			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+idVisita+'-'+elementoVisibilidad;
				var index = elementoVisibilidad;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/visibilidadAuditoria/'
					,'sufijo':sufijo
					,'columna':'index'
					,'index': index
				};
				dataVisibilidadIniciativaFotos.push(arrayFoto);
			}
			//

			//INSERTAMOS EN EL ARREGLO
			arrayVisibilidadIniciativa = {
				'visitaVisibilidad':visitaVisibilidad
				,'visitaVisibilidadDet':visitaVisibilidadDet
				,'elementoVisibilidad': elementoVisibilidad
				,'presencia': presencia
				,'observacion': observacion
				,'comentario': comentario
			};
			dataVisibilidadIniciativa.push(arrayVisibilidadIniciativa);
			cont++;

		});

		$.when( Fn.enviarFotos(dataVisibilidadIniciativaFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataVisibilidadIniciativa': dataVisibilidadIniciativa, 'dataVisibilidadIniciativaFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarVisibilidadAuditoriaIniciativa', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarVisibilidadAuditoriaAdicional: function(){
		var dataVisibilidadAdicional = [];
		var arrayVisibilidadAdicional = [];
		var dataVisibilidadAdicionalFotos = [];
		var arrayFoto = [];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.tr-visibilidadAdicional').each(function(row){
			var tr = $(this);
			var visitaVisibilidad = tr.data('visitavisibilidad');
			var visitaVisibilidadDet = tr.data('visitavisibilidaddet');
			var elementoVisibilidad = tr.data('elementovisibilidad');
			
			var presencia='';
			var comentario='';
			var cantidad='';
			var foto='';

			if ( tr.find('#presencia-'+elementoVisibilidad).is(':checked') ) {
				presencia = tr.find('#presencia-'+elementoVisibilidad).val();
			}
			cantidad = tr.find('#cantidad-'+elementoVisibilidad).val();
			comentario = tr.find('#comentario-'+elementoVisibilidad).val();		
			foto = tr.find('#img-fotoprincipal-'+elementoVisibilidad).attr('src');
			if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/visibilidadAuditoria') || foto=='') {
				foto = null;
			}

			//INSERTAMOS FOTOS
			if ( foto !== null ) {
				var sufijo = 'CONTI'+idVisita+'-'+elementoVisibilidad;
				var index = elementoVisibilidad;
				arrayFoto = {
					'idVisita':idVisita
					,'contenido':foto
					,'ruta': 'fotos/impactTrade_Android/visibilidadAuditoria/'
					,'sufijo':sufijo
					,'columna':'index'
					,'index': index
				};
				dataVisibilidadAdicionalFotos.push(arrayFoto);
			}
			//

			//INSERTAMOS EN EL ARREGLO
			arrayVisibilidadAdicional = {
				'visitaVisibilidad':visitaVisibilidad
				,'visitaVisibilidadDet':visitaVisibilidadDet
				,'elementoVisibilidad': elementoVisibilidad
				,'presencia': presencia
				,'cantidad': cantidad
				,'comentario': comentario
			};
			dataVisibilidadAdicional.push(arrayVisibilidadAdicional);
			cont++;

		});

		$.when( Fn.enviarFotos(dataVisibilidadAdicionalFotos) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataVisibilidadAdicional': dataVisibilidadAdicional,'dataVisibilidadAdicionalFotos':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarVisibilidadAuditoriaAdicional', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarEncuestaPremio: function(){
		var dataVisitaEncuestaPremio = [];
		var arrayEncuestaPremio = [];
		var dataEncuestaPremioFoto=[];
		var arrayFoto=[];
		var idVisita = $("#idVisita").val();
		var cont=0;

		$('.encuestaPremio').each(function(ix,val){
			var control = $(this);
			var encuesta = control.val();
			var visitaEncuesta= control.data('visitaencuesta');
			var fotoEncuesta= control.data('fotoencuesta');
			var foto = '';

			if (fotoEncuesta==1) {
				foto = $('#img-fotoprincipal-'+encuesta).attr('src');
				if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/encuestasPremio') || foto=='') {
					foto = null;
				};

				//INSERTAMOS FOTOS
				if ( foto !== null ) {
					var sufijo = 'CONTI'+encuesta;
					arrayFoto = {
						'idVisita':idVisita
						,'contenido':foto
						,'ruta': 'fotos/impactTrade_Android/encuestasPremio/'
						,'sufijo':sufijo
						,'columna':'encuesta'
						,'encuesta':encuesta
					};
					dataEncuestaPremioFoto.push(arrayFoto);
				}
			}
		});

		$('.inputEncuestaRespuesta').each(function(row){
			var ipt = $(this);
			var encuesta = ipt.data('encuesta');
			var tipoPregunta = ipt.data('tipopregunta');
			var pregunta = ipt.data('pregunta');
			var respuesta = '';

			if ( tipoPregunta==1 ) {
				respuesta = ipt.val();
			} else if(tipoPregunta==2 || tipoPregunta==3){
				if ( ipt.is(':checked') ) {
					respuesta = ipt.val();
				}
			}

			if ( respuesta!=='') {
				//INSERTAMOS EN EL ARRGLO
				arrayEncuestaPremio = {
					'encuesta' : encuesta
					,'tipoPregunta': tipoPregunta
					,'pregunta' : pregunta
					,'respuesta' : respuesta
				};
				dataVisitaEncuestaPremio.push(arrayEncuestaPremio);
				cont++;
			};
		})

		$.when( Fn.enviarFotos(dataEncuestaPremioFoto) ).then( function(af){
			if ( !af ) {
				ContingenciaRutas.mostrarMensajeFotos();
			} else {
				var data = {'idVisita': idVisita, 'dataVisitaEncuestaPremio': dataVisitaEncuestaPremio,'dataEncuestaPremioFoto':af };
				var jsonString = { 'data': JSON.stringify(data) };
				var config = { 'url':ContingenciaRutas.url+'guardarEncuestaPremio', 'data': jsonString };

				$.when( Fn.ajax(config) ).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.data.html;
					Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true});
				});
			}
		});
	},

	guardarCargaData: function(modalId_){
		var data=Fn.formSerializeObject('frm-cargarData');
		data['idUsuario']=$('#codUsuarioSeleccionado').val();
		data['fecha']=$('#txt-fechas_simple').val();
		


		var data_fotos={ };
			data_fotos['arr_fotos']= [arr_fotos];
		$.when( Fn.enviarFotosModulos(data_fotos) ).then( function(af){

			data['arr_fotos']=(af[0]!=null)? af[0] : [];
					
			var jsonString = { 'data': JSON.stringify(data) };
			var configAjax = { 'url': ContingenciaRutas.url + 'guardarDataTabla', 'data': jsonString };
			
			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+modalId_+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn1};
				Fn.showModal({ id:modalId,title:a.msg.title,content:a.data.html,btn:btn,show:true});
			});
		});
	}

	
	
}

ContingenciaRutas.load();