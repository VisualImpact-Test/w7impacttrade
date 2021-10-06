var Promocion = {

    secciones: ['Promocion', 'Lista','TipoPromocion'],
    tabSeleccionado: '',
    grupoCanal:null,
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Promocion.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/Promociones/';
            $(".card-body > ul > li > a[class*='active']").click();
        });

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();

            $(".dv_cadena").hide();
            $(".dv_canal").hide();
            $(".dv_grupoCanal").hide();
            $(".dv_banner").hide();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Promocion.tabSeleccionado = Promocion.secciones[indiceSeccion];

            if(Promocion.secciones[indiceSeccion] == 'Promocion'){
                $('.btn-CargaMasiva').show();
            }else if(Promocion.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
                $(".dv_cadena").show();
                $(".dv_canal").show();
                $(".dv_grupoCanal").show();
            }
            Promocion.cambiarSeccionActivo();
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Promocion.customDataTable;
            Gestion.seccionActivo = Promocion.tabSeleccionado
            Gestion.idFormSeccionActivo = 'formFiltroPromociones';
            Gestion.getTablaActivo = 'getTabla' + Promocion.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Promocion.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Promocion.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Promocion.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Promocion.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Promocion.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Promocion.tabSeleccionado

            if($("#"+Gestion.idContentActivo).find('.noResultado').length > 0){
                $('.btn-Consultar').click()
            }
            setTimeout(function(){
                if(Gestion.$dataTable[Gestion.idContentActivo]){
                    Gestion.$dataTable[Gestion.idContentActivo].columns.adjust();
                }
            }, 500);
        });

        $(document).on("change", ".cuenta_cliente", function (e) {
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
                        Promocion.grupoCanal=a.data.grupoCanal;
                    }
				}
			});
        });

        $(document).on("change", ".canal_cliente", function (e) {
			var data = {'idCanal': $(this).val(),'idCuenta':$('#cuenta_cliente').val(),'idProyecto':$('#proyecto_cliente').val()};

            var jsonString = { 'data': JSON.stringify(data) };
		
            var config = { 'url': Gestion.urlActivo + "getSegCliente", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                
                if (a.result == 1) $('.cliente_sl').html("<select id='cliente' name='cliente' + class='form-control form-control-sm my_select2'>"+a.data.html+"</select>");
            });

        });
    },

    cambiarSeccionActivo: function () {
        switch (Promocion.tabSeleccionado) {
            case 'Promocion':
                Promocion.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                Promocion.customDataTable = Gestion.defaultDT;
                break;
            case 'TipoPromocion':
                Promocion.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
        $(document).on('click',".btn-agregar-elemento-lista",function(){
            var data = {};
            data['id'] = $("#elemento").val();
            data['marca'] = $('#marca').val();

			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestion.urlActivo + 'getElementoLista', 'data': jsonString };

            if(data.id != '' && data.marca !=''){

                $.when(Fn.ajax(config)).then(function (a) {
                    
     
                    $('#tabla_elemento_lista').append(a.data.html);
                    
                    $('body').attr('class',"modal-open");
                });
            }
            
        });

        $(document).on("change", ".canal_cliente", function (e) {
            var data = {'idCanal': $(this).val()};
            var jsonString = { 'data': JSON.stringify(data) };
            var config = { 'url': Gestion.urlActivo + "getSegCliente", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                
                if (a.result == 1) $('.cliente_sl').html("<select id='cliente' name='cliente' + class='form-control form-control-sm my_select2'>"+a.data.html+"</select>");
            });

		});
    },
}

Promocion.load();