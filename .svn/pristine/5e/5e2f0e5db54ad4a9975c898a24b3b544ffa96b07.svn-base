<?php
$num = 1;
$nameTextoAlternativa = 'textoAlternativa';
$estadoAlternativa = 'estadoAlternativa';
$select2 = "my_select2EditarAlternativas"; 
$checkFoto = "chkFoto";
?>
 

<form id="formEditarAlternativas">
    <input class='d-none' type='text' name='idPregunta' id="idPregunta" value='<?=$pregunta['idPregunta']?>'>

    <div class='form-row'>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 mb-2 ">
            <h6><i class="fa fa-question-circle"></i> Pregunta: <b><?=$pregunta['nombre']?></b></h6>
        </div>
        
    </div>
    <hr class="solid mb-2 mt-0">

    <div class="form-row mb-3">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class='table table-sm table-bordered text-nowrap'>
                    <thead class='thead-light'>
                        <tr>
                            <th class="text-center align-middle">
                                ACTUALIZAR
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-20">ALTERNATIVAS</div>
                            </th>
                            <th class="text-center align-middle">
                                <div>ESTADO</div>
                            </th>
                            <th class="text-center align-middle">
                                <div>FOTO</div>
                            </th>
                            <th class="text-center align-middle">
                                <button  class="btn btn-AgregarElemento btn-secondary" title="Agregar Elemento"><strong>AGREGAR FILA</strong> <i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='trPadre d-none' data-select2="<?= $select2 ?>" data-classmodal="<?=$class?>">
                            <td></td>

                            <td class="text-center" data-name='<?= $nameTextoAlternativa ?>'>
                                <input type="text" class="form-control form-control-sm" placeholder="Alternativa">
                            </td>
                            <td class="text-center" data-name='<?= $estadoAlternativa ?>'>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input uncheckableRadio" type="radio" value="true">
                                    <label class="form-check-label">Activar</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input uncheckableRadio" type="radio" value="false">
                                    <label class="form-check-label">Desactivar</label>
                                </div>
                            </td>
                            <td class="text-center" data-name='<?= $checkFoto ?>'>
                                <div class="form-check form-check-inline" style="margin-right: 0;">
                                    <input class="form-check-input" type="checkbox" value="true">
                                </div>
                            </td>
                            <td class="text-left">
                                <button style="left: 45%;" class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                            </td> 
                        </tr>

                        <?php
                        foreach ($data as $key => $row) { ?>
                            <tr class='trHijo table-secondary' data-fila="<?=$num?>">
                                <td class="text-center">
                                    <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row['idAlternativa'] ?>'>
                                    <button class="border-0 btn btn-EditarPreguntasHijo btn-outline-secondary" title="Editar Preguntas Hijo" disabled><i class="fa fa-list"></i></button>
                                </td>
                                <td class="text-center">
                                    <input value="<?=$row['nombre']?>" name='<?= $nameTextoAlternativa ?>-<?= $num ?>' id='<?= $nameTextoAlternativa ?>-<?= $num ?>' type="text" class="form-control form-control-sm" placeholder="textotest" disabled>
                                </td>
                                <td class="text-center">
                                    <div id='<?= $estadoAlternativa ?>-<?= $num ?>' class="form-check form-check-inline">
                                        <input name='<?= $estadoAlternativa ?>-<?= $num ?>' class="form-check-input uncheckableRadio" type="radio" value="true" disabled <?=$row['estado'] == 1 ? "Checked":'' ?>>
                                        <label class="form-check-label">Activar</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name='<?= $estadoAlternativa ?>-<?= $num ?>' class="form-check-input uncheckableRadio" type="radio" value="false" disabled <?=$row['estado'] != 1 ? "Checked":'' ?>>
                                        <label class="form-check-label">Desactivar</label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div id='<?= $checkFoto ?>-<?= $num ?>' class="form-check form-check-inline" style="margin-right: 0;">
                                        <input name='<?= $checkFoto ?>-<?= $num ?>' class="form-check-input" type="checkbox" value="1" disabled <?=$row['foto'] == 1 ? "Checked":'' ?> >
                                        <label class="form-check-label"></label>
                                    </div>
                                </td>
                                <td class="text-left" >
                                    <button style="left: 45%;" class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento" disabled><i class="fa fa-trash"></i></button>
                                </td>

                            </tr>
                        <?php $num++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</form>

<script>
    $('.<?= $select2 ?>').select2({
        dropdownParent: $("div.modal-content-<?= $class ?>"),
        width: '100%'
    });
</script>