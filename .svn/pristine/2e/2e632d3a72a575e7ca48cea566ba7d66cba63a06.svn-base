var VisibilidadTrad = {

    secciones: ['Elemento', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },
    grupoCanal:null,
    load: function () {

        $(document).ready(function (e) {
            VisibilidadTrad.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/VisibilidadTrad/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
            if($('#cuenta option').length>=2){
                $("#cuenta").prop('selectedIndex', 1);
                $("#cuenta").change();
            }
            $('.btn-Consultar').click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            VisibilidadTrad.tabSeleccionado = VisibilidadTrad.secciones[indiceSeccion];

            if(VisibilidadTrad.secciones[indiceSeccion] == 'Elemento'){
                $('.btn-CargaMasiva').hide();
            }else if(VisibilidadTrad.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }

            VisibilidadTrad.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + VisibilidadTrad.tabSeleccionado;
            // $('.contentGestion').addClass('d-none');
            // $('#' + Gestion.idContentActivo).removeClass('d-none');
            $('.contentGestion').removeClass('d-none');
            $('.contentGestion').hide(500);
            $('.' + Gestion.idContentActivo).show(500);
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + VisibilidadTrad.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = VisibilidadTrad.customDataTable;
            Gestion.seccionActivo = VisibilidadTrad.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + VisibilidadTrad.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + VisibilidadTrad.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + VisibilidadTrad.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + VisibilidadTrad.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + VisibilidadTrad.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + VisibilidadTrad.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + VisibilidadTrad.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + VisibilidadTrad.tabSeleccionado
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
                        VisibilidadTrad.grupoCanal=a.data.grupoCanal;
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
        switch (VisibilidadTrad.tabSeleccionado) {
            case 'Elemento':
                VisibilidadTrad.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                VisibilidadTrad.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
       
    },
}

VisibilidadTrad.load();