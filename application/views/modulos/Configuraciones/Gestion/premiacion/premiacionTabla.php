<div class="card-datatable">
    <table class="table table-striped table-bordered nowrap" width="100%">
        <thead>
            <tr>
                <th class="text-center">OPCIONES</th>
                <th class="text-center">NOMBRE</th>
                <th class="text-center">FECHA INICIO</th>
                <th class="text-center">FECHA FIN</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultados as $value) {

            ?>
                <tr data-id="<?= $value['idPremiacion'] ?>" >
                    <td>
                        <div>
                            <button class="btn btn-Editar btn-outline-secondary border-0" title="Editar"><i class="fas fa-lg fa-edit"></i></button>
                        </div>
                    </td>
                    <td><?= !empty($value['nombre']) ? $value['nombre'] : '-' ?></td>
                    <td><?= !empty($value['fechaInicio']) ? $value['fechaInicio'] : '-' ?></td>
                    <td><?= !empty($value['fechaCaducidad']) ? $value['fechaCaducidad'] : '-' ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>