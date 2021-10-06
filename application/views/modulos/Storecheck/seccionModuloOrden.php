<?php
$cantidadVisitasOrden = count($visitasOrden);

$limiteFotosMiniaturas = 11;
$noPasoLimiteFotos = $cantidadVisitasOrden < $limiteFotosMiniaturas;
$contadorFotosCarousel = 0;
$ubicacionFotos = "http://movil.visualimpact.com.pe/fotos/impactTrade_android/orden/";
$direccionNoImage = base_url() . "public/assets/images/sin-imagen-small.png";
$primeraIteracion = true;
$numeroVisita = 1;
?>

<div class="col-md-6">
    <div class="mb-3 card">
        <div class="card-header"><i class="fa fa-picture-o" aria-hidden="true"></i> &nbsp;&nbsp;Módulo Orden &nbsp;<span class="badge badge-secondary"><?= $cantidadVisitasOrden ?> Visitas</span></div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($cantidadVisitasOrden == 0) { ?>
                        No se han encontrado resultados
                    <?php } else { ?>
                        <div class="swiper-container swiper-container-v">
                            <div class="swiper-wrapper">
                                <?php foreach ($visitasOrden as $keyVisita => $visita) {
                                    $link = !empty($visita['fotoUrl']) ? $ubicacionFotos . $visita['fotoUrl'] : $direccionNoImage; ?>
                                    <div class="swiper-slide">
                                        <div class="swiper-container swiper-container-h">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <img src="<?= $link ?>" class="mw-100 rounded-top swiper-myImg">
                                                    <div class="row ml-0 mw-100 align-items-center swiper-myInfo">
                                                        <div class="mh-100 mw-100 col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0 overflow-auto">
                                                            <p class="m-0">
                                                                COD. VISITA: <?= $visita['idVisita'] ?>
                                                                <button data-urlfoto="<?= $link ?>" class="btn-verFoto swiper-btn btn-sm border-0 btn-transition btn btn-outline-dark"><i class="fa fa-camera"></i></button>
                                                            </p>
                                                            <p class="m-0"> <?= $visita['tipoUsuario'] ?>: <?= $visita['nombreUsuario'] ?></p>
                                                            <p class="m-0">FECHA: <?= date_change_format($visita['fecha']) ?> | HORA INICIO: <?= time_change_format($visita['horaIni']) ?> | HORA FIN: <?= time_change_format($visita['horaFin']) ?></p>
                                                            <p class="m-0">ESTADO: <?= !empty($visita['ordenEstado']) ? $visita['ordenEstado'] : '-' ?> | ORDEN: <?= !empty($visita['orden']) ? $visita['orden'] : '-' ?></p>
                                                            <p class="m-0">DESCRIPCIÓN: <?= !empty($visita['descripcion']) ? $visita['descripcion'] : '-' ?> OTRO: <?= !empty($visita['flagOtro']) ? 'Sí' : 'No' ?></p>
                                                        </div>
                                                    </div>
                                                </div>
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