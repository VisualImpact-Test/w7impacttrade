var CuentasCanales = {

    secciones: ['Cuenta', 'TipoUsuarioCuenta', 'Proyecto', 'GrupoCanal', 'Canal', 'SubCanal'],
    tabSeleccionado: '',
    customDataTable: function () { },

    load: function () {

        $(document).ready(function (e) {
            CuentasCanales.eventos();
            Gestion.urlActivo = 'configuraciones/maestros/CuentasCanales/';
            $(".card-body > ul > li > a[class*='active']").click();
            $('.btn-Consultar').click();
        });

        $(document).on('click', '.card-body > ul > li > a', function (e) {
            $('.btn-Consultar').click();
        });

        $(".card-body > ul > li > a").click(function (e) {
            e.preventDefault();

            var indiceSeccion = $(this).attr('href').split('-')[2];
            CuentasCanales.tabSeleccionado = CuentasCanales.secciones[indiceSeccion];

            CuentasCanales.cambiarSeccionActivo();
            Gestion.idContentActivo = 'tab-content-' + indiceSeccion;
            if (typeof Gestion.$dataTable[Gestion.idContentActivo] != 'undefined') Gestion.$dataTable[Gestion.idContentActivo].columns.adjust().draw();
            Gestion.funcionCustomDT = CuentasCanales.customDataTable;
            Gestion.seccionActivo = CuentasCanales.tabSeleccionado
            Gestion.idFormSeccionActivo = 'seccionFiltros'
            Gestion.getTablaActivo = 'getTabla' + CuentasCanales.tabSeleccionado
            Gestion.getFormNewActivo = 'getFormNew' + CuentasCanales.tabSeleccionado
            Gestion.getFormUpdateActivo = 'getFormUpdate' + CuentasCanales.tabSeleccionado
            Gestion.getFormCargaMasivaActivo = 'getFormCargaMasiva' + CuentasCanales.tabSeleccionado
            Gestion.funcionRegistrarActivo = 'registrar' + CuentasCanales.tabSeleccionado
            Gestion.funcionActualizarActivo = 'actualizar' + CuentasCanales.tabSeleccionado
            Gestion.funcionGuardarCargaMasivaActivo = 'guardarCargaMasiva' + CuentasCanales.tabSeleccionado

            //Ajustar columnas
            setTimeout(function () {
                if (Gestion.$dataTable[Gestion.idContentActivo]) {
                    Gestion.$dataTable[Gestion.idContentActivo].columns.adjust();
                }
            }, 500);

            $('.btn-New-Foto').hide();
            $('.btn-New').show();
            if(indiceSeccion == 0){
                $('.btn-New-Foto').show();
                $('.btn-New').hide();
            }
        });

        $(document).on("click", ".btn-New-Foto", function (e) {
            e.preventDefault();

            var data = { 'seccionActivo': Gestion.seccionActivo };
            var dataExtra = $(this).attr('data-extra');
            var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);

            serialize.seccionActivo = Gestion.seccionActivo;

            Object.assign(serialize, { "dataExtra": dataExtra });
            var jsonString = { 'data': JSON.stringify(serialize) };
            var config = { 'url': Gestion.urlActivo + Gestion.getFormNewActivo, 'data': jsonString };

            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;

                ++modalId;
                Gestion.idModalPrincipal = modalId;
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var fn1 = 'Fn.showConfirm({ fn:"CuentasCanales.registrar()",content:"¿Esta seguro de realizar el registro?" });';

                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };
                btn[1] = { title: 'Registrar', fn: fn1 };

                Fn.showModal({ id: modalId, show: true, class: 'modalNew', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });

            });
        });

        $(document).on("click", ".btn-Editar-Foto", function (e) {
            e.preventDefault();

            var data = { 'id': $(this).closest('tr').data('id'), 'seccionActivo': Gestion.seccionActivo };
            var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
            Object.assign(data, serialize);

            var jsonString = { 'data': JSON.stringify(data) };

            var config = { 'url': Gestion.urlActivo + Gestion.getFormUpdateActivo, 'data': jsonString };

            $.when(Fn.ajax(config)).then(function (a) {

                if (a.result === 2) return false;

                ++modalId;
                Gestion.idModalPrincipal = modalId;
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var fn1 = 'Fn.showConfirm({ fn:"CuentasCanales.actualizar()",content:"¿Esta seguro de actualizar los datos?" });';

                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };
                btn[1] = { title: 'Actualizar', fn: fn1 };
                Fn.showModal({ id: modalId, show: true, class: 'modalUpdate', title: a.msg.title, frm: a.data.html, btn: btn, width: a.data.width });
            });
        });

        $(document).on('click', '.prettyphoto', function (e) {
            e.preventDefault();

            ++modalId;

            var foto = $(this).data('foto');

            Fn.showLoading(true);

            $.when($.post(site_url + Gestion.urlActivo + "/mostrarFoto", { foto: foto }, function (data) {
                dataBody = data;
            })).then(() => {
                ++modalId;
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };

                Fn.showLoading(false);
                Fn.showModal({ id: modalId, show: true, title: "FOTOS", content: dataBody, btn: btn });
            });
        });
    },

    cambiarSeccionActivo: function () {
        $('.btn-CargaMasiva').addClass('d-none');
        switch (CuentasCanales.tabSeleccionado) {
            case 'Cuenta':
                CuentasCanales.customDataTable = Gestion.defaultDT;
                break;
            case 'TipoUsuarioCuenta':
                CuentasCanales.customDataTable = Gestion.defaultDT;
                break;
            case 'Proyecto':
                $('.btn-CargaMasiva').removeClass('d-none');
                CuentasCanales.customDataTable = Gestion.defaultDT;
                break;
            case 'GrupoCanal':
                CuentasCanales.customDataTable = Gestion.defaultDT;
                break;
            case 'Canal':
                CuentasCanales.customDataTable = Gestion.defaultDT;
                break;
            case 'SubCanal':
                CuentasCanales.customDataTable = Gestion.defaultDT;
                break;
        }
    },

    registrar: function () {
        var file_data = $('#inputFileCargo').prop('files')[0];
        if (!file_data) {
            ++modalId;
            var btn = [{ 'title': 'Aceptar', 'fn': 'Fn.showModal({ id:' + modalId + ', show: false });' }];

            Fn.showModal({
                'id': modalId,
                'show': true,
                'title': 'Advertencia',
                'content': 'Debe subir el logo de la cuenta.',
                'btn': btn
            });
            return false;
        }
        var file_name = file_data.name;
        var formato = file_name.split(".");

        if ((formato[1] == 'jpg') || (formato[1] == 'JPG') || (formato[1] == 'png') || (formato[1] == 'PNG')) {
            var nombre = $('#nombre').val();
            var ruc = $('#ruc').val();
            var nombreComercial = $('#nombreComercial').val();
            var razonSocial = $('#razonSocial').val();
            var direccion = $('#direccion').val();
            var ubigeo = $('#ubigeo').val();
            var urlCss = $('#urlCss').val();
            var form_data = new FormData();

            form_data.append('file', file_data);
            form_data.append('nombre', nombre);
            form_data.append('ruc', ruc);
            form_data.append('nombreComercial', nombreComercial);
            form_data.append('razonSocial', razonSocial);
            form_data.append('direccion', direccion);
            form_data.append('ubigeo', ubigeo);
            form_data.append('urlCss', urlCss);
            $.ajax({
                url: site_url + 'index.php/' + Gestion.urlActivo + 'registrarCuenta',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                beforeSend: function () {
                    Fn.showLoading(true);
                },
                success: function (a) {
                    if (a.result === 2) return false;
                    if (typeof a.data.validaciones !== null) $.mostrarValidaciones('formNew', a.data.validaciones);
                    if (typeof a.data.validacionesMulti !== null) $.mostrarValidaciones('formNew', a.data.validacionesMulti);

                    ++modalId;
                    var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

                    if (a.result == 1) fn += 'Fn.showModal({ id:' + modalId + ',show:false });$(".btn-Consultar").click();';

                    var btn = [];
                    btn[0] = { title: 'Cerrar', fn: fn };
                    Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, frm: a.msg.content });

                    $('.prettyphoto').data('foto', site_url + 'public/assets/images/logos/' + file_name);
                    $('.prettyphoto').removeClass('disabled');
                },
                error: function () {
                    ++modalId;
                    var btn = [{ 'title': 'Aceptar', 'fn': 'Fn.showModal({ id:' + modalId + ', show: false });' }];

                    Fn.showModal({
                        'id': modalId,
                        'show': true,
                        'title': 'ERROR',
                        'content': 'Ocurrio un error inesperado en el sistema.',
                        'btn': btn
                    });
                },
                complete: function () {
                    setTimeout(
                        function () {
                            Fn.showLoading(false);
                            a.resolve(result);
                        }
                        , 100);
                }
            });
        } else {
            ++modalId;
            var btn = [{ 'title': 'Aceptar', 'fn': 'Fn.showModal({ id:' + modalId + ', show: false });' }];

            Fn.showModal({
                'id': modalId,
                'show': true,
                'title': 'Advertencia',
                'content': '<div class="alert alert-info">La imagen debe ser en formato jpg o png</div>',
                'btn': btn
            });
        }
    },

    actualizar: function () {
        var file_data = $('#inputFileCargo').prop('files')[0];
        var file_name = '';
        var formato = file_name.split(".");
        if (file_data) {
            file_name = file_data.name;
            formato = file_name.split(".");
            if ((formato[1] != 'jpg') && (formato[1] != 'JPG') && (formato[1] != 'png') && (formato[1] != 'PNG')) {
                ++modalId;
                var btn = [{ 'title': 'Aceptar', 'fn': 'Fn.showModal({ id:' + modalId + ', show: false });' }];

                Fn.showModal({
                    'id': modalId,
                    'show': true,
                    'title': 'Advertencia',
                    'content': '<div class="alert alert-info">La imagen debe ser en formato jpg o png</div>',
                    'btn': btn
                });

                return false;
            }
        }
        
        var nombre = $('#nombre').val();
        var idCuenta = $('#idCuenta').val();
        var ruc = $('#ruc').val();
        var nombreComercial = $('#nombreComercial').val();
        var razonSocial = $('#razonSocial').val();
        var direccion = $('#direccion').val();
        var ubigeo = $('#ubigeo').val();
        var urlCss = $('#urlCss').val();
        var form_data = new FormData();

        form_data.append('file', file_data);
        form_data.append('idCuenta', idCuenta);
        form_data.append('nombre', nombre);
        form_data.append('ruc', ruc);
        form_data.append('nombreComercial', nombreComercial);
        form_data.append('razonSocial', razonSocial);
        form_data.append('direccion', direccion);
        form_data.append('ubigeo', ubigeo);
        form_data.append('urlCss', urlCss);
        $.ajax({
            url: site_url + 'index.php/' + Gestion.urlActivo + Gestion.funcionActualizarActivo,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'post',
            beforeSend: function () {
                Fn.showLoading(true);
            },
            success: function (a) {
                if (a.result === 2) return false;
                if (typeof a.data.validaciones !== null) $.mostrarValidaciones('formUpdate', a.data.validaciones);
                if (typeof a.data.validacionesMulti !== null) $.mostrarValidaciones('formUpdate', a.data.validacionesMulti);

                ++modalId;
                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';

                if (a.result == 1) fn += 'Fn.showModal({ id:' + modalId + ',show:false });$(".btn-Consultar").click();';

                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };
                Fn.showModal({ id: modalId, show: true, title: a.msg.title, btn: btn, frm: a.msg.content });

                $('.prettyphoto').data('foto', site_url + 'public/assets/images/logos/' + file_name);
                $('.prettyphoto').removeClass('disabled');
            },
            error: function () {
                ++modalId;
                var btn = [{ 'title': 'Aceptar', 'fn': 'Fn.showModal({ id:' + modalId + ', show: false });' }];

                Fn.showModal({
                    'id': modalId,
                    'show': true,
                    'title': 'ERROR',
                    'content': 'Ocurrio un error inesperado en el sistema.',
                    'btn': btn
                });
            },
            complete: function () {
                setTimeout(
                    function () {
                        Fn.showLoading(false);
                        a.resolve(result);
                    }
                    , 100);
            }
        });
    },

    eventos: function () {

    },
}

CuentasCanales.load();