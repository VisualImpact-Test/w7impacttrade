var TradeVisibilidad = {
    url : 'configuraciones/gestion/trade/visibilidad/',
    idModal:0,
    dataListaCategoriaNombre:[],
    dataListaProyectoNombre:[],
    handsontable:'',
    handsontableArray:[],

    secciones: ['Elemento', 'Lista','ListaModulacion'],
    tabSeleccionado: '',
    grupoCanal:null,
    elementosVisibilidad:null,
    customDataTable: function () { },
 
    load: function () {

        $(document).ready(function (e) {
            TradeVisibilidad.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/trade/visibilidad/';
            Gestion.idFormSeccionActivo = 'frm-trade-visibilidad';
            $('#nav-link-0').click();
            $('#tab-content-1-filter').hide();
        });

        // $('.card-header > .nav > .nav-item > a').on('shown.bs.tab', function (e) {
        //     $('.btn-Consultar').click();
        // });

        $(".card-body > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion=$(this).data('value');

            TradeVisibilidad.tabSeleccionado = TradeVisibilidad.secciones[indiceSeccion];

            if(TradeVisibilidad.secciones[indiceSeccion] == 'Elemento'){
                $('.btn-CargaMasiva-elemento').show();
                $('.btn-CargaMasiva').hide();
                $('.btn-CargaMasiva-modulacion').hide();
                $('#tab-content-1-filter').hide();
            }else if(TradeVisibilidad.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva-elemento').hide();
                $('.btn-CargaMasiva').show();
                $('.btn-CargaMasiva-modulacion').hide();
                //seleccionar cuenta
                if($('#cuenta_filtro option').length>=2){
                    $("#cuenta_filtro").prop('selectedIndex', 1);
                    $("#cuenta_filtro").change();
                }
                $('#tab-content-1-filter').show();
            }else if(TradeVisibilidad.secciones[indiceSeccion] == 'ListaModulacion'){
                $('.btn-CargaMasiva-elemento').hide();
                $('.btn-CargaMasiva').hide();                
                $('.btn-CargaMasiva-modulacion').show(); 
                $('#tab-content-1-filter').show();       
            }

            TradeVisibilidad.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + TradeVisibilidad.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('.contentGestion').removeClass('d-none');
            $('.contentGestion').hide(500);
            $('.' + Gestion.idContentActivo).show(500);
            $('.funciones .btn-seccion-' + TradeVisibilidad.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            //
            Gestion.funcionCustomDT = TradeVisibilidad.customDataTable;
            Gestion.seccionActivo = TradeVisibilidad.tabSeleccionado
            //Gestion.idFormSeccionActivo = 'seccion' + TradeVisibilidad.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + TradeVisibilidad.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + TradeVisibilidad.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + TradeVisibilidad.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + TradeVisibilidad.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + TradeVisibilidad.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + TradeVisibilidad.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + TradeVisibilidad.tabSeleccionado
            $('.btn-Consultar').click();
        });

        $(document).on('click','.btn-CargaMasiva-elemento', function(e){
            var data={};
            var jsonString={'data':JSON.stringify(data)};
            var configAjax={'url':TradeVisibilidad.url+'nuevoElementoMasivo', 'data':jsonString};

            $.when(Fn.ajax(configAjax)).then( function(a){
                ++modalId;
                var fn1='TradeVisibilidad.confirmarGuardarNuevoElementoMasivo();';
                var fn2='Fn.showModal({ id:'+modalId+',show:false });';
                var btn=new Array();
                    btn[0]={title:'Guardar', fn:fn1};
                    btn[1]={title:'Cerrar', fn:fn2};
                    
                var message = a.data.html;
                Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});
                TradeVisibilidad.idModal = modalId;

                //Generamos la VENTANA
                TradeVisibilidad.ventanaCargaMasiva();
            });
        });

        // $(document).on("change", ".cuenta_cliente", function (e) {
		// 	var data = {'idCuenta':$(this).val()};

        //     var jsonString = { 'data': JSON.stringify(data) };
		
        //     var config = { 'url': Gestion.urlActivo + "getProyectos", 'data': jsonString };
        //     $.when(Fn.ajax(config)).then(function (a) {

        //         if (a.result === 2) return false;
        //         if (a.result == 1){
		// 			$('.grupoCanal_sl').html('<select id="grupoCanal" name="grupoCanal" class="form-control form-control-sm my_select2 grupoCanal_cliente">'+a.data.html3+'</select>')
                    
        //             $('.proyecto_sl').html('<select id="proyecto_cliente" name="proyecto" class="form-control form-control-sm my_select2">'+a.data.html2+'</select>')
                    
        //             $('.cliente_sl').html("<select id='cliente' name='cliente' + class='form-control form-control-sm my_select2'>"+a.data.html+"</select>");
                    
        //             if(a.data.grupoCanal!=null){
        //                 TradeVisibilidad.grupoCanal=a.data.grupoCanal;
        //             }
		// 		}
		// 	});
        // });
        $(document).on("change", ".canal_cliente", function (e) {
			var data = {'idCanal': $(this).val(),'idCuenta':$('#cuenta_cliente').val(),'idProyecto':$('#proyecto_cliente').val()};

            var jsonString = { 'data': JSON.stringify(data) };
		
            var config = { 'url': Gestion.urlActivo + "getSegCliente", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                
                if (a.result == 1) $('.cliente_sl').html("<select id='cliente' name='cliente' + class='form-control form-control-sm my_select2'>"+a.data.html+"</select>");
            });

        });

        $(document).on("change", ".grupoCanal_sl", function (e) {
            var idGrupoCanal =  $(this).val();
            
            var html="<option >--Seleccionar--</option>";
            if( TradeVisibilidad.grupoCanal[idGrupoCanal]!=null){
                for (var [key, value] of Object.entries(TradeVisibilidad.grupoCanal[idGrupoCanal])) {
                    html+='<option value='+key+'>'+value+'</option>';
                }
            }
            $('.canal_sl').html('<select id="canal" name="canal" class="form-control form-control-sm my_select2 canal_cliente">'+html+'</select>')
        });

        $(document).on('click','.btn-CargaMasiva-modulacion', function(e){
            var data={};
            var jsonString={'data':JSON.stringify(data)};
            var configAjax={'url':TradeVisibilidad.url+'getFormCargaMasivaListaModulacion','data':jsonString};

            $.when(Fn.ajax(configAjax)).then( function(a){
                ++modalId;
                var fn1='TradeVisibilidad.confirmarGuardarNuevoModulacionMasivo();';
                var fn2='Fn.showModal({ id:'+modalId+', show:false});';
                var btn=new Array();
                    btn[0]={title:'Guardar', fn:fn1};
                    btn[1]={title:'Cerrar', fn:fn2};

                var message=a.data.html;
                Fn.showModal({ id:modalId, show:true, title:a.msg.title, content:message, btn:btn, width:a.data.htmlWidth});
                TradeVisibilidad.idModal=modalId;

                //Generamos la VENTANA
                TradeVisibilidad.llenarHTObjectsFeatures(a.data.ht);
            });
        });

        $(document).on("change", ".tipoElemento", function (e) {
            var idTipoElemento =  $(this).val();
            
            var html="<option >--Seleccionar--</option>";
            if( TradeVisibilidad.elementosVisibilidad[idTipoElemento]!=null){
                for (var [key, value] of Object.entries(TradeVisibilidad.elementosVisibilidad[idTipoElemento])) {
                    html+='<option value='+key+'>'+value+'</option>';
                }
            }
            $(this).parent().parent().find('.elementoVisibilidad').html(html);
        });

        $(document).on('shown.bs.tab','a[data-toggle="tab"][class*="tabCMasiva"]', function(e){
            var target = $(e.target).attr('href');
            var nroHoja = $(e.target).data('nrohoja');
            TradeVisibilidad.handsontableArray[nroHoja].render(); 
        })
    },

    /*cambiarSeccionActivo: function () {
        switch (TradeVisibilidad.tabSeleccionado) {
            case 'Elemento':
                TradeVisibilidad.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                TradeVisibilidad.customDataTable = Gestion.defaultDT;
                break;
        }
    },*/

    cambiarSeccionActivo: function () {
        switch (TradeVisibilidad.tabSeleccionado) {
            case 'Elemento':
                TradeVisibilidad.customDataTable = function(){
                    Gestion.$dataTable[Gestion.idContentActivo] = $('#' + Gestion.idContentActivo + ' table').DataTable({
                        columnDefs: [
                            { targets: 0, orderable: false, className: 'select-checkbox tex-center' },
                            { targets: [1, 2], searchable: false, orderable: false, className: 'text-center' },
                            { targets: [-1, -2, -3], className: 'text-center' },
                            { targets: 'colNumerica', className: 'text-center' },
                        ],
                        select: { style: 'multi', selector: 'td:first-child' },
                        buttons: ['excel','pageLength', 'selectAll',
                            'selectNone'],
                    });
                    Gestion.columnaOrdenDT = 1;
                }
                break;
            case 'Lista':
                TradeVisibilidad.customDataTable = function(){
                    Gestion.$dataTable[Gestion.idContentActivo] = $('#' + Gestion.idContentActivo + ' table').DataTable({
                        columnDefs: [
                            { targets: 0, orderable: false, className: 'select-checkbox tex-center' },
                            { targets: [1, 2], searchable: false, orderable: false, className: 'text-center' },
                            { targets: [-1, -2, -3], className: 'text-center' },
                            { targets: 'colNumerica', className: 'text-center' },
                        ],
                        select: { style: 'multi', selector: 'td:first-child' },
                        buttons: ['excel','pageLength', 'selectAll',
                            'selectNone'],
                    });
                    Gestion.columnaOrdenDT = 1;
                }
                break;
        }
    },



    eventos: function () {
    },

    ventanaCargaMasiva: function(){
        var sourceCategorias = TradeVisibilidad.dataListaCategoriaNombre;
        var data = [];
        var container = document.getElementById('nuevoElementoMasivo');

        var settings={
            licenseKey: 'non-commercial-and-evaluation',
            data: null,
            dataSchema: {nombre:null, categoria:null, proyecto:null },
            colHeaders: ['NOMBRE ELEMENTO(*)', 'CATEGORÍA'],
            startRows: 10,
            //startCols: 4,
            columns:[
                {data: 'nombre'},
                {data: 'categoria'
                    ,type: 'dropdown'
                    , source: sourceCategorias
                }
            ],
            minSpareCols: 1, //always keep at least 1 spare row at the right
            minSpareRows: 1,  //always keep at least 1 spare row at the bottom,
            rowHeaders: true, //n° contador de las filas
            //filters: true, // permite filtrar en la columna, pero elimina la opción STARTROWS
            contextMenu: true,
            dropdownMenu: true, //desplegable en la columna, ofrece oopciones
            height: 300,
            //width: '100%',
            stretchH: 'all', //Expande todas las columnas al 100%
            maxRows: 250, //cantidad máxima de filas
            manualColumnResize: true
           
        };

        TradeVisibilidad.handsontable = new Handsontable(container, settings);

        //Renderizar la ventana
        setTimeout(function(){
            TradeVisibilidad.handsontable.render(); 
        }, 1000);
    },

    llenarHTObjectsFeatures: function(ht){
        ht.forEach( function(value, index){
            var container = document.getElementById('divHT'+index);

            var settings={
                licenseKey: 'non-commercial-and-evaluation',
                data: value.data,
                colHeaders: value.headers,
                columns:value.columns,
                startRows: 10,
                minSpareRows:1,
                minSpareCols:1,
                rowHeaders:true,
                contextMenu: true,
                dropdownMenu:true,
                height:320,
                stretchH: 'all',
                maxRows: 200,
                manualColumnResize:true
            };

            TradeVisibilidad.handsontableArray[index] = new Handsontable(container, settings);
            setTimeout(function(){
                TradeVisibilidad.handsontableArray[index].render(); 
            }, 1000);
        });       
    },

    confirmarGuardarNuevoElementoMasivo: function(){
        var contColsInvalid = 0;
            contColsInvalid = $('#nuevoElementoMasivo .htInvalid').length;
        var arrayDataTradeVisibilidad = [];
        for (var ix = 0; ix < TradeVisibilidad.handsontable.countRows(); ix++) {
            if (!TradeVisibilidad.handsontable.isEmptyRow(ix)) {
                arrayDataTradeVisibilidad.push(TradeVisibilidad.handsontable.getDataAtRow(ix));
            }
        }

        if ( arrayDataTradeVisibilidad.length==0) {
            ++modalId;
            var fn='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Cerrar',fn:fn};
            var message = Fn.message({ 'type': 2, 'message': 'No se ha detectado el llenado de la data, por favor ingrese la información solicitada' });
            Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
            return false;
        } else if ( contColsInvalid>0) {
            ++modalId;
            var fn='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Cerrar',fn:fn};
            var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresadoso o datos erróneos, verificar los datos remarcados en rojo' });
            Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
            return false;
        } else {
            ++modalId;
            var fn1='TradeVisibilidad.guardarNuevoElementoMasivo();Fn.showModal({ id:'+modalId+',show:false });';
            var fn2='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Continuar',fn:fn1};
                btn[1]={title:'Cerrar',fn:fn2};
            var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
            Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
        }
    },

    guardarNuevoElementoMasivo: function(){
        var arrayDataTradeVisibilidad = [];
        for (var ix = 0; ix < TradeVisibilidad.handsontable.countRows(); ix++) {
            if (!TradeVisibilidad.handsontable.isEmptyRow(ix)) {
                arrayDataTradeVisibilidad.push(TradeVisibilidad.handsontable.getDataAtRow(ix));
            }
        }

        var dataArrayCargaMasiva = arrayDataTradeVisibilidad;
        var data = {'dataArray': dataArrayCargaMasiva};
        var jsonString = {'data': JSON.stringify(data)};
        var configAjax = {'url':TradeVisibilidad.url+'guardarNuevoElementoMasivo', 'data':jsonString};

        $.when(Fn.ajax(configAjax)).then(function(a){
            ++modalId;
            var fn='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Cerrar',fn:fn};
            var message = a.msg.content;
            Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:a.data.htmlWidth});

            if (a.result==1) {
                Fn.showModal({ id:TradeVisibilidad.idModal, show:false});
                //$('#btn-filtrarObligatoriaVisibilidad').click();
            }
        });
    },

    confirmarGuardarNuevoModulacionMasivo: function(){
        var contColsInvalid=0, contInvalidos=0;
        var contCabecera=0, contDetalle=0;
        var htmlMessage='';
        var contIdLista=0;
        var arrayDataTradeVisibilidadGlobal=[];

        $('.tabCMasiva').each(function(e,val){
            var control= $(val);
            var index = control.data('nrohoja');
            var arrayDataTradeVisibilidad=new Array();
            
            contInvalidos = $('#hoja'+index+' .htInvalid').length;
            contColsInvalid = contColsInvalid + contInvalidos;

            for (var ix = 0; ix < TradeVisibilidad.handsontableArray[index].countRows(); ix++) {
                if (!TradeVisibilidad.handsontableArray[index].isEmptyRow(ix)) {
                    if( index==0 ) contCabecera++;
                    if( index>0 ) contDetalle++;

                    if ( TradeVisibilidad.handsontableArray[index].getDataAtRow(ix)[0] == "" ) {
                        contIdLista++;
                    }
                    arrayDataTradeVisibilidad.push(TradeVisibilidad.handsontableArray[index].getDataAtRow(ix));
                }
            }
            arrayDataTradeVisibilidadGlobal.push(arrayDataTradeVisibilidad);
        });

        if (contCabecera==0) {
            ++modalId;
            var fn='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Cerrar',fn:fn};
            var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados en el <strong>área de la lista</strong>' });
            Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
            return false;
        } else if(contDetalle==0){
            ++modalId;
            var fn='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Cerrar',fn:fn};
            var message = Fn.message({ 'type': 2, 'message': 'Se encontró <strong>datos obligatorios</strong> que no fueron ingresados en el área de los <strong>detalles de elementos</strong>' });
            Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
            return false;
        } else if (contColsInvalid>0) {
            ++modalId;
            var fn='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Cerrar',fn:fn};
            var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresado o datos erróneos, verificar los datos remarcados en rojo' });
            Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
            return false;
        } else if( contIdLista>0 ){
            ++modalId;
            var fn='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Cerrar',fn:fn};
            var message = Fn.message({ 'type': 2, 'message': 'Se encontró que el valor de <strong>ID LISTA</strong> no fue ingresado en algunas filas' });
            Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
            return false;
        } else {
            ++modalId;
            var fn1='TradeVisibilidad.guardarNuevoModulacionMasivo();Fn.showModal({ id:'+modalId+',show:false });';
            var fn2='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Continuar',fn:fn1};
                btn[1]={title:'Cerrar',fn:fn2};
            var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
            Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
        }
    },

    guardarNuevoModulacionMasivo: function(){
        var arrayDataTradeVisibilidadGlobal=[];

        $('.tabCMasiva').each(function(e,val){
            var control= $(val);
            var index = control.data('nrohoja');
            var arrayDataTradeVisibilidad=new Array();
            
            for (var ix = 0; ix < TradeVisibilidad.handsontableArray[index].countRows(); ix++) {
                if (!TradeVisibilidad.handsontableArray[index].isEmptyRow(ix)) {
                    arrayDataTradeVisibilidad.push(TradeVisibilidad.handsontableArray[index].getDataAtRow(ix));
                }
            }
            arrayDataTradeVisibilidadGlobal.push(arrayDataTradeVisibilidad);
        });

        var dataArrayCargaMasiva=arrayDataTradeVisibilidadGlobal;
        var data={'dataArray': dataArrayCargaMasiva};
        var jsonString={'data': JSON.stringify(data)};
        var configAjax={'url':TradeVisibilidad.url+'guardarCargaMasivaListaModulacion', 'data':jsonString};

        $.when(Fn.ajax(configAjax)).then(function(a){
            ++modalId;
            var fn='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Cerrar', fn:fn};
            var message = a.msg.message;
            Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:a.data.htmlWidth});

            if (a.result==1) {
                Fn.showModal({ id:TradeVisibilidad.idModal, show:false});
                $('.btn-Consultar').click();
            }
        });
    }
}

TradeVisibilidad.load();