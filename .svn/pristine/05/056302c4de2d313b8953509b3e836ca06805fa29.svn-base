<p>Lista de Órdenes:</p>
<table style="width: 100%;">
<?$idCliente = '';?>
<?foreach($datos as $idAudClienteEvalPreg => $row){?>
	<?if( $idCliente != $row['idCliente'] ){?>
		<tr><td style="color: #000ca2;"><h3><b>Tienda:</b> <?=$row['cliente']?></h3></td></tr>
	<?}?>
	<tr><td style="margin-left: 2rem;"><b>Pregunta:</b> <?=$row['pregunta']?></td></tr>
	<tr><td style="margin-left: 2rem;"><b>Orden de Trabajo:</b> <?=$row['ordenTrabajo']?></td></tr>
	<?if( !empty($item[$idAudClienteEvalPreg]) ){?>
	<tr>
		<td style="margin-left: 2rem;">
			<b>Items Faltantes:</b>
			<?foreach($item[$idAudClienteEvalPreg] as $i){?>
				<li><?=$i?></li>
			<?}?>
		</td>
	</tr>
	<?}?>
	<tr><td colspan=2 style="border-bottom: 1px solid #dedede; text-align: right;" ><a href="<?=site_url('/liveStorecheckOrden/formulario/'.$idAudClienteEvalPreg)?>" target="_blank" >Responder</a></td></tr>
	<?$idCliente = $row['idCliente'];?>
<?}?>
</table>
<hr>
<p style="margin: 0;float:left;text-align:justify;font-size:0.7em;">Aviso: Este mensaje , así como los archivos adjuntos, ha sido elaborado únicamente para uso de la persona o entidad a la que es remitido, ya que puede contener información confidencial. Si el lector de este mensaje no es el destinatario señalado, le indicamos que cualquier divulgación , retransmisión o copia de esta comunicación, está estrictamente prohibida. Si Usted ha recibido esta comunicación por error , por favor sírvase informarlo de inmediato al remitente del correo electrónico y borrar inmediatamente el mensaje original.<br><br> Finalmente se deja establecido que el mensaje remitido a través de nuestro servidor de correo en caso no se refiera a información con nuestro giro profesional y propósitos del mismo, deberá entenderse como la opinión del remitente, bajo responsabilidad individual de éste, y sin que involucre o comprometa a nuestra organización con dicha opinión o comentario.</p>