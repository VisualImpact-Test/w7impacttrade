<div class="card-datatable">
    <table id="tablaDetalladoEncuesta" class="table table-striped table-bordered nowrap w-100" style="font-size:12px;">
        <thead>
            <tr>
                <th rowspan="3" class="noVis text-center">#</th>
                <th class="text-center" rowspan="3">HABILITAR PDF<br><input type="checkbox" id="chkb-habilitarTodos" name="chkb-habilitarTodos" class="habilitarTodos"></th>
                <th rowspan="3" class="text-center">FECHA</th>
                <th rowspan="3" class="text-center">GRUPO CANAL</th>
                <th rowspan="3" class="text-center">CANAL</th>
                <th rowspan="3" class="text-center ">SUBCANAL</th>
                <?
                if (!empty($segmentacion['headers'])) {
                    foreach ($segmentacion['headers'] as $k => $v) { ?>
                        <th rowspan="3" class="text-center"><?= strtoupper($v['header']) ?></th>
                <? }
                } ?>
                <th rowspan="3" class="text-center">COD VISUAL</th>
                <th rowspan="3" class="text-center ">COD <?= $this->sessNomCuentaCorto ?></th>
                <th rowspan="3" class="text-center ">COD PDV</th>
                <th rowspan="3" class="text-center">PDV</th>
                <th rowspan="3" class="text-center">TIPO CLIENTE</th>
                <th rowspan="3" class="text-center ">DEPARTAMENTO</th>
                <th rowspan="3" class="text-center ">PROVINCIA</th>
                <th rowspan="3" class="text-center ">DISTRITO</th>
                <th rowspan="3" class="text-center">COD <br />USUARIO</th>
                <th rowspan="3" class="text-center">PERFIL USUARIO</th>
                <th rowspan="3" class="text-center">NOMBRE USUARIO</th>
                <th rowspan="3" class="text-center">INCIDENCIA</th>
                <th rowspan="3" class="text-center">ENCUESTADO</th>
                <? foreach ($listaEncuesta as $keyEncuesta => $encuesta) { ?>
                    <?
                    $cant_col_preg = count($listaPregunta[$keyEncuesta]) * 4;
                    $cant_col_preg_op = !empty($listaOpciones[$keyEncuesta]['opciones']) ? count($listaOpciones[$keyEncuesta]['opciones'])  : 0;
                    ?>
                    <th rowspan="1" class="text-center" colspan="<?= ($cant_col_preg + $cant_col_preg_op) ?>"><?= !empty($encuesta["nombre"]) ? (($encuesta["nombre"])): '-'  ?></th>
                    <th rowspan="3" class="text-center">FOTO(S) <br> ENCUESTA</th>
                <? }              
                ?>
            </tr>
            <tr>
                <? foreach ($listaEncuesta as $keyEncuesta => $encuesta) {
                    foreach ($listaPregunta[$keyEncuesta] as $keyPregunta => $pregunta) { 
                        $col_opciones = !empty($listaOpciones[$keyEncuesta][$keyPregunta]) ? count($listaOpciones[$keyEncuesta][$keyPregunta]) : 0;
                    ?>
                        <th rowspan="1" colspan="<?= (3+$col_opciones)?>" class="text-center">
                            <!-- PREGUNTA -->
                            <?= !empty(($pregunta["nombre"])) ? (($pregunta["nombre"])) : '' ?>  
                        
                            <!-- IMAGEN DE LA PREGUNTA-->
                        
                            <?= !empty(($pregunta["imagen"])) ?  rutaImagen(['foto'=>$pregunta['imagen'],'modulo'=>'impactTrade_Android','icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0'])  : '' ?>  

                        </th>
                        <th rowspan="2" class="text-center">FOTO(S) <br> PREGUNTA</th>
                    <? } ?>
                <? } ?>
            </tr>
            <tr>
                <? foreach ($listaEncuesta as $keyEncuesta => $encuesta) {
                    foreach ($listaPregunta[$keyEncuesta] as $keyPregunta => $pregunta) { ?>
                        <th rowspan="1" class="text-center">ALTERNATIVA</th>
                        <th rowspan="1" class="text-center" colspan="1">FOTOS</th>
                        <th rowspan="1" class="text-center" colspan="1">COMENTARIO</th>
                        
                        <?
                        if(empty($listaOpciones[$keyEncuesta][$keyPregunta])) continue;
                        foreach($listaOpciones[$keyEncuesta][$keyPregunta] as $keyOpcion => $opcion){?>
                            <? if( empty($opcion['nombre'])) continue;?>
                            <th rowspan="1" class="text-center" ><?= !empty($opcion['nombre']) ? ($opcion['nombre']): '' ?></th>
                        <?}?>
                    <? } ?>
                <? } ?>
            </tr>
        </thead>
    </table>
</div>