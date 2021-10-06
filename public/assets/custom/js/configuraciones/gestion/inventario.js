var Inventario = {

    secciones: ['Lista'],
    tabSeleccionado: '',
    grupoCanal:null,
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Inventario.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/inventario/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
            if($('#cuenta option').length>=2){
                $("#cuenta").prop('selectedIndex', 1);
                $("#cuenta").change();
            }
            $('.btn-Consultar').click();
        });

        $('.card-header > .nav > .nav-item > a').on('shown.bs.tab', function (e) {
            $('.btn-Consultar').click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Inventario.tabSeleccionado = Inventario.secciones[indiceSeccion];

            if(Inventario.secciones[indiceSeccion] == 'Promocion'){
                $('.btn-CargaMasiva').hide();
            }else if(Inventario.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }

            Inventario.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Inventario.tabSeleccionado;
            // $('.contentGestion').addClass('d-none');
            // $('#' + Gestion.idContentActivo).removeClass('d-none');
            $('.contentGestion').removeClass('d-none');
            $('.contentGestion').hide(500);
            $('.' + Gestion.idContentActivo).show(500);
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Inventario.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Inventario.customDataTable;
            Gestion.seccionActivo = Inventario.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Inventario.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Inventario.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Inventario.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Inventario.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Inventario.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Inventario.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Inventario.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Inventario.tabSeleccionado
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
                        Inventario.grupoCanal=a.data.grupoCanal;
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

        $(document).on("change", ".grupoCanal_sl", function (e) {
            var idGrupoCanal =  $(this).val();

            var html="<option >--Seleccionar--</option>";
            if( Inventario.grupoCanal[idGrupoCanal]!=null){
                for (var [key, value] of Object.entries(Adicional.grupoCanal[idGrupoCanal])) {
                    html+='<option value='+key+'>'+value+'</option>';
                }
            }
            $('.canal_sl').html('<select id="canal" name="canal" class="form-control form-control-sm my_select2 canal_cliente canal_sl">'+html+'</select>')
            
        });
    },

    cambiarSeccionActivo: function () {
        switch (Inventario.tabSeleccionado) {
            case 'Lista':
                Inventario.customDataTable = Gestion.defaultDT;
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
    },
}

Inventario.load();