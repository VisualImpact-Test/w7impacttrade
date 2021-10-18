<div>
	<div class="text-center"><h2><strong><?=$cliente;?></strong></h2><hr style="margin-bottom:0px;"></div>
	<p class="user-name">
	</p>
	<?
		$cabecera=''; $cuerpo='';
		$i = 1;
		foreach ($fotos as $kf => $row){
			$hora=''; $modulo='';
			$claseActiva = $kf==0 ? 'active':'';
			$cabecera .= '<li data-target="#carouselExampleIndicators" data-slide-to="'.$kf.'" class="'.$claseActiva.'"></li>';

			// $modulo = $row['modulo']=='FOTOS' ? 'moduloFotos' : $row['modulo'];
			switch($row['modulo']){
				case 'FOTOS':
					$modulo = 'moduloFotos';
					break;
				case 'INICIATIVAS':
					$modulo = 'iniciativa';
					break;
				case 'INTELIGENCIA COMPETITIVA':
					$modulo = 'inteligencia';
					break;
				case 'VISIBILIDAD AUDITORIA':
					$modulo = 'visibilidadAuditoria';
					break;
				case 'EVIDENCIA FOTOGRAFICA':
					$modulo = 'evidenciaFotografica';
					break;
				default:
					$modulo = $row['modulo'];
					break;
			}

			$res = explode("_", $row['foto']);
			//var_dump($res);
			if ( isset($res[2]) ) {
				if ( $res[2]=='SOD.jpg' ) {
					$modulo = 'SOD';
				} elseif ( $res[2]=='SOS.jpg' ) {
					$modulo = 'SOS';
				} elseif ( $res[2]=='ENCARTES.jpg' ) {
					$modulo = 'ENCARTES';
				}
			}

			$modulo_ = $modulo;
			$modulo_ = $modulo_=='moduloFotos' ? 'FOTOS' : $modulo_ ;
			$hora = $modulo_=='FOTOS' ? $row['hora'] : $hora;

			$cuerpo .= '<div class="carousel-item '.$claseActiva.'">';
				// $cuerpo .= '<center class="mb-2">Módulo: <strong>'.$row['modulo'].'</strong>'.$hora.'</center>';

				$cuerpo .= '
				<div class="w-100 mb-3 p-0">
					<div class="card-body p-0">
						<ul class="nav nav-tabs nav-justified">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" data-value="1"><strong>'.$row['modulo'].'</strong></a>
							</li>
						</ul>
					</div>
				</div>';

				$cuerpo .= '
				<div style="margin-bottom:5px;">
					<label style="font-weight: bold;font-size: 15px;">Perfil: <label style="font-weight: 200;">'.$perfil.'</label></label><br>
					<label style="font-weight: bold;font-size: 15px;">Usuario: <label style="font-weight: 200;">'.$usuario.'</label></label><br>
				';
				(!empty($hora) ? $cuerpo .= '
					<label style="font-weight: bold;font-size: 15px;">Hora: <label style="font-weight: 200;">'.$hora.'</label></label><br>
				' : '');
				$cuerpo .= '
				</div>
				';

				$cuerpo .= '<img class="d-block w-100" src="'.site_url("controlFoto/obtener_carpeta_foto/{$modulo}/{$row['foto']}").'" alt="'.$row['modulo'].'">';
				$cuerpo .= '<div class="font-weight-bold mt-2" style="font-size: 17px;text-align: right;">'.$i++.'/'.count($fotos).'</div>';
			$cuerpo .= '</div>';
		}
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
</div>