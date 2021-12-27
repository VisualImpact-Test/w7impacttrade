<div class="col-md-12 col-sm-12 col-xs-12">
<br>
    <span style="color: #676767;" class="pt-4">FECHA: <b><?= get_fecha_larga($usuario['fecha'])." (".date_change_format($usuario['fecha']).")"?></b></span> <br>
    <div class="row px-3 pb-2" style="text-transform: uppercase;color: #676767;">
      <div class="column" >
        <p>
            Usuario: <b><?= $usuario['nombre']?></b> <br>
            Hora inicio Primera Visita: <b><?= "{$usuario['horaIni_primera_visita']} ";?></b> <br>
            Hora inicio Última Visita: <b><?= "{$usuario['horaIni_ultima_visita']} ";?></b> <br>
        </p>
        <img src="" alt="">
      </div>
      <div class="column px-4" >
        <p>
            Programados: <b><?= $usuario['programados']?></b> <br>
            Visitados: <b><?= $usuario['visitados']?></b> <br>
            Incidencias: <b><?= $usuario['incidencias']?></b> <br>
        </p>
      </div>
    </div>
    <div id="mapCanvas" style="width:100%;height:800px;"></div>
</div>
<script>
// Cargamos Ubicaciones Destinos
var ubicaciones=<?=json_encode($destinos);?>;
var marcadores = new Array();
var mensajes = new Array();
var indice=0; //console.log(ubicaciones);
$.each(ubicaciones, function(index, value) {
	var ubicacion = new Array();
    var icon;
	ubicacion.push(value.direccion);
    ubicacion.push(((value.latitud==null) || (value.latitud==0))?'-12.0864729':value.latitud);
    ubicacion.push(((value.longitud==null)|| (value.latitud==0))?'-77.0807102':value.longitud);
    if (value.accion=='sinvisita') {
        icon= '<?=base_url()?>public/assets/images/maps/tienda_1.png';
    } else {
        if(value.accion=='incidencia'){
            icon = '<?=base_url()?>public/assets/images/maps/tienda_2.png';
        }else if (value.fuera_de_rango == 1){
            icon = '<?=base_url()?>public/assets/images/maps/tienda_6.png';
        }else{
			icon = '<?=base_url()?>public/assets/images/maps/tienda_3.png';
        }

        if(value.primera_visita == 1){
            icon= '<?=base_url()?>public/assets/images/maps/tienda_5.png';
        }else if(value.ultima_visita == 1){
            icon= '<?=base_url()?>public/assets/images/maps/tienda_4.png';
        }

        if(value.accion == 'encurso'){
            icon= '<?=base_url()?>public/assets/images/maps/tienda_7.png';
        }
       
    };
    ubicacion.push(icon);
	ubicacion.push(value.hora);
	marcadores[indice] = ubicacion;
	//
    let fotos = ' <div class="row d-flex justify-content-center"> ';
    for (let i = 0; i < value.cantFotos; i++) {
        
        fotos += ` <div class="column px-2">`;
            fotos += ` <a href="javascript:;" style="margin-right:3px;font-size: 15px;" class="lk-show-foto" data-modulo="${value['foto'+i].carpeta}" data-foto="${value['foto'+i].foto}" >`;
                fotos += ` <img src="<?=base_url().'controlFoto/obtener_carpeta_foto/'?>${value['foto'+i].ruta}" alt="" height="50">`;
            fotos += ` </a>`;
        fotos += ` </div>`;
    }
    fotos += ' </div> ';
    let htmlEstadoVisita = '';
        if (value.accion=='incidencia'){
            htmlEstadoVisita = `
                                Estado: ${'Incidencia'}  <br>
                                Nombre Incidencia: ${value.incidencia} <br>
                                GPS: ${value.distance} ${value.gpsIni}<br>
            `;
        }else if(value.accion=='sinvisita')
        {
            htmlEstadoVisita = `
                                Estado: ${'Sin Visitar'} <br>
            `;
        }else if(value.accion=='encurso'){
            htmlEstadoVisita = `
                                Estado: ${'En curso'} <br>
                                GPS: ${value.distance} ${value.gpsIni}<br>
            `;
        }else{
            htmlEstadoVisita = `
                                Estado: ${'Efectiva'} <br>
                                GPS: ${value.distance} ${value.gpsIni}<br>
            `;
        }
	var html = `<div class="info_content">
                    <h5>${value.destino}</h5>
                    <p>${value.direccion} <br>
                    Fecha: ${value.fecha} <br>
                    Hora Inicio: ${value.hora} <br>
                    Hora Fin: ${value.hora_fin} <br>
                    ${htmlEstadoVisita}
                    </p>
                    ${fotos}
                </div>`;
	var contenido = new Array();
	contenido.push(html);
	mensajes[indice] = contenido;
	//
	indice++;
});

// Cargamos Geolocalizaciones Ruta
var geolocalizaciones=<?=json_encode($geolocalizacion);?>;
var startLatitud;
var startLongitud;
var endLatitud;
var endLongitud;
$.each(geolocalizaciones, function(index, value) {
	if(value.primero=='1'){
		startLatitud = value.latitud;
		startLongitud = value.longitud;
	}
	//
	if(value.ultimo=='1'){
		endLatitud = value.latitud;
		endLongitud = value.longitud;
	}
});

// Load initialize function
console.log(startLatitud, startLongitud);
console.log(endLatitud, endLongitud);
initialize();

function initialize(){
    var map;
    var line;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
		mapTypeId: google.maps.MapTypeId.ROADMAP
    };
	
	var directionDisplay;
    var directionsService = new google.maps.DirectionsService();
	directionsDisplay = new google.maps.DirectionsRenderer({
        suppressMarkers: false
    });
                    
    // Display a map on the web page
    map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
    map.setTilt(50);
	directionsDisplay.setMap(map);

    //Añadir flechas on the MAP
    line = new google.maps.Polyline({
        map:map,
        icons: [{
            icon:{
                path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                strokeColor:'#0000ff',
                fillColor:'#0000ff',
                fillOpacity:1,
                lineWidth: 10
            },
            repeat: '20px',
            path:[]
        }]
    })
        
    // Multiple markers location, latitude, and longitude
    var markers = marcadores; //console.log(marcadores);            
    // Info window content
    var infoWindowContent = mensajes;
        
    // Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Place each marker on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0],
			label: {
				text: markers[i][4],
				fontSize: '12px',
				color: "#C70E20",
				fontWeight: "bold"
			},
			//icon:'<?=base_url()?>public/img/maps/tienda.png'
            icon: {
				url: markers[i][3],
				labelOrigin: new google.maps.Point(17, 35)
			}
        });
        
        // Add info window to marker    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Center the map to fit all markers on the screen
        map.fitBounds(bounds);
    }
	
	
    // Direcciones de movimiento
	var waypts = [];
	$.each(geolocalizaciones, function(index, value) {
		if((value.primero!='1')&&(value.ultimo!='1')){
			latLng = new google.maps.LatLng(value.latitud, value.longitud)
            var path = line.getPath().getArray(), latLng;
            //path.push(latLng);
            //line.setPath(path);
			waypts.push({
				location: latLng,
				stopover: true
			});
		}
	});
	

    start = new google.maps.LatLng(startLatitud, startLongitud);
    end = new google.maps.LatLng(endLatitud, endLongitud);
	
	var request = {
        origin: start,
        destination: end,
        waypoints: waypts,
        optimizeWaypoints: true,
        travelMode: google.maps.DirectionsTravelMode.WALKING
    };

    var alerta = new google.maps.Circle({
      strokeColor: '#FF0000',
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: '#FF0000',
      fillOpacity: 0.35,
      map: map,
      center: startLongitud,
      radius: 100
    });

    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
            var route = response.routes[0];
        }
    });

    // Set zoom level
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(4);
        google.maps.event.removeListener(boundsListener);
    });
}
</script>