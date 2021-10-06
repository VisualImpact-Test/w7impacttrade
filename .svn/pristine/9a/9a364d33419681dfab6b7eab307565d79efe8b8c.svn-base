<?php
$num = 1;
$select2 = "my_select2EditarPreguntaHijo"; 
$pregunta="id";
?>
 

<form id="formEditarPreguntaHijo">
    <input class='d-none' type='text' name='idAlternativa' id="idAlternativa" value='<?=$alternativa['idAlternativa']?>'>

    <div class='form-row'>
        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11 mb-2 ">
            <h6><i class="fa fa-question-circle"></i> Altenativa: <b><?=$alternativa['nombre']?></b></h6>
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
                                <div class="wr-20">PREGUNTA HIJO</div>
                            </th>
                            <th class="text-center align-middle">
                                <button  class="btn btn-AgregarElemento btn-secondary" title="Agregar Elemento"><strong>AGREGAR FILA</strong> <i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='trPadre d-none' data-select2="<?= $select2 ?>" data-classmodal="<?=$class?>">
                            <td></td>

                            <td class="text-center">
                                <select class='form-control form-control-sm my_select2' name="idPregunta" disabled>
                                    <?php foreach ($preguntas as $idPregunta => $pre) { ?>
                                            <option value='<?= $pre['idPregunta'] ?>'><?= $pre['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            
                            <td class="text-left">
                                <button style="left: 45%;" class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                            </td> 
                        </tr>

                        <?php
                        foreach ($data as $key => $row) { ?>
                            <tr class='trHijo table-secondary' data-fila="<?=$num?>">
                                <td class="text-center">
                                    <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row['idPregunta'] ?>'>
                                </td>
                              
                                <td class="text-center" data-name='<?= $pregunta ?>'>
                                    <select class='form-control form-control-sm my_select2' disabled="disabled" name="idPregunta">
                                        <?php foreach ($preguntas as $idPregunta => $pre) { ?>
                                                <option value='<?= $pre['idPregunta'] ?>' <?= isset($row['idPregunta']) ? ( $row['idPregunta']==$pre['idPregunta'] ? "selected" : "" ) : '' ?> ><?= $pre['nombre'] ?></option>
                                        <?php } ?>
                                    </select>
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