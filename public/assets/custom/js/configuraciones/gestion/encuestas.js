var Encuestas = {
    idEncuesta:0,
    idPregunta:0,
    secciones: ['Encuesta', 'Lista'],
    tabSeleccionado: '',
    grupoCanal:null,
    idCuenta:0,
    grupoCanal_canales:null,
    ordernOpcion:0,

    customDataTable: function () { },

    dataTipoPregunta: [],
    dataObligatorio: [],

    handsontable : '',


    load: function () {

        $(document).ready(function (e) {
            Encuestas.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/encuestas/';
            $(".card-body > ul > li > a[class*='active']").click();
            $('.btn-Consultar').click();
        });

        $(document).on('dblclick', '.card-body > ul > li > a', function (e) {
            $('.btn-Consultar').click();
        });

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Encuestas.tabSeleccionado = Encuestas.secciones[indiceSeccion];

            if(Encuestas.secciones[indiceSeccion] == 'Encuesta'){
                $('#btn-CargaMasivaEncuesta1').removeClass('d-none');
                $('#btn-CargaMasivaLista').addClass('d-none');
                $('#configuracion-filtro').addClass('d-none');
            }else if(Encuestas.secciones[indiceSeccion] == 'Lista'){
                $('#btn-CargaMasivaLista').removeClass('d-none');
                $('#btn-CargaMasivaEncuesta1').addClass('d-none');
                $('#configuracion-filtro').removeClass('d-none');
            }

            Encuestas.cambiarSeccionActivo();
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Encuestas.customDataTable;
            Gestion.seccionActivo = Encuestas.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccionListayEncuesta'
            Gestion.getTablaActivo = 'getTabla' + Encuestas.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Encuestas.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Encuestas.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Encuestas.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Encuestas.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Encuestas.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Encuestas.tabSeleccionado
            Gestion.funcionActualizarCargaMasivaActivo = 'actualizarCargaMasiva' + Encuestas.tabSeleccionado

            //Ajustar columnas
            setTimeout(function(){
                if(Gestion.$dataTable[Gestion.idContentActivo]){
                    Gestion.$dataTable[Gestion.idContentActivo].columns.adjust();
                }
            }, 500);
        });

        $(document).on('click',"#eliminar_encuesta",function(){
            $("#tabla_encuesta_lista " +this).on('click', function() {
                var toma1 = "", toma2 = "", toma3 = ""; 
                        toma1 += $(this).find('td:eq(1)').html();
                        toma2 += $(this).find('td:eq(3)').html();
                        toma3 += $(this).find('td:eq(5)').html();
         
                $("#respuesta").text(toma1 + toma2 + toma3);
            });
            var data = {};
			data['id'] = $("#encuesta").val();
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestion.urlActivo + 'getEncuesta', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {
                var t = $('#tabla_encuesta_lista').DataTable();
             
                    t.row.add( a.data.html ).draw( false );
                $('#tabla_encuesta_lista').append(a.data.html);
			});
        });

        $(document).on('click','#btn-CargaMasivaEncuesta', function(e){
        	e.preventDefault();
            var data ={};
            var jsonString = {'data': JSON.stringify(data)};
            var configAjax = {'url':  Gestion.urlActivo +'getFormCargaMasivaEncuesta', 'data': jsonString};

            $.when( Fn.ajax(configAjax)).then( function(a){
                ++modalId;
                var message = a.data.html;
                Gestion.idModalPrincipal = modalId;
                var btn = [];
				var fn = [];

				fn[1] = 'Encuestas.confirmarGuardarMasivoEncuestas();';
                fn[0] = 'Fn.showModal({ id:' + modalId + ',show:false });';

				btn[0] = { title: 'Cerrar', fn: fn[0] };
				btn[1] = { title: 'Guardar', fn: fn[1] };

                Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:'80%'});
                Encuestas.cargaMasivaEncuesta();
            });
        });
    },

    cambiarSeccionActivo: function () {
        switch (Encuestas.tabSeleccionado) {
            case 'Encuesta':
                Encuestas.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                Encuestas.customDataTable = Gestion.defaultDT;
                break;
            
        }
    },

    eventos: function () {
        $(document).on('click',".btn-agregar-encuesta-lista",function(){
            var data = {};
            data['id'] = $("#encuesta").val();
            
            data['idCuenta'] = $(".flt_cuenta ").val();
			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestion.urlActivo + 'getEncuesta', 'data': jsonString };

            if(data.id != ''){

                $.when(Fn.ajax(config)).then(function (a) {
                    
                    // ++modalId;
                    // var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                    
                    // var btn = [];
                    // btn[0] = { title: 'Cerrar', fn: fn };
                    // Fn.showModal({ id: modalId, show: true, title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
                    
                    
                    $('#tabla_encuesta_lista').append(a.data.html);
                    
                    $('body').attr('class',"modal-open");
                });
            }
            
        });
        $(document).on('click',"#fila_temporal_encuesta",function(){
            $(this).remove();
        });

        $(document).on("click", ".btn-Preguntas", function (e) {
			e.preventDefault();
            Gestion.seccionActivo= "Pregunta";
            Gestion.btnConsultar= ".btn-Consultar-pregunta";
            var data = { 'id': $(this).closest('tr').data('id') };
            
			var serialize = Fn.formSerializeObject("formEditarPreguntas");
            Object.assign(data, serialize);

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + 'getTablaPregunta', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Encuestas.resetActivo();';
				var fn1 = 'Fn.showConfirm({ fn:"Encuestas.actualizar_preguntas()",content:"¿Esta seguro de actualizar los datos?" });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Actualizar', fn: fn1 };
				Fn.showModal({ id: modalId, class: a.data.class, show: true, title: "Editar Preguntas", frm: a.data.html, btn: btn,width:a.data.width });
			});
		});
        $(document).on("click", ".table .trHijo .btn-EditarAlternativas", function (e) {
			e.preventDefault();
			var tr = $(this).closest('tr');
			var table = $(this).closest('table');
			var lastTh = $(table).find('thead tr:first th:last');

			var idSeleccionado = $(tr).find("input[name|='id']").val();
	
            var data = { 'id': idSeleccionado };
			var serialize = Fn.formSerializeObject("formEditarAlternativas");
            Object.assign(data, serialize);
            

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + 'getTablaAlternativa', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Encuestas.resetActivo();';
				var fn1 = 'Fn.showConfirm({ fn:"Encuestas.actualizar_alternativas()",content:"¿Esta seguro de actualizar los datos?" });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Actualizar', fn: fn1 };
				Fn.showModal({ id: modalId, class: a.data.class, show: true, title: "Editar Alternativas", frm: a.data.html, btn: btn,large:true });
			});
	
        });
        $(document).on("click", ".table .trHijo .btn-EditarAlternativasOpciones", function (e) {
			e.preventDefault();
			var tr = $(this).closest('tr');
			var table = $(this).closest('table');
			var lastTh = $(table).find('thead tr:first th:last');

			var idSeleccionado = $(tr).find("input[name|='id']").val();
	
            var data = { 'id': idSeleccionado };

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + 'getTablaAlternativaOpciones', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Encuestas.resetActivo();';
				var fn1 = 'Fn.showConfirm({ fn:"Encuestas.actualizar_alternativas_opciones()",content:"¿Esta seguro de actualizar los datos?" });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Actualizar', fn: fn1 };
				Fn.showModal({ id: modalId, class: a.data.class, show: true, title: "Editar Opciones de Alternativas", frm: a.data.html, btn: btn,large:true });
			});
	
        });

        $(document).on("click", ".table .trHijo .btn-EditarPreguntasHijo", function (e) {
			e.preventDefault();
			var tr = $(this).closest('tr');
			var table = $(this).closest('table');
			var lastTh = $(table).find('thead tr:first th:last');

			var idSeleccionado = $(tr).find("input[name|='id']").val();
	
            var data = { 'id': idSeleccionado };
			var serialize = Fn.formSerializeObject("formEditarAlternativas");
            Object.assign(data, serialize);
            

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + 'getTablaPreguntaHijo', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Encuestas.resetActivo();';
				var fn1 = 'Fn.showConfirm({ fn:"Encuestas.actualizar_preguntas_hijo()",content:"¿Esta seguro de actualizar los datos?" });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Actualizar', fn: fn1 };
				Fn.showModal({ id: modalId, class: a.data.class, show: true, title: "Editar Alternativas", frm: a.data.html, btn: btn,large:true });
			});
	
		});
        $(document).on("click", ".btn-clickToAgregar", function (e) {
            $('.btn-AgregarElemento').click();
        });
        $(document).on("click", "table thead th .btn-AgregarElementoOpcion", function (e) {
			e.preventDefault();
            Encuestas.ordenOpcion += 1;
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

			$(trPadre).find('select').removeAttr('disabled');
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
					if(tdName = "txtOrden" && inputText[0].id == `txtOrden-${nextFila}`) {
                        $(inputText[0]).val(Encuestas.ordenOpcion);
                    }
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
        $(document).on("click", "table .trHijo .btn-BorrarElementoOpcion", function (e) {
			e.preventDefault();
            if(Encuestas.ordenOpcion >= 0) {
                console.log(Encuestas.ordenOpcion -= 1);
            }
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
        $(document).on("click", ".btn-cargarImagenPreg", function (e) {

            let control = $(this);
            control.closest('tr').find(".inputFilePreg").click();

        });        
        
        $(document).on("change", ".canal_cliente", function (e) {
           var data = {'idCanal': $('#canal_form').val(),'idCuenta':$('#cuenta').val(),'idProyecto':$('#proyecto').val()};
            var jsonString = { 'data': JSON.stringify(data) };
            var config = { 'url': Gestion.urlActivo + "getSegCliente", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                
                if (a.result == 1) $('.cliente_sl_form').html("<select id='cliente_form' name='cliente_form' + class='form-control form-control-sm my_select2'>"+a.data.html+"</select>");
            });
        });

        $(document).on("change", ".fl-control", function(file_) {
			var content = $(this).attr("data-content");
			var file = file_.target.files[0];
			var foto_content = $(this).attr("data-foto-content");
            let tr = $(this).closest('tr');

            tr.find(".btn-verImagenPreg").removeAttr("disabled");
            tr.find(".lk-show-foto-imagen").addClass("d-none")
            tr.find(".btn-verImagenPreg").removeClass("d-none")

			if(file.size>=2*1024*1024) {
				++modalId;
				var btn=[];
				var fn='Fn.showModal({ id:'+modalId+',show:false });';

				btn[0]={title:'Continuar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:'Archivo',content:"El tamaño del archivo seleccionado excede al permitido (2MB)",btn:btn });
				return;
			}
			Imagen.show( file_, foto_content, content, this );
        });
		
		
        
        $(document).on("change", ".cuenta_cliente", function (e) {
            Encuestas.idCuenta = $(this).val();
            var data = {'idCuenta':Encuestas.idCuenta};

            var jsonString = { 'data': JSON.stringify(data) };
		
            var config = { 'url': Gestion.urlActivo + "getProyectos", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                if (a.result == 1){
					$('.grupoCanal_sl_form').html('<select id="grupoCanal_form" name="grupoCanal_form" class="form-control form-control-sm my_select2 grupoCanal_cliente">'+a.data.html3+'</select>')
                    
                    $('.proyecto_sl_form').html('<select id="proyecto_form" name="proyecto_form" class="form-control form-control-sm my_select2">'+a.data.html2+'</select>')
                    
                    $('.cliente_sl_form').html("<select id='cliente_form' name='cliente_form' + class='form-control form-control-sm my_select2'>"+a.data.html+"</select>");
                    
                    if(a.data.grupoCanal!=null){
                        Encuestas.grupoCanal=a.data.grupoCanal;
                    }
				}
			});

        });
        
        $(document).on("click", ".remove-truncate", function (e) {
            $( "td" ).removeClass( "text-truncate" );
            $("td").css("max-width", '1000px');
            Gestion.$dataTable[Gestion.idContentActivo].columns.adjust();
        });

        $(document).on("change", ".grupoCanal_cliente", function (e) {
            var idGrupoCanal =  $(this).val();
            var data = {'idGrupoCanal':Encuestas.idCuenta};

            var jsonString = { 'data': JSON.stringify(data) };
            var config = { 'url': Gestion.urlActivo + "getCanales", 'data': jsonString };

            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                if (a.result == 1){
                    if(a.data.grupoCanal!=null){
                        Encuestas.grupoCanal=a.data.grupoCanal;
                    }
                }
                
                var html="<option value=''>--Seleccionar--</option>";
                $('.cliente_sl_form').html("<select id='cliente_form' name='cliente_form' + class='form-control form-control-sm my_select2'>"+html+"</select>");
                if( Encuestas.grupoCanal[idGrupoCanal]!=null){
                    for (var [key, value] of Object.entries(Encuestas.grupoCanal[idGrupoCanal])) {
                        html+='<option value='+key+'>'+value+'</option>';
                    }
                }
                $('.canal_sl_form').html('<select id="canal_form" name="canal_form" class="form-control form-control-sm my_select2 canal_cliente">'+html+'</select>')
    
            });        
		});

        $(document).on("change", ".grupoCanal", function (e) {
            var idGrupoCanal =  $(this).val();
            
            var html="<option value=''>--Seleccionar--</option>";
            if( Encuestas.grupoCanal_canales[idGrupoCanal]!=null){
                for (var [key, value] of Object.entries(Encuestas.grupoCanal_canales[idGrupoCanal])) {
                    html+='<option value='+key+'>'+value+'</option>';
                }
            }
            $('.canal_form').html('<select id="canal_form" name="canal_form" class="form-control form-control-sm my_select2">'+html+'</select>')
           
		});
        $(document).on("click", ".tabCargaMasiva", function (e) {
            let hoja = $(".tabCargaMasiva.active").data("nrohoja");
            
            if(hoja == 1){
                $(".msgCargaEncuestas").removeClass("d-none");
            }else{
                $(".msgCargaEncuestas").addClass("d-none");
            }
		});

        $(document).on("click", ".btn-CargaMasivaListas", function (e) {
			e.preventDefault();

			var config = { 'url': Gestion.urlActivo + Gestion.getFormCargaMasivaActivo };
			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var fn1 = 'Gestion.confirmarGuardarCargaMasiva();';
				var fn2 = 'Gestion.confirmarActualizarCargaMasiva();';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Actualizar', fn: fn2 };
				btn[2] = { title: 'Guardar', fn: fn1 };

				Fn.showModal({ id: modalId, show: true, class: 'modalCargaMasiva', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
				HTCustom.llenarHTObjectsFeatures(a.data.ht);
			});
		});
        $(document).on("change", ".chk-foto", function (e) {
            let control = $(this);
            let tr = $(this).closest('tr');
            if(control.prop("checked")){
                control.closest('tr').find(".chkFotoObligatoria").removeAttr("disabled");
            }
            if(!control.prop("checked")){
                control.closest('tr').find(".chkFotoObligatoria").attr("disabled","disabled");
            }
           
		});
        $(document).on("change", "table .trHijo .chk-ActualizarElemento", function (e) {
			e.preventDefault();
			var valorCheck = $(this).prop('checked');
			var tr = $(this).closest('tr');
			var inputs = $(tr).find(':input');
			var chkActualizarElemento = $(tr).find('.chk-ActualizarElemento');
            
            tr.find(".chk-foto").change();
            
			$.each(inputs, function (i, v) {
				$(this).attr('disabled', !valorCheck);
			});

            
			valorCheck ? $(tr).removeClass('table-secondary') : $(tr).addClass('table-secondary');
            
			$(chkActualizarElemento).attr('disabled', false);
            
            
            // console.log(tr.find(".fotoMiniatura").attr("src"));
            if(tr.find(".fotoMiniatura").attr("src") == "") {
                $(".btn-verImagenPreg").attr("disabled","disabled")

            }
            else {
            
                tr.find(".btn-verImagenPreg").removeAttr("disabled")
            };
           
		});
        $(document).on("click", ".btn-verImagenPreg", function (e) {
			e.preventDefault();

			var control = $(this);
			var tr = $(this).closest('tr');
			
            tr.find(".fotoMiniatura").click();
           
		});
		
		$('#canal_form').change();

    },
    resetActivo: function(){
        Gestion.btnConsultar= ".btn-Consultar";
        Gestion.seccionActivo= "Encuesta";
    },
    

    actualizar_preguntas: function () {

        var dataFotosFotos = [];
        $('.trHijo').each( function(ix,val){
            var tr = $(this);
            var visitaModuloFoto = "";
            let fila = tr.data("fila");
            let idPreg = tr.data("codpregunta");

			var foto='';

            foto = tr.find('#img-fotoprincipal-'+fila).attr('src');
            if ( typeof foto === 'undefined' || foto.includes('fotos/impactTrade_Android/moduloFotos') || foto=='') {
				foto = null;
			};

            if ( foto !== null ) {
				var sufijo = 'PREG'+visitaModuloFoto;
				arrayFoto = {
					'idVisita': Fn.generarCorrelativo(idPreg,6)
					,'contenido':foto
					,'ruta': 'archivos/impactTrade_Android/'
					,'sufijo':sufijo
					,'columna':'fila'
                    ,'fila': fila
				};
				dataFotosFotos.push(arrayFoto);
			}
        });


        $.when( Fn.enviarFotos(dataFotosFotos) ).then( function(af){
            if ( !af ) {
                ++modalId;
                var fn='Fn.showModal({ id:'+modalId+',show:false });';
                var btn=new Array();
                    btn[0]={title:'Cerrar',fn:fn};
                var message = Fn.message({ 'type': 2, 'message': 'Se encontró inconvenientes al momento de proceder con el almacenamiento de las fotos' });
                Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
                return false;
            }
            var data = Fn.formSerializeObject('formEditarPreguntas');
                data.dataFotosFotos = af;
            var jsonString = { 'data': JSON.stringify(data) };
            var config = { 'url': Gestion.urlActivo + "actualizarPreguntas", 'data': jsonString };
            Encuestas.idEncuesta =$('#idEncuesta').val();

            $.when(Fn.ajax(config)).then(function (a) {

        
                if (a.result === 2) return false;
                if (typeof a.data.validaciones !== null) $.mostrarValidaciones('formEditarPreguntas', a.data.validaciones);

                ++modalId;
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

                if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });Encuestas.refrescar_pregunta()';

                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };
                Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
            });
    }   );
    },

    actualizar_alternativas: function () {
		var data = Fn.formSerializeObject('formEditarAlternativas');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Gestion.urlActivo + "actualizarAlternativas", 'data': jsonString };
        Encuestas.idEncuesta =$('#idPregunta').val();

		$.when(Fn.ajax(config)).then(function (a) {

	
            if (a.result === 2) return false;
            if (typeof a.data.validaciones !== null) $.mostrarValidaciones('formEditarAlternativas', a.data.validaciones);

            ++modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

            if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });';

            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
		});
    },
    actualizar_alternativas_opciones: function () {
		var data = Fn.formSerializeObject('formEditarAlternativasOpciones');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Gestion.urlActivo + "actualizarAlternativasOpciones", 'data': jsonString };
        Encuestas.idEncuesta =$('#idPregunta').val();

		$.when(Fn.ajax(config)).then(function (a) {

	
            if (a.result === 2) return false;
            if (typeof a.data.validaciones !== null) $.mostrarValidaciones('formEditarAlternativasOpciones', a.data.validaciones);

            ++modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

            if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });';

            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
		});
    },

    actualizar_preguntas_hijo: function () {
		var data = Fn.formSerializeObject('formEditarPreguntaHijo');
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Gestion.urlActivo + "actualizarPreguntasHijo", 'data': jsonString };
        Encuestas.idEncuesta =$('#idPregunta').val();

		$.when(Fn.ajax(config)).then(function (a) {

	
            if (a.result === 2) return false;
            if (typeof a.data.validaciones !== null) $.mostrarValidaciones('formEditarPreguntaHijo', a.data.validaciones);

            ++modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

            if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });';

            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };
            Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
		});
    },

    refrescar_pregunta: function(){
        Gestion.seccionActivo= "Pregunta";
        Gestion.btnConsultar= ".btn-Consultar-pregunta";
        var data = { 'id':Encuestas.idEncuesta};
        
        var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
        Object.assign(data, serialize);

        var jsonString = { 'data': JSON.stringify(data) };

        var config = { 'url': Gestion.urlActivo + 'getTablaPregunta', 'data': jsonString };

        $.when(Fn.ajax(config)).then(function (a) {

            Encuestas.close_all_modal(modalId);
            if (a.result === 2) return false;

            ++modalId;
            Gestion.idModalPrincipal = modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Encuestas.resetActivo();';
            var fn1 = 'Fn.showConfirm({ fn:"Encuestas.actualizar_preguntas()",content:"¿Esta seguro de actualizar los datos?" });';

            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };
            btn[1] = { title: 'Actualizar', fn: fn1 };
            Fn.showModal({ id: modalId,class: a.data.class, show: true, title: "Editar Preguntas", frm: a.data.html, btn: btn,large:true });
        });
    },

    close_all_modal: function($id_active){
        for (let index = 0; index <= $id_active; index++) {
            Fn.showModal({id:index,show:false});
        }
    },

    cargaMasivaEncuesta: function(){
		var sourceTipoPregunta = Encuestas.dataTipoPregunta;
		var sourceObligatorio = Encuestas.dataObligatorio;

		var data = [];
		var container = document.getElementById('nuevoMasivoEncuesta');
		
		var settings = {
			licenseKey: 'non-commercial-and-evaluation',
			data: null,
			dataSchema: {
                'encuesta' : null
				, 'foto' : null 
				, 'tipoPregunta' : null 
				, 'pregunta' : null 
				, 'obligatorio' : null 
				, 'orden' : null 
				, 'alternativa' : null 
            },
			colHeaders: ['ENCUESTA','FOTO', 'TIPO PREGUNTA', 'PREGUNTA', 'OBLIGATORIO','ORDEN','ALTERNATIVA'],
			startRows: 10,
			//startCols: 4,
			columns: [
				{
                    data: 'encuesta'
				},
				{
                    data: 'foto'
                    , type: 'dropdown'
                    , source: sourceObligatorio
				},
				{
                    data: 'tipoPregunta'
                    , type: 'dropdown'
                    , source: sourceTipoPregunta
                }
				,
				{ data: 'pregunta'},

				{ data: 'obligatorio'
                    , type: 'dropdown'
                    , source: sourceObligatorio
				},
				{
                    data: 'orden'
                    , type:'numeric'
				},
				{ data: 'alternativa'
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
			maxRows: 1000, //cantidad máxima de filas
			manualColumnResize: true
		};

		Encuestas.handsontable = new Handsontable(container, settings);

		setTimeout(function(){
			Encuestas.handsontable.render(); 
		}, 1000);
	},

    confirmarGuardarMasivoEncuestas: function(){
		var valoresNecesarios=0;
		var contColsInvalid = 0;
			contColsInvalid = $('#nuevoPuntoMasivo .htInvalid').length;

		for (var ix = 0; ix < Encuestas.handsontable.countRows(); ix++) {
			if (!Encuestas.handsontable.isEmptyRow(ix)) {
                var columnaEncuesta = Encuestas.handsontable.getDataAtCell(ix,0); if ( columnaEncuesta==null) { valoresNecesarios++; }

			}
		}

        var btn = [];
        var fn = [];

		if ( valoresNecesarios>0 ) {
			++modalId;
			fn[0]='Fn.showModal({ id:'+modalId+',show:false });';
            btn[0]={title:'Cerrar',fn:fn[0]};
			var message = Fn.message({ 'type': 2, 'message': 'Se encontrarón valores necesarios a completar' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
			return false;
		} else {
			++modalId;
			fn[0]='Fn.showModal({ id:'+modalId+',show:false });';
			fn[1]='Encuestas.guardarMasivoEncuestas();Fn.showModal({ id:'+modalId+',show:false });';
            btn[0]={title:'Cerrar',fn:fn[0]};
            btn[1]={title:'Continuar',fn:fn[1]};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
			Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
		}
	},

    guardarMasivoEncuestas: function(){
		var arrayDataEncuestas = [];
		for (var ix = 0; ix < Encuestas.handsontable.countRows(); ix++) {
			if (!Encuestas.handsontable.isEmptyRow(ix)) {
				arrayDataEncuestas.push(Encuestas.handsontable.getDataAtRow(ix));
			}
		}

		var dataArrayCargaMasiva = arrayDataEncuestas;
		var data = { 'dataArray': dataArrayCargaMasiva};
		var jsonString = {'data': JSON.stringify(data)};
		var configAjax = {'url': Gestion.urlActivo+'guardarCargaMasivaEncuesta', 'data':jsonString};

		$.when(Fn.ajax(configAjax)).then(function(a){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });Fn.showModal({ id:'+Gestion.idModalPrincipal+',show:false }); $(".btn-Consultar").click();';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = a.msg.content;
			Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:'80%'});
		});
	},
    
}

Encuestas.load();