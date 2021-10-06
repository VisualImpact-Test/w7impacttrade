var VisibilidadTrad = {

    secciones: ['Elemento', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            VisibilidadTrad.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/VisibilidadTrad/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            VisibilidadTrad.tabSeleccionado = VisibilidadTrad.secciones[indiceSeccion];

            if(VisibilidadTrad.secciones[indiceSeccion] == 'Elemento'){
                $('.btn-CargaMasiva').show();
            }else if(VisibilidadTrad.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }

            VisibilidadTrad.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + VisibilidadTrad.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
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