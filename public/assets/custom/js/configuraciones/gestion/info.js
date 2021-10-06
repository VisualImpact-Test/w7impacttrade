var Info = {

    secciones: ['Elemento', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Info.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/gestorTiendaInfo/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();

            if($('#cuenta_filtro option').length>=2){
                $("#cuenta_filtro").prop('selectedIndex', 1);
                $("#cuenta_filtro").change();
            }
            $('.btn-Consultar').click();

        });

        $('.card-header > .nav > .nav-item > a').on('shown.bs.tab', function (e) {
            $('.btn-Consultar').click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            
            var indiceSeccion = $(this).attr('href').split('-')[2];
            Info.tabSeleccionado = Info.secciones[indiceSeccion];
            
            if(Info.secciones[indiceSeccion] == 'Elemento'){
                $('.btn-CargaMasiva').hide();
            }else if(Info.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
                if($('#cuenta option').length>=2){
                    $("#cuenta").prop('selectedIndex', 1);
                    $("#cuenta").change();
                }
            }

            Info.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Info.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            // $('#' + Gestion.idContentActivo).removeClass('d-none');
            // $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.contentGestion').removeClass('d-none');
            $('.contentGestion').hide(500);
            $('.' + Gestion.idContentActivo).show(500);
            $('.funciones .btn-seccion-' + Info.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Info.customDataTable;
            Gestion.seccionActivo = Info.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Info.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Info.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Info.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Info.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Info.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Info.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Info.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Info.tabSeleccionado
        });
    },

    cambiarSeccionActivo: function () {
        switch (Info.tabSeleccionado) {
            case 'Elemento':
                Info.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                Info.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
       
    },
}

Info.load();