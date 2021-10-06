var Icompetitiva = {

    secciones: ['Categoria', 'Lista'],
    tabSeleccionado: '',
    grupoCanal: null,
    marcas: null,
    idCuenta:0,
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Icompetitiva.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/Icompetitiva/';
            $(".card-body > ul > li > a[class*='active']").click();
 
        });

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Icompetitiva.tabSeleccionado = Icompetitiva.secciones[indiceSeccion];

            if(Icompetitiva.secciones[indiceSeccion] == 'Categoria'){
                $('.btn-CargaMasiva').show();
            }else if(Icompetitiva.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }

            Icompetitiva.cambiarSeccionActivo();
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Icompetitiva.customDataTable;
            Gestion.seccionActivo = Icompetitiva.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Icompetitiva.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Icompetitiva.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Icompetitiva.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Icompetitiva.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Icompetitiva.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Icompetitiva.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Icompetitiva.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Icompetitiva.tabSeleccionado

            if($("#"+Gestion.idContentActivo).find('.noResultado').length > 0){
                $('.btn-Consultar').click()
            }
            setTimeout(function(){
                if(Gestion.$dataTable[Gestion.idContentActivo]){
                    Gestion.$dataTable[Gestion.idContentActivo].columns.adjust();
                }
            }, 500);
        });

        
    },

    cambiarSeccionActivo: function () {
        switch (Icompetitiva.tabSeleccionado) {
            case 'Categoria':
                Icompetitiva.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                Icompetitiva.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
       $(document).on("change", ".cuenta_cliente", function (e) {
            Icompetitiva.idCuenta = $(this).val();
			var data = {'idCuenta':$(this).val()};

            var jsonString = { 'data': JSON.stringify(data) };
		
            var config = { 'url': Gestion.urlActivo + "getProyectos", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                if (a.result == 1){
					$('.grupoCanal_sl').html('<select id="grupoCanal" name="grupoCanal" class="form-control form-control-sm my_select2 grupoCanal_cliente">'+a.data.html3+'</select>')
                    
                    $('.proyecto_sl').html('<select id="proyecto_cliente" name="proyecto" class="form-control form-control-sm my_select2">'+a.data.html2+'</select>')
                    
                    $('.cliente_sl').html("<select id='cliente' name='cliente' + class='form-control form-control-sm my_select2'>"+a.data.html+"</select>");
                    
                    if(a.data.grupoCanal!=null){
                        Icompetitiva.grupoCanal=a.data.grupoCanal;
                    }
				}
			});

		});
        
        
        
        
        $(document).on("change", ".grupoCanal_cliente", function (e) {
            var idGrupoCanal =  $(this).val();
            var html="<option >--Seleccionar--</option>";
            if( Icompetitiva.grupoCanal[idGrupoCanal]!=null){
                for (var [key, value] of Object.entries(Icompetitiva.grupoCanal[idGrupoCanal])) {
                    html+='<option value='+key+'>'+value+'</option>';
                }
            }
            $('.canal_sl').html('<select id="canal" name="canal" class="form-control form-control-sm my_select2 canal_cliente">'+html+'</select>')

        });

        $(document).on("change", ".canal_cliente", function (e) {
            var data = {'idCanal': $(this).val(),'idCuenta':$('#cuenta').val(),'idProyecto':$('#proyecto').val()};
             var jsonString = { 'data': JSON.stringify(data) };
             var config = { 'url': Gestion.urlActivo + "getSegCliente", 'data': jsonString };
             $.when(Fn.ajax(config)).then(function (a) {
 
                 if (a.result === 2) return false;
                 
                 if (a.result == 1) $('.cliente_sl').html("<select id='cliente' name='cliente' + class='form-control form-control-sm my_select2'>"+a.data.html+"</select>");
             });
 
         });
         
         $(document).on("change", ".sl_categoria", function (e) {
            var idCategoria =  $(this).val();
            var html="<option value=''>-- Seleccionar --</option>";
            if( Icompetitiva.marcas[idCategoria]!=null){
                for (var [key, value] of Object.entries(Icompetitiva.marcas[idCategoria])) {
                    html+='<option value='+key+'>'+value+'</option>';
                }
            }
            $(this).closest('.trHijo').find('.sl_marca').html(html);

        });

        $(document).on("change",".sl_marca",function(e){
            let idMarca = $(this).val();
            let marcas = [];
            $.each($('.sl_marca'),function(i,v){
                if(i != 0 ){
                    if($(this).val() != ""){
                        if($.inArray($(this).val(),marcas) != -1){
                            ++modalId;
                            var btn = [];
                            var data = {};
                            var fn0 = 'Fn.showModal({ id:' + modalId + ',show:false });';
                            btn[0] = { title: 'Aceptar', fn: fn0 };
                            Fn.showModal({ id: modalId, show: true, title: 'Alerta', content: Fn.message({'type':2,'message':'La marca: <b>' + $(".sl_marca:eq("+i+") option:selected").text() + '</b> ya existe en la lista'}), btn: btn });
                            $(this).val('');
                            $(this).select2({
                                dropdownParent: $(".frmContenedorselect2"),
                                width: '100%'
                            });
                        }
                    }
                    marcas.push($(this).val())
                }
            });

        });


        
    },
}

Icompetitiva.load();