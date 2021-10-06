var Adicional = {

    secciones: ['Elemento', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Adicional.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/auditoria/Adicional/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Adicional.tabSeleccionado = Adicional.secciones[indiceSeccion];

            if(Adicional.secciones[indiceSeccion] == 'Elemento'){
                $('.btn-CargaMasiva').show();
            }else if(Adicional.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }
            
            Adicional.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Adicional.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Adicional.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Adicional.customDataTable;
            Gestion.seccionActivo = Adicional.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Adicional.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Adicional.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Adicional.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Adicional.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Adicional.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Adicional.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Adicional.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Adicional.tabSeleccionado
        });
    },

    cambiarSeccionActivo: function () {
        switch (Adicional.tabSeleccionado) {
            case 'Elemento':
                Adicional.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                Adicional.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
       
    },
}

Adicional.load();