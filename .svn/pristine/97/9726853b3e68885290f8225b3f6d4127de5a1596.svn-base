var Basemadre = {
	frmMaestrosBasemadre: 'frm-maestrosBasemadre',
	frmBasemadreSeleccionarPunto: 'frm-basemadreSeleccionarPunto',
	frmBasemadreNuevoEditarPunto: 'frm-basemadreNuevoEditarPunto',
	contentDetalle: 'idDetalleMaestrosBasemadre',
	url : 'configuraciones/maestros/basemadre/',
	idModal: 0,

	dataListaRegiones : [],
	dataListaCuentaProyecto : [],
	dataListaCuentaGrupoCanalCanal: [],
	dataListaCadenaBanner: [],
	dataListaCuentaProyectoZona: [],
	dataListaPlazaTodo: [],
	dataListaPlazaMayorista: [],

	dataListaRegionesNombre: [],
	dataListaRegionesDepartamentoProvinciaDistrito: [],
	dataListaProvinciasNombre: [],
	dataListaDistritosNombre: [],
	dataListaZonaPeligrosaNombre: [],
	dataListaCuentaNombre: [],
	dataListaProyectoNombre: [],
	dataListaFrecuenciaNombre: [],
	dataListaZonaNombre: [],
	dataListaGrupoCanalNombre: [],
	dataListaCanalNombre: [],
	dataListaCadenaNombre: [],
	dataListaBannerNombre: [],
	dataListaPlazaNombre: [],
	dataListaDistribuidoraSucursalNombre: [],

	handsontable : '',

	load: function(){

		$(document).on('click','#btn-filtrarMaestrosBasemadre', function(e){
			e.preventDefault();

			var control = $(this);
			var config = {
				'idFrm' : Basemadre.frmMaestrosBasemadre
				,'url': Basemadre.url + control.data('url')
				,'contentDetalle': Basemadre.contentDetalle
			};

			Fn.loadReporte(config);
		});

		$(document).on('click','.cambiarEstado', function(e){
			e.preventDefault();
			var control = $(this);
			var data = { cliente:control.data('cliente'), clienteHistorico: control.data('clientehistorico'), estado:control.data('estado') };

			++modalId;
			var fn1='Basemadre.guardarCambiarEstado('+JSON.stringify(data)+');Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		});

		$(document).on('click','#btn-deBajaMaestrosBasemadre', function(e){
			e.preventDefault();

			var dataClienteHistorico = [];
			var arrayClienteHistorico=[];
			var cont=0;

			$('#tb-maestrosBasemadreDetalle').DataTable().rows().every(function(rowIdx, tableLoop, rowLoop){
				var data = this.node();
				var tr = $(data);
				var cliente = '';
				var clienteHistorico = '';

				if ( tr.find('input[name="deBaja"]').is(':checked') ) {
					var input = tr.find('input[name=deBaja]');
					cliente = input.data('cliente')
					clienteHistorico = input.data('clientehistorico');

					//INSERTAMOS ARRAY
					arrayClienteHistorico = {'cliente':cliente, 'clienteHistorico':clienteHistorico};
					dataClienteHistorico.push(arrayClienteHistorico);
					cont++;
				}
			});
			
			if (dataClienteHistorico.length==0) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+', show:false});';
				var btn = new Array();
					btn[0]={title:'Cerrar', fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'No se ha reportado ningún cambio' });
				Fn.showModal({ id:modalId, show:true, title:'Verificar Información', content:message, btn:btn});
			} else {
				++modalId;
				var fn1='Basemadre.guardarCambiarEstadoMasivo('+JSON.stringify(dataClienteHistorico)+');';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la edición de los <strong>'+cont+'</strong> registros?' });
					message+='<div class="themeWhite p-3">';
						message+='<div class="card"><div class="card-body">';
						message+='<form id="frm-fechaFinDeBaja"><div>';
							message+='<h5 class="card-title">INGRESAR FECHA FIN</h5>';
							message+='<input class="form-control text-center ipWidth" type="date" placeholder="Fecha Fin" id="fecFin" name="fecFin" patron="requerido">';
						message+='</div></form></div></div>';
					message+='</div>';
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				Basemadre.idModal = modalId;
			}
		});

		$(document).on('click','#chkb-deBajaTodo', function(){
			var input = $(this);
			
			if (input.is(':checked')) {
				$('#tb-maestrosBasemadreDetalle').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.dataDeBaja').prop('checked', true);
				});
			} else {
				$('#tb-maestrosBasemadreDetalle').DataTable().rows().every(function (rowIdx, tableLoop, rowLoop) {
					var data = this.node();
					$(data).find('.dataDeBaja').prop('checked', false);
				});
			}
		});

		$(document).on('click','#btn-nuevoMaestrosBasemadre', function(e){
			e.preventDefault();

			var data={};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = { 'url': Basemadre.url+'seleccionarPunto', 'data':jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Basemadre.confirmarTipoRegistroPunto();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'70%'});

				$('.dvListaCliente').hide();
				Basemadre.idModal = modalId;
			})
		});

		$(document).on('change','input[name=tipoRegistro]', function(){
			var control = $(this);
			var value = control.val();

			if (value==1) {
				$('.dvListaCliente').show(300);
				$('#clienteRegistro').attr('patron','requerido');
			} else {
				$('.dvListaCliente').hide(300);
				$('#clienteRegistro').removeAttr('patron','requerido');
			}

			$('#clienteRegistro').val('');
		})

		/**GEOLOCALIZACIÓN**/
		$(document).on('change','#departamento', function(){
			var control = $(this);
        	var cod_departamento = control.val();

        	var option='';
        	option +='<option value="">-- Provincias --</option>';
        	if ( typeof Basemadre.dataListaRegiones[cod_departamento] !== 'undefined') {
	        	$.each(Basemadre.dataListaRegiones[cod_departamento]['listaProvincias'], function(ix,val){
	        		option +='<option value="'+val.cod_provincia+'">'+val.provincia+'</option>';
	        	});
	        }

        	$('#provincia option').remove();
        	$('#provincia').append(option).trigger("create");
        	$('#distrito option').remove();
        	$('#distrito').append('<option value="">-- Distritos --</option>').trigger("create");
        	$('#cod_ubigeo').val('');
		});

		$(document).on('change','#provincia', function(){
        	var control = $(this);
        	var cod_departamento = $('#departamento').val();
        	var cod_provincia = control.val();

        	var option='';
        	option +='<option value="">-- Distritos --</option>';
        	if ( typeof Basemadre.dataListaRegiones[cod_departamento]['listaProvincias'][cod_provincia] !== 'undefined') {
	        	$.each(Basemadre.dataListaRegiones[cod_departamento]['listaProvincias'][cod_provincia]['listaDistritos'], function(ix,val){
	        		option +='<option value="'+val.cod_distrito+'" data-ubigeo="'+val.cod_ubigeo+'">'+val.distrito+'</option>';
	        	});
	        }

        	$('#distrito option').remove();
        	$('#distrito').append(option).trigger("create");
        	$('#cod_ubigeo').val('');
        });

        $(document).on('change','#distrito', function(){
        	var control = $('#distrito option:selected');
        	var cod_ubigeo = control.data('ubigeo');

        	$('#cod_ubigeo').val(cod_ubigeo);
        });

        $(document).on('click','#buscarDireccionMapa', function(e){
        	e.preventDefault();

        	var departamento = $('#departamento option:selected').text();
        	var provincia = $('#provincia option:selected').text();
        	var distrito = $('#distrito option:selected').text();
        	var direccion = $('#direccion').val();
        	/*Algunas variables fueron creado en la vista*/
        	var address = departamento+'-'+provincia+'-'+distrito+'-'+direccion;
        	geocoder.geocode({'address':address}, function(results, status){
        		if (status=='OK') {
        			Basemadre.clearMarkers();
        			map.setCenter(results[0].geometry.location);
        			var marker = new google.maps.Marker({
        				map:map,
        				position: results[0].geometry.location
        			});

        			markers.push(marker);

        			$('#latitud').val(results[0].geometry.location.lat());
        			$('#longitud').val(results[0].geometry.location.lng());

        			google.maps.event.addListener(marker,'dragend', function(){ Basemadre.openInfoWindow(marker); Basemadre.codeLatLng(); })
        			google.maps.event.addListener(marker,'click', function(){ Basemadre.openInfoWindow(marker); Basemadre.codeLatLng(); })
        		} else {
        			alert('Geocode was not successful for the following reason: ' + status);
        		}
        	})
        });
        /**FIN GEOLOCALIZACIÓN**/

        $(document).on('change','#cuenta', function(){
        	var control = $(this);
        	var cuenta = control.val();
        	var option='';

        	/**PROYECTO**/
        	option+='<option value="">-- Proyecto --</option>';
        	if ( typeof Basemadre.dataListaCuentaProyecto[cuenta] !== 'undefined') {
	        	$.each(Basemadre.dataListaCuentaProyecto[cuenta]['listaProyectos'], function(ix,val){
	        		option+='<option value="'+val.idProyecto+'">'+val.proyecto+'</option>';
	        	});
	        }
        	$('#proyecto option').remove();
        	$('#proyecto').append(option).trigger("create");

        	/**GRUPO CANAL**/
        	option='';
        	option+='<option value="">-- Grupo Canal --</option>';
        	if ( typeof Basemadre.dataListaCuentaGrupoCanalCanal[cuenta] !== 'undefined') {
        		$.each(Basemadre.dataListaCuentaGrupoCanalCanal[cuenta]['listaGrupoCanal'], function(ix,val){
        			option+='<option value="'+val.idGrupoCanal+'">'+val.grupoCanal+'</option>';
        		})
        	}
        	$('#grupoCanal option').remove();
        	$('#grupoCanal').append(option).trigger("create");

        	/**CANAL**/
        	$('#canal option').remove();
        	$('#canal').append('<option value="">-- Canal --</option>').trigger("create");
        	$('#canal').change();
        });

        $(document).on('change','#proyecto', function(){
        	var control = $(this);
        	var cuenta = $('#cuenta').val();
        	var proyecto = control.val();

        	var option='';
        		option+='<option value="">-- Zonas --</option>';
        	if ( typeof Basemadre.dataListaCuentaProyectoZona[cuenta] !== 'undefined') {
        		if ( typeof Basemadre.dataListaCuentaProyectoZona[cuenta][proyecto] !== 'undefined') {
		        	$.each(Basemadre.dataListaCuentaProyectoZona[cuenta][proyecto]['listaZonas'], function(ix,val){
		        		option+='<option value="'+val.idZona+'">'+val.zona+'</option>';
		        	});
		        }
	    	}

        	$('#zona option').remove();
        	$('#zona').append(option).trigger("create");
        })

        $(document).on('change','#grupoCanal', function(){
        	var control = $(this);
        	var grupoCanal = control.val();
        	var cuenta = $('#cuenta').val();

        	var option='';
        		option='<option value="">-- Canal --</option>';
        	if ( typeof Basemadre.dataListaCuentaGrupoCanalCanal[cuenta]['listaGrupoCanal'][grupoCanal] !== 'undefined') {
	        	$.each(Basemadre.dataListaCuentaGrupoCanalCanal[cuenta]['listaGrupoCanal'][grupoCanal]['listaCanal'], function(ix,val){
	        		option+='<option value="'+val.idCanal+'">'+val.canal+'</option>';
	        	});
	        }
        	$('#canal option').remove();
        	$('#canal').append(option).trigger("create");
        	$('#canal').change();

        	/**SEGMENTACION CLIENTE TRADICIONAL**/
        	var opcionPlaza='<option value="">-- Plaza --</option>';
        	//4 => HFS;
        	if (jQuery.inArray(grupoCanal,['4']) !== -1) {
        		//PLAZAS
    			$.each(Basemadre.dataListaPlazaTodo, function(ix,val){
    				opcionPlaza+='<option value="'+val.idPlaza+'">'+val.plaza+'</option>';	
    			});

        		$('.divDistribuidoraSucursal').show(300);
        		$('#distribuidoraSucursal').attr("patron","requerido");
        	} else {
        		//PLAZAS
    			$.each(Basemadre.dataListaPlazaMayorista, function(ix,val){
    				opcionPlaza+='<option value="'+val.idPlaza+'">'+val.plaza+'</option>';	
    			});

        		$('.divDistribuidoraSucursal').hide(300);
        		$('#distribuidoraSucursal').removeAttr("patron","requerido");
        	}

        	$('#plaza option').remove();
        	$('#plaza').append(opcionPlaza).trigger("create");
        	$('#distribuidoraSucursal').val('').change();
        	$('.btn-deleteRow').click();

        	$('#cadena').val('').change();
        	$('#banner').val('');
        });

        $(document).on('change','#canal', function(){
        	var control = $(this);
        	var canal = control.val();
        	if ( canal.length>0) {
        		$('.segmentacionCliente').hide(200);
        		if ( jQuery.inArray(canal,['1','2','3','8','9','10','11','12','13']) !== -1) {
        			$('.segmentacionClienteTradicional').show(500);
        			$('.segmentacionClienteModerno').hide(500);

        			$('#plaza').attr("patron","requerido");
        			$('#banner').removeAttr("patron","requerido");
        		} else if ( jQuery.inArray(canal,['4','6','7']) !== -1) {
        			$('.segmentacionClienteTradicional').hide(500);
        			$('.segmentacionClienteModerno').show(500);

        			$('#banner').attr("patron","requerido");
        			$('#plaza').removeAttr("patron","requerido");
        		} else {
        			$('.segmentacionCliente').show(200);
        			$('.segmentacionClienteTradicional').hide(300);
        			$('.segmentacionClienteModerno').hide(300);

        			$('#plaza').removeAttr("patron","requerido");
        			$('#banner').removeAttr("patron","requerido");
        		}
        	} else {
        		$('.segmentacionCliente').show(200);
        		$('.segmentacionClienteTradicional').hide(300);
        		$('.segmentacionClienteModerno').hide(300);
        		$('#plaza').removeAttr("patron","requerido");
        		$('#banner').removeAttr("patron","requerido");
        	}
        })

        $(document).on('change','#cadena', function(){
        	var control = $(this);
        	var cadena = control.val();

        	var option='';
        		option='<option value="">-- Banner --</option>';
        	if ( typeof Basemadre.dataListaCadenaBanner[cadena] !== 'undefined') {
	        	$.each(Basemadre.dataListaCadenaBanner[cadena]['listaBanner'], function(ix,val){
	        		option+='<option value="'+val.idBanner+'">'+val.banner+'</option>';
	        	});
	        }

        	$('#banner option').remove();
        	$('#banner').append(option).trigger("create");
        });

        $(document).on('click','#addDistribuidoraSucursal', function(e){
        	e.preventDefault();

        	var distribuidoraSucursal = $('#distribuidoraSucursal').val();
        	if (distribuidoraSucursal.length>0) {
	        	var distribuidoraSucursalText = $('#distribuidoraSucursal option:selected').text();

	        	var fila='';
	        		fila+='<tr>';
	        			fila+='<td>'+distribuidoraSucursalText;
	        				fila+='<div class="hide"><input type="text" name="distribuidoraSucursal" value="'+distribuidoraSucursal+'"></div>';
	        			fila+='</td>'
	        			fila+='<td class="text-center">';
	        				fila+='<button type="button" class="btn-deleteRow btn btn-danger" ><i class="fas fa-trash fa-lg"></i></button>';
	        			fila+='</td>';
	        		fila+='</tr>';

	        	$('#tb-distribuidoraSucursal tbody').append(fila).trigger("create");
	        	$('#distribuidoraSucursal').val('');
	        }
        });

        $(document).on('click','.btn-deleteRow', function(e){
        	e.preventDefault();

        	var control = $(this);
        	control.parents('tr').remove();
        });

        $(document).on('click','.editarClienteHistorico', function(e){
        	e.preventDefault();

        	var control = $(this);
        	var cliente = control.data('cliente');
        	var clienteHistorico = control.data('clientehistorico');

        	var data = { 'cliente':cliente,'clienteHistorico':clienteHistorico };
        	var jsonString = {'data':JSON.stringify(data)};
        	var configAjax = {'url':Basemadre.url+'editarPunto', 'data':jsonString};

        	$.when(Fn.ajax(configAjax)).then( function(a){
        		++modalId;
        		var fn1='Basemadre.confirmarActualizarPunto();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Actualizar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'90%'});

				$('#canal').change();
				var grupoCanal = a.data.grupoCanal;
				//4 => HFS
				if (jQuery.inArray(grupoCanal,[4]) !== -1) {
	        		$('.divDistribuidoraSucursal').show(300);
	        		$('#distribuidoraSucursal').attr("patron","requerido");
	        	} else {
	        		$('.divDistribuidoraSucursal').hide(300);
	        		$('#distribuidoraSucursal').removeAttr("patron","requerido");
	        	}
	        	//
	        	Basemadre.idModal = modalId;
        	});
        });

        $(document).on('click','#btn-cargaMasivaMaestrosBasemadre', function(e){
        	e.preventDefault();

        	var data ={};
			var jsonString = {'data': JSON.stringify(data)};
			var configAjax = { 'url': Basemadre.url+'nuevoPuntoMasivo', 'data':jsonString};

			$.when( Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Basemadre.confirmarGuardarNuevoPuntoMasivo();';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Guardar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = a.data.html;
				Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'90%'});

				
				var sourceDepartamentos = Basemadre.dataListaRegionesNombre;
				var sourceProvincias = Basemadre.dataListaProvinciasNombre;
				var sourceDistritos = Basemadre.dataListaDistritosNombre;
				var sourceZonaPeligrosa = Basemadre.dataListaZonaPeligrosaNombre;
				var sourceCuenta = Basemadre.dataListaCuentaNombre;
				var sourceProyecto = Basemadre.dataListaProyectoNombre;
				var sourceFrecuencia = Basemadre.dataListaFrecuenciaNombre;
				var sourceZona = Basemadre.dataListaZonaNombre;
				var sourceGrupoCanal = Basemadre.dataListaGrupoCanalNombre;
				var sourceCanal = Basemadre.dataListaCanalNombre;
				var sourceCadena = Basemadre.dataListaCadenaNombre;
				var sourceBanner = Basemadre.dataListaBannerNombre;
				var sourcePlaza = Basemadre.dataListaPlazaNombre;
				var sourceDistribuidoraSucursal = Basemadre.dataListaDistribuidoraSucursalNombre;

				var data = [];
				var container = document.getElementById('nuevoPuntoMasivo');
				//var hot = new Handsontable(container, {
				
				
				var settings = {
					licenseKey: 'non-commercial-and-evaluation',
					data: null,
					dataSchema: {nombreComercial:null, razonSocial:null, number:{ruc:null, dni:null}, ubigeo:{departamento:null,provincia:null,distrito:null,codigo:null}, direccion:null, referencia:null, latitud:null, longitud:null, zonaPeligrosa:null, codCliente:null, flagCartera:null, fechas:{inicio:null, fin:null}, cuenta:null, proyecto:null, frecuencia:null, zona:null, segNegocio:{grupoCanal:null, canal:null}, segClienteModeno:{cadena:null, banner:null}, segClienteTradicional:{plaza:null, distribuidoraSucursal:null} },
					colHeaders: ['NOMBRE COMERCIAL', 'RAZÓN SOCIAL', 'RUC', 'DNI','DEPARTAMENTO','PROVINCIA','DISTRITO','CÓDIGO UBIGEO','DIRECCIÓN','REFERENCIA','LATITUD','LONGITUD','ZONA PELIGROSA', 'CÓDIGO CLIENTE','CLIENTE CARTERA','FECHA INICIO','FECHA FIN','CUENTA','PROYECTO','FRECUENCIA','ZONA','GRUPO CANAL','CANAL','CADENA','BANNER','PLAZA','DISTRIBUIDORA SUCURSAL'],
					startRows: 10,
					//startCols: 4,
					columns: [
						{data: 'nombreComercial'},
						{data: 'razonSocial'},
						{ data: 'number.ruc'
							, type:'numeric'
							/*, numericFormat:{
								pattern: '00000000000'
							}*/
						},
						{ data: 'number.dni'
							, type:'numeric'
							/*, numericFormat:{
								pattern: '00000000'
							}*/
						},
						{ data: 'ubigeo.departamento'
							, type: 'dropdown'
							, source: sourceDepartamentos
						},
						{ data: 'ubigeo.provincia'
							, type: 'dropdown'
							, source: sourceProvincias
						},
						{ data: 'ubigeo.distrito'
							, type: 'dropdown'
							, source: sourceDistritos
						},
						{ data: 'ubigeo.codigo'
							, type:'numeric'
							, readOnly: true
						},
						{ data: 'direccion'},
						{ data: 'referencia'},
						{ data: 'latitud'},
						{ data: 'longitud'},
						{ data: 'zonaPeligrosa'
							, type:'dropdown'
							, source: sourceZonaPeligrosa
						},
						{ data: 'codCliente'},
						{ data: 'flagCartera'
							, type:'dropdown'
							, source: ['SI','NO']
						},
						{ data: 'fechas.inicio'
							, type:'date'
							, dateFormat: 'DD/MM/YYYY'
							, allowEmpty: false
						},
						{ data: 'fechas.fin'
							, type:'date'
							, dateFormat: 'DD/MM/YYYY'
							, allowEmpty: true
						},
						{ data: 'cuenta'
							, type:'dropdown'
							, source: sourceCuenta
						},
						{ data: 'proyecto'
							, type:'dropdown'
							, source: sourceProyecto
						},
						{ data: 'frecuencia'
							, type:'dropdown'
							, source: sourceFrecuencia
						},
						{ data: 'zona'
							, type:'dropdown'
							, source: sourceZona
						},
						{ data: 'segNegocio.grupoCanal'
							, type:'dropdown'
							, source: sourceGrupoCanal
						},
						{ data: 'segNegocio.canal'
							, type:'dropdown'
							, source: sourceCanal
						},
						{ data: 'segClienteModeno.cadena'
							, type:'dropdown'
							, source: sourceCadena
						},
						{ data: 'segClienteModeno.banner'
							, type:'dropdown'
							, source: sourceBanner
						},
						{ data: 'segClienteTradicional.plaza'
							, type:'dropdown'
							, source: sourcePlaza
						},
						{ data: 'segClienteTradicional.distribuidoraSucursal'
							, type:'dropdown'
							, source: sourceDistribuidoraSucursal
						}
					],
					minSpareCols: 1, //always keep at least 1 spare row at the right
					minSpareRows: 1,  //always keep at least 1 spare row at the bottom,
					rowHeaders: true, //n° contador de las filas
					//filters: true, // permite filtrar en la columna, pero elimina la opción STARTROWS
					contextMenu: true,
					dropdownMenu: true, //desplegable en la columna, ofrece oopciones
					height: 300,
					//width: '100%',
					stretchH: 'all', //Expande todas las columnas al 100%
					maxRows: 50, //cantidad máxima de filas
					manualColumnResize: true,
					//FUNCIONES
					cells: function(row,col, prop){
						if (col==3) {
							//console.log('row - col',row+'-'+col);
						}
					},
					afterChange: function(changes, source){
						//console.log('changes',changes); //Todos los cambios que se han hecho
						//console.log('source',source); //El tipo de cambio que se ha hecho.
						var elemento = this; 
						//console.log('elemento',elemento);//El div.container del handsontable

						if (changes!=null) {
							changes.forEach( function(item){
								if (item[1]=='ubigeo.departamento' || item[1]=='ubigeo.provincia' || item[1]=='ubigeo.distrito') {
									var dataDepartamento= Basemadre.handsontable.getDataAtCell(item[0],4);
									var dataProvincia=Basemadre.handsontable.getDataAtCell(item[0],5);
									var dataDistrito=Basemadre.handsontable.getDataAtCell(item[0],6);
									var concatenado = dataDepartamento+'-'+dataProvincia+'-'+dataDistrito;

									var codigoUbigeo = Basemadre.dataListaRegionesDepartamentoProvinciaDistrito.find( itemDepartamentoProvinciaDistrito => itemDepartamentoProvinciaDistrito.departamentoProvinciaDistrito === concatenado);
									if ( typeof codigoUbigeo !== 'undefined') {
										Basemadre.handsontable.setDataAtCell(item[0],7,codigoUbigeo['cod_ubigeo']);
										Basemadre.handsontable.setCellMeta(item[0],7,'className','changeTrue');
									} else {
										Basemadre.handsontable.setDataAtCell(item[0],7,'*');
									}
								} 
							})
						}
					}
				};

				Basemadre.handsontable = new Handsontable(container, settings);

				setTimeout(function(){
					Basemadre.handsontable.render(); 
				}, 1000);
			});
        });

		$(document).on('click','#btn-addColumnaCargaMasiva', function(e){
			e.preventDefault();

			var contColumna = parseInt($('#contColumnasDistribuidora').val()) + 1;
			var sourceDistribuidoraSucursal = Basemadre.dataListaDistribuidoraSucursalNombre;

			var settings = Basemadre.handsontable.getSettings();
			var indexColumna = parseInt(Basemadre.handsontable.getSettings().columns.length) + 1;

			var clmDistribuidoraSucursal = {};
				clmDistribuidoraSucursal["data"] = "distribuidoraSucursal"+contColumna;
				clmDistribuidoraSucursal["type"] = "dropdown";
				clmDistribuidoraSucursal["source"] = sourceDistribuidoraSucursal;

			var columnsArray = Basemadre.handsontable.getSettings().columns;
				columnsArray.push(clmDistribuidoraSucursal);

			settings["columns"] = columnsArray;

			var colHeadersArray = Basemadre.handsontable.getSettings().colHeaders;
				colHeadersArray.push("DISTRIBUIDORA SUCURSAL " + contColumna);

			settings["colHeaders"] = colHeadersArray;

			Basemadre.handsontable.updateSettings(settings);
			$("#contColumnasDistribuidora").val(contColumna);
		});
	},

	initialize: function() {
		var latitud = $('#latitud').val();
			latitud = latitud.length>0 ? latitud : -9.189967;
		var longitud = $('#longitud').val();
			longitud = longitud.length>0 ? longitud : -75.015152;

		geocoder = new google.maps.Geocoder();
		//
		var latlng = new google.maps.LatLng(latitud, longitud);
		var mapOptions = {
			zoom: 4,
			center: latlng
		}
		map = new google.maps.Map(document.getElementById('map_canvas_inicio'), mapOptions);

		google.maps.event.addListenerOnce(map, 'idle', function(){
			var currentCenter = map.getCenter();
			google.maps.event.trigger(map, 'resize');
			map.setCenter(currentCenter);
			map.setZoom(6);
			var marker = new google.maps.Marker({
				map:map,
				draggable: true,
				position: currentCenter
			});

			google.maps.event.addListener(marker, 'dragend', function(){ Basemadre.openInfoWindow(marker);Basemadre.codeLatLng(); });
			google.maps.event.addListener(marker, 'click', function(){ Basemadre.openInfoWindow(marker);Basemadre.codeLatLng(); });
		})
	},

	clearMarkers: function(){
		for (var i = 0; i < markers.length; i++) {
			markers[i].setMap(null);
		}
	},

	openInfoWindow: function(marker){
		var markerLatLng = marker.getPosition();
		$('#latitud').val(markerLatLng.lat());
		$('#longitud').val(markerLatLng.lng());
	},

	codeLatLng: function(){
		var latitud = parseFloat($('#latitud').val());
		var longitud = parseFloat($('#longitud').val());

		var latlng = new google.maps.LatLng(latitud,longitud);

		geocoder.geocode({'latLng':latlng}, function(results, status){
			if (status=='OK') {
				if (results[0]) {
					$('#direccion').val(results[0].formatted_address);
				} else {
					alert('No se generó un registro');
				}
			} else {
				alert('Geolocalización falló debido a: ' + status);
			}
		})
	},

	guardarCambiarEstado: function(dataCliente){
		var data = dataCliente;
		var jsonString = { 'data': JSON.stringify(data) };
		var configAjax = { 'url': Basemadre.url + 'cambiarEstado', 'data': jsonString };
		
		$.when( Fn.ajax(configAjax)).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});

			if (a.result==1) {
				var tdButton = $('#ch-'+data.clienteHistorico);
				var td = tdButton.parent();
				tdButton.remove();
				td.html(a.data.html);

				var tdChkb = $('#chkb-'+data.clienteHistorico);
				var tdChkbChildren = tdChkb.children().remove();
				tdChkb.html(a.data.htmlChkb);

				if (data.estado==1) { $('#tr-'+data.clienteHistorico).addClass('tdBloqueado'); } 
				else {	$('#tr-'+data.clienteHistorico).removeClass('tdBloqueado');	}
			}
		});
	},

	guardarCambiarEstadoMasivo: function(dataClientes){
		$.when( Fn.validateForm({'id':'frm-fechaFinDeBaja'}) ).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				var fecha = $('#fecFin').val();
				var data ={'fecFin':fecha, 'dataClienteHistorico':dataClientes};
				var jsonString = {'data': JSON.stringify(data)};
				var configAjax = {'url':Basemadre.url+'cambiarEstadoMasivo', 'data':jsonString };

				$.when( Fn.ajax(configAjax)).then( function(a){
					++modalId;
					var fn='Fn.showModal({ id:'+modalId+',show:false });';
					var btn=new Array();
						btn[0]={title:'Cerrar',fn:fn};
					var message = a.msg.content;
					Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn});
					
					if (a.result==1) {
						Fn.showModal({ id:Basemadre.idModal, show:false});
						$('#btn-filtrarMaestrosBasemadre').click();
					}
				});
			}
		});
	},

	confirmarTipoRegistroPunto: function(){
		$.when( Fn.validateForm({ 'id':Basemadre.frmBasemadreSeleccionarPunto} ) ).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				++modalId;
				var fn1='Basemadre.registrarNuevoPuntoHistorico();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		})
	},

	registrarNuevoPuntoHistorico: function(){
		var data =  Fn.formSerializeObject(Basemadre.frmBasemadreSeleccionarPunto);
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = { 'url': Basemadre.url+'nuevoPunto', 'data':jsonString};

		$.when( Fn.ajax(configAjax)).then( function(a){
			Fn.showModal({ id: Basemadre.idModal, show:false });

			++modalId;
			var fn1='Basemadre.confirmarGuardarNuevoPunto();';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Guardar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = a.data.html;
			Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'90%'});
		})
	},

	confirmarGuardarNuevoPunto: function(){
		$.when( Fn.validateForm({'id':Basemadre.frmBasemadreNuevoEditarPunto})).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				++modalId;
				var fn1='Basemadre.guardarNuevoPunto();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		});
	},

	guardarNuevoPunto: function(){
		var data = Fn.formSerializeObject(Basemadre.frmBasemadreNuevoEditarPunto);
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':Basemadre.url+'guardarNuevoPunto', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				if (a.data.htmlButtons==1) {
					btn[0]={title:'Cerrar',fn:fn};
				} else if (a.data.htmlButtons==2) {
					$('#deTodosModos').val(1);
					btn[0]={title:'Guardar DE TODOS MODOS',fn:fn+a.data.htmlGuardar};
					btn[1]={title:'Cerrar',fn:fn+'Basemadre.cambiarEstadoGuardar();'};
				} else {
					btn[0]={title:'Cerrar',fn:fn};
				}
				
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true, width:a.data.width});

			if (a.result==1) {
				//Fn.showModal({ id:ContingenciaRutas.idModal,show:false });
				//$("#btn-filtrarMaestrosBasemadre").click();
			}
		});
	},

	cambiarEstadoGuardar: function(){
		$('#deTodosModos').val(0);
	},

	confirmarActualizarPunto: function(){
		$.when( Fn.validateForm({'id':Basemadre.frmBasemadreNuevoEditarPunto})).then( function(a){
			if (!a) {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
				return false;
			} else {
				++modalId;
				var fn1='Basemadre.actualizarPunto();Fn.showModal({ id:'+modalId+',show:false });';
				var fn2='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Continuar',fn:fn1};
					btn[1]={title:'Cerrar',fn:fn2};
				var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
				Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			}
		})
	},

	actualizarPunto: function(){
		$('#'+Basemadre.frmBasemadreNuevoEditarPunto).find('select').prop('disabled',false);
		var data = Fn.formSerializeObject(Basemadre.frmBasemadreNuevoEditarPunto);
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url':Basemadre.url+'actualizarPunto', 'data': jsonString };

		$.when( Fn.ajax(config) ).then( function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				if (a.data.htmlButtons==1) {
					btn[0]={title:'Cerrar',fn:fn};
				} else if (a.data.htmlButtons==2) {
					$('#deTodosModos').val(1);
					btn[0]={title:'Guardar DE TODOS MODOS',fn:fn+a.data.htmlGuardar};
					btn[1]={title:'Cerrar',fn:fn+'Basemadre.cambiarEstadoGuardar();'};
				} else {
					btn[0]={title:'Cerrar',fn:fn};
				}
				
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true, width:a.data.width});

			if (a.result==1) {
				$('#'+Basemadre.frmBasemadreNuevoEditarPunto).find('select').prop('disabled',true);
				//Fn.showModal({ id:ContingenciaRutas.idModal,show:false });
				//$("#btn-filtrarMaestrosBasemadre").click();
			} else {
				//Fn.showModal({ id:Basemadre.idModal,show:false });
			}
		});
	},

	confirmarGuardarNuevoPuntoMasivo: function(){
		//var arrayDataClientes = Basemadre.handsontable.getData();
		var contColsInvalid = 0;
			contColsInvalid = $('#nuevoPuntoMasivo .htInvalid').length;
		var arrayDataClientes = [];
		for (var ix = 0; ix < Basemadre.handsontable.countRows(); ix++) {
			if (!Basemadre.handsontable.isEmptyRow(ix)) {
				arrayDataClientes.push(Basemadre.handsontable.getDataAtRow(ix));
			}
		}

		if ( arrayDataClientes.length==0) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'No se ha detectado el llenado de la data, por favor ingrese la información solicitada' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else if ( contColsInvalid>0) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados en rojo' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else {
			++modalId;
			var fn1='Basemadre.guardarNuevoPuntoMasivo();Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Continuar',fn:fn1};
				btn[1]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		}
	},

	guardarNuevoPuntoMasivo: function(){
		var arrayDataClientes = [];
		for (var ix = 0; ix < Basemadre.handsontable.countRows(); ix++) {
			if (!Basemadre.handsontable.isEmptyRow(ix)) {
				arrayDataClientes.push(Basemadre.handsontable.getDataAtRow(ix));
			}
		}

		var dataArrayCargaMasiva = arrayDataClientes;
		var jsonString = {'data': JSON.stringify(dataArrayCargaMasiva)};
		var configAjax = {'url':Basemadre.url+'guardarNuevoPuntoMasivo', 'data':jsonString};

		$.when(Fn.ajax(configAjax)).then(function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});
		});
	}
}

Basemadre.load();