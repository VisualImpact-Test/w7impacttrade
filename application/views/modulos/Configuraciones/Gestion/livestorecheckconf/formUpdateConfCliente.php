<form id="formUpdate">
    <div class='form-row'>
    <input class="d-none" type="text" name="idx" value="<?= $data[$this->model->tablas['confCliente']['id']] ?>">
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <input type="hidden" name="sl_cuenta" id="sl_cuenta" value="3">
            <input type="hidden" name="sl_proyecto" id="sl_proyecto" value="3">
            <label for='sl_plazas'>Plazas</label><br>    
            <select class="my_select2 form-control" name="sl_plazas" id="sl_plazas">
                    <?=htmlSelectOptionArray($plazas,$data['idPlaza'])?>
            </select>
            
            <!-- <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'> -->
        </div>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='sl_clientes'>Clientes</label><br>    
            <select class="my_select2 form-control" name="sl_clientes" id="sl_clientes">
                    <?=htmlSelectOptionArray($clientes,$data['idCliente'])?>
            </select>
            
            <!-- <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'> -->
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
        <label for='sl_tipoCliente'>Tipo Cliente</label><br>    
            <select class="my_select2 form-control" name="sl_tipoCliente" id="sl_tipoCliente">
                <?=htmlSelectOptionArray($tiposCliente,$data['idTipoCliente'])?>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha de Inicio</label><br>
            <input value="<?=!empty($data['fecIni'])? date_change_format($data['fecIni']): ''?>" id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFin'>Fecha de Fin</label><br>
            <input value="<?=!empty($data['fecFin'])? date_change_format($data['fecFin']): ''?>" id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin'>
        </div>
 
    </div>

</form>
<script>
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });
    $('#fechaInicio').daterangepicker(singleDatePickerModal);
    $('#fechaFin').daterangepicker($.extend({
        "autoUpdateInput": false,
    }, singleDatePickerModal));
    $('#fechaInicio').on('apply.daterangepicker', function(ev, picker) {
        $('#fechaFin').val('');
    });
    $('#fechaFin').on('apply.daterangepicker', function(ev, picker) {
        $.fechaLimite(picker, "#fechaFin", "#fechaInicio");
    });
    $('#sl_plazas').on('change',function(){
        if($(this).val()!= ''){
			var data = { 'id': $(this).val() };
			var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
			Object.assign(data, serialize);

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + 'getClientesByPlaza', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

                $('#sl_clientes').html(a.data.clientes);
                $('#codCliente').val('');
            });
        };
    });
</script>
