var ModulosApp = {
    idModal: 0,
    data: {},
    url: 'configuraciones/administracion/modulosApp/',
    load: function(){

        $('.slt-cuenta').select2({
            dropdownParent: $("#frm-moduloApp-filtro"),
            width: '100%',
            placeholder: "-- Cuenta --"
        });
        $('.slt-aplicacion').select2({
            dropdownParent: $("#frm-moduloApp-filtro"),
            width: '100%',
            placeholder: "-- Aplicación --"
        });
        $('.slt-tipoUsuario').select2({
            dropdownParent: $("#frm-moduloApp-filtro"),
            width: '100%',
            placeholder: "-- Tipo Usuario --"
        });
        $('.slt-canal').select2({
            dropdownParent: $("#frm-moduloApp-filtro"),
            width: '100%',
            placeholder: "-- Canal --"
        });
        

        $(document).on('click', '#btn-moduloApp-consultar', function(){
            var config = {
                url: ModulosApp.url + 'consultar',
                data: { data: JSON.stringify(Fn.formSerializeObject('frm-moduloApp-filtro')) }
            };

            $.when( Fn.ajax(config) ).then(function(a){
                if( a.result == 2 ) return false;
                $('#contentPermisos').html(a.data.view);
            });
        });

        $(document).on('click', '#btn-moduloApp-nuevo', function(){
            var config = {
                url: ModulosApp.url + 'formulario',
                data: { data: {} }
            };

            $.when( Fn.ajax(config) ).then(function(a){
                ++modalId;
                Fn.showModal({
                    id: modalId,
                    show: true,
                    title: 'Nuevo',
                    frm: a.data.view,
                    btn: [
                        { title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' },
                        { title: 'Guardar', id: 'btn-moduloApp-guardar' }
                    ],
                    width:a.data.width,
                });

                ModulosApp.idModal = modalId;
            });
        });

        $(document).on('click', '#btn-moduloApp-guardar', function(){
            var control = $(this);
            var msg = '';
            if( !$('#frm-moduloApp-config .slt-aplicacion').val().length ){
                msg = Fn.message({ type: 2, message: 'Debe seleccionar una aplicación' });
            }
            if( !$('#frm-moduloApp-config .slt-tipoUsuario').val().length &&
                !$('#frm-moduloApp-config .slt-canal').val().length 
            ){
                msg = Fn.message({ type: 2, message: 'Debe seleccionar por lo menos un Tipo de Usuario o Canal' });
            }
            else if( !$('#frm-moduloApp-config .check-moduloNew:checked').length ){
                msg = Fn.message({ type: 2, message: 'Debe seleccionar por lo menos un módulo' });
            }

            ++modalId;
            if( msg.length ){
                Fn.showModal({
                    id: modalId,
                    show: true,
                    title: 'Alerta',
                    frm: msg,
                    btn: [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
                });

                return false;
            }

            Fn.showModal({
                id: modalId,
                show: true,
                title: 'Confirmar',
                frm: Fn.message({ type: 3, message: '¿Desea guardar los datos ingresados?' }),
                btn: [
                    { title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' },
                    { title: 'Continuar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false }); ModulosApp.guardar();' },
                ]
            });
        });

        $(document).on('click', '#btn-moduloApp-eliminar', function(){
            ++modalId;
            if( !$('.check-moduloEdit:checked').length ){
                Fn.showModal({
                    id: modalId,
                    show: true,
                    title: 'Alerta',
                    frm: Fn.message({ type: 2, message: 'No se seleccionado ningún grupo para eliminar' }),
                    btn: [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' }]
                });

                return false;
            }

            var data = [];
            $.each($('.check-moduloEdit:checked'), function(i, v){
                data.push($(v).data());
            });

            ModulosApp.data = {};
            ModulosApp.data['grupo'] = data;

            Fn.showModal({
                id: modalId,
                show: true,
                title: 'Confirmar',
                frm: Fn.message({ type: 3, message: '¿Desea eliminar los datos seleccionados?' }),
                btn: [
                        { title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' },
                        { title: 'Continuar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false }); ModulosApp.eliminar();' },
                    ]
            });
            
        });

        $(document).on('click', '.btn-moduloApp-eliminar', function(){
            var control = $(this);

            ModulosApp.data = {};
            ModulosApp.data['idModuloTipo'] = control.closest('.list-group-item').data('id');

            ++modalId;
            Fn.showModal({
                id: modalId,
                show: true,
                title: 'Confirmar',
                frm: Fn.message({ type: 3, message: '¿Desea eliminar el registro?' }),
                btn: [
                        { title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' },
                        { title: 'Continuar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false }); ModulosApp.eliminar();' },
                    ]
            });

        });

        $(document).on('click', '.btn-moduloApp-oblig', function(){
            var control = $(this);

            ModulosApp.data = {};
            ModulosApp.data['idModuloTipo'] = control.closest('.list-group-item').data('id');
            ModulosApp.data['flagObligatorio'] = control.data('flagObligatorio') ? 0 : 1;

            ++modalId;
            Fn.showModal({
                id: modalId,
                show: true,
                title: 'Confirmar',
                frm: Fn.message({ type: 3, message: '¿Desea cambiar el registro obligatorio?' }),
                btn: [
                        { title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' },
                        { title: 'Continuar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false }); ModulosApp.editar();' },
                    ]
            });

        });

        $(document).on('change', '.slt-cuenta', function(){
            var control = $(this);
            var frm = control.closest('form');

            var list = [ 'aplicacion', 'canal' ];
            var listId = { aplicacion: 'idAplicacion', canal: 'idCanal' };
            var listEl = { aplicacion: frm.find('.slt-aplicacion'), canal: frm.find('.slt-canal') };

            var data = { data: JSON.stringify({ list: list, idCuenta: control.val() }) };
            var url = ModulosApp.url + 'datos';

            var dfd = $.Deferred();
            var html = {};

            $.each(list, function(il, vl){
                html[vl] = '<option value=""></option>';
            })

            $.when( Fn.ajax({ url: url, data: data }) ).then(function(a){
                if( a.result == 2 ) return false;

                $.each(list, function(il, vl){
                    if( a.data[vl] ){
                        $.each(a.data[vl], function(idt, vdt){
                            html[vl] += '<option value="' + vdt[listId[vl]] + '">' + vdt.nombre + '</option>';
                        });
                    }
                });

                dfd.resolve();
            });

            $.when( dfd ).then(function(){
                $.each(list, function(il, vl){
                    $.each(listEl[vl], function(ile, vle){
                        $(vle).html(html[vl]);
                    });
                });
            });
        });

        $(document).on('change', '.slt-aplicacion', function(){
            var control = $(this);
            var frm = control.closest('form');

            var list = [ 'modulos' ];
            var listId = { modulos: 'idModulo' };
            var listEl = { modulos: frm.find('#lst-moduloApp') };

            var data = { data: JSON.stringify({ list: list, idAplicacion: control.val() }) };
            var url = ModulosApp.url + 'datos';

            var dfd = $.Deferred();
            var html = {};

            $.each(list, function(il, vl){
                html[vl] = '<li>* Seleccionar Aplicación</li>';
            })

            $.when( Fn.ajax({ url: url, data: data }) ).then(function(a){
                if( a.result == 2 ) return false;

                $.each(list, function(il, vl){
                    if( a.data[vl] && a.data[vl].length > 0 ){
                        html[vl] = '';
                        $.each(a.data[vl], function(idt, vdt){
                            html[vl] += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                                html[vl] += '<div class="form-check form-check-inline">';
                                    html[vl] += '<input type="checkbox"';
                                        html[vl] += 'id="check-moduloNew-' + vdt[listId[vl]] + '"';
                                        html[vl] += 'class="check-moduloNew form-check-input"';
                                        html[vl] += 'style="width: 15px; height: 15px;"';
                                        html[vl] += 'name="idModulo"';
                                        html[vl] += 'value="' + vdt[listId[vl]] + '"';
                                    html[vl] += '>';
                                    html[vl] += '<label class="lbl-moduloApp form-check-label cursor-pointer mb-0 ml-2" for="check-moduloNew-' + vdt[listId[vl]] + '">';
                                        html[vl] += vdt.nombre;
                                    html[vl] += '</label>';
                                html[vl] += '</div>';
                                html[vl] += '<div class="custom-control custom-switch">';
                                    html[vl] += '<input type="checkbox" id="sw-oblig-' + vdt[listId[vl]] + '"';
                                        html[vl] += 'class="sw-oblig custom-control-input"';
                                        html[vl] += 'name="flagObligatorio[' + vdt[listId[vl]] + ']"';
                                        html[vl] += 'value="1"';
                                        html[vl] += 'disabled';
                                    html[vl] += '>';
                                    html[vl] += '<label class="txt-oblig custom-control-label cursor-pointer" for="sw-oblig-' + vdt[listId[vl]] + '">Obligatorio</label>';
                                html[vl] += '</div>';
                            html[vl] += '</li>';
                        });
                    }
                });

                dfd.resolve();
            });

            $.when( dfd ).then(function(){
                $.each(list, function(il, vl){
                    $.each(listEl[vl], function(ile, vle){
                        $(vle).html(html[vl]);
                    });
                });
            });
        });
        $('#btn-moduloApp-consultar').click();

    },
    guardar: function(){
        var config = {
            url: ModulosApp.url + 'guardar',
            data: { data: JSON.stringify(Fn.formSerializeObject('frm-moduloApp-config')) }
        };

        $.when( Fn.ajax(config) ).then(function(a){
            if( a.result == 2 ) return false;

            ++modalId;
            var btn = [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' }];
            if( a.result == 1 ){
                Fn.showModal({ id: ModulosApp.idModal, show: false });
                btn = [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false }); $("#btn-moduloApp-consultar").click(); ' }];
            }

            Fn.showModal({
                id: modalId,
                show: true,
                title: 'Nuevo',
                frm: a.msg.content,
                btn: btn
            });
        });
        
    },
    editar: function(){
        var config = {
            url: ModulosApp.url + 'editar',
            data: { data: JSON.stringify(ModulosApp.data) }
        };

        $.when( Fn.ajax(config) ).then(function(a){
            if( a.result == 2 ) return false;

            ++modalId;
            var btn = [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' }];
            if( a.result == 1 ){
                Fn.showModal({ id: ModulosApp.idModal, show: false });
                btn = [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false }); $("#btn-moduloApp-consultar").click(); ' }];
            }

            Fn.showModal({
                id: modalId,
                show: true,
                title: 'Editar',
                frm: a.msg.content,
                btn: btn
            });

        })
    },
    eliminar: function(){
        var config = {
            url: ModulosApp.url + 'eliminar',
            data: { data: JSON.stringify(ModulosApp.data) }
        };

        $.when( Fn.ajax(config) ).then(function(a){
            if( a.result == 2 ) return false;

            ++modalId;
            var btn = [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false });' }];
            if( a.result == 1 ){
                Fn.showModal({ id: ModulosApp.idModal, show: false });
                btn = [{ title: 'Cerrar', fn: 'Fn.showModal({ id: ' + modalId + ', show: false }); $("#btn-moduloApp-consultar").click(); ' }];
            }

            Fn.showModal({
                id: modalId,
                show: true,
                title: 'Eliminar',
                frm: a.msg.content,
                btn: btn
            });

        })
    }

}
ModulosApp.load();