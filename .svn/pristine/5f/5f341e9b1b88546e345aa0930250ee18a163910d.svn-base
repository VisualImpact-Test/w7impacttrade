var Obligatoria = {
    url : 'configuraciones/gestion/auditoria/Obligatoria/',
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
            Obligatoria.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/auditoria/Obligatoria/';
            $('#nav-link-0').click();
            $('#tab-content-1-filter').hide();
        });

        // $('.card-header > .nav > .nav-item > a').on('shown.bs.tab', function (e) {
        //     $('.btn-Consultar').click();
        // });

        $(".card-body > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion=$(this).data('value');

            Obligatoria.tabSeleccionado = Obligatoria.secciones[indiceSeccion];

            if(Obligatoria.secciones[indiceSeccion] == 'Elemento'){
                $('.btn-CargaMasiva-elemento').show();
                $('.btn-CargaMasiva').hide();
                $('.btn-CargaMasiva-modulacion').hide();
                $('#tab-content-1-filter').hide();
            }else if(Obligatoria.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva-elemento').hide();
                $('.btn-CargaMasiva').show();
                $('.btn-CargaMasiva-modulacion').hide();
                //seleccionar cuenta
                if($('#cuenta_filtro option').length>=2){
                    $("#cuenta_filtro").prop('selectedIndex', 1);
                    $("#cuenta_filtro").change();
                }
                $('#tab-content-1-filter').show();
            }else if(Obligatoria.secciones[indiceSeccion] == 'ListaModulacion'){
                $('.btn-CargaMasiva-elemento').hide();
                $('.btn-CargaMasiva').hide();                
                $('.btn-CargaMasiva-modulacion').show(); 
                $('#tab-content-1-filter').hide();       
            }

            Obligatoria.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Obligatoria.tabSeleccionado;
            $('.contentGestion').addClass('d-none');
            $('.contentGestion').removeClass('d-none');
            $('.contentGestion').hide(500);
            $('.' + Gestion.idContentActivo).show(500);
            $('.funciones .btn-seccion-' + Obligatoria.tabSeleccionado).removeClass('d-none');
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            //
            Gestion.funcionCustomDT = Obligatoria.customDataTable;
            Gestion.seccionActivo = Obligatoria.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Obligatoria.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Obligatoria.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Obligatoria.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Obligatoria.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Obligatoria.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Obligatoria.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Obligatoria.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Obligatoria.tabSeleccionado
            $('.btn-Consultar').click();
        });

        $(document).on('click','.btn-CargaMasiva-elemento', function(e){
            var data={};
            var jsonString={'data':JSON.stringify(data)};
            var configAjax={'url':Obligatoria.url+'nuevoElementoMasivo', 'data':jsonString};

            $.when(Fn.ajax(configAjax)).then( function(a){
                ++modalId;
                var fn1='Obligatoria.confirmarGuardarNuevoElementoMasivo();';
                var fn2='Fn.showModal({ id:'+modalId+',show:false });';
                var btn=new Array();
                    btn[0]={title:'Guardar', fn:fn1};
                    btn[1]={title:'Cerrar', fn:fn2};
                    
                var message = a.data.html;
                Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});
                Obligatoria.idModal = modalId;

                //Generamos la VENTANA
                Obligatoria.ventanaCargaMasiva();
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
        //                 Obligatoria.grupoCanal=a.data.grupoCanal;
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
            if( Obligatoria.grupoCanal[idGrupoCanal]!=null){
                for (var [key, value] of Object.entries(Obligatoria.grupoCanal[idGrupoCanal])) {
                    html+='<option value='+key+'>'+value+'</option>';
                }
            }
            $('.canal_sl').html('<select id="canal" name="canal" class="form-control form-control-sm my_select2 canal_cliente">'+html+'</select>')
        });

        $(document).on('click','.btn-CargaMasiva-modulacion', function(e){
            var data={};
            var jsonString={'data':JSON.stringify(data)};
            var configAjax={'url':Obligatoria.url+'getFormCargaMasivaListaModulacion','data':jsonString};

            $.when(Fn.ajax(configAjax)).then( function(a){
                ++modalId;
                var fn1='Obligatoria.confirmarGuardarNuevoModulacionMasivo();';
                var fn2='Fn.showModal({ id:'+modalId+', show:false});';
                var btn=new Array();
                    btn[0]={title:'Guardar', fn:fn1};
                    btn[1]={title:'Cerrar', fn:fn2};

                var message=a.data.html;
                Fn.showModal({ id:modalId, show:true, title:a.msg.title, content:message, btn:btn, width:a.data.htmlWidth});
                Obligatoria.idModal=modalId;

                //Generamos la VENTANA
                Obligatoria.llenarHTObjectsFeatures(a.data.ht);
            });
        });

        $(document).on("change", ".tipoElemento", function (e) {
            var idTipoElemento =  $(this).val();
            
            var html="<option >--Seleccionar--</option>";
            if( Obligatoria.elementosVisibilidad[idTipoElemento]!=null){
                for (var [key, value] of Object.entries(Obligatoria.elementosVisibilidad[idTipoElemento])) {
                    html+='<option value='+key+'>'+value+'</option>';
                }
            }
            $(this).parent().parent().find('.elementoVisibilidad').html(html);
        });

        $(document).on('shown.bs.tab','a[data-toggle="tab"][class*="tabCMasiva"]', function(e){
            var target = $(e.target).attr('href');
            var nroHoja = $(e.target).data('nrohoja');
            Obligatoria.handsontableArray[nroHoja].render(); 
        })
    },

    cambiarSeccionActivo: function () {
        switch (Obligatoria.tabSeleccionado) {
            case 'Elemento':
                Obligatoria.customDataTable = Gestion.defaultDT;
                break;
            case 'Lista':
                Obligatoria.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
    },

    ventanaCargaMasiva: function(){
        var sourceCategorias = Obligatoria.dataListaCategoriaNombre;
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

        Obligatoria.handsontable = new Handsontable(container, settings);

        //Renderizar la ventana
        setTimeout(function(){
            Obligatoria.handsontable.render(); 
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

            Obligatoria.handsontableArray[index] = new Handsontable(container, settings);
            setTimeout(function(){
                Obligatoria.handsontableArray[index].render(); 
            }, 1000);
        });       
    },

    confirmarGuardarNuevoElementoMasivo: function(){
        var contColsInvalid = 0;
            contColsInvalid = $('#nuevoElementoMasivo .htInvalid').length;
        var arrayDataObligatoria = [];
        for (var ix = 0; ix < Obligatoria.handsontable.countRows(); ix++) {
            if (!Obligatoria.handsontable.isEmptyRow(ix)) {
                arrayDataObligatoria.push(Obligatoria.handsontable.getDataAtRow(ix));
            }
        }

        if ( arrayDataObligatoria.length==0) {
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
            var fn1='Obligatoria.guardarNuevoElementoMasivo();Fn.showModal({ id:'+modalId+',show:false });';
            var fn2='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Continuar',fn:fn1};
                btn[1]={title:'Cerrar',fn:fn2};
            var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
            Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
        }
    },

    guardarNuevoElementoMasivo: function(){
        var arrayDataObligatoria = [];
        for (var ix = 0; ix < Obligatoria.handsontable.countRows(); ix++) {
            if (!Obligatoria.handsontable.isEmptyRow(ix)) {
                arrayDataObligatoria.push(Obligatoria.handsontable.getDataAtRow(ix));
            }
        }

        var dataArrayCargaMasiva = arrayDataObligatoria;
        var data = {'dataArray': dataArrayCargaMasiva};
        var jsonString = {'data': JSON.stringify(data)};
        var configAjax = {'url':Obligatoria.url+'guardarNuevoElementoMasivo', 'data':jsonString};

        $.when(Fn.ajax(configAjax)).then(function(a){
            ++modalId;
            var fn='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Cerrar',fn:fn};
            var message = a.msg.content;
            Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:a.data.htmlWidth});

            if (a.result==1) {
                Fn.showModal({ id:Obligatoria.idModal, show:false});
                //$('#btn-filtrarObligatoriaVisibilidad').click();
            }
        });
    },

    confirmarGuardarNuevoModulacionMasivo: function(){
        var contColsInvalid=0, contInvalidos=0;
        var contCabecera=0, contDetalle=0;
        var htmlMessage='';
        var contIdLista=0;
        var arrayDataObligatoriaGlobal=[];

        $('.tabCMasiva').each(function(e,val){
            var control= $(val);
            var index = control.data('nrohoja');
            var arrayDataObligatoria=new Array();
            
            contInvalidos = $('#hoja'+index+' .htInvalid').length;
            contColsInvalid = contColsInvalid + contInvalidos;

            for (var ix = 0; ix < Obligatoria.handsontableArray[index].countRows(); ix++) {
                if (!Obligatoria.handsontableArray[index].isEmptyRow(ix)) {
                    if( index==0 ) contCabecera++;
                    if( index>0 ) contDetalle++;

                    if ( Obligatoria.handsontableArray[index].getDataAtRow(ix)[0] == "" ) {
                        contIdLista++;
                    }
                    arrayDataObligatoria.push(Obligatoria.handsontableArray[index].getDataAtRow(ix));
                }
            }
            arrayDataObligatoriaGlobal.push(arrayDataObligatoria);
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
            var fn1='Obligatoria.guardarNuevoModulacionMasivo();Fn.showModal({ id:'+modalId+',show:false });';
            var fn2='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Continuar',fn:fn1};
                btn[1]={title:'Cerrar',fn:fn2};
            var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
            Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
        }
    },

    guardarNuevoModulacionMasivo: function(){
        var arrayDataObligatoriaGlobal=[];

        $('.tabCMasiva').each(function(e,val){
            var control= $(val);
            var index = control.data('nrohoja');
            var arrayDataObligatoria=new Array();
            
            for (var ix = 0; ix < Obligatoria.handsontableArray[index].countRows(); ix++) {
                if (!Obligatoria.handsontableArray[index].isEmptyRow(ix)) {
                    arrayDataObligatoria.push(Obligatoria.handsontableArray[index].getDataAtRow(ix));
                }
            }
            arrayDataObligatoriaGlobal.push(arrayDataObligatoria);
        });

        var dataArrayCargaMasiva=arrayDataObligatoriaGlobal;
        var data={'dataArray': dataArrayCargaMasiva};
        var jsonString={'data': JSON.stringify(data)};
        var configAjax={'url':Obligatoria.url+'guardarCargaMasivaListaModulacion', 'data':jsonString};

        $.when(Fn.ajax(configAjax)).then(function(a){
            ++modalId;
            var fn='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Cerrar', fn:fn};
            var message = a.msg.message;
            Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:a.data.htmlWidth});

            if (a.result==1) {
                Fn.showModal({ id:Obligatoria.idModal, show:false});
                $('.btn-Consultar').click();
            }
        });
    }
}

Obligatoria.load();