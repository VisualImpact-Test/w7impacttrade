<?php $cantidadFotos = count($fotosClientes); ?>
<?php if ($cantidadFotos < 11) { ?>
    <style>
        .carousel-thumbnails .carousel-indicators img {
            max-width: 100px;
            height: 50px;
            overflow: hidden;
            display: block;
        }

        .carousel-thumbnails .carousel-indicators li {
            height: auto;
            max-width: 100px;
            width: 100px;
            border: none;
            box-shadow: 1px 3px 5px 0px rgba(0, 0, 0, 0.75);

            &.active {
                border-bottom: 4px solid #fff;
            }
        }
    </style>
<?php } ?>


<div id="carouselIndicators" class="carousel slide carousel-fade carousel-thumbnails" data-ride="carousel">
    <ol class="carousel-indicators">

        <?php $contador = 0;
        foreach ($fotosClientes as $key => $row) {
            reset($fotosClientes);
            $primeraIteracion = ($key === key($fotosClientes)) ? true : false;
            $link = site_url().'ControlFoto/obtener_carpeta_foto/'.$row['carpetaFoto'].'/'.($row['imgRef']);
			// $link = "{$this->aWebUrl['fotos']['movil']}moduloFotos/{$row['imgRef']}";
            $claseActiva = !empty($primeraIteracion) ? 'class="active"' : '';
        ?>

            <?php if ($cantidadFotos < 11) { ?>
                <li data-target="#carouselIndicators" data-slide-to="<?= $contador ?>" <?= $claseActiva ?>> <img class="d-block w-100" src="<?= $link ?>" class="img-fluid"></li>
            <?php } else { ?>
                <li data-target="#carouselIndicators" data-slide-to="<?= $contador ?>" <?= $claseActiva ?>> <img class="d-block w-100" src="<?= $link ?>" class="img-fluid"></li>
            <?php } ?>

        <?php $contador++;
        } ?>

    </ol>
    <div class="carousel-inner">

        <?php foreach ($fotosClientes as $key => $row) {
            reset($fotosClientes);
            $primeraIteracion = ($key === key($fotosClientes)) ? true : false;
            $link = site_url().'ControlFoto/obtener_carpeta_foto/'.$row['carpetaFoto'].'/'.($row['imgRef']);
			// $link = "{$this->aWebUrl['fotos']['movil']}moduloFotos/{$row['imgRef']}";
            $claseActiva = !empty($primeraIteracion) ? 'active' : '';
        ?>
            <div class="carousel-item <?= $claseActiva ?>" style="text-align: center;margin-bottom: 90px;">
                <img src="<?= $link ?>" class="" alt="..." style="height: 600px;margin: auto;">
                <div class="carousel-caption d-none d-md-block">
                    <p class="m-0">Modulo: <?= $row['modulo'] ?></p>
                    <p class="m-0">Tipo Foto: <?= $row['tipoFoto'] ?></p>
                    <p class="m-0">Hora: <?= $row['horaFoto'] ?></p>
                    <br>
                    <br>
                </div>
            </div>
        <?php } ?>

    </div>
    <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev" style="background: #706767;">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next" style="background: #706767;">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>