var Gestorx = {

    secciones: ['InfoPlaza'
                ,'TipoCliente'
                ,'TipoAuditoria'
                ,'Empresa'
                ,'InfPlaza'
                ,'ConfPlaza'
                ,'ConfCliente'
                ,'ConfTipoCliente'
                ,'TipoResponsable'
                ,'Responsable'
                ,'ListaEvaluacion'
                ,'Preguntas'
                ,'TipoEvaluacion'
                ,'Evaluacion'
                ],
    tabSeleccionado: '',
    matEnTabla : [],
    encEnTabla: [],
    tabActivo : '',
    tabSeleccionadoCeldas : [],
    nSheets : 0,
    hSheets : [],
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            Gestorx.eventos();
            Gestion.urlActivo = 'configuraciones/gestion/livestorecheckconf/';
            $(".card-body > ul > li > a[class*='active']").click();
        });

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();
            $('.card-header > .scrollmenu > a').removeClass('active');
            var indiceSeccion = $(this).attr('href').split('-')[2];
            Gestorx.tabSeleccionado = Gestorx.secciones[indiceSeccion];

            Gestorx.hSheets = [];
            Gestorx.tabSeleccionadoCeldas = [];

            switch (indiceSeccion) {
                case '0':
                    Gestorx.nSheets = 1;
    
                    Gestorx.hSheets.push('Tipos Información');
                    Gestorx.tabSeleccionadoCeldas.push(['NOMBRE TIPO INFO(*)']);
                    break;
                case '1':
                    Gestorx.nSheets = 1;
                    Gestorx.hSheets.push('Tipos Cliente');
                    Gestorx.tabSeleccionadoCeldas.push(['NOMBRE TIPO CLIENTE(*)']);
                    break;
                case '2':
                    Gestorx.nSheets = 1;
                    Gestorx.hSheets.push('Tipos Auditoría');
                    Gestorx.tabSeleccionadoCeldas.push(['NOMBRE TIPO DE AUDITORÍA(*)']);
                    break;
                case '3':
                    Gestorx.nSheets = 1;
                    Gestorx.hSheets.push('Empresa (competencia)');
                    Gestorx.tabSeleccionadoCeldas.push(['NOMBRE EMPRESA(*)']);
                    break;
                case '4':
                    Gestorx.nSheets = 1;
                    Gestorx.hSheets.push('Información de Plaza');
                    Gestorx.tabSeleccionadoCeldas.push(['PLAZA(*)','TIPO INFO(*)','VALOR(*)','EMPRESA (COMPETENCIA)','FECHA INICIO(*)','FECHA FIN']);
                    break;
                case '5':
                    Gestorx.nSheets = 1;
                    Gestorx.hSheets.push('Configuración de Plaza');
                    Gestorx.tabSeleccionadoCeldas.push(['PLAZA(*)','TIPO CLIENTE(*)','PROMEDIO(*)','FECHA INICIO(*)','FECHA FIN']);
                    break;
                case '6':
                    Gestorx.nSheets = 2;
                    Gestorx.hSheets.push('Config de Cliente');
                    Gestorx.hSheets.push('Config Aud Cliente');
                    Gestorx.tabSeleccionadoCeldas.push(['CODIGO CLIENTE(*)','TIPO CLIENTE(*)','FECHA INICIO(*)','FECHA FIN']);
                    Gestorx.tabSeleccionadoCeldas.push(['CODIGO CLIENTE(*)','TIPO AUDITORÍA(*)','MATERIAL(*)','PRESENCIA']);
                    break;
                case '7':
                    Gestorx.nSheets = 1;
                    Gestorx.hSheets.push('Config de Tipo Cliente');
                    Gestorx.tabSeleccionadoCeldas.push(['TIPO CLIENTE(*)','TIPO AUDITORÍA(*)','MATERIAL(*)','FECHA INICIO(*)','FECHA FIN']);
                    break;
                case '8':
                    Gestorx.nSheets = 1;
                    Gestorx.hSheets.push('Tipo Responsable');
                    Gestorx.tabSeleccionadoCeldas.push(['NOMBRE TIPO DE RESPONSABLE(*)']);
                    break;
                case '9':
                    Gestorx.nSheets = 1;
                    Gestorx.hSheets.push('Responsables');
                    Gestorx.tabSeleccionadoCeldas.push(['TIPO(*)','NOMBRES(*)','APELLIDOS(*)','EMAIL(*)']);
                    break;
                case '10':
                    Gestorx.nSheets = 1;
                    Gestorx.hSheets.push('Lista Evaluación');
                    Gestorx.tabSeleccionadoCeldas.push(['TIPO AUDITORÍA(*)','TIPO CLIENTE','FECHA INICIO(*)','FECHA FIN(*)','EVALUACIÓN','ENCUESTA']);
                    break;
                case '11':
                    Gestorx.nSheets = 1;
                    Gestorx.hSheets.push('Enc - Preg - Alt');
                    Gestorx.tabSeleccionadoCeldas.push(['TÍTULO ENCUESTA(*)','TIPO PREGUNTA(*)','TIPO AUDITORÍA','TIPO PRESENCIA','VER DETALLE','PREGUNTA(*)','ALTERNATIVA']);
                    break;
                case '12':
                    Gestorx.nSheets = 1;
                    Gestorx.hSheets.push('Tipo Evaluación');
                    Gestorx.tabSeleccionadoCeldas.push(['NOMBRE TIPO EVALUACIÓN(*)']);
                    break;
                case '13':
                    Gestorx.nSheets = 1;
                    Gestorx.hSheets.push('Evaluación');
                    Gestorx.tabSeleccionadoCeldas.push(['NOMBRE EVALUACIÓN(*)','TIPO EVALUACIÓN(*)']);
                    break;
                default:
                    break;
            }
            Gestorx.cambiarSeccionActivo();
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
            if(typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = Gestorx.customDataTable;
            Gestion.seccionActivo = Gestorx.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccion' + Gestorx.tabSeleccionado
            Gestion.getTablaActivo = 'getTabla' + Gestorx.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + Gestorx.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + Gestorx.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + Gestorx.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + Gestorx.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + Gestorx.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + Gestorx.tabSeleccionado

            if($("#"+Gestion.idContentActivo).find('.noResultado').length > 0){
                        $('.btn-Consultar').click()
            }

            //Ajustar columnas
            setTimeout(function(){
                if(Gestion.$dataTable[Gestion.idContentActivo]){
                    Gestion.$dataTable[Gestion.idContentActivo].columns.adjust();
                }
            }, 500);
        });
    },

    cambiarSeccionActivo: function () {
        switch (Gestorx.tabSeleccionado) {
            case 'InfoPlaza':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'TipoCliente':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'TipoResponsable':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'Responsable':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'TipoAuditoria':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'Empresa':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'InfPlaza':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'ConfPlaza':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'ConfCliente':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'ConfTipoCliente':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'ListaEvaluacion':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'Preguntas':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'TipoEvaluacion':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
            case 'Evaluacion':
                Gestorx.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    eventos: function () {
        
        $(document).on( 'click', 'tr td.details-control', function () {
            var detailRows = [];
            var tr = $(this).closest('tr');
            var row = Gestion.$dataTable[Gestion.idContentActivo].row( tr );
            var idx = $.inArray( tr.attr('data-id'), detailRows );
     
            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();
     
                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                let data_reg = [];
                data_reg.push({
                    'Usuario': $(tr).data('usuario'),
                    'fechaReg': $(tr).data('fechareg'),
                    'horaReg': $(tr).data('horareg'),
                    'fechaMod': $(tr).data('fechamodificacion'),
                
                })
                row.child( Gestorx.format( data_reg ) ).show();
     
                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        } );

		$(document).on("click", ".btn-ClienteAud", function (e) {
            e.preventDefault();

			var data = { 'id': $(this).closest('tr').data('id') , 'seccionActivo':Gestion.seccionActivo };
			var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
			Object.assign(data, serialize);

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + 'getFormClienteAud', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				Fn.showModal({ id: modalId, show: true, class: 'modalUpdate', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
			});
		});
		$(document).on("click", ".btn-refresh-ClienteAud", function (e) {
            e.preventDefault();

			var data = { 'id': $('input[name=idConfCliente]').val() };

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + 'getFormClienteAud', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;
                Fn.closeModals(modalId);
                
				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				Fn.showModal({ id: modalId, show: true, class: 'modalUpdate', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
			});
		});
		$(document).on("click", ".btn-ClienteAudDet", function (e) {
            e.preventDefault();

			var data = { 'id': $(this).closest('tr').data('id') , 'seccionActivo':Gestion.seccionActivo };
			var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
			Object.assign(data, serialize);

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + 'getFormClienteAudDet', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				Fn.showModal({ id: modalId, show: true, class: 'modalUpdate', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
			});
		});
		$(document).on("click", ".btn-editarRegistro", function (e) {
            e.preventDefault();

			var data = { 'id': $(this).closest('tr').data('id') , 'seccionActivo':Gestion.seccionActivo };
			var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
			Object.assign(data, serialize);

			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestion.urlActivo + 'getFormClienteAudDet', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var fn1 = 'Fn.showConfirm({ fn:"Gestion.actualizar()",content:"¿Esta seguro de actualizar los datos?" });';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Actualizar', fn: fn1 };
				Fn.showModal({ id: modalId, show: true, class: 'modalUpdate', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
			});
		});
		$(document).on("click", ".btn-presencia", function (e) {
            let $id = $(this).closest('tr').data('id');
            var config={ idForm:'formTemporal',fn:"Gestorx.actualizarPresenciaConfClienteAudDet("+$id+")",content:"¿Deseas cambiar el estado de este Registro?" };
            Fn.showConfirm(config);
         
		});

		$(document).on("click", ".btn-New-ClienteAud", function (e) {
            e.preventDefault();

			var data = { 'id': $('input[name=idConfCliente]').val() };
			var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
			Object.assign(data, serialize);

			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestion.urlActivo + 'getFormNewClienteAud', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });Gestorx.resetFuncionesGestion();';
                // Gestion.funcionRegistrarActivo = "registrar" + Gestorx.tabSeleccionado
				var fn1 ='Gestorx.validarRegistroClienteAud();';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Guardar', fn: fn1 };
				Fn.showModal({ id: modalId, show: true, class: 'modalNew', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
			});
		});

		$(document).on("click", ".btn-New-ClienteAudDet", function (e) {
            e.preventDefault();

			var data = { 'id': $('input[name=idConfClienteDet]').val()};
			var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
			Object.assign(data, serialize);

			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestion.urlActivo + 'getFormNewClienteAudDet', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var fn1 ='Gestorx.validarRegistroClienteAudDet();';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Guardar', fn: fn1 };
				Fn.showModal({ id: modalId, show: true, class: 'modalNew', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
			});
		});

        $(document).on("click", ".btn-cargaMasiva_clienteAud", function (e) {
			e.preventDefault();
            var data = { 'id': $(this).closest('tr').data('id') , 'seccionActivo':Gestion.seccionActivo };
			var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
			Object.assign(data, serialize);

			var jsonString = { 'data': JSON.stringify(data) };
			var config = { 'url': Gestion.urlActivo + 'getFormCargaMasivaClienteAudDet', 'data': jsonString };
			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

				++modalId;
				Gestion.idModalPrincipal = modalId;
				var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
				var fn1 = 'Gestorx.confirmarCargaMasivaAudDet();';

				var btn = [];
				btn[0] = { title: 'Cerrar', fn: fn };
				btn[1] = { title: 'Guardar', fn: fn1 };

				Fn.showModal({ id: modalId, show: true, class: 'modalCargaMasiva', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
				HTCustom.llenarHTObjectsFeatures(a.data.ht);
			});
		});

		$(document).on("click", ".btn-xlsxFormato", function (e) {
            var wb = XLSX.utils.book_new();
            wb.Props = {
                    Title: "SheetJS Tutorial",
                    Subject: "Test",
                    Author: "Red Stapler",
                    CreatedDate: new Date(2017,12,19)
            };
            for (let i = 0; i < Gestorx.nSheets; i++) {
                wb.SheetNames.push(Gestorx.hSheets[i]);

                var ws_data = [Gestorx.tabSeleccionadoCeldas[i]];
                var ws = XLSX.utils.aoa_to_sheet(ws_data);
    
                wb.Sheets[Gestorx.hSheets[i]] = ws;
            }

            var wbout = XLSX.write(wb, {bookType:'xlsx',  type: 'binary'});
            function s2ab(s) {
            
                    var buf = new ArrayBuffer(s.length);
                    var view = new Uint8Array(buf);
                    for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
                    return buf;
                    
            }
            saveAs(new Blob([s2ab(wbout)],{type:"application/octet-stream"}), Gestorx.hSheets[0]+'.xlsx');
        });
        $(document).on('click', '.btn-live-encuesta-ver', function(e){
			e.preventDefault();
			var control = $(this);

			var data = { 'data': JSON.stringify(control.data()) };
			var url =   Gestion.urlActivo + 'verDetallePreguntas';

			$.when( Fn.ajax({ 'url': url, 'data': data }) ).then(function(a){
				if( a['result'] != 2 ){
					var idModal = ++modalId;
					var btn = [{ 'title': 'Cerrar', 'fn': 'Fn.showModal({ id: ' + idModal + ', show: false });' }];
					Fn.showModal({
							'id': idModal,
							'show': true,
							'title': 'Detalle',
							'frm': a['data']['view'],
							'btn': btn
						});
				}
			});
		});

  


    },
    format:function  ( d ) {
            let html = '';
                html += 'Usuario Registro: '+d[0].Usuario + '<br>';
                html += 'Fecha de Registro: '+d[0].fechaReg + '<br>';
                html += 'Hora de Registro: '+d[0].horaReg + '<br>';
                html += 'Fecha de Última Modificación: '+d[0].fechaMod + '<br>';
        return html; 
    },
    resetFuncionesGestion: function(){
        Gestion.funcionRegistrarActivo = "registrar" + Gestorx.tabSeleccionado
    },
    validarRegistroClienteAud: function(){
		var config={ idForm:'formNew',fn:"Gestorx.registrarClienteAud()",content:"¿Deseas guardar este Registro?" };
		Fn.showConfirm(config);
    },
    validarRegistroClienteAudDet: function(){
		var config={ idForm:'formNew',fn:"Gestorx.registrarClienteAudDet()",content:"¿Deseas guardar este Registro?" };
		Fn.showConfirm(config);
    },
    reabrirOpcion: function(config){

    },
    registrarClienteAud: function () {
		$('#li-destino-elementos option').each(function() { $(this).prop("selected",true); });
		var data = Fn.formSerializeObject('formNew');
		data.seccionActivo = Gestion.seccionActivo; 
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Gestion.urlActivo + 'registrarClienteAud', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {

			if (a.result === 2) return false;
			if (typeof a.data.validaciones !== null) $.mostrarValidaciones('formNew', a.data.validaciones);
			if (typeof a.data.validacionesMulti !== null) $.mostrarValidaciones('formNew', a.data.validacionesMulti);
			
			++modalId;
			var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

			if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });$(".btn-refresh-ClienteAud").click();';

			var btn = [];
			btn[0] = { title: 'Cerrar', fn: fn };
			Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
		});
	},
    registrarClienteAudDet: function () {
		$('#li-destino-elementos option').each(function() { $(this).prop("selected",true); });
		var data = Fn.formSerializeObject('formNew');
		data.seccionActivo = Gestion.seccionActivo; 
		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Gestion.urlActivo + 'registrarClienteAudDet', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {

			if (a.result === 2) return false;
			if (typeof a.data.validaciones !== null) $.mostrarValidaciones('formNew', a.data.validaciones);
			if (typeof a.data.validacionesMulti !== null) $.mostrarValidaciones('formNew', a.data.validacionesMulti);
			
			++modalId;
			var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

			if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });$(".btn-refresh-ClienteAud").click();';

			var btn = [];
			btn[0] = { title: 'Cerrar', fn: fn };
			Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, content: a.msg.content });
		});
	},
    actualizarPresenciaConfClienteAudDet: function($id){
        var data = { 'id': $id,'idConfClienteAud':$('input[name=idConfClienteDet]').val()};

        var jsonString = { 'data': JSON.stringify(data) };
        var config = { 'url': Gestion.urlActivo + 'actualizarEstadoConfClienteAudDet', 'data': jsonString };

        $.when(Fn.ajax(config)).then(function (a) {

            if (a.result === 2) return false;

            ++modalId;
            Gestion.idModalPrincipal = modalId;
            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });$(".btn-refresh-ClienteAud").click();';

            var btn = [];
            btn[0] = { title: 'Aceptar', fn: fn };
            Fn.showModal({ id: modalId, show: true, class: 'modalUpdate', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
        });
    },

    
	confirmarCargaMasivaAudDet: function(){
		var contColsInvalid = 0;
			contColsInvalid = $('#divTablaCargaMasiva .htInvalid').length;

		if ( contColsInvalid>0) {
			++modalId;
			var fn='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[0]={title:'Cerrar',fn:fn};
			var message = Fn.message({ 'type': 2, 'message': 'Se encontró datos obligatorios que no fueron ingresados, verificar los datos remarcados <label style="color:red">en rojo</label>' });
			Fn.showModal({ id:modalId,title:'Alerta',frm:message,btn:btn,show:true});
			return false;
		} else {
			++modalId;
			var fn1='Gestorx.guardarCargaMasivaAudDet();Fn.showModal({ id:'+modalId+',show:false });';
			var fn2='Fn.showModal({ id:'+modalId+',show:false });';
			var btn=new Array();
				btn[1]={title:'Continuar',fn:fn1};
				btn[0]={title:'Cerrar',fn:fn2};
			var message = Fn.message({ 'type': 3, 'message': '¿Desea continuar con la carga masiva ?' });
			Fn.showModal({ id:modalId,title:'Alerta',frm:message,btn:btn,show:true});
		}
	},


	guardarCargaMasivaAudDet: function(){
		var data = {'idConfClienteAud':$("input[name=idConfClienteAud]").val()};
		var HT = [];
		$.each(HTCustom.HTObjects, function (i, v) {
			if (typeof v !== 'undefined') HT.push(v.getSourceData());
		});
		data['HT'] = HT;

		var jsonString = { 'data': JSON.stringify(data) };
		var config = { 'url': Gestion.urlActivo + 'guardarCargaMasivaAudDet', 'data': jsonString };

		$.when(Fn.ajax(config)).then(function (a) {

			if (a.result === 2) return false;

			++modalId;
			var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

			if (a.result == 1) fn += 'Fn.showModal({ id:' + Gestion.idModalPrincipal + ',show:false });$(".btn-refresh-ClienteAud").click();';

			var btn = [];
			btn[0] = { title: 'Cerrar', fn: fn };
			Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, frm: a.msg.content });
		});

	},
}

Gestorx.load();