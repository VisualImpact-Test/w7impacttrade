<!-- div donde se dibuja el mapa-->
<div id="map_canvas_inicio" class="dv-maps"></div>
<script type="text/javascript">
  var lat = <?= $lati_1; ?>;
  var lng = <?= $long_1; ?>;
  var lat_cliente = <?= empty($lati_2) ? '0' : $lati_2; ?>;
  var lng_cliente = <?= empty($long_2) ? '0' : $long_2; ?>;
  var modulo = '<?php echo $modulo; ?>';

  initialize();

  function initialize() {

    geocoder = new google.maps.Geocoder();

    //Si hay valores creamos un objeto Latlng
    if (lat != '' && lng != '') {
      var latLng = new google.maps.LatLng(lat, lng);
    } else {
      //Si no creamos el objeto con una latitud cualquiera como la de Lima - Perú por ej
      if (modulo != 'pcr') {
        console.log("GPS USUARIO NO VALIDO");
      }

      var latLng = new google.maps.LatLng(-0, -0);
    }

    if (lat_cliente != '' && lng_cliente != '') {
      var latLng2 = new google.maps.LatLng(lat_cliente, lng_cliente);
    } else {
      //Si no creamos el objeto con una latitud cualquiera como la de Lima - Perú por ej
      if (modulo != 'pcr') {
        console.log("GPS CLIENTE NO VALIDO");
      }

      var latLng2 = new google.maps.LatLng(-0, -0);
    }

    //Definimos algunas opciones del mapa a crear
    var myOptions = {
      center: latLng, //centro del mapa
      zoom: 15, //zoom del mapa
      mapTypeId: google.maps.MapTypeId.ROADMAP //tipo de mapa, carretera, híbrido,etc
    };
    //creamos el mapa con las opciones anteriores y le pasamos el elemento div
    map = new google.maps.Map(document.getElementById("map_canvas_inicio"), myOptions);

    //creamos el marcador en el mapa
    marker = new google.maps.Marker({
      map: map, //el mapa creado en el paso anterior
      position: latLng, //objeto con latitud y longitud
      draggable: true, //que el marcador se pueda arrastrar
      icon: '<?= base_url() ?>public/assets/images/maps/icon.png'
    });

    marker2 = new google.maps.Marker({
      map: map, //el mapa creado en el paso anterior
      position: latLng2, //objeto con latitud y longitud
      draggable: true, //que el marcador se pueda arrastrar
      icon: '<?= base_url() ?>public/assets/images/maps/tienda.png'
    });

    google.maps.event.addListenerOnce(map, 'idle', function() {
      var currentCenter = map.getCenter();
      google.maps.event.trigger(map, 'resize');
      map.setCenter(currentCenter);

      map.setZoom(15);
    });

  }
</script>