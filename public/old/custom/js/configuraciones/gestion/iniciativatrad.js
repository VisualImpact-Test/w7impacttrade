var IniciativaTrad = {

    secciones: ['Elemento','Iniciativa', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            IniciativaTrad.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/IniciativaTrad/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            
            var indiceSeccion = $(this).attr('href').split('-')[2];
            IniciativaTrad.tabSeleccionado = IniciativaTrad.secciones[indiceSeccion];
            
            if(IniciativaTrad.secciones[indiceSeccion] == 'Iniciativa'){
                $('.btn-CargaMasiva').show();
            }else if(IniciativaTrad.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }

            IniciativaTrad.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + IniciativaTrad.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + IniciativaTrad.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = IniciativaTrad.customDataTable;
            Gestion.seccionActivo = IniciativaTrad.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + IniciativaTrad.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + IniciativaTrad.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + IniciativaTrad.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + IniciativaTrad.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + IniciativaTrad.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + IniciativaTrad.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + IniciativaTrad.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + IniciativaTrad.tabSeleccionado
        });
    },

    cambiarSeccionActivo: function () {
        switch (IniciativaTrad.tabSeleccionado) {
            case 'Elemento':
                IniciativaTrad.customDataTable = Gestion.defaultDT;
                break;
            case 'Iniciativa':
                IniciativaTrad.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                IniciativaTrad.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
       
    },
}

IniciativaTrad.load();