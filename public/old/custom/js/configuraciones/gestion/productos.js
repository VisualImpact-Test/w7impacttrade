var Productos = {

    secciones: ['Producto', 'Lista','Precio','ListaPrecio'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Productos.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/Productos/';
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Productos.tabSeleccionado = Productos.secciones[indiceSeccion];
            
            if(Productos.secciones[indiceSeccion] == 'Producto'){
                $('.btn-CargaMasiva').show();
            }else if(Productos.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
            }else if(Productos.secciones[indiceSeccion] == 'Precio'){
                $('.btn-CargaMasiva').show();
            }else if(Productos.secciones[indiceSeccion] == 'ListaPrecio'){
                $('.btn-CargaMasiva').show();
            }
            
            
            Productos.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Productos.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('#' + Gestion.idContentActivo).removeClass('d-none');
            $(".funciones a[class*='btn-seccion-']").addClass('d-none');
            $('.funciones .btn-seccion-' + Productos.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Productos.customDataTable;
            Gestion.seccionActivo = Productos.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Productos.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Productos.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Productos.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Productos.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Productos.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Productos.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Productos.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Productos.tabSeleccionado
        });
    },

    cambiarSeccionActivo: function () {
        switch (Productos.tabSeleccionado) {
            case 'Producto':
                Productos.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                Productos.customDataTable = Gestion.defaultDT;
                break;
            case 'Precio':
                Productos.customDataTable = Gestion.defaultDT;
                break;
            case 'ListaPrecio':
                Productos.customDataTable = Gestion.defaultDT;
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

Productos.load();