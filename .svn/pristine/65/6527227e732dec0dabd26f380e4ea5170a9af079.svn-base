var Promocion = {

    secciones: ['Promocion', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Promocion.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/Promociones/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Promocion.tabSeleccionado = Promocion.secciones[indiceSeccion];

            if(Promocion.secciones[indiceSeccion] == 'Promocion'){
                $('.btn-CargaMasiva').show();
            }else if(Promocion.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }
            Promocion.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Promocion.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Promocion.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Promocion.customDataTable;
            Gestion.seccionActivo = Promocion.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Promocion.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Promocion.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Promocion.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Promocion.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Promocion.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Promocion.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Promocion.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Promocion.tabSeleccionado
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

Promocion.load();