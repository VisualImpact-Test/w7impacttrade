<?php
$cantidadVisitasSod = count($visitasSod);
$cantidadVisitasSodCategoriasDetallados = 0;
foreach ($visitasSod as $key => $visita) {
    if (empty($visita['categorias'])) break;
    foreach ($visita['categorias'] as $key => $categoria) {
        if (empty($categoria['detallados'])) break;
        $cantidadVisitasSodCategoriasDetallados += count($categoria['detallados']);
    }
}

$limiteFotosMiniaturas = 11;
$noPasoLimiteFotos = $cantidadVisitasSodCategoriasDetallados < $limiteFotosMiniaturas;
$contadorFotosCarousel = 0;
$direccionNoImage = base_url() . "public/assets/images/sin-imagen-small.png";
$primeraIteracion = true;
$numeroVisita = 1;
?>

<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-header"><i class="fa fa-picture-o" aria-hidden="true"></i> &nbsp;&nbsp;Módulo Sod &nbsp;<span class="badge badge-secondary"><?= $cantidadVisitasSod ?> Visitas | <?= $cantidadVisitasSodCategoriasDetallados ?> Fotos</span></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($cantidadVisitasSodCategoriasDetallados == 0) { ?>
                        No se han encontrado resultados
                    <?php } else { ?>
                        <div class="swiper-container swiper-container-v">
                            <div class="swiper-wrapper">
                                <?php
                                foreach ($visitasSod as $keyVisita => $visita) { ?>
                                    <div class="swiper-slide">
                                        <div class="swiper-container swiper-container-h">
                                            <div class="swiper-wrapper">
                                                <?php foreach ($visita['categorias'] as $keyCategoria => $categoria) {
                                                    $numeroDetalle = 1;
                                                    foreach ($categoria['detallados'] as $keyDetallado => $detallado) {
                                                        $link = !empty($detallado['fotoUrl']) ? verificarUrlFotos($detallado['fotoUrl']) . 'sod/' . $detallado['fotoUrl'] : $direccionNoImage; ?>
                                                        <div class="swiper-slide">
                                                            <img src="<?= $link ?>" class="mw-100 rounded-top swiper-myImg">
                                                            <div class="row ml-0 mw-100 align-items-center swiper-myInfo">
                                                                <div class="mh-100 mw-100 col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0 overflow-auto">
                                                                    <p class="m-0">COD. VISITA: <?= $visita['idVisita'] ?> <button data-urlfoto="<?= $link ?>" class="btn-verFoto swiper-btn btn-sm border-0 btn-transition btn btn-outline-dark"><i class="fa fa-camera"></i></button></p>
                                                                    <p class="m-0"> <?= $visita['tipoUsuario'] ?>: <?= $visita['nombreUsuario'] ?></p>
                                                                    <p class="m-0"> FECHA: <?= date_change_format($visita['fecha']) ?> | HORA: <?= time_change_format($categoria['hora']) ?></p>
                                                                    <p class="m-0">CATEGORÍA: <?= $categoria['categoria'] ?> | DETALLADO: <?= $numeroDetalle ?>/<?=count($categoria['detallados'])?></p>
                                                                    <p class="m-0">MARCA: <?= $detallado['marca'] ?> | ELEMENTO VISIBILIDAD: <?= $detallado['tipoElementoVisibilidad'] ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php $numeroDetalle++; ?>
                                                    <?php  } ?>
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