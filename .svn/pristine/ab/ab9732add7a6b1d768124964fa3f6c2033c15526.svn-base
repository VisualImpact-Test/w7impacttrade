var Archivo = {

    secciones: ['Lista'],
    tabSeleccionado: '',
    grupoCanal:null,
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Archivo.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/Archivo/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
            $('.btn-Consultar').click();
            if($('#cuenta option').length>=2){
                $("#cuenta").prop('selectedIndex', 1);
                $("#cuenta").change();
            }
        });

        $('.card-header > .nav > .nav-item > a').on('shown.bs.tab', function (e) {
            $('.btn-Consultar').click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Archivo.tabSeleccionado = Archivo.secciones[indiceSeccion];

            if(Archivo.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
                if($('#cuenta option').length>=2){
                    $("#cuenta").prop('selectedIndex', 1);
                    $("#cuenta").change();
                }
            }
            Archivo.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Archivo.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('.contentGestion').removeClass('d-none');
            $('.contentGestion').hide(500);
            $('.' + Gestion.idContentActivo).show(500);
            $('.funciones .btn-seccion-' + Archivo.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Archivo.customDataTable;
            Gestion.seccionActivo = Archivo.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Archivo.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Archivo.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Archivo.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Archivo.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Archivo.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Archivo.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Archivo.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Archivo.tabSeleccionado
        });

        $(document).on("change", ".cuenta_cliente", function (e) {
			var data = {'idCuenta':$(this).val()};

            var jsonString = { 'data': JSON.stringify(data) };
		
            var config = { 'url': Gestion.urlActivo + "getProyectos", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                if (a.result == 1){
                    $('.proyecto_sl').html('<select id="proyecto_cliente" name="proyecto" class="form-control form-control-sm my_select2">'+a.data.html2+'</select>')
				}
			});
        });
         
    },

    cambiarSeccionActivo: function () {
        switch (Archivo.tabSeleccionado) {
            case 'Lista':
                Archivo.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
 
    },
}

Archivo.load();