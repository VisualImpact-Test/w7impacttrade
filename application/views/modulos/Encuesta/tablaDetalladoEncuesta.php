<div class="card-datatable">
    <table id="tablaDetalladoEncuesta" class="table table-striped table-bordered nowrap w-100" style="font-size:12px;">
        <thead>
            <tr>
                <th rowspan="3" class="noVis text-center">#</th>
                <th class="text-center" rowspan="3">HABILITAR PDF<br><input type="checkbox" id="chkb-habilitarTodos" name="chkb-habilitarTodos" class="habilitarTodos"></th>
                <th rowspan="3" class="text-center">FECHA</th>
                <th rowspan="3" class="text-center">GRUPO CANAL</th>
                <th rowspan="3" class="text-center">CANAL</th>
                <th rowspan="3" class="text-center hideCol">SUBCANAL</th>
                <?
                if (!empty($segmentacion['headers'])) {
                    foreach ($segmentacion['headers'] as $k => $v) { ?>
                        <th rowspan="3" class="text-center"><?= strtoupper($v['header']) ?></th>
                <? }
                } ?>
                <th rowspan="3" class="text-center">COD VISUAL</th>
                <th rowspan="3" class="text-center hideCol">COD <?= $this->sessNomCuentaCorto ?></th>
                <th rowspan="3" class="text-center hideCol">COD PDV</th>
                <th rowspan="3" class="text-center">PDV</th>
                <th rowspan="3" class="text-center">TIPO CLIENTE</th>
                <th rowspan="3" class="text-center hideCol">DEPARTAMENTO</th>
                <th rowspan="3" class="text-center hideCol">PROVINCIA</th>
                <th rowspan="3" class="text-center hideCol">DISTRITO</th>
                <th rowspan="3" class="text-center">COD <br />USUARIO</th>
                <th rowspan="3" class="text-center">PERFIL USUARIO</th>
                <th rowspan="3" class="text-center">NOMBRE USUARIO</th>
                <th rowspan="3" class="text-center">INCIDENCIA</th>
                <th rowspan="3" class="text-center">ENCUESTADO</th>
                <? foreach ($listaEncuesta as $keyEncuesta => $encuesta) { ?>
                    <?
                    $cant_col_preg = count($listaPregunta[$keyEncuesta]) * 3;
                    $cant_col_preg_op = !empty($listaOpciones[$keyEncuesta]['opciones']) ? count($listaOpciones[$keyEncuesta]['opciones']) : 0;
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
                        <th rowspan="1" colspan="<?= (2+$col_opciones)?>" class="text-center">
                            <!-- PREGUNTA -->
                            <?= !empty(($pregunta["nombre"])) ? (($pregunta["nombre"])) : '' ?>  
                        
                            <!-- IMAGEN DE LA PREGUNTA-->
                        
                            <?= !empty(($pregunta["imagen"])) ?  rutafotoModulo(['foto'=>$pregunta['imagen'],'modulo'=>'encuestaFotosRefencia','icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0'])  : '' ?>  

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
        <tbody>
            <?
            $contador = 0;
            foreach ($visitas as $keyVisita => $visita) {
                $contador++;
            ?>
                <tr>
                    <td><?= $contador ?></td>
                    <td class="text-center">
                        <input name="check[]" id="check" class="check" type="checkbox" value="<?= $visita['idVisita']; ?>" />
                    </td>
                    <td><?= verificarEmpty($visita["fecha"], 3) ?></td>
                    <td><?= verificarEmpty($visita["grupoCanal"], 3) ?></td>
                    <td><?= verificarEmpty($visita["canal"], 3) ?></td>
                    <td><?= verificarEmpty($visita["subCanal"], 3) ?></td>
                    <? if (!empty($segmentacion['headers'])) {
                        foreach ($segmentacion['headers'] as $k => $v) { ?>
                            <td class="text-<?= (!empty($visita[($v['columna'])]) ? $v['align'] : '-') ?>"><?= (!empty($visita[($v['columna'])]) ? $visita[($v['columna'])] : '-') ?></td>
                    <? }
                    } ?>
                    <td class="text-center"><?= verificarEmpty($visita["idCliente"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visita["codCliente"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visita["codDist"], 3) ?></td>
                    <td><?= verificarEmpty($visita["razonSocial"], 3) ?></td>
                    <td><?= verificarEmpty($visita["tipoCliente"], 3) ?></td>
                    <td><?= verificarEmpty($visita["ciudad"], 3) ?></td>
                    <td><?= verificarEmpty($visita["provincia"], 3) ?></td>
                    <td><?= verificarEmpty($visita["distrito"], 3) ?></td>
                    <td class="text-center"><?= verificarEmpty($visita["idUsuario"], 3) ?></td>
                    <td><?= verificarEmpty($visita["tipoUsuario"], 3) ?></td>
                    <td><?= verificarEmpty($visita["usuario"], 3) ?></td>
                    <td><?= verificarEmpty($visita['incidencia'], 3) ?></td>
                    <td><?= !empty($visita['encuestado']) ? 'SÍ' : '-' ?></td>
                    <?
                    foreach ($listaEncuesta as $keyEncuesta => $encuesta) {
                    ?>
                        <?
                        foreach ($listaPregunta[$keyEncuesta] as $keyPregunta => $pregunta) {
                            $respuesta = (isset($visitaEncuesta[$visita['idVisita']][$keyPregunta])) ? implode(", ", array_unique($visitaEncuesta[$visita['idVisita']][$keyPregunta])) : '-';

                            $tieneFotoAlternativa = false;
                            if(!empty($visitaFotoSub[$visita['idVisita']][$keyPregunta])){
                                foreach($visitaFotoSub[$visita['idVisita']][$keyPregunta] AS $k => $v){
                                    if(!empty($v)){
                                        $tieneFotoAlternativa = true;
                                    }
                                }
                            }
                            if ($tieneFotoAlternativa == true) {
                                $fotoSub = '<a href="javascript:;" class="lk-alternativa-foto a-fa" data-foto="" data-modulo="encuestas" data-comentario="" data-idvisitaencuesta="' . $idVisitaEncuesta[$visita['idVisita']][$keyEncuesta] . '" data-idpregunta="' . $keyPregunta . '"><i class="fa fa-camera" ></i></a>';
                            } else {
                                $fotoSub = "-";
                            }

                            if (!empty($visitaFotoPreg[$visita['idVisita']][$keyEncuesta][$keyPregunta])) {
                                $fotoPreg = '<a href="javascript:;" class="lk-pregunta-foto a-fa"  data-modulo="encuestas" data-comentario="" data-idvisitaencuesta="' . $idVisitaEncuesta[$visita['idVisita']][$keyEncuesta] . '" data-idpregunta="' . $keyPregunta . '"><i class="fa fa-camera" ></i></a>';
                            } else {
                                $fotoPreg = "-";
                            }
                            
                        ?>
                            <td><?= $respuesta ?></td>
                            <td class="text-center"><?= $fotoSub ?></td>
                            
                            <?if($pregunta['idTipoPregunta'] != 4 ){?>
                                <td class="text-center"><?=$fotoPreg?></td>          
                            <?}?>

                            <?
                            if(empty($listaOpciones[$keyEncuesta][$keyPregunta])) continue;
                            foreach($listaOpciones[$keyEncuesta][$keyPregunta] as $keyOpcion => $opcion){?>
                                <? if( empty($opcion['nombre'])) continue;?>
                                <td rowspan="1" class="text-center" ><?= !empty($visitaEncuesta[$visita['idVisita']]['opciones'][$keyPregunta][$opcion['idAlternativaOpcion']]) ? implode(", ", array_unique($visitaEncuesta[$visita['idVisita']]['opciones'][$keyPregunta][$opcion['idAlternativaOpcion']])): '' ?></td>
                            <?}?>  
                            <?if($pregunta['idTipoPregunta'] == 4 ){?>
                                <td class="text-center"><?= $fotoPreg?> </td>          
                            <?}?>
                        <?
                        }
                        ?>
                        <?
                        if ($encuesta["foto"] == 1) {
                            if (isset($visitaFoto[$visita['idVisita']][$keyEncuesta]) || isset($flagFotoMultiple[$visita['idVisita']][$keyEncuesta])) {
                                $foto = '<a href="javascript:;" class="lk-encuesta-foto a-fa text-center" data-foto="' . $visitaFoto[$visita['idVisita']][$keyEncuesta] . '" data-modulo="encuestas" data-comentario="" data-idvisitaencuesta="' . $idVisitaEncuesta[$visita['idVisita']][$keyEncuesta] . '"><i class="fa fa-camera" ></i></a>';
                            } else {
                                $foto = "-";
                            }
                        }
                        ?>
                    <td rowspan="1" class="text-center"><?= $foto ?></td>
                    <?
                    }
                    ?>
                </tr>
            <?
            }
            ?>
        </tbody>
    </table>
</div>