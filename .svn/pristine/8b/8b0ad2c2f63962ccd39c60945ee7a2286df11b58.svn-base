<style>
span.select2{
    width: 94% !important;
}
.input-group-btn{
    width: 5% !important;
}
</style>
<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
        <input type="hidden" name="sl_cuenta" id="sl_cuenta" value="3">
        <input type="hidden" name="sl_proyecto" id="sl_proyecto" value="3">
            <!-- <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'> -->
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
        <label for='sl_tipoCliente'>Tipo Cliente</label><br>    
            <select class="my_select2_modal form-control" name="sl_tipoCliente" id="sl_tipoCliente">
                <?=htmlSelectOptionArray($tiposCliente)?>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
        <label for='sl_tipoAuditoria'>Tipo Auditoría</label><br>    
            <select class="my_select2_modal form-control" name="sl_tipoAuditoria" id="sl_tipoAuditoria">
                <?=htmlSelectOptionArray($tiposAuditoria)?>
            </select>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha de Inicio</label><br>
            <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFin'>Fecha de Fin</label><br>
            <input id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin'>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='materialesExt' class="matExtVar">Lista Materiales</label><br>
            <div class="input-group">
            <select class=" my_select2_modal form-control" name="materialesExt" id="materialesExt">
                <?=htmlSelectOptionArray($materiales)?>
            </select>
            <span class="input-group-btn">
                <button class="btn btn-primary btn-addMatExt fas fa-plus" type="button"></button>
            </span>
            </div>

        </div>

        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <table class="mb-0 table table-bordered no-footer w-100 text-nowrap">
                <thead class="thead-light"> 
                    <tr>
                        <th class="text-center" style="width: 20%;">#</th>
                        <th class="text-center matExtVar" style="width: 80%;">MATERIAL</th>
                        <th class="text-center " style="width: 80%;">ELIMINAR</th>

                    </tr>
                </thead>
                <tbody id="tbodyMateriales">

                </tbody>
            </table>
        </div>
    </div>

</form>
<script>
    Gestorx.matEnTabla = [];
    $('.my_select2_modal').select2({
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

    $('#sl_tipoAuditoria').on("change", function (e) {
            e.preventDefault();
			var data = { 'id': $(this).val() };
			var serialize = Fn.formSerializeObject(Gestion.idFormSeccionActivo);
			Object.assign(data, serialize);

			var jsonString = { 'data': JSON.stringify(data) };

			var config = { 'url': Gestion.urlActivo + 'getMatExtByTipoAud', 'data': jsonString };

			$.when(Fn.ajax(config)).then(function (a) {

				if (a.result === 2) return false;

                $('th.matExtVar').text($('#sl_tipoAuditoria :selected').text().toUpperCase());
                $('label.matExtVar').text('Lista ' + $('#sl_tipoAuditoria :selected').text());

                $('#tbodyMateriales').html('');
                Gestorx.matEnTabla = [];
                $('#materialesExt').html(a.data.materiales);
        });
    });
    $('.btn-addMatExt').on("click", function (e) {
        
        let idMatExt = $('#materialesExt').val();
        if(idMatExt != ''){

            
            let matExt =  $('#materialesExt :selected').text();
            
            if($.inArray(Number(idMatExt),Gestorx.matEnTabla) >=0) {
                return false;
            }
            // return false;
            
            let html = '<tr>';
                html += '<td class="text-center">'+Fn.generarCorrelativo(idMatExt,6)+'<input type="hidden" name="idMaterial" value="'+idMatExt+'"></td>'
                html += '<td>'+matExt+'<input type="hidden" name="material" value="'+matExt+'"></td>'
                html += '<td class="text-center"><btn class="btn btn-danger fas fa-trash  btn-borrarfila" data-idMat = "'+idMatExt+'"></btn></td>'
                html += '</tr>';

            $('#tbodyMateriales').prepend(html);
            Gestorx.matEnTabla.push(Number(idMatExt));
        }
    });
    $(document).on("click",'.btn-borrarfila', function (e) {
        $(this).parents('tr').remove();
        
        Gestorx.matEnTabla = [];
        $.each($('.btn-borrarfila'),function(i,v){

            let idMatExt = ($(this).data('idmat'));

            Gestorx.matEnTabla.push(Number(idMatExt));
        });
    });
</script>
