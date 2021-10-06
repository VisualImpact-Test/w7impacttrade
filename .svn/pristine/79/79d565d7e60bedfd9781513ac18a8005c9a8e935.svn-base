<div>
	<h4><strong><?=$cliente;?></strong></h4>
	<p class="user-name">Perfil: <?=$perfil;?><br>Usuario: <?=$usuario;?></p>
	
	<?
		$cabecera=''; $cuerpo='';
		foreach ($fotos as $kf => $row){
			$hora=''; $modulo='';
			$claseActiva = $kf==0 ? 'active':'';
			$cabecera .= '<li data-target="#carouselExampleIndicators" data-slide-to="'.$kf.'" class="'.$claseActiva.'"></li>';

			$modulo = $row['modulo']=='FOTOS' ? 'moduloFotos' : $row['modulo'];
			$res = explode("_", $row['foto']);
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
			$hora = $modulo_=='FOTOS' ? ' - Hora: <strong>'.$row['hora'].'</strong>' : $hora;

			$cuerpo .= '<div class="carousel-item '.$claseActiva.'">';
				$cuerpo .= '<center>Modulo: <strong>'.$modulo_.'</strong>'.$hora.'</center>';
				$cuerpo .= '<img class="d-block w-100" src="'.$this->fotos_url.$modulo.'/'.$row['foto'].'" alt="'.$row['modulo'].'">';
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