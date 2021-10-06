var Adicional = {
    url : 'configuraciones/gestion/auditoria/Adicional/',
    idModal:0,
    dataListaCategoriaNombre:[],
    dataListaProyectoNombre:[],
    handsontable:'',

    secciones: ['Elemento', 'Lista'],
    tabSeleccionado: '',
    grupoCanal:null,
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Adicional.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/auditoria/Adicional/';
          
            $(".card-header > .nav > .nav-item > a[class*='active']").click();
            //seleccionar cuenta
            if($('#cuenta_filtro option').length>=2){
                $("#cuenta_filtro").prop('selectedIndex', 1);
                $("#cuenta_filtro").change();
            }
            $('.btn-Consultar').click();
        });

        $('.card-header > .nav > .nav-item > a').on('shown.bs.tab', function (e) {
            $('.btn-Consultar').click();
        });

        $(".card-header > .nav > .nav-item > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            Adicional.tabSeleccionado = Adicional.secciones[indiceSeccion];

            if(Adicional.secciones[indiceSeccion] == 'Elemento'){
                $('.btn-CargaMasiva-elemento').show();
                $('.btn-CargaMasiva').hide();
            }else if(Adicional.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva-elemento').hide();
                $('.btn-CargaMasiva').show();
                if($('#cuenta option').length>=2){
                    $("#cuenta").prop('selectedIndex', 1);
                    $("#cuenta").change();
                }
            }
            
            Adicional.cambiarSeccionActivo();
            Gestion.idContentActivo = 'content' + Adicional.tabSeleccionado;
            $('.contentGestion').removeClass('d-none');
            $('.contentGestion').hide(500);
            $('.' + Gestion.idContentActivo).show(500);
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

        $(document).on('click','.btn-CargaMasiva-elemento', function(e){
            var data={};
            var jsonString={'data':JSON.stringify(data)};
            var configAjax={'url':Adicional.url+'nuevoElementoMasivo', 'data':jsonString};

            $.when(Fn.ajax(configAjax)).then( function(a){
                ++modalId;
                var fn1='Adicional.confirmarGuardarNuevoElementoMasivo();';
                var fn2='Fn.showModal({ id:'+modalId+',show:false });';
                var btn=new Array();
                    btn[0]={title:'Guardar', fn:fn1};
                    btn[1]={title:'Cerrar', fn:fn2};
                    
                var message = a.data.html;
                Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});
                Adicional.idModal = modalId;

                //Generamos la VENTANA
                Adicional.ventanaCargaMasiva();
            });
        })

        $(document).on("change", ".cuenta_cliente", function (e) {
			var data = {'idCuenta':$(this).val()};

            var jsonString = { 'data': JSON.stringify(data) };
		
            var config = { 'url': Gestion.urlActivo + "getProyectos", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                if (a.result == 1){
					$('.grupoCanal_sl').html('<select id="grupoCanal" name="grupoCanal" class="form-control form-control-sm my_select2 grupoCanal_cliente">'+a.data.html3+'</select>')
                    
                    $('.proyecto_sl').html('<select id="proyecto_cliente" name="proyecto" class="form-control form-control-sm my_select2">'+a.data.html2+'</select>')
                    
                    $('.cliente_sl').html("<select id='cliente' name='cliente' + class='form-control form-control-sm my_select2'>"+a.data.html+"</select>");
                    
                    if(a.data.grupoCanal!=null){
                        Adicional.grupoCanal=a.data.grupoCanal;
                    }
				}
			});
        });
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
            if( Adicional.grupoCanal[idGrupoCanal]!=null){
                for (var [key, value] of Object.entries(Adicional.grupoCanal[idGrupoCanal])) {
                    html+='<option value='+key+'>'+value+'</option>';
                }
            }
            $('.canal_sl').html('<select id="canal" name="canal" class="form-control form-control-sm my_select2 canal_cliente canal_sl">'+html+'</select>')
            
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

    ventanaCargaMasiva: function(){
        var sourceCategorias = Adicional.dataListaCategoriaNombre;
        var sourceProyectos = Adicional.dataListaProyectoNombre;

        var data = [];
        var container = document.getElementById('nuevoElementoMasivo');

        var settings={
            licenseKey: 'non-commercial-and-evaluation',
            data: null,
            dataSchema: {nombre:null, categoria:null, proyecto:null },
            colHeaders: ['NOMBRE ELEMENTO(*)', 'CATEGORÍA', 'PROYECTO'],
            startRows: 10,
            columns:[
                {data: 'nombre'},
                {data: 'categoria'
                    ,type: 'dropdown'
                    , source: sourceCategorias
                },
                {data: 'proyecto'
                    , type:'dropdown'
                    , source: sourceProyectos
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
            manualColumnResize: true,
            afterChange: function(changes, source){
                var celda = this;
                if (changes!=null) {
                    changes.forEach( function(item){
                        if (item[1]=='nombre') {
                            var proyecto = Adicional.handsontable.getDataAtCell(item[0],2);
                            if (proyecto=="" || proyecto==null || proyecto==" ") {
                                Adicional.handsontable.setDataAtCell(item[0],2,'*');
                            }
                        }
                    });
                }
            }
        };

        Adicional.handsontable = new Handsontable(container, settings);

        //Renderizar la ventana
        setTimeout(function(){
            Adicional.handsontable.render(); 
        }, 1000);
    },

    confirmarGuardarNuevoElementoMasivo: function(){
        var contColsInvalid = 0;
            contColsInvalid = $('#nuevoElementoMasivo .htInvalid').length;
        var arrayDataAdicional = [];
        for (var ix = 0; ix < Adicional.handsontable.countRows(); ix++) {
            if (!Adicional.handsontable.isEmptyRow(ix)) {
                arrayDataAdicional.push(Adicional.handsontable.getDataAtRow(ix));
            }
        }

        if ( arrayDataAdicional.length==0) {
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
            var fn1='Adicional.guardarNuevoElementoMasivo();Fn.showModal({ id:'+modalId+',show:false });';
            var fn2='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Continuar',fn:fn1};
                btn[1]={title:'Cerrar',fn:fn2};
            var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la acción?' });
            Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
        }
    },

    guardarNuevoElementoMasivo: function(){
        var arrayDataAdicional = [];
        for (var ix = 0; ix < Adicional.handsontable.countRows(); ix++) {
            if (!Adicional.handsontable.isEmptyRow(ix)) {
                arrayDataAdicional.push(Adicional.handsontable.getDataAtRow(ix));
            }
        }

        var dataArrayCargaMasiva = arrayDataAdicional;
        var data = {'dataArray': dataArrayCargaMasiva};
        var jsonString = {'data': JSON.stringify(data)};
        var configAjax = {'url':Adicional.url+'guardarNuevoElementoMasivo', 'data':jsonString};

        $.when(Fn.ajax(configAjax)).then(function(a){
            ++modalId;
            var fn='Fn.showModal({ id:'+modalId+',show:false });';
            var btn=new Array();
                btn[0]={title:'Cerrar',fn:fn};
            var message = a.msg.content;
            Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true,width:a.data.htmlWidth});

            if (a.result==1) {
                Fn.showModal({ id:Adicional.idModal, show:false});
            }
        });
    },
}

Adicional.load();