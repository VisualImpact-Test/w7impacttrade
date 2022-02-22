<form id="formUpdate">
    <input class="d-none" type="text" name="idlst" value="<?//= $data[$this->model->tablas['lista']['id']] ?>">
    <div class='form-row'>
                <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
                    <label for='canal'>Canal</label><br>
                     <select id='canal' name='canal' class='form-control form-control-sm my_select2 canal_cliente'>
                    <?php if (!empty($data['idCanal'])) { ?>
                        <option value='<?= $data['idCanal'] ?>' selected><?= $data['canal'] ?></option>
                    <?php } ?>
                    <?php foreach ($canales as $idCanal => $canal) { ?>
                        <?php if ($data['idCanal'] != $canal['idCanal']) { ?>
                            <option value='<?= $canal['idCanal'] ?>'><?= $canal['nombre'] ?></option>
                        <?php } ?>
                    <?php } ?>
                    </select>
                </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='proyecto'>Proyecto</label><br>
            <select id='proyecto' name='proyecto' class='form-control form-control-sm my_select2'>
                    <?php if (!empty($data['idProyecto'])) { ?>
                        <option value='<?= $data['idProyecto'] ?>' selected><?= $data['proyecto'] ?></option>
                    <?php } ?>
                <?php foreach ($proyectos as $idProyecto => $proyecto) { ?>
                    <?php if ($data['idProyecto'] != $proyecto['idProyecto']) { ?>
                    <option value='<?= $proyecto['idProyecto'] ?>'><?= $proyecto['nombre'] ?></option>
                    <?php } ?>

                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaInicio'>Fecha Inicio</label><br>
            <input id='fechaInicio' name='fechaInicio' type='text' class='form-control form-control-sm' placeholder='Fecha Inicio'>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label for='fechaFin'>Fecha Fin</label><br>
            <input id='fechaFin' name='fechaFin' type='text' class='form-control form-control-sm' placeholder='Fecha Fin'>
        </div>
    </div>
    <div class='form-row'>
        <div class='col-xs-5 col-sm-5 col-md-5 col-lg-5 mb-2'>
            <label for='marca'>Marcas</label><br>
                <select id='marca' name='marca' class='form-control form-control-sm my_select2'>
                                    <option value=''>-- Seleccionar --</option>
                                    <?php foreach ($marcas as $idMarca => $marca) { ?>
                                        <option value='<?= $marca['idMarca'] ?>'><?= $marca['nombre'] ?></option>
                                    <?php } ?>
                </select>
        </div>
        <div class='col-xs-2 col-sm-2 col-md-2 col-lg-2 mb-2'  >
        <label for="">Agregar</label>
                                <i id="btn-agregar-elemento-lista" type="button" class="fas fa-plus btn-agregar-elemento-lista form-control btn btn-primary" style="
                                        height: 30px;
                                        left: 5%;
                                        padding-top: 8px;
                                    ">ADD</i>
        </div>

    </div>
    
    <div class="form-row">
        <table id="tabla_elemento_lista" class="widget-content table-responsive table-content" style="overflow-y: scroll;max-height:150px;">
                <thead>
                    <th></th>
                    <th>CATEGORIA</th>
                    <th>MARCA</th>
                </thead>
                <tbody>
                    <?foreach($lista_elementos as $row){?>
                    <tr id='fila_temporal_encuesta'>
                        <td><i class="fas fa-trash" id="eliminar_fila_elemento"></i></td>
                        <td><input  readonly='readonly' style='border:none;' class ='form-control' id='elemento_<?=$row[$this->mode->tablas['lista']['id']]?>' name='elemento_<?=$row[$this->mode->tablas['lista']['id']]?>' value='<?=$row['nombre']?>'></td>
                        <td><input  readonly='readonly' style='border:none;' class ='form-control' id='marca_<?=$row[$this->mode->tablas['marca']['id']]?>' name='marca_<?=$row[$this->mode->tablas['marca']['id']]?>' value='<?=$row['marca']?>'></td>
                    </tr>    
                    <?}?>
                    
                </tbody>
    
        </table>
    </div>
</form>



<script>

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
    $('.my_select2').select2({
        dropdownParent: $("div.modal-content"),
        width: '100%'
    });

    // var checkList = document.getElementById('listEncuestas');
    //     checkList.getElementsByClassName('anchor')[0].onclick = function (evt) {
    //         if (checkList.classList.contains('visible'))
    //             checkList.classList.remove('visible');
    //         else
    //             checkList.classList.add('visible');
    // }
    // // Todo esto para los dos primeros selects juntos
    // $('#fecIni').daterangepicker(singleDatePickerModal);
    // $('#fecFin').daterangepicker($.extend({
    //     "autoUpdateInput": false,
    // }, singleDatePickerModal));
    // $('#fecIni').on('apply.daterangepicker', function(ev, picker) {
    //     $('#fecFin').val('');
    // });
    // $('#fecFin').on('apply.daterangepicker', function(ev, picker) {
    //     $.fechaLimite(picker, "#fecFin", "#fecIni");
    // });

    // // Todo esto para los dos segundos selects juntos
    // $('#fecIni2').daterangepicker(singleDatePickerModal);
    // $('#fecFin2').daterangepicker($.extend({
    //     "autoUpdateInput": false,
    // }, singleDatePickerModal));
    // $('#fecIni2').on('apply.daterangepicker', function(ev, picker) {
    //     $('#fecFin2').val('');
    // });
    // $('#fecFin2').on('apply.daterangepicker', function(ev, picker) {
    //     $.fechaLimite(picker, "#fecFin2", "#fecIni2");
    // });

    // // Esto para poner el modal como parent para los select2
    // $('.my_select2').select2({
    //     dropdownParent: $("div.modal-content"),
    //     width: '100%'
    // });
</script>