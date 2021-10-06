<style>
	.chart-map{
		height: 500px;
	}
</style>

<div id="regions-chart" class="chart-map"></div>

<? 
	$arrayRegiones = array(); 
	foreach ($regiones as $kr => $row){
		$arr = array(
			'id' => $row['idMap']
			, 'value' => $row['value']
			, 'valueEF' => !empty($row['valueEF']) ? $row['valueEF'] : 0
			, 'valueNE' => !empty($row['valueNE']) ? $row['valueNE'] : 0
			, 'valueIN' => !empty($row['valueIN']) ? $row['valueIN'] : 0
			, 'valueSV' => !empty($row['valueSV']) ? $row['valueSV'] : 0
		);
		array_push($arrayRegiones, $arr);
	}
?>

<script>
	var colorCuenta = "";

	anychart.onDocumentReady(function(){
		//Cargamos la data
		var dataSet = <? echo json_encode($arrayRegiones);?>;
		console.log('DataSet',dataSet);

		//Creamos la variable MAPA
		var map = anychart.map();

		//Asignamos el pais
		map.geoData(anychart.maps.peru);

		//Asignamos la data
		var series = map.choropleth(dataSet);

		//Set the container
		map.container('regions-chart');

		//Vista HOVER mouse
		map.tooltip()
			.useHtml(true)
			.width(250)
			.title({fontColor: '#7c868e'})
			.format( function(e){
				return '<span>Visitas Programadas: '+e.getData('value')+'</span><br>'+
					'<span>Visitas Efectivas: '+e.getData('valueEF')+'</span><br>'+
					'<span>Visitas No Efectivas: '+e.getData('valueNE')+'</span><br>'+
					'<span>Visitas Incidencia: '+e.getData('valueIN')+'</span><br>'+
					'<span>Sin Visitar: '+e.getData('valueSV')+'</span><br>';
			});

		//Graficamos el mapa
		map.draw();
	});

</script>