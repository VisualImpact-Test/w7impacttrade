<style>
.tableFixHead          { overflow-y: auto; height: 100px; }
.tableFixHead thead th { position: sticky; top: 0;padding: 8px 16px }
.tableFixHead tbody tr td { padding: 8px 16px }

table  { border-collapse: collapse; width: 100%; }
th     { background:#eee; }
</style>

<?php
$num = 1;
$nameSelectElemento= 'elemento_motivo';
$select2 = "my_select2AgregarElemento"; 
$class = "modalUpdateMotivo";
?>
<form id="formUpdateIniciativaElementoMotivo">
    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label >Iniciativa</label>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <input type="hidden" name="idIniciativa" value="<?= !empty($iniciativa['idIniciativa']) ? $iniciativa['idIniciativa'] :''  ?>">
            <label id="lblIniciativaActual"><?= !empty($iniciativa['nombre']) ? $iniciativa['nombre'] :''  ?></label>
        </div>
    </div>

    <div class='form-row'>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <label >Elemento</label>
        </div>
        <div class='col-xs-6 col-sm-6 col-md-6 col-lg-6 mb-2'>
            <input type="hidden" name="idElementoVis" value="<?= !empty($elemento['idElementoVis']) ? $elemento['idElementoVis'] :''  ?> ">
            <label id="lblElementoActual"><?= !empty($elemento['nombre']) ? $elemento['nombre'] :''  ?> </label>
        </div>
    </div>

    <div class="form-row mb-3">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-wrapper-scroll-y my-custom-scrollbar">
                <table class='table-Success table-sm table-bordered text-nowrap tableFixHead'>
                    <div>
                        <thead class='thead-dark'>
                            <tr>
                                <th class="text-center align-middle">
                                    ACTUALIZAR
                                </th>
                                <th class="text-center align-middle">
                                    <div class="wr-20">MOTIVO</div>
                                </th>
                                <div>
                                    <th class="text-center align-middle">
                                        <button  class="btn btn-AgregarElemento btn-primary" title="Agregar Elemento"><strong>AGREGAR FILA</strong> <i class="fa fa-plus"></i></button>
                                    </th>
                                </div>
                            </tr>
                        </thead>
                    </div>
                    <div>
                        <tbody>
                            <tr class='trPadre d-none' data-select2="<?= $select2 ?>" data-classmodal="<?=$class?>">
                                <td></td>
                                <td class="text-center">
                                    <select class='form-control form-control-sm elemento'  name="motivo_seleccion" >
                                        <option value=''>-- Seleccionar --</option>
                                        <?php foreach ($motivos as $idElemento => $motivo) { ?>
                                            <option value='<?= $motivo['idEstadoIniciativa']?>'><?= $motivo['nombre']?></option>
                                        <?php } ?>
                                    </select>
                                </td>

                                <td class="text-left">
                                    <div style="padding-left: 45%;">
                                        <button  class="border-0 btn-BorrarElemento btn-outline-secondary" title="Eliminar Motivo"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td> 
                            </tr>

                            <?php
                            if(isset($elementos_motivos)){
                                foreach ($elementos_motivos as $row) { ?>
                                    <tr class='trHijo table-secondary' data-fila="<?=$num?>">
                                        <td class="text-center">
                                            <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row['idEstadoIniciativa'] ?>'>
                                        </td>
                                        <td class="text-center">
                                            <input value="<?=$row['nombre']?>" type="text" class="form-control form-control-sm" placeholder="textotest" disabled readonly="readonly">
                                        </td>
                                        
                                        <td class="text-left" >
                                            <div style="padding-left: 45%;">
                                                <button  class="border-0   btn-BorrarElemento btn-outline-secondary" title="Eliminar Motivo" disabled><i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>

                                    </tr>
                                <?php $num++;
                                    } 
                            }
                            ?>
                        </tbody>
                    </div>
                </table>
            </div>
        </div>
    </div>
</form>
