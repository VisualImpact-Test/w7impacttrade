<div style="padding:20px; border: 1px solid #E6E9ED;">
	<form name="editarIniciativas" id="editarIniciativas" method="post" autocomplete="off">
		<div class="form-group">
			<label>PRESENCIA</label>
			<select class="form-control" name="sel-presencia" id="sel-presencia">
				<? $selected1 =($iniciativas[0]['presencia']==1)?'selected':''; ?>
				<? $selected0 =($iniciativas[0]['presencia']==0)?'selected':''; ?>
				<option value="1" <?=$selected1?>>PRESENTE</option>
				<option value="0"<?=$selected0?>>NO PRESENTE</option>
			</select>
		</div>
		<div class="form-group">
			<label>MOTIVO</label>
			<select class="form-control" name="sel-motivo" id="sel-motivo">
				<option value="0">SELECCIONE MOTIVO</option>
				<? foreach($estados as $row){ ?>
				<?
					$selected =($iniciativas[0]['idEstadoIniciativa']==$row['idEstadoIniciativa'])?'selected':'';
				?>
				<option value="<?=$row['idEstadoIniciativa']?>" <?=$selected?>><?=$row['nombre']?></option>
				<? } ?>
			</select>
		</div>
		<div class="form-group">
			<label>CANTIDAD</label>
			<input type="int" class="form-control input-sm" id="txt-cantidad" name="txt-cantidad" value="<?=$iniciativas[0]['cantidad']?>" readonly="">
		</div>
	  <!-- input hidden -->
	    <input type="hidden" name="idIniciativaDet" id="idIniciativaDet" value="<?=$iniciativas[0]['idVisitaIniciativaTradDet']?>">
	    <input type="hidden" name="idMotivo" id="idMotivo" value="<?=$iniciativas[0]['idEstadoIniciativa']?>">
	  <!-- input hidden -->
	  <!--<button type="submit" class="btn btn-primary" style="margin-bottom: 0px;float: right !important" id="btn-actualizar-iniciativas" disabled="">Actualizar</button>-->
	</form>
	<div id="resultadoIniciativasEditar" style="margin-top:15px;"></div>
</div>