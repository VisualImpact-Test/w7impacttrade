<?php
$cantidadVisitasSeguimientoPlan = count($visitasSeguimientoPlan);
$cantidadVisitasSeguimientoPlanDetallados = 0;
foreach ($visitasSeguimientoPlan as $key => $visita) {
    if (empty($visita['detallados'])) continue;
    $cantidadVisitasSeguimientoPlanDetallados += count($visita['detallados']);
}

$limiteFotosMiniaturas = 11;
$noPasoLimiteFotos = $cantidadVisitasSeguimientoPlanDetallados + $cantidadVisitasSeguimientoPlan < $limiteFotosMiniaturas;
$contadorFotosCarousel = 0;
$direccionNoImage = base_url() . "public/assets/images/sin-imagen-small.png";
$primeraIteracion = true;
$numeroVisita = 1;
?>

<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-header"><i class="fa fa-picture-o" aria-hidden="true"></i> &nbsp;&nbsp;Módulo Seguimiento Plan &nbsp;<span class="badge badge-secondary"><?= $cantidadVisitasSeguimientoPlan ?> Visitas | <?= $cantidadVisitasSeguimientoPlanDetallados ?> Detallados</span></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($cantidadVisitasSeguimientoPlan == 0) { ?>
                        No se han encontrado resultados
                    <?php } else { ?>
                        <div class="swiper-container swiper-container-v">
                            <div class="swiper-wrapper">
                                <?php foreach ($visitasSeguimientoPlan as $keyVisita => $visita) {
                                    $linkImagenVisita = !empty($visita['fotoUrl']) ? verificarUrlFotos($visita['fotoUrl']) . 'seguimientoPlan/' . $visita['fotoUrl'] : $direccionNoImage;
                                    $numeroDetalle = 1;
                                ?>
                                    <div class="swiper-slide">
                                        <div class="swiper-container swiper-container-h">
                                            <div class="swiper-wrapper">

                                                <div class="swiper-slide">
                                                    <img src="<?= $linkImagenVisita ?>" class="mw-100 rounded-top swiper-myImg">
                                                    <div class="row ml-0 mw-100 align-items-center swiper-myInfo">
                                                        <div class="mh-100 mw-100 col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0 overflow-auto">

                                                            <p class="m-0">COD. VISITA: <?= $visita['idVisita'] ?> <button data-urlfoto="<?= $linkImagenVisita ?>" class="btn-verFoto swiper-btn btn-sm border-0 btn-transition btn btn-outline-dark"><i class="fa fa-camera"></i></button></p>
                                                            <p class="m-0"> <?= $visita['tipoUsuario'] ?>: <?= $visita['nombreUsuario'] ?></p>
                                                            <p class="m-0">
                                                                FECHA: <?= date_change_format($visita['fecha']) ?> | HORA: <?= time_change_format($visita['hora']) ?>
                                                            </p>
                                                            <p class="m-0">DETALLADOS: <?= $visita['cantidadDetallados'] ?></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <?php foreach ($visita['detallados'] as $keyDetallado => $detallado) {
                                                    $link = !empty($detallado['fotoUrl']) ? $ubicacionFotos . $detallado['fotoUrl'] : $direccionNoImage; ?>
                                                    <div class="swiper-slide">
                                                        <img src="<?= $link ?>" class="mw-100 rounded-top swiper-myImg">
                                                        <div class="row ml-0 mw-100 align-items-center swiper-myInfo">
                                                            <div class="mh-100 mw-100 col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0 overflow-auto">
                                                                <p class="m-0">COD. VISITA: <?= $visita['idVisita'] ?> <button data-urlfoto="<?= $link ?>" class="btn-verFoto swiper-btn btn-sm border-0 btn-transition btn btn-outline-dark"><i class="fa fa-camera"></i></button> </p>
                                                                <p class="m-0"> <?= $visita['tipoUsuario'] ?>: <?= $visita['nombreUsuario'] ?></p>
                                                                <p class="m-0">FECHA: <?= date_change_format($visita['fecha']) ?> | HORA: <?= time_change_format($visita['hora']) ?></p>
                                                                <p class="m-0">Nº Detallado: <?= $numeroDetalle . '/' . $visita['cantidadDetallados'] ?></p>
                                                                <p class="m-0"> ARMADO: <?= !empty($detallado['armado']) ? 'Sí' : 'No' ?> | REVESTIDO: <?= !empty($detallado['armado']) ? 'Sí' : 'No' ?></p>
                                                                <p class="m-0"> MOTIVO: <?= !empty($detallado['motivo']) ? $detallado['motivo'] : '-' ?> | COMENTARIO: <?= !empty($detallado['comentario']) ? $detallado['comentario'] : '-' ?></p>
                                                                <p class="m-0"> MARCA: <?= !empty($detallado['marca']) ? $detallado['marca'] : '-' ?></p>
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