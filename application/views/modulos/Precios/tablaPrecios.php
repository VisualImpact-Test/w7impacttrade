<div class="card-datatable">
    <table id="tablaVisitasPrecios" class="mb-0 table table-bordered text-nowrap" style="width:100%;">
        <thead>
            <tr>
                <th class="text-center noVis">#</th>
                <th class="text-center">GRUPO CANAL</th>
                <th class="text-center">CANAL</th>
                <th class="text-center hideCol">SUB CANAL</th>

                <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                    <th class="text-center"><?= strtoupper($v['header']) ?></th>
                <? } ?>

                <th class="text-center">COD VISUAL</th>
				<th class="text-center hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
				<th class="text-center hideCol">COD PDV</th>
				<th class="text-center">PDV</th>
				<th class="text-center">TIPO CLIENTE</th>

                <th class="text-center">COD USUARIO</th>
                <th class="text-center">PERFIL USUARIO</th>
                <th class="text-center">NOMBRE<br />USUARIO</th>

                <th class="text-center hideCol">DEPARTAMENTO</th>
                <th class="text-center hideCol">PROVINCIA</th>
                <th class="text-center hideCol">DISTRITO</th>

                <th class="text-center">CATEGORÍA</th>
                <th class="text-center">MARCA</th>
                <th class="text-center">COD PRODUCTO</th>
                <th class="text-center">PRODUCTO</th>
                <th class="text-center">PRECIO</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>