var Icompetitiva = {

    secciones: ['Categoria', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Icompetitiva.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/Icompetitiva/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Icompetitiva.tabSeleccionado = Icompetitiva.secciones[indiceSeccion];

            if(Icompetitiva.secciones[indiceSeccion] == 'Categoria'){
                $('.btn-CargaMasiva').show();
            }else if(Icompetitiva.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }

            Icompetitiva.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Icompetitiva.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Icompetitiva.tabSeleccionado).removeClass('d-none');
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
       
    },
}

Icompetitiva.load();