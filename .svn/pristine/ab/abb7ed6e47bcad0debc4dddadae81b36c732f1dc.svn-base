<?php
$num = 1;
$nameCadena = 'cadena';
$nameBanner = 'banner';
$select2 = "my_select2EditarHistorico"; ?>

<form id="formEditarHistorico">
    <input class='d-none' type='text' name='menu' value='<?=$menu?>'>
    <input class='d-none' type='text' name='idUsuarioHistorico' value='<?=$idUsuarioHistorico?>'>

    <div class='form-row'>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <h6><i class="fa fa-pencil-square-o"></i> Banners:</h6>
            <hr class="solid mb-2 mt-0">
        </div>
    </div>

    <div class="form-row mb-3">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="overflow-auto hr-15">
                <table class='table table-sm table-bordered text-nowrap'>
                    <thead class='thead-light'>
                        <tr>
                            <th class="text-center align-middle">
                                ACTUALIZAR
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-10">CADENA</div>
                            </th>
                            <th class="text-center align-middle">
                                <div class="wr-10">BANNER</div>
                            </th>
                            <th class="text-center align-middle">
                                <button class="btn btn-AgregarElemento btn-secondary" title="Agregar Elemento"><strong>AGREGAR FILA</strong> <i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class='trPadre d-none' data-select2="<?= $select2 ?>" data-classmodal="<?=$class?>">
                            <td></td>
                            <td class="text-center" data-name='<?= $nameCadena ?>'>
                                <select class='form-control form-control-sm'>
                                    <option value=''>-- Seleccionar --</option>
                                    <?php foreach ($cadenas as $key => $row) { ?>
                                        <option value='<?= $row['idCadena'] ?>'><?= $row['nombreCadena'] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="text-center" data-name='<?= $nameBanner ?>'>
                                <select class='form-control form-control-sm'>
                                    <option value=''>-- Seleccionar --</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <button class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>

                        <?php
                        foreach ($bannersDeHistorico as $key => $row) { ?>
                            <tr class='trHijo table-secondary' data-fila="<?=$num?>">
                                <td class="text-center">
                                    <input name='id-<?= $num ?>' class="chk-ActualizarElemento" type="checkbox" value='<?= $row['idUsuarioHistBanner'] ?>'>
                                </td>
                                <td class="text-center">
                                    <select name='<?= $nameCadena ?>-<?= $num ?>' id='<?= $nameCadena ?>-<?= $num ?>' class='form-control form-control-sm <?= $select2 ?>' disabled>
                                        <option value=''>-- Seleccionar --</option>
                                        <?php
                                        $cadenaSeleccionada = ['idCadena' =>  $row['idCadena'], 'nombreCadena' => $row['cadena']];
                                        agregarSiNoEsta($cadenaSeleccionada, $cadenas);
                                        foreach ($cadenas as $cadena) {
                                            $stringSelected = ($cadena['idCadena'] == $row['idCadena']) ? 'selected' : ''; ?>
                                            <option value='<?= $cadena['idCadena'] ?>' <?= $stringSelected ?>><?= $cadena['nombreCadena'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>

                                <td class="text-center">
                                    <select name='<?= $nameBanner ?>-<?= $num ?>' id='<?= $nameBanner ?>-<?= $num ?>' class='form-control form-control-sm <?= $select2 ?>' disabled>
                                        <option value=''>-- Seleccionar --</option>
                                        <?php
                                        $bannerSeleccionado = ['idBanner' =>  $row['idBanner'], 'nombreBanner' => $row['banner']];
                                        agregarSiNoEsta($bannerSeleccionado, $banners[$row['idCadena']]);
                                        foreach ($banners[$row['idCadena']] as $banner) {
                                            $stringSelected = ($banner['idBanner'] == $row['idBanner']) ? 'selected' : ''; ?>
                                            <option value='<?= $banner['idBanner'] ?>' <?= $stringSelected ?>><?= $banner['nombreBanner'] ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button class="border-0 btn btn-BorrarElemento btn-outline-secondary" title="Eliminar Elemento" disabled><i class="fa fa-trash"></i></button>
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
    var banners = <?= json_encode($banners) ?>;
    $('.<?= $select2 ?>').select2({
        dropdownParent: $("div.modal-content-<?= $class ?>"),
        width: '100%'
    });
</script>