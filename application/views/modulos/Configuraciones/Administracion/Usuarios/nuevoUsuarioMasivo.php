<div class="row themeWhite">
	<div class="col-md-12">
		<div class="mb-3 mt-3 card">
			<div class="card-header">
				CARGA MASIVA DE RUTAS
			</div>
			<div class="card-body">
				<div class="">
					<div class="alert alert-warning" role="alert">
						<i class="fas fa-check-circle"></i> La columna <strong>CÓDIGO USUARIO (*)</strong> es generado por el sistema, no es necesario ingresar.<br>
						<i class="fas fa-check-circle"></i> Se pide que los valores a ingresar en la tabla sean en letra <strong>MAYÚSCULA</strong>, para estandarizar y evitar inconvenientes.<br>
						<i class="fas fa-check-circle"></i> Si algunas celdas aparecen en color <strong>rojo</strong>, a pesar de no tener información, se recomienda verificar que no exista espacios en blanco.<br>
						<i class="fas fa-check-circle"></i> La carga masiva tiene un tope <strong>máximo de 500 filas</strong>, si usted dispone de más datos, se recomienda realizar el procedimiento dos veces.<br>
					</div>
				</div>
				<div class="tab-content">
					<div class="table-responsive">
						<div id="nuevoUsuarioMasivo"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	Usuarios.datatipoDocumento = JSON.parse('<?=json_encode($tipoDocumento)?>');
	Usuarios.dataProyecto = JSON.parse('<?=json_encode($listaProyectos)?>');
	Usuarios.dataTipoUsuario = JSON.parse('<?=json_encode($tipoUsuario)?>');
	Usuarios.dataAplicacion = JSON.parse('<?=json_encode($aplicacion)?>');
	/*Visitas.dataListaUsuarios = JSON.parse('<?=json_encode($listaUsuarios)?>');
	Visitas.dataListaUsuariosNombres = JSON.parse('<?=json_encode($listaUsuariosNombres)?>');*/
	
</script>