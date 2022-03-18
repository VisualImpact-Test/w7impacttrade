<?php
$cantidadVisitasSos = count($visitasSos);
$cantidadVisitasSosCategorias = 0;
foreach ($visitasSos as $key => $value) {
    if (empty($value['categorias'])) break;
    $cantidadVisitasSosCategorias += count($value['categorias']);
}

$limiteFotosMiniaturas = 11;
$noPasoLimiteFotos = $cantidadVisitasSosCategorias < $limiteFotosMiniaturas;
$contadorFotosCarousel = 0;
$direccionNoImage = base_url() . "public/assets/images/sin-imagen-small.png";
$primeraIteracion = true;
$numeroVisita = 1;
?>

<div class="col-md-12">
    <div class="mb-3 card">
        <div class="card-header"><i class="fa fa-picture-o" aria-hidden="true"></i> &nbsp;&nbsp;Módulo Sos &nbsp;<span class="badge badge-secondary"><?= $cantidadVisitasSos ?> Visitas | <?= $cantidadVisitasSosCategorias ?> Fotos</span></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($cantidadVisitasSosCategorias == 0) { ?>
                        No se han encontrado resultados
                    <?php } else { ?>
                        <div class="swiper-container swiper-container-v">
                            <div class="swiper-wrapper">
                                <?php foreach ($visitasSos as $keyVisita => $visita) {
                                    $numeroDetalle = 1; ?>
                                    <div class="swiper-slide">
                                        <div class="swiper-container swiper-container-h">
                                            <div class="swiper-wrapper">
                                                <?php foreach ($visita['categorias'] as $keyDetallado => $categoria) {
                                                    $link = !empty($categoria['fotoUrl']) ? verificarUrlFotos($categoria['fotoUrl']) . 'sos/' . $categoria['fotoUrl'] : $direccionNoImage; ?>
                                                    <div class="swiper-slide">
                                                        <img src="<?= $link ?>" class="mw-100 rounded-top swiper-myImg">
                                                        <div class="row ml-0 mw-100 align-items-center swiper-myInfo">
                                                            <div class="mh-100 mw-100 col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0 overflow-auto">

                                                                <p class="m-0">COD. VISITA: <?= $visita['idVisita'] ?> <button data-urlfoto="<?= $link ?>" class="btn-verFoto swiper-btn btn-sm border-0 btn-transition btn btn-outline-dark"><i class="fa fa-camera"></i></button></p>
                                                                <p class="m-0"><?= $visita['tipoUsuario'] ?>: <?= $visita['nombreUsuario'] ?></p>
                                                                <p class="m-0">
                                                                    FECHA: <?= date_change_format($visita['fecha']) ?> | HORA: <?= time_change_format($categoria['hora']) ?>
                                                                </p>
                                                                <p class="m-0">CATEGORÍA: <?= $categoria['categoria'] ?> | COMPETENCIA: <?= $categoria['cantidadCompetencia'] ?></p>
                                                                <button data-objetodetallados='<?= json_encode($categoria['detallados']) ?>' class="btn-getDetalladoModuloSos swiper-btn btn- btn-sm border-0 btn-transition btn btn-outline-dark">Ver <?= $categoria['numDet'] ?> detallados</button>
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