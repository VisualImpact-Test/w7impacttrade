	<?
	$cabecera = '';
	$cuerpo = '';
	$i = 1;
	$vacios = 0;

	foreach ($moduloFotos as $kf => $row) {
		if(empty($row['foto'])){
			$vacios++;
		}else{
			$hora = '';
			$claseActiva = (($kf-$vacios) == 0) ? 'active' : '';
			$foto = $row['foto'];

			$cabecera .= '<li data-target="#carouselExampleIndicators" data-slide-to="' . $kf . '" class="' . $claseActiva . '"></li>';
	
			$cuerpo .= '<div class="carousel-item ' . $claseActiva . '">';
			$cuerpo .= '<img class="d-block w-100" src="' . site_url("controlFoto/obtener_carpeta_foto/encuestas/{$foto}") . '" alt="Modulo Fotos">';
			$cuerpo .= '<div class="font-weight-bold mt-2" style="font-size: 17px;text-align: right;padding-right:5px;padding-bottom:5px;">' . $i++ . '/' . (count($moduloFotos) - $vacios). '</div>';
			$cuerpo .= '</div>';
		}
	}
	?>

	<div class="row moduloFotos" id="idModuloFotos">
		<div class="col-lg-12">
			<div class="main-card mb-3 card">
				<div class="card-body p-0">
					<?
					if ($cuerpo != '') {
					?>
						<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<?= $cabecera; ?>
							</ol>
							<div class="carousel-inner">
								<?= $cuerpo; ?>
							</div>
							<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="sr-only">Anterior</span>
							</a>
							<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="sr-only">Siguiente</span>
							</a>
						</div>

					<?
					} else { getMensajeGestion('noResultados'); }
					?>
				</div>
			</div>
		</div>
	</div>