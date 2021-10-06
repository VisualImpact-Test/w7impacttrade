<h4><strong><?=$cliente?></strong></h4>
<p class="user-name">Perfil: <?=$perfil;?> <br>Usuario: <?=$usuario;?></p>
<!-- div donde se dibuja el mapa-->
<div id="map_canvas_inicio" class="dv-maps" style="height: 500px;"></div>
<script type="text/javascript">
lat = <?php echo $latitud; ?>;
lng = <?php echo $longitud; ?>;

lat_cliente = <?php echo $latitud_cliente; ?>;
lng_cliente= <?php echo $longitud_cliente; ?>;

initialize();

function initialize() {
     
      geocoder = new google.maps.Geocoder();
        
       //Si hay valores creamos un objeto Latlng
       if(lat !=0 && lng !=0)
      {
         var latLng1 = new google.maps.LatLng(lat,lng);
         var latLng2 = new google.maps.LatLng(lat_cliente,lng_cliente);
      }
      else
      {
        //Si no creamos el objeto con una latitud cualquiera como la de Lima - Perú por ej
         var latLng1 = new google.maps.LatLng(-12.0478158,-77.06220280000002);
      }
      //Definimos algunas opciones del mapa a crear
       var myOptions = {
          center: latLng1,//centro del mapa
          zoom: 15,//zoom del mapa
          mapTypeId: google.maps.MapTypeId.ROADMAP //tipo de mapa, carretera, híbrido,etc
        };
        //creamos el mapa con las opciones anteriores y le pasamos el elemento div
        map = new google.maps.Map(document.getElementById("map_canvas_inicio"), myOptions);
         
        //creamos el marcador en el mapa
        marker = new google.maps.Marker({
            map: map,//el mapa creado en el paso anterior
            position: latLng1,//objeto con latitud y longitud
            draggable: true, //que el marcador se pueda arrastrar
			icon:'<?=base_url()?>public/assets/images/maps/icon.png'
        });
		
		marker2 = new google.maps.Marker({
            map: map,//el mapa creado en el paso anterior
            position: latLng2,//objeto con latitud y longitud
            draggable: true, //que el marcador se pueda arrastrar
			icon:'<?=base_url()?>public/assets/images/maps/tienda.png'
        });
		
	google.maps.event.addListenerOnce(map, 'idle', function () {
                 var currentCenter = map.getCenter();
                 google.maps.event.trigger(map, 'resize');
                 map.setCenter(currentCenter);

                 map.setZoom(15);
             });
		
}
</script>