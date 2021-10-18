var IniciativaTrad = {

    secciones: ['Motivo','Iniciativa','Elemento', 'Lista'],
    tabSeleccionado: "Motivo",
    elementos: null,
    grupoCanal:null,
    idModal:null,
    idModalMotivos:null,
    index:null,
    
    customDataTable: function () {
        
    },

    load: function () {

        $(document).ready(function (e) {
            IniciativaTrad.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/IniciativaTrad/';
            $(".card-body > ul > li > a[class*='active']").dblclick();
        });

        $(".card-body > ul > li > a").dblclick(function (e) {
            e.preventDefault();

            var indiceSeccion=$(this).data('value');
            console.log(indiceSeccion);
            IniciativaTrad.tabSeleccionado = IniciativaTrad.secciones[indiceSeccion];

            if(IniciativaTrad.secciones[indiceSeccion] == 'Motivo'){
                $('.btn-CargaMasiva').hide();
                $('#contentLista-filter').hide();
                $('#btn-cargaMasivaAlternativa').hide();
            }else if(IniciativaTrad.secciones[indiceSeccion] == 'Elemento'){
                $('.btn-CargaMasiva').show();
                $('#contentLista-filter').hide();
                $('#btn-cargaMasivaAlternativa').hide();
            }else if(IniciativaTrad.secciones[indiceSeccion] == 'Iniciativa'){
                $('.btn-CargaMasiva').show();
                $('#contentLista-filter').hide();
                $('#btn-cargaMasivaAlternativa').hide();
            }else if(IniciativaTrad.secciones[indiceSeccion] == 'Lista'){
                $('.btn-CargaMasiva').show();
                $('#contentLista-filter').show();
                $('#btn-cargaMasivaAlternativa').show();
            }
            Gestion.idContentActivo = 'content' + IniciativaTrad.tabSeleccionado;

            IniciativaTrad.cambiarSeccionActivo();
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

            $('.btn-Consultar').click();
        });

        $(document).on("change", ".grupoCanal_sl", function (e) {
            var idGrupoCanal =  $(this).val();
            
            var html="<option  value='' >--Seleccionar--</option>";
            if( IniciativaTrad.grupoCanal[idGrupoCanal]!=null){
                for (var [key, value] of Object.entries(IniciativaTrad.grupoCanal[idGrupoCanal])) {
                    html+='<option value='+key+'>'+value+'</option>';
                }
            }
            $('.canal_sl').html('<select id="canal" name="canal" class="form-control form-control-sm my_select2 canal_cliente canal_sl">'+html+'</select>')
        });


        $(document).on("click", ".btn-seleccionarMotivos", function (e) {
            e.preventDefault();
            var iniciativa=$('#idx').val();
            
            if(iniciativa!=null){
                var motivo =  ($(this).parent().parent().find(".motivos")[0].id);
                var ind=motivo.split('-')[1];
                var idElemento=$('#iniciativa_elemento-'+ind).val();
    
                IniciativaTrad.index = ind;
                var data={};
              
                data['idIniciativa']=iniciativa;
                data['idElementoVis']=idElemento;

                if(idElemento=="" || idElemento==null){
                    ++modalId;
                    var fn='Fn.showModal({ id:'+modalId+',show:false });';
                    var btn=new Array();
                        btn[0]={title:'Cerrar',fn:fn};
                    var message = Fn.message({ 'type': 2, 'message': 'Se requiere la seleccion del elemento.' });
                    Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
                }else{
                    var jsonString={'data':JSON.stringify(data)};
                    var configAjax={'url':Gestion.urlActivo +'getFormUpdateIniciativaMotivo', 'data':jsonString};
        
                    $.when(Fn.ajax(configAjax)).then( function(a){
                        ++modalId;
                        var fn1='IniciativaTrad.guardarIniciativaElementoMotivo();';
                        var fn2='Fn.showModal({ id:'+modalId+',show:false });';
                        var btn=new Array();
                            btn[0]={title:'Cerrar', fn:fn2};
                            btn[1]={title:'Guardar', fn:fn1};
                            
                        var message = a.data.html;
                        Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});
                        IniciativaTrad.idModalMotivos = modalId;
                    });
                }

            }else{
                var motivo =  ($(this).parent().parent().find(".motivos")[0].id);
                var ind=motivo.split('-')[1];
                var idElemento=$('#iniciativa_elemento-'+ind).val();
    
                IniciativaTrad.index = ind;
                var data={};

                var iniciativa_nombre=$('#nombre').val();
                var elemento= $('#iniciativa_elemento-'+ind).text();

                if(idElemento=="" || idElemento==null){
                    ++modalId;
                    var fn='Fn.showModal({ id:'+modalId+',show:false });';
                    var btn=new Array();
                        btn[0]={title:'Cerrar',fn:fn};
                    var message = Fn.message({ 'type': 2, 'message': 'Se requiere la seleccion del elemento.' });
                    Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
                }else{
                    var jsonString={'data':JSON.stringify(data)};
                    var configAjax={'url':Gestion.urlActivo +'getFormNewIniciativaMotivo', 'data':jsonString};
        
                    $.when(Fn.ajax(configAjax)).then( function(a){
                        ++modalId;
                        var fn1='IniciativaTrad.guardarIniciativaElementoMotivo();';
                        var fn2='Fn.showModal({ id:'+modalId+',show:false });';
                        var btn=new Array();
                            btn[0]={title:'Cerrar', fn:fn2};
                            btn[1]={title:'Guardar', fn:fn1};
                            
                        var message = a.data.html;
                        Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});
                        IniciativaTrad.idModalMotivos = modalId;

                        $('#lblIniciativaActual').htm(iniciativa_nombre);
                        $('#lblElementoActual').val(elemento);
                    });
                }
            }           
        });

        $(document).on("click", ".btn-seleccionarMotivosExistente", function (e) {
            e.preventDefault();
            var ind =  $(this).data('id');

            var iniciativa=$('#idx').val();
            var idElemento=ind;

            var data={};
            data['idIniciativa']=iniciativa;
            data['idElementoVis']=idElemento;

            if(idElemento=="" || idElemento==null){
                ++modalId;
                var fn='Fn.showModal({ id:'+modalId+',show:false });';
                var btn=new Array();
                    btn[0]={title:'Cerrar',fn:fn};
                var message = Fn.message({ 'type': 2, 'message': 'Se requiere la seleccion del elemento.' });
                Fn.showModal({ id:modalId,title:'Alerta',content:message,btn:btn,show:true});
            }else{
                var jsonString={'data':JSON.stringify(data)};
                var configAjax={'url':Gestion.urlActivo +'getFormUpdateIniciativaMotivo', 'data':jsonString};
    
                $.when(Fn.ajax(configAjax)).then( function(a){
                    ++modalId;
                    var fn1='IniciativaTrad.guardarIniciativaElementoMotivoExistente();';
                    var fn2='Fn.showModal({ id:'+modalId+',show:false });';
                    var btn=new Array();
                        btn[0]={title:'Cerrar', fn:fn2};
                        btn[1]={title:'Guardar', fn:fn1};
                        
                    var message = a.data.html;
                    Fn.showModal({ id:modalId,show:true,title:a.msg.title,content:message,btn:btn, width:a.data.htmlWidth});
                    IniciativaTrad.idModalMotivos = modalId;
                });
            }
        });

        $(document).on('click','#btn-cargaMasivaAlternativa', function(e){
			e.preventDefault();

			var control= $(this);
			var data={};
			var jsonString = {data: JSON.stringify(data)};
			var configAjax = {url: Gestion.urlActivo + 'iniciativaCargaMasivaAlternativa', data:jsonString };

			$.when(Fn.ajax(configAjax)).then( function(a){
				++modalId;
				var fn1='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn1};
				var message = a.data.html;
				Fn.showModal({ id:modalId,title:a.msg.title,content:message,btn:btn,show:true, width:a.data.htmlWidth});
			});
		});

        $(document).on('click','#btn-finListasVigentes', function(e){
			e.preventDefault();

			++modalId;
            let fn = [];
            let btn = [];
            let msgConfirm = "¿Está seguro(a) de actualizar las listas vigentes? Esto actualizará todos las listas que se encuentren vigentes en el rango de fecha seleccionado."
            let titleConfirm = "Alerta!";

            fn[0] = 'Fn.showModal({ id:'+modalId+',show:false });';
            fn[1] = 'Fn.showModal({ id:'+modalId+',show:false });';
            btn[0] = {title:'Cerrar', fn:fn[0],};
            btn[1] = {title:'Aceptar', fn:fn[1], class:'btn-trade-visual border-0 btn-btnConfirmActualizarListas'};

            Fn.showModal({ id:modalId, title:titleConfirm, content:msgConfirm, btn:btn, show:true, width:'50%'});
		});

        $(document).on('click','.btn-btnConfirmActualizarListas', function(e){
			e.preventDefault();

			let data = { 'txt-fechas': $('#txt-fechas').val() };
			let jsonString = {data: JSON.stringify(data)};
			let configAjax = {url: Gestion.urlActivo + 'actualizarListasVigentes', data:jsonString };

			$.when(Fn.ajax(configAjax)).then( function(a){
				++modalId;
				let fn = [];
				let btn = [];

                fn[0] = 'Fn.showModal({ id:'+modalId+',show:false });$(".btn-Consultar").click();';
                btn[0] = {title:'Cerrar', fn:fn[0]};

				Fn.showModal({ id:modalId, title:a.msg.title, content:a.msg.content, btn:btn, show:true, width:'50%'});
			});
		});
    },

    cambiarSeccionActivo: function () {
        switch (IniciativaTrad.tabSeleccionado) {
            case 'Motivo':
                IniciativaTrad.customDataTable = Gestion.defaultDT;
                break;
            case 'Elemento':
                IniciativaTrad.customDataTable = function(){
                    Gestion.$dataTable[Gestion.idContentActivo] = $('#' + Gestion.idContentActivo + ' table').DataTable({
                        columnDefs: [
                            { targets: 0, orderable: false, className: 'select-checkbox tex-center' },
                            { targets: [1, 2], searchable: false, orderable: false, className: 'text-center' },
                            { targets: [-1, -2, -3], className: 'text-center' },
                            { targets: 'colNumerica', className: 'text-center' },
                        ],
                        select: { style: 'multi', selector: 'td:first-child' },
                        // buttons: ['excel','pageLength', 'selectAll',
                        //     'selectNone'],
                    });
                    Gestion.columnaOrdenDT = 1;
                }
                break;
            case 'Iniciativa':
                IniciativaTrad.customDataTable = function(){
                    Gestion.$dataTable[Gestion.idContentActivo] = $('#' + Gestion.idContentActivo + ' table').DataTable({
                        columnDefs: [
                            { targets: 0, orderable: false, className: 'select-checkbox tex-center' },
                            { targets: [1, 2], searchable: false, orderable: false, className: 'text-center' },
                            { targets: [-1, -2, -3], className: 'text-center' },
                            { targets: 'colNumerica', className: 'text-center' },
                        ],
                        select: { style: 'multi', selector: 'td:first-child' },
                        // buttons: ['excel','pageLength', 'selectAll',
                        //     'selectNone'],
                    });
                    Gestion.columnaOrdenDT = 1;
                }
                break;
            case 'Lista':
                IniciativaTrad.customDataTable = function(){
                    Gestion.$dataTable[Gestion.idContentActivo] = $('#' + Gestion.idContentActivo + ' table').DataTable({
                        columnDefs: [
                            { targets: 0, orderable: false, className: 'select-checkbox tex-center' },
                            { targets: [1, 2], searchable: false, orderable: false, className: 'text-center' },
                            { targets: [-1, -2, -3], className: 'text-center' },
                            { targets: 'colNumerica', className: 'text-center' },
                        ],
                        select: { style: 'multi', selector: 'td:first-child' },
                        // buttons: ['excel','pageLength', 'selectAll',
                        //     'selectNone'],
                    });
                    Gestion.columnaOrdenDT = 1;
                }
                break;
        }
    },

    eventos: function () {
        $(document).on("change", ".canal_cliente", function (e) {
            var data = {'idCanal': $(this).val()};
            var jsonString = { 'data': JSON.stringify(data) };
            var config = { 'url': Gestion.urlActivo + "getSegCliente", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                
                if (a.result == 1) $('.cliente_sl').html("<select id='cliente' name='cliente' + class='form-control form-control-sm my_select2'>"+a.data.html+"</select>");
            });

		});
        $(document).on("change", "#iniciativa", function (e) {
            var data = {'idIniciativa': $(this).val()};
            var jsonString = { 'data': JSON.stringify(data) };
            var config = { 'url': Gestion.urlActivo + "getElementosIniciativa", 'data': jsonString };
            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                
                if (a.result == 1) $('#li-origen-elementos').html(a.data.html);
                if (a.result == 1) $('#li-destino-elementos').html('');
            });

        });
        $('body').on('click', '.pasarElementos', function(e){
			return !$('#li-origen-elementos option:selected').remove().appendTo('#li-destino-elementos');
		});	
		
		$('body').on('click', '.quitarElementos', function(e){
			return !$('#li-destino-elementos option:selected').remove().appendTo('#li-origen-elementos');
        });
        

        $('body').on('change', '.iniciativas', function(e){
            var ini=$(this);
            var idIniciativa=$(this).val();

            if(IniciativaTrad.elementos!=null){
                var html="<option value=''>-- Seleccionar --</option>";
                IniciativaTrad.elementos.forEach(function(i,v){
                    if(i.idIniciativa==idIniciativa){
                        html+="<option value="+i.idElementoVis+">"+i.nombre+"</option>";
                    }
                });
                $(this).closest('tr').find('.elementos').html(html);
            }
           
        });
        
		
    },

    guardarIniciativaElementoMotivo: function(){
        var frm = Fn.formSerializeObject("formUpdateIniciativaElementoMotivo");
        if(frm['motivo_seleccion']!=null){
            var array=JSON.stringify(frm['motivo_seleccion']);
            $("#iniciativa_elemento_motivo-"+(IniciativaTrad.index)).val(array);
        }
        Fn.showModal({ id: IniciativaTrad.idModalMotivos,show:false });
        IniciativaTrad.index=null;
    },

    guardarIniciativaElementoMotivoExistente: function(){
        var frm = Fn.formSerializeObject("formUpdateIniciativaElementoMotivo");

        var jsonString={'data':JSON.stringify(frm)};
        var configAjax={'url':Gestion.urlActivo +'updateIniciativaElementoMotivo', 'data':jsonString};

        $.when(Fn.ajax(configAjax)).then( function(a){

            ++modalId;
            var fn1='Fn.showModal({ id:'+modalId+', show:false});Fn.showModal({ id:'+IniciativaTrad.idModalMotivos+', show:false});';
            var btn=new Array();
                btn[0]={title:'Cerrar', fn:fn1};

            var message=a.msg.content;
            Fn.showModal({ id:modalId, show:true, title:a.msg.title, content:message, btn:btn, width:a.data.htmlWidth});
            IniciativaTrad.index=null;
        });
    },

    cargaMasivaAlternativa: function() {
		var file_data = $('#archivo').prop('files')[0];
		var validar=true;
		
        var fechaInicio= $('#fecha_ini').val();
        var fechaFin=$('#fecha_fin').val();

		if(file_data==undefined){
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			Fn.showModal({ id:modalId,show:true,title:"Validacion Carga Masiva Iniciativa",content:"Se requiere la carga del archivo.",btn:btn});
			validar=false;
		}

		if(validar){
			var file_name = file_data.name;
			var formato = file_name.split(".");		
			
			var form_data = new FormData();             
			form_data.append('file', file_data); 
            form_data.append('fecIni', fechaInicio); 
            form_data.append('fecFin', fechaFin); 

			if((formato[1]=='csv')||(formato[1]=='CSV')){	
				$.ajax({
					url: site_url+'index.php/configuraciones/gestion/iniciativaTrad/carga_masiva_alternativa',
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,                         
					type: 'post',
					beforeSend: function(){
						Fn.showLoading(true,'Procesando');
					},
					success: function(a){
						$("#cargas_detalles").empty();
						$("#cargas_detalles").html(a.data);
						$('#btn-sellin-filter').click();
						Fn.showLoading(false);
						setTimeout(IniciativaTrad.ejecutarBat, 0 );
					},
				});
			} else {
				++modalId;
				var fn='Fn.showModal({ id:'+modalId+',show:false });';
				var btn=new Array();
					btn[0]={title:'Cerrar',fn:fn};
				Fn.showModal({ id:modalId,show:true,title:"Validacion Carga Masiva Iniciativas",content:"Solo se permite archivos con formato .csv",btn:btn});
				validar=false;
			} 

		}
	
		
	},
	ejecutarBat: function(){
		$.ajax({
			type: "POST",
			url: site_url+'public/bat/bat_iniciativas.php',
			success: function(data) {
				console.log('listo');
			}
		});
	},
}

IniciativaTrad.load();