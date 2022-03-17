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
            </tr>
        </thead>
        <tbody>
            <? foreach ($dataEncuestaVertical as $k => $data) {
                if(empty($dataVisitaVertical[$data['idVisita']])) continue;
                $visita = $dataVisitaVertical[$data['idVisita']]; 
            ?>
                <tr>
                    <td class="text-center" style="vertical-align: middle;"><?= $k; ?></td>
                    <td class="text-center"><?= !empty($visita['fecha']) ? $visita['fecha'] : ' - '  ?></td>
                    <td class="text-left"><?= !empty($visita['tipoUsuario']) ? $visita['tipoUsuario'] : ' - '  ?></td>
                    <td class="text-center"><?= !empty($visita['idUsuario']) ? $visita['idUsuario'] : ' - '  ?></td>
                    <td class="text-left"><?= !empty($visita['usuario']) ? $visita['usuario'] : ' - '  ?></td>
                    <td class="text-left"><?= !empty($visita['grupoCanal']) ? $visita['grupoCanal'] : ' - '  ?></td>
                    <td class="text-left"><?= !empty($visita['canal']) ? $visita['canal'] : ' - '  ?></td>
                    <? foreach ($segmentacion['headers'] as $k => $v) { ?>
                        <td class="text-left"><?= (!empty($visita[($v['columna'])]) ? $visita[($v['columna'])] : '-') ?></td>
                    <? } ?>
                    <td class="text-center"><?= !empty($visita['idCliente']) ? $visita['idCliente'] : ' - '  ?></td>
                    <td class="text-center"><?= !empty($visita['codCliente']) ? $visita['codCliente'] : ' - '  ?></td>
                    <td class="text-center"><?= !empty($visita['codDist']) ? $visita['codDist'] : ' - '  ?></td>
                    <td class="text-left"><?= !empty($visita['razonSocial']) ? $visita['razonSocial'] : ' - '  ?></td>
                    <td class="text-left"><?= !empty($visita['subCanal']) ? $visita['subCanal'] : ' - '  ?></td>
                    <td class="text-left"><?= !empty($visita['incidencia']) ? $visita['incidencia'] : ' - '  ?></td>
                    <td class="text-left"> 
                        <?=!empty($data['encuesta']) ? $data['encuesta'] : '-' ?>
                        <?=!empty($data['imgRef']) ? rutafotoModulo(['foto'=>$data['imgRef'],'modulo'=>'encuestas','icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0']) : ''?>
                    </td>
                    <td class="text-left"> <?= !empty($data['tipoPregunta']) ? $data['tipoPregunta'] : ' - '  ?> </td>
                    <td class="text-left">
                        <?=!empty($data['pregunta']) ? $data['pregunta'] : '-' ?>
                        <?=!empty($data['imgPreg']) ? rutafotoModulo(['foto'=>$data['imgPreg'],'modulo'=>'encuestas','icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0']) : ''?>

                    </td>
                    <?if($data['idTipoPregunta'] != 4){?>
                    <td class="text-left"> 
                        <?=!empty($data['respuesta']) ? $data['respuesta'] : '-' ?>
                        <?=!empty($data['imgRefSub']) ? rutafotoModulo(['foto'=>$data['imgRefSub'],'modulo'=>'encuestas','icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0']) : ''?>
                    </td>
                    <td class="text-center"> - </td>
                    <?}?>
                    <?if($data['idTipoPregunta'] == 4){?>
                        <td class="text-left"> 
                        <?=!empty($data['respuesta']) ? $data['respuesta'] : '-' ?>
                        <?=!empty($data['imgRefSub']) ? rutafotoModulo(['foto'=>$data['imgRefSub'],'modulo'=>'encuestas','icono'=>'fal fa-image-polaroid fa-lg btn-outline-primary btn border-0']) : ''?>
                        </td>
                        <td class="text-center"> 
                        <?=!empty($data['alternativaOpcion']) ? $data['alternativaOpcion'] : '-' ?>
                        </td>
                    <?}?>

                </tr>
            <? } ?>
        </tbody>
    </table>
</div>