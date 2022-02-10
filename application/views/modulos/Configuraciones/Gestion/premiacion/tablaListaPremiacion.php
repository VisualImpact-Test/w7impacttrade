
<div class="card-datatable">
    <table class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th></th>
                <th class="text-center">#</th>
                <th class="text-center">OPCIONES</th>
                <th class="text-center">COD LISTA</th>
                <th class="text-center">COD VISUAL</th>
                <th class="text-center">COD CLIENTE</th>
                <th class="text-center">CLIENTE</th>
                <th class="text-center">TIPO USUARIO</th>
                <th class="text-center">GRUPO CANAL</th>
                <th class="text-center">CANAL</th>
                <th class="text-center">PROYECTO</th>
                <th class="text-center" style="width: 500px !important">PREMIACIONES</th>
                <th class="text-center">FECHA INICIO</th>
                <th class="text-center">FECHA FIN</th>
                <th class="text-center">FECHA MODIFICACIÓN</th>
                <th class="text-center">ESTADO</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['premiacion'] as $row => $value) {
                $badge = $value['estado'] == 1 ? 'badge-success' : 'badge-danger';
                $mensajeEstado = $value['estado'] == 1 ? 'Activo' : 'Inactivo';
                $iconoBotonEstado = $value['estado'] == 1 ? 'fal fa-lg fa-toggle-on' : 'fal fa-lg fa-toggle-off';
            ?>
                <tr data-id="<?= $value['idListPremiacion'] ?>" data-estado="<?= $value['estado'] ?>">
                    <td></td>
                    <td></td>
                    <td>
                        <div>
                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-lg fa-edit"></i></button>
                            <!--<button class="btn btn-CambiarEstado btn-outline-secondary border-0" title="Activar/Desactivar"><i class="<?= $iconoBotonEstado ?>"></i></button>-->
                        </div>
                    </td>
                    <td><?= !empty($value['idListPremiacion']) ? $value['idListPremiacion'] : '-' ?></td>
                    <td><?= !empty($value['idCliente']) ? $value['idCliente'] : '-' ?></td>
                    <td><?= !empty($value['codCliente']) ? $value['codCliente'] : '-' ?></td>
                    <td><?= !empty($value['razonSocial']) ? $value['razonSocial'] : verificarEmpty($value['nombreComercial'],3) ?></td>
                    <td><?= !empty($value['tipo']) ? $value['tipo'] : '-' ?></td>
                    <td><?= !empty($value['grupoCanal']) ? $value['grupoCanal'] : '-' ?></td>
                    <td><?= !empty($value['canal']) ? $value['canal'] : '-' ?></td>
                    <td><?= !empty($value['proyecto']) ? $value['proyecto'] : '-' ?></td>
                    <td class=" text-truncate" style="width: 200px;white-space: initial;"><?=isset($data['premiacionDet'][$value['idListPremiacion']])?implode(',',$data['premiacionDet'][$value['idListPremiacion']]):'-';?> </td>
                    <td data-order="<?= $value['fecIni'] ?>"><?= !empty($value['fecIni']) ? $value['fecIni']  : '-' ?></td>
                    <td data-order="<?= $value['fecFin'] ?>"><?= !empty($value['fecFin']) ? $value['fecFin']  : '-' ?></td>
                    <td data-order="<?= $value['fechaModificacion'] ?>"><?= !empty($value['fechaModificacion']) ? $value['fechaModificacion'] : '-' ?></td>
                    <td data-order="<?= $mensajeEstado ?>" class="style-icons">
                        <span class="badge <?= $badge ?>"><?= $mensajeEstado ?></span>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
