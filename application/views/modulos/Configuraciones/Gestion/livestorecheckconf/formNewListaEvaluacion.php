<style>
/* span.select2{
    width: 94% !important;
}
.input-group-btn{
    width: 5% !important;
} */
</style>
<form id="formNew">
    <div class='form-row'>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
        <input type="hidden" name="sl_cuenta" id="sl_cuenta" value="3">
        <input type="hidden" name="sl_proyecto" id="sl_proyecto" value="3">
            <!-- <label for='nombre'>Nombre</label><br>
            <input id='nombre' name='nombre' type='text' class='form-control form-control-sm' placeholder='Nombre'> -->
        </div>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <label for='sl_tipoAuditoria'>Tipo Auditoría</label><br>    
            <select class="my_select2_modal form-control" name="sl_tipoAuditoria" id="sl_tipoAuditoria">
                <?=htmlSelectOptionArray($tiposAuditoria)?>
            </select>
        </div>
        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2 d-none sl_tipoCliente'>
        <label  for='sl_tipoCliente'>Tipo Cliente</label><br>    
            <select class="my_select2_modal form-control" name="sl_tipoCliente" id="sl_tipoCliente">
                <?=htmlSelectOptionArray($tiposCliente)?>
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
        <div class='col-xs-5 col-sm-5 col-md-5 col-lg-5 mb-2'>
            <label for='evalDet' class="tablaDetalle">Lista de Evaluaciones</label><br>
            <select class="my_select2_modal form-control" name="evalDet" id="evalDet">
                <?=htmlSelectOptionArray($evaluaciones)?>
            </select>
     
        </div>
        <div class='col-xs-5 col-sm-5 col-md-5 col-lg-5 mb-2'>
            <label for='encuesta' class="tablaDetalle">Formato de Preguntas</label><br>
            <select class="my_select2_modal form-control" name="encuesta" id="encuesta">
                <?=htmlSelectOptionArray($encuestas)?>
            </select>
        </div>
        <div class='col-xs-2 col-sm-1 col-md-2 col-lg-2 mb-2'>
            <label for='button' class="tablaDetalle">⠀</label><br>
            <span class="input-group-btn">
                <button class="btn btn-primary btn-addEvalDet fas fa-plus" type="button"></button>
            </span>

        </div>

        <div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2'>
            <div style="width:100%; height:300px; overflow:auto;">
                <table class="mb-0 table table-bordered no-footer w-100 text-nowrap">
                    <thead class="thead-light"> 
                        <tr>
                            <th class="text-center" style="width: 15%;">#</th>
                            <th class="text-center " style="width: 40%;">EVALUACIÓN</th>
                            <th class="text-center " style="width: 40%;">FORMATO DE PREGUNTAS</th>
                            <th class="text-center " style="width: 5%;">ELIMINAR</th>

                        </tr>
                    </thead>
                    <tbody id="tbodyTablaDetalle">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</form>
<script>
    Gestorx.matEnTabla = [];
    Gestorx.encEnTabla = [];
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
        
                if($(this).val() == '2'){
                    $('#formNew div.sl_tipoCliente').removeClass('d-none');
                }else{
                    $('#formNew div.sl_tipoCliente').addClass('d-none');
                }
                $('#tbodyTablaDetalle').html('');
                Gestorx.matEnTabla = [];
                Gestorx.encEnTabla = [];
    });
    $('.btn-addEvalDet').on("click", function (e) {

        if($('#sl_tipoAuditoria').val() == ''){
            let config = {};
            ++modalId;
            let message = Fn.message({type:'2',message:'Asegurate de Seleccionar el tipo Auditoria'});

            var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
            var btn = [];
            btn[0] = { title: 'Cerrar', fn: fn };

            Fn.showModal({ id: modalId, show: true, title: 'Alerta', content: message, btn: btn});

            return false;
        };
        let idEvaluacion = $('#evalDet').val();
        if(idEvaluacion != ''){
            let idEncuesta = $('#encuesta').val();
            if($('#sl_tipoAuditoria').val() == '2' && idEncuesta == ''){
                let config = {};
                ++modalId;
                let message = Fn.message({type:'2',message:'La Lista de evaluación para Clientes necesita establecer el tipo Encuesta'});

                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };
                Fn.showModal({ id: modalId, show: true, title: 'Alerta', content: message, btn: btn});
                return false;
            }
            
            let evaluacion =  $('#evalDet :selected').text();
            let encuesta =  '';
            if(idEncuesta != ''){
                encuesta = $('#encuesta :selected').text();

            }else{
                encuesta = '';
            }

            
            if($.inArray(Number(idEvaluacion),Gestorx.matEnTabla) >=0) {
                let config = {};
                ++modalId;
                let message = Fn.message({type:'2',message:'Ya existe un registro igual en la tabla'});

                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };

                Fn.showModal({ id: modalId, show: true, title: 'Alerta', content: message, btn: btn});

                return false;
            }
            if($.inArray(Number(idEncuesta),Gestorx.encEnTabla) >=0) {
                let config = {};
                ++modalId;
                let message = Fn.message({type:'2',message:'Ya existe un registro igual en la tabla'});

                var fn = 'Fn.showModal({ id:' + modalId + ',show:false });';
                var btn = [];
                btn[0] = { title: 'Cerrar', fn: fn };

                Fn.showModal({ id: modalId, show: true, title: 'Alerta', content: message, btn: btn});

                return false;
            }
            // return false;
            
            let html = '<tr>';
                html += '<td class="text-center">'+Fn.generarCorrelativo(idEvaluacion,6)+'<input type="hidden" name="idMaterial" value="'+idEvaluacion+'"></td>'
                html += '<td>'+evaluacion+'<input type="hidden" name="idEvaluacion" value="'+idEvaluacion+'"></td>'
                html += '<td>'+encuesta+'<input type="hidden" name="idEncuesta" value="'+idEncuesta+'"></td>'
                html += '<td class="text-center"><btn class="btn btn-danger fas fa-trash  btn-borrarfila" data-idMat = "'+idEvaluacion+'" data-idenc = "'+idEncuesta+'"></btn></td>'
                html += '</tr>';

            $('#tbodyTablaDetalle').prepend(html);
            Gestorx.matEnTabla.push(Number(idEvaluacion));
            if(idEncuesta != ''){
                Gestorx.encEnTabla.push(Number(idEncuesta));
            }
        }
    });
    $(document).on("click",'.btn-borrarfila', function (e) {
        $(this).parents('tr').remove();
        
        Gestorx.matEnTabla = [];
        Gestorx.encEnTabla = [];
        $.each($('.btn-borrarfila'),function(i,v){

            let idEvaluacion = ($(this).data('idmat'));
            let idEncuesta = ($(this).data('idenc'));

            Gestorx.matEnTabla.push(Number(idEvaluacion));
            Gestorx.encEnTabla.push(Number(idEncuesta));
        });
    });
</script>
