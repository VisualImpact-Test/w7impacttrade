var Inventario = {

    secciones: ['Promocion', 'Lista'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Inventario.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/inventario/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Inventario.tabSeleccionado = Inventario.secciones[indiceSeccion];

            if(Inventario.secciones[indiceSeccion] == 'Promocion'){
                $('.btn-CargaMasiva').show();
            }else if(Inventario.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }

            Inventario.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Inventario.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
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
    },

    cambiarSeccionActivo: function () {
        switch (Inventario.tabSeleccionado) {
            case 'Promocion':
                Inventario.customDataTable = Gestion.defaultDT;
                break;
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