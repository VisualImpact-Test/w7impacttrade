var Visibilidad = {

    secciones: ['Categoria', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Visibilidad.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/Visibilidad/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Visibilidad.tabSeleccionado = Visibilidad.secciones[indiceSeccion];

            if(Visibilidad.secciones[indiceSeccion] == 'Categoria'){
                $('.btn-CargaMasiva').hide();
            }else if(Visibilidad.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }

            Visibilidad.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Visibilidad.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Visibilidad.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Visibilidad.customDataTable;
            Gestion.seccionActivo = Visibilidad.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Visibilidad.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Visibilidad.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Visibilidad.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Visibilidad.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Visibilidad.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Visibilidad.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Visibilidad.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Visibilidad.tabSeleccionado
        });
    },

    cambiarSeccionActivo: function () {
        switch (Visibilidad.tabSeleccionado) {
            case 'Categoria':
                Visibilidad.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                Visibilidad.customDataTable = Gestion.defaultDT;
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

Visibilidad.load();