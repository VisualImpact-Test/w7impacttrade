<?
$idTipoUsuario = $this->idTipoUsuario;
?>
<form id="frm-moduloApp-config">
    <div class="row mx-2">
        <div class="col-12 mb-2">
            <h4 class="col-form-label">Configuración: </h4>
        </div>
        <div class="col-12">
            <div class="row mx-2">
                <div class="col-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label">Cuenta:</label>
                        <div class="col-8">
                            <select class="slt-cuenta form-control" name="idCuenta" >
                                <option value=""></option>
                                <?foreach($aListCuenta as $vcue){?>
                                    <option value="<?=$vcue['idCuenta']?>"><?=$vcue['nombre']?></option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label">Aplicación:</label>
                        <div class="col-8">
                            <select class="slt-aplicacion form-control" name="idAplicacion" >
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label">Tipo Usuario:</label>
                        <div class="col-8">
                            <select class="slt-tipoUsuario form-control" name="idTipoUsuario" >
                                <option value=""></option>
                                <?foreach($aListTipoUsuario as $vtu){?>
                                    <option value="<?=$vtu['idTipoUsuario']?>"><?=$vtu['nombre']?></option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group row">
                        <label class="col-4 col-form-label">Canal:</label>
                        <div class="col-8">
                            <select class="slt-canal form-control" name="idCanal" >
                                <option value=""></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4">
            <h4 class="col-form-label">Módulos: </h4>
        </div>
        <div class="col-10 offset-1">
            <div class="form-group row">
                <div class="col-5">
                    <div class="form-check form-check-inline">
                        <input type="checkbox"
                            id="check-moduloNew-all"
                            class="form-check-input"
                            style="width: 15px; height: 15px;"
                        >
                        <label class="lbl-moduloApp form-check-label col-form-label cursor-pointer mb-0 ml-2" for="check-moduloNew-all">
                            Marcar todo
                        </label>
                    </div>
                </div>
                <div class="input-group col-7">
                    <input type="text" id="sch-moduloApp" class="form-control" placeholder="Buscar">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                </div>
            </div>
            <ul id="lst-moduloApp" class="list-group list-group-flush" style="overflow-y: auto; max-height: 40vh;">
                <li>* Seleccionar Aplicación</li>
            </ul>
        </div>
    </div>
</form>
<script>
    $(document).off('keyup', '#sch-moduloApp').on('keyup', '#sch-moduloApp', function(){
        var control = $(this);
        var searchTerm = control.val();
        var searchSplit = searchTerm.replace(/ /g, "'):containsi('")

        $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
                return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
            }
        });

        $('#lst-moduloApp .lbl-moduloApp').not(":containsi('" + searchSplit + "')").each(function(e){
            $(this).closest('.list-group-item').removeClass('d-flex').addClass('d-none');
        });

        $('#lst-moduloApp .lbl-moduloApp:containsi("' + searchSplit + '")').each(function(e){
            $(this).closest('.list-group-item').addClass('d-flex').removeClass('d-none');
        });
    });
    
    $(document).off('change', '#check-moduloNew-all').on('change', '#check-moduloNew-all', function(){
        var control = $(this);
        if( $('.check-moduloNew').length > 0 )
            $('.check-moduloNew').prop('checked', control.is(':checked')).change();
    });

    $(document).off('change', '.check-moduloNew').on('change', '.check-moduloNew', function(){
        var control = $(this);
        if( control.is(':checked') ){
            control.closest('.list-group-item').find('.sw-oblig').prop('disabled', false);
        }
        else{
            control.closest('.list-group-item').find('.sw-oblig')
                .prop('disabled', true)
                .prop('checked', false);

            control.closest('.list-group-item').find('.txt-oblig').removeClass('text-danger');
        }
    });

    $(document).off('change', '.sw-oblig').on('change', '.sw-oblig', function(){
        var control = $(this);
        if( control.is(':checked') )
            control.closest('.custom-switch').find('.txt-oblig').addClass('text-danger');
        else
            control.closest('.custom-switch').find('.txt-oblig').removeClass('text-danger');
    });

    $('#frm-moduloApp-config .slt-cuenta').select2({
            dropdownParent: $("#frm-moduloApp-config"),
            width: '100%',
            placeholder: "-- Cuenta --"
    });
    $('#frm-moduloApp-config .slt-aplicacion').select2({
        dropdownParent: $("#frm-moduloApp-config"),
        width: '100%',
        placeholder: "-- Aplicación --"
    });
    $('#frm-moduloApp-config .slt-tipoUsuario').select2({
        dropdownParent: $("#frm-moduloApp-config"),
        width: '100%',
        placeholder: "-- Tipo Usuario --"
    });
    $('#frm-moduloApp-config .slt-canal').select2({
        dropdownParent: $("#frm-moduloApp-config"),
        width: '100%',
        placeholder: "-- Canal --"
    });
        

</script>