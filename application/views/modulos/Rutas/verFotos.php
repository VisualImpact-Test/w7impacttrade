	<div class="text-center"><h2><strong><?=$cliente;?></strong></h2><hr style="margin-bottom:0px;"></div>
	<div style="margin-bottom:5px;margin-top:5px;">
		<label style="font-weight: bold;font-size: 15px;">Perfil: <label style="font-weight: 200;"><?=$perfil ?></label></label><br>
		<label style="font-weight: bold;font-size: 15px;">Usuario: <label style="font-weight: 200;"><?=$usuario?></label></label><br>
	</div>
	<p class="user-name">
	</p>
	<?
		$cabecera=''; $cuerpo='';
		$cabeceraOtras=''; $cuerpoOtras='';
		$i = 1;
		$iOtras = 1;

		foreach ($moduloFotos as $kf => $row){
			$hora=''; 
			$claseActiva = $kf==0 ? 'active':'';
			$cabecera .= '<li data-target="#carouselExampleIndicators" data-slide-to="'.$kf.'" class="'.$claseActiva.'"></li>';

			// $modulo = $row['modulo']=='FOTOS' ? 'moduloFotos' : $row['modulo'];

			$cuerpo .= '<div class="carousel-item '.$claseActiva.'">';
				// $cuerpo .= '<center class="mb-2">Módulo: <strong>'.$row['modulo'].'</strong>'.$hora.'</center>';

				$cuerpo .= '
				<div style="margin-top:5px;padding-left:5px;padding-top:5px;">
					<label style="font-weight: bold;font-size: 15px;">Tipo Foto: <label style="font-weight: 200;">'.$row['nombreTipoFoto'].'</label></label><br>
				</div>';


				$cuerpo .= '
				<div style="margin-bottom:5px;padding-left:5px;">
				';
				(!empty($row['hora']) ? $cuerpo .= '
					<label style="font-weight: bold;font-size: 15px;">Hora: <label style="font-weight: 200;">'.$row['hora'].'</label></label><br>
				' : '');
				$cuerpo .= '
				</div>
				';

				$cuerpo .= '<img class="d-block w-100" src="'.site_url("controlFoto/obtener_carpeta_foto/moduloFotos/{$row['foto']}").'" alt="Modulo Fotos">';
				$cuerpo .= '<div class="font-weight-bold mt-2" style="font-size: 17px;text-align: right;padding-right:5px;padding-bottom:5px;">'.$i++.'/'.count($moduloFotos).'</div>';
			$cuerpo .= '</div>';
		}
		
		foreach ($fotos as $kf => $row){
			$hora=''; 
			$claseActiva = $kf==0 ? 'active':'';
			$cabeceraOtras .= '<li data-target="#carouselExampleIndicators2" data-slide-to="'.$kf.'" class="'.$claseActiva.'"></li>';

			// $modulo = $row['modulo']=='FOTOS' ? 'moduloFotos' : $row['modulo'];
			$modulo=$row['carpetaFoto'];

			$cuerpoOtras .= '<div class="carousel-item '.$claseActiva.'">';
				// $cuerpoOtras .= '<center class="mb-2">Módulo: <strong>'.$row['modulo'].'</strong>'.$hora.'</center>';

				$cuerpoOtras .= '
				<div style="margin-top:5px;padding-left:5px;padding-top:5px;">
					<label style="font-weight: bold;font-size: 15px;">Modulo: <label style="font-weight: 200;">'.$row['modulo'].'</label></label><br>
				</div>';
				

				$cuerpoOtras .= '
				<div style="margin-bottom:5px;padding-left:5px;">
				';
				(!empty($row['hora']) ? $cuerpoOtras .= '
					<label style="font-weight: bold;font-size: 15px;">Hora: <label style="font-weight: 200;">'.$row['hora'].'</label></label><br>
				' : '');
				$cuerpoOtras .= '
				</div>
				';

				$cuerpoOtras .= '<img class="d-block w-100" src="'.site_url("controlFoto/obtener_carpeta_foto/{$modulo}/{$row['foto']}").'" alt="'.$row['modulo'].'">';
				$cuerpoOtras .= '<div class="font-weight-bold mt-2" style="font-size: 17px;text-align: right;padding-right:5px;padding-bottom:5px;">'.$iOtras++.'/'.count($fotos).'</div>';
			$cuerpoOtras .= '</div>';
		}
	?>


	<div class="card w-100 mb-3 p-0">
		<div class="card-body p-0">
			<ul class="nav nav-tabs nav-underline nav-justified">
				<li class="nav-item tabVerFotos" data-value="1">
					<a class="nav-link active" data-toggle="tab" href="#tab-content-0" >Fotos</a>
				</li>
				<li class="nav-item tabVerFotos" data-value="2">
					<a class="nav-link" data-toggle="tab" href="#tab-content-1">Otros</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="row  moduloFotos" id="idModuloFotos">
		<div class="col-lg-12">
			<div class="main-card mb-3 card">
				<div class="card-body p-0" >
					<?
					if($cuerpo!=''){
						?>
						<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<?=$cabecera;?>
							</ol>
							<div class="carousel-inner">
								<?=$cuerpo;?>
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
						
					}else{?>

						<?=getMensajeGestion('noResultados');?>
					<?
						}
					 ?>
				</div>
			</div>
		</div>
	</div>

	<div class="row otrosModulos" id="idOtrosModulos" style="display:none">
		<div class="col-lg-12">
			<div class="main-card mb-3 card">
				<div class="card-body p-0" >
					<?
						if($cuerpoOtras!=''){
							?>
							<div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
								<ol class="carousel-indicators">
									<?=$cabeceraOtras;?>
								</ol>
								<div class="carousel-inner">
									<?=$cuerpoOtras;?>
								</div>
								<a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="sr-only">Anterior</span>
								</a>
								<a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="sr-only">Siguiente</span>
								</a>
							</div>
						<?
							}else{
								?>
								<?=getMensajeGestion('noResultados');?>
								<?
							}
						 ?>
				</div>
			</div>
		</div>
	</div>



	