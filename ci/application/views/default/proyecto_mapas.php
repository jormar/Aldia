<?php get_header() ?>
<span><b>Actividad</b></span>
<p><?php echo $actividad->act_desc; ?></p>
<br>
<span><b>Mapa</b></span>
<script>
var map;
function initialize() {

		var marker;
	  	  var  myOptions = {
	      zoom: 8,
	      center: new google.maps.LatLng(<?php echo $mapa->map_lang; ?>,
										 <?php echo $mapa->map_lat; ?>),
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    }

	  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

	  //Se cargar el marcador
	  
	  var marker_loc = new google.maps.LatLng(<?php echo $mapa->map_lat; ?>,
										      <?php echo $mapa->map_lang; ?>);
	  var load_marker = new google.maps.Marker({
		  position: marker_loc,
		  map: map
		  });

	  map.setCenter(marker_loc);

	 //var contenido = "hola"+ <?php echo $mapa->map_desc; ?> + " ";
	 //alert("<?php echo $mapa->map_desc; ?>");
	 var load_info = new google.maps.InfoWindow({ 	 
		      content: "<?php echo $mapa->map_desc; ?>",
      		  size: new google.maps.Size(50,50)
      });


	//Click Handler del marker cargado para desplegar la informacion
      google.maps.event.addListener(load_marker, 'click', function() {
		   
		   load_info.open(map,load_marker);

		   });


//Listener para agregar marcador al momento de hacer click
	  google.maps.event.addListener(map, 'click', function(event) {

			if(marker){
				  if(load_marker){
					  load_marker.setMap(null);
					  }
				  marker.setMap(null);
			  }
			if(load_marker){
					  load_marker.setMap(null);
				 }

			  var loc = event.latLng;
		  	  marker = new google.maps.Marker({
     		 	 position: loc,
     			 map: map
  			  });
			
			$("#map_lat").val(loc.lat());
			$("#map_lang").val(loc.lng()); 
  			map.setCenter(loc);
			
		//Box con la informacion del marker
   		 var infowindow = new google.maps.InfoWindow({ 	
			 content: "Agregue una descripción de la actividad",
   	   		 size: new google.maps.Size(50,50)
   		 });

		//Click Handler del maker para desplegar la informacion
			google.maps.event.addListener(marker, 'click', function() {
    				infowindow.open(map,marker);
 			 });
	  });

}




function loadScript() {
	  var script = document.createElement("script");
      script.type = "text/javascript";
	  script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyCqbQIBVYn7OMpzQC9YiTHTOpHsGx30XRU&sensor=true&callback=initialize";
      document.body.appendChild(script);
}

window.onload = loadScript;
</script>

<div id="map_canvas" style="width:100%; height:200px"></div>


<label id="lat"></label>
<br>
<label  id="lng"></label>

<form id="mapa_edita_form" action="<?php echo site_url('proyecto/editar_mapa/'.$actividad->act_id) ?>" method="POST">

	<?php $input = 'map_lat'; ?>
    <div>
    	<label for="<?php echo $input ?>" class=""></label>
    	<input type="hidden"   name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
        <?php echo Message::print_form_error($input) ?>
    </div>

	<?php $input = 'map_lang'; ?>
    <div>
    	<label for="<?php echo $input ?>" class=""></label>
    	<input type="hidden" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
        <?php echo Message::print_form_error($input) ?>
    </div>
    <?php $input = 'map_desc' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Descripción:</label>
            <textarea  name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $this->input->post($input) ?></textarea>
            <?php echo Message::print_form_error($input) ?>
        </div>


	<input type="submit" name="submit-map-editar" value="Establecer Marcador" />
</form>






<?php get_footer() ?>
