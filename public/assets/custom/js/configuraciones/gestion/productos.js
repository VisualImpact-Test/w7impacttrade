var Productos = {

    secciones: ['Producto', 'Lista','Precio','ListaPrecio','Marca','UnidadMedidaProducto','Surtido','Categoria','Motivo'],
    tabSeleccionado: '',
    grupoCanal:null,
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Productos.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/Productos/';
            $(".card-body > ul > li > a[class*='active']").click();


            //seleccionar cuenta
            // if($('#cuenta_producto option').length>=2){
            //     $("#cuenta_producto").prop('selectedIndex', 1);
            //     $("#cuenta_producto").change();
            // }
        });

        $('.btnReporte').on('click', function(e){
			e.preventDefault();
			var opcion = $(this).attr("data-value");

			if ( opcion==1 ) {
				$('.tipoGrafica').hide(500);
				$('.tipoDetallado').show(500);
				$('#idTipoFormato').val(1);
			} else if ( opcion==2 ) {
				$('.tipoGrafica').show(500);
				$('.tipoDetallado').hide(500);
				$('#idTipoFormato').val(2);
			}
        });
        

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Productos.tabSeleccionado = Productos.secciones[indiceSeccion];

            $(".dv_cadena").hide();
            $(".dv_canal").hide();
            $(".dv_grupoCanal").hide();
            $(".dv_banner").hide();

            if(Productos.secciones[indiceSeccion] == 'Producto'){
                $('.btn-CargaMasiva').show();
            }else if(Productos.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
                //seleccionar cuenta
                if($('#cuenta_filtro option').length>=2){
                    $("#cuenta_filtro").prop('selectedIndex', 1);
                    $("#cuenta_filtro").change();
                }
                $(".dv_cadena").show();
                $(".dv_canal").show();
                $(".dv_grupoCanal").show();
                $(".dv_banner").show();

            }else if(Productos.secciones[indiceSeccion] == 'Precio'){
                if($('#cuenta_producto_precio option').length>=2){
                    $("#cuenta_producto_precio").prop('selectedIndex', 1);
                    $("#cuenta_producto_precio").change();
                }

                $('.btn-CargaMasiva').hide();
            }else if(Productos.secciones[indiceSeccion] == 'ListaPrecio'){
                $('.btn-CargaMasiva').hide();

                if($('#cuenta_precio option').length>=2){
                    $("#cuenta_precio").prop('selectedIndex', 1);
                    $("#cuenta_precio").change();
                }
                $(".dv_canal").show();
                $(".dv_grupoCanal").show();


            }else if(Productos.secciones[indiceSeccion] == 'Marca'){
                $('.btn-CargaMasiva').show();
                //seleccionar cuenta
                if($('#cuenta_marca option').length>=2){
                    $("#cuenta_marca").prop('selectedIndex', 1);
                    $("#cuenta_marca").change();
                }
            }else if(Productos.secciones[indiceSeccion] == 'UnidadMedidaProducto'){
                $('.btn-CargaMasiva').show();
                //seleccionar cuenta
                if($('#cuenta_unidad_medida_producto option').length>=2){
                    $("#cuenta_unidad_medida_producto").prop('selectedIndex', 1);
                    $("#cuenta_unidad_medida_producto").change();
                }
            }else if(Productos.secciones[indiceSeccion] == 'Motivo'){
                $('.btn-CargaMasiva').hide();
            }
            
            
            Productos.cambiarSeccionActivo();
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Productos.customDataTable;
            Gestion.seccionActivo = Productos.tabSeleccionado
            // Gestion.idFormSeccionActivo = 'seccion' + Productos.tabSeleccionado
            Gestion.idFormSeccionActivo = 'formFiltroProductos';
            Gestion.getTablaActivo = 'getTabla' + Productos.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Productos.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Productos.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Productos.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Productos.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Productos.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Productos.tabSeleccionado

            if($("#"+Gestion.idContentActivo).find('.noResultado').length > 0){
                $('.btn-Consultar').click()
            }
            setTimeout(function(){
                if(Gestion.$dataTable[Gestion.idContentActivo]){
                    Gestion.$dataTable[Gestion.idContentActivo].columns.adjust();
                }
            }, 500);
        });

        $(document).on("change", ".grupoCanal_sl", function (e) {
            var idGrupoCanal =  $(this).val();
            
            var html="<option value='' >--Seleccionar--</option>";
            if( Productos.grupoCanal[idGrupoCanal]!=null){
                for (var [key, value] of Object.entries(Productos.grupoCanal[idGrupoCanal])) {
                    html+='<option value='+key+'>'+value+'</option>';
                }
            }
            $('.canal_sl').html('<select id="canal" name="canal" class="form-control form-control-sm my_select2 canal_cliente">'+html+'</select>')
        });
    },

    cambiarSeccionActivo: function () {
        switch (Productos.tabSeleccionado) {
            case 'Producto':
                Productos.customDataTable = function(){
                    Gestion.$dataTable[Gestion.idContentActivo] = $('#' + Gestion.idContentActivo + ' table').DataTable({
                        columnDefs: [
                            { targets: 0, orderable: false, className: 'select-checkbox tex-center' },
                            { targets: [1, 2], searchable: false, orderable: false, className: 'text-center' },
                            { targets: [-1, -2, -3], className: 'text-center' },
                            { targets: 'colNumerica', className: 'text-center' },
                        ],
                        select: { style: 'multi', selector: 'td:first-child' },
                    });
                    Gestion.columnaOrdenDT = 1;
                }
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
            case 'Marca':
                Productos.customDataTable = Gestion.defaultDT;
                break;
            case 'UnidadMedidaProducto':
                Productos.customDataTable = Gestion.defaultDT;
                break;
            case 'Surtido':
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
        
		$(document).on("change", ".grupoCanal_cliente", function (e) {
            var idGrupoCanal =  $(this).val();
            var html="<option >--Seleccionar--</option>";
            if( Productos.grupoCanal[idGrupoCanal]!=null){
                for (var [key, value] of Object.entries(Productos.grupoCanal[idGrupoCanal])) {
                    html+='<option value='+key+'>'+value+'</option>';
                }
            }
            $('.canal_sl').html('<select id="canal" name="canal" class="form-control form-control-sm my_select2 canal_cliente">'+html+'</select>')

        });
		
        $(document).on("change", ".cuenta_precio", function (e) {
			var data = {'cuenta':$(this).val()};

            var jsonString = { 'data': JSON.stringify(data) };
		
            var config = { 'url': Gestion.urlActivo + "getProductos", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                if (a.result == 1){
                    if(a.data.productos!=null){
                            $('.producto_sl').html('<select id="producto" name="producto" class="form-control form-control-sm my_select2 ">'+a.data.productos+'</select>')
                    }
					
                }
			});
		});
        
		$(document).on("change", ".canal_cliente", function (e) {
			var data = {'idCanal': $(this).val(),'idCuenta':$('#cuenta').val(),'idProyecto':$('#proyecto').val()};

            var jsonString = { 'data': JSON.stringify(data) };
		
            var config = { 'url': Gestion.urlActivo + "getSegCliente", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                
                if (a.result == 1) $('.cliente_sl').html("<select id='cliente' name='cliente' + class='form-control form-control-sm my_select2'>"+a.data.html+"</select>");
            });

        });
        

        $(document).on("change", "#proyecto_lista_producto", function (e) {
			var data = {'idProyecto': $(this).val(), 'idCuenta': $('#cuenta_cliente').val()};
            var jsonString = { 'data': JSON.stringify(data) };
            var config = { 'url': Gestion.urlActivo + "getElementos", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                
                if (a.result == 1){
                    var html="";
                    html+='<td></td>';
                    html+='<td class="text-center" data-name=elemento_lista>';
                    html+="    <select class='form-control form-control-sm'>";
                    html+="        <option value=''>-- Seleccionar --</option>";
                    if(a.data.elementos!=null){
                        a.data.elementos.forEach(function(i,v){
                            html+="<option value="+i.idProducto+">"+i.nombre+"</option>";
                        });
                    }
                    
                    html+="</select></td>";
                    html+='<td class="text-left">';
                    html+='<button style="left: 45%;" class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>';
                    html+='</td>';
                    $('.trPadre').html(html);
                    
                }  
            });

		});
    },
}

Productos.load();