<div class="card-datatable">
    <table id="tablaDetalladoEncuesta" class="table table-striped table-bordered nowrap" style="font-size:12px;width:100%">
        <thead>
            <tr>
                <th class="text-center align-middle noVis">#</th>
                <th class="text-center align-middle">FECHA</th>
                <th class="text-center align-middle">PERFIL USUARIO</th>
                <th class="text-center align-middle">COD USUARIO</th>
                <th class="text-center align-middle">NOMBRE USUARIO</th>
                <th class="text-center align-middle">GRUPO CANAL</th>
                <th class="text-center align-middle">CANAL</th>
                <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <th class="text-center align-middle"><?= strtoupper($v['header']) ?></th>
                <? } ?>
                <th class="text-center align-middle">COD VISUAL</th>
                <th class="text-center align-middle hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
                <th class="text-center align-middle hideCol">COD PDV</th>
                <th class="text-center align-middle">PDV</th>
                <th class="text-center align-middle">TIPO CLIENTE</th>
                <th class="text-center align-middle">INCIDENCIA</th>
                <th class="text-center align-middle">ENCUESTA</th>
                <th class="text-center align-middle">TIPO PREGUNTA</th>
                <th class="text-center align-middle">PREGUNTA</th>
                <th class="text-center align-middle">RESPUESTA</th>
                <th class="text-center align-middle">VALORACIÓN</th>
                <th class="text-center align-middle">COMENTARIO</th>
            </tr>
        </thead>

    </table>
</div>