<?php
$cantidadVisitasDespacho = count($visitasDespacho);
$cantidadVisitasDespachoDetallados = 0;
foreach ($visitasDespacho as $key => $visita) {
    if (empty($visita['detallados'])) continue;
    $cantidadVisitasDespachoDetallados += count($visita['detallados']);
}

$limiteFotosMiniaturas = 11;
$noPasoLimiteFotos = $cantidadVisitasDespachoDetallados < $limiteFotosMiniaturas;
$contadorFotosCarousel = 0;
$ubicacionFotos = "http://movil.visualimpact.com.pe/fotos/impactTrade_android/despacho/";
$direccionNoImage = base_url() . "public/assets/images/sin-imagen-small.png";
$primeraIteracion = true;
$numeroVisita = 1;
?>

<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-header"><i class="fa fa-picture-o" aria-hidden="true"></i> &nbsp;&nbsp;Módulo Despacho &nbsp;<span class="badge badge-secondary"><?= $cantidadVisitasDespacho ?> Visitas | <?= $cantidadVisitasDespachoDetallados ?> Detallados</span></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($cantidadVisitasDespachoDetallados == 0) { ?>
                        No se han encontrado resultados
                    <?php } else { ?>
                        <div class="swiper-container swiper-container-v">
                            <div class="swiper-wrapper">
                                <?php foreach ($visitasDespacho as $keyVisita => $visita) {
                                    $numeroDetalle = 1; ?>
                                    <div class="swiper-slide">
                                        <div class="swiper-container swiper-container-h">
                                            <div class="swiper-wrapper">
                                                <?php foreach ($visita['detallados'] as $keyDetallado => $detallado) {
                                                    $link = !empty($detallado['fotoUrl']) ? $ubicacionFotos . $detallado['fotoUrl'] : $direccionNoImage; ?>
                                                    <div class="swiper-slide">
                                                        <img src="<?= $link ?>" class="mw-100 rounded-top swiper-myImg">
                                                        <div class="row ml-0 mw-100 align-items-center swiper-myInfo">
                                                            <div class="mh-100 mw-100 col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0 overflow-auto">
                                                                <?php if (empty($detallado['idVisitaDesapachosDet'])) { ?>
                                                                    <p class="m-0">COD. VISITA: <?= $visita['idVisita'] ?> <button data-urlfoto="<?= $link ?>" class="btn-verFoto swiper-btn btn-sm border-0 btn-transition btn btn-outline-dark"><i class="fa fa-camera"></i></button></p>
                                                                    <p class="m-0"> <?= $visita['tipoUsuario'] ?>: <?= $visita['nombreUsuario'] ?></p>
                                                                    <p class="m-0">
                                                                        FECHA: <?= date_change_format($visita['fecha']) ?> | HORA: <?= time_change_format($visita['hora']) ?>
                                                                    </p>
                                                                    <p class="m-0">DETALLADOS: <?= $visita['cantidadDetallados'] ?></p>
                                                                <?php } else { ?>
                                                                    <p class="m-0">COD. VISITA: <?= $visita['idVisita'] ?> <button data-urlfoto="<?= $link ?>" class="btn-verFoto swiper-btn btn-sm border-0 btn-transition btn btn-outline-dark"><i class="fa fa-camera"></i></button></p>
                                                                    <p class="m-0"> <?= $visita['tipoUsuario'] ?>: <?= $visita['nombreUsuario'] ?></p>
                                                                    <p class="m-0">
                                                                        FECHA: <?= date_change_format($visita['fecha']) ?> | HORA: <?= time_change_format($visita['hora']) ?>
                                                                    </p>
                                                                    <p class="m-0">DETALLADOS: <?= $numeroDetalle . '/' . $visita['cantidadDetallados'] ?></p>
                                                                    <p class="m-0"> <?= $visita['tipoUsuario'] ?>: <?= $visita['nombreUsuario'] ?></p>
                                                                    <p class="m-0">HORA INICIO: <?= !empty($detallado['horaIni']) ? time_change_format($detallado['horaIni']) : '-' ?> | HORA FIN: <?= !empty($detallado['horaFin']) ?  time_change_format($detallado['horaFin']) : '-' ?></p>
                                                                    <p class="m-0">INCIDENCIA: <?= !empty($detallado['incidencia']) ? $detallado['incidencia'] : '-' ?> | PLACA: <?= !empty($detallado['placa']) ? $detallado['placa'] : '-' ?></p>
                                                                    <p class="m-0">COMENTARIO: <?= !empty($detallado['comentario']) ? $detallado['comentario'] : '-' ?></p>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php $numeroDetalle++; ?>
                                                <?php  } ?>
                                            </div>
                                            <div class="swiper-pagination swiper-pagination-h"></div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                    <?php $numeroVisita++; ?>
                                <?php } ?>
                            </div>
                            <div class="swiper-pagination swiper-pagination-v"></div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>