<?php get_header() ?>
<?php
	echo '<script>var map;
	var markersArray = [];

	$(document).ready(function() {
		var latlng = new google.maps.LatLng('.$PROYECTO->proy_map_lat.','.$PROYECTO->proy_map_long.');
		var myOptions = {
      			zoom: 5,
      			center: latlng,
     			mapTypeId: google.maps.MapTypeId.ROADMAP
    		};
    		map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
		google.maps.event.addListener(map, \'click\', function(event) {
    			placeMarker(event.latLng);
  		});

		var marker = new google.maps.Marker({
      			position: new google.maps.LatLng('.$PROYECTO->proy_map_lat.','.$PROYECTO->proy_map_long.'), 
     	 		map: map
  		});

		markersArray.push(marker);
	});

	function placeMarker(location) {
		if(markersArray.length != 0) {
			markersArray[0].setMap(null);
			markersArray = [];
		}
		var zoomAux = document.getElementById("proy_map_zoom");
		var latitudAux = document.getElementById("proy_map_lat");
		var longitudAux = document.getElementById("proy_map_long");

		zoomAux.value = map.getZoom();
		latitudAux.value = location.lat();
		longitudAux.value = location.lng();

  		var marker = new google.maps.Marker({
      			position: location, 
     	 		map: map
  		});
	
		markersArray.push(marker);
		map.setCenter(location);
	}	

	</script>'; ?>


    <h3 class=""><?php echo $PROYECTO->proy_titulo ?></h3>

    <?php get_sidebar('proyecto_menu') ?>

    <p class="top-info">
        Indique aqu&iacute todos los datos del proyecto.<br/>
	Una vez creado el proyecto, puede volver a cambiar estos datos para ajustarlos en la medida que se va desarrollando el mismo.<br/>
	Mientras m&aacute;s datos aporte sobre el proyecto, tendr&aacute;
        mejores oportunidades de conseguir financiamiento.
    </p>

    <div class="register-form">
        <?php Message::print_all_messages() ?>
        <?php // Message::print_all_form_errors() ?>

        <form action="<?php echo site_url('proyecto/datos/'.$PROYECTO->proy_id) ?>" method="POST">

            <?php $input = 'proy_titulo' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> T&iacute;tulo:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'proy_tipo' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class=""><span class="required">*</span> Tipo de proyecto:</label>
                <select name="<?php echo $input ?>" id="<?php echo $input ?>" >
                    <option value="">Seleccione...</option>
					<?php foreach(get_proy_tipos() as $key => $value ) { ?>
                    <option value="<?php echo $key ?>" <?php if($PROYECTO->$input == $key) echo 'selected' ?> ><?php echo $value ?></option>
					<?php } ?>
                </select>
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'proy_justificacion' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Naturaleza y Justificaci&oacute;n:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $PROYECTO->$input ?></textarea>
		<button type="button" id="helpBut1" onClick="mostrar('helpBut1','helpSpan1','helpP1')" style="border-style:none;color:red;background-color:#FFFFFF;cursor: help;border-style:outset;">+</button> <span id="helpSpan1"><b>Ayuda:</b> breve descripci&oacuten del proyecto y el motivo de su realizaci&oacuten</span>
		<p id="helpP1" class="helpP1" style="text-align: justify;display:none;cursor:pointer;margin-left:16px;margin-right:14px;" onClick="mostrar('helpBut1','helpSpan1','helpP1')">
			<b>Mencionar a quien va dirigido el proyecto (niños,adultos, deportistas, tercera edad), de que tratara (cultura, deportivo, administrativo, entre otros) y el fin de la realizaci&oacuten del proyecto<br/><br/>
			Ejemplo: este proyecto va dirigido a la comunidad adolescente con interes deportivo ya que se construira una cancha con el fin de alejar a la juventud de los malos pasos y promover el deporte en la comunidad X</b>
		</p>
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'proy_obj_gen' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Objetivo General:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $PROYECTO->$input ?></textarea>
		<button type="button" id="helpBut2" onClick="mostrar('helpBut2','helpSpan2','helpP2')" style="border-style:none;color:red;background-color:#FFFFFF;cursor: help;border-style:outset;">+</button> <span id="helpSpan2"><b>Ayuda:</b> las metas principales que desea lograr con el proyecto</span>
		<p id="helpP2" class="helpP2" style="text-align: justify;display:none;cursor:pointer;margin-left:16px;margin-right:14px;" onClick="mostrar('helpBut2','helpSpan2','helpP2')">
			<b>Describir los fines al momentos de realizar el proyecto de manera general, sin lujo de detalles, es decir, describir a grandes rasgos el proyecto<br/><br/>
			Ejemplo: <br/>
			&nbsp&nbsp1) Estudiar el terreno de la cancha deportiva<br/>
			&nbsp&nbsp2) Montar sistema de electricidad<br/>
			&nbsp&nbsp3) Montar sistema de cableado electrico<br/>
			.<br/>
			.<br/>
			.</b>
		</p>
                <?php echo Message::print_form_error($input) ?>
            </div>

			<?php $input = 'proy_obj_esp' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Objetivos espec&iacute;ficos:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $PROYECTO->$input ?></textarea>
		<button type="button" id="helpBut3" onClick="mostrar('helpBut3','helpSpan3','helpP3')" style="border-style:none;color:red;background-color:#FFFFFF;cursor: help;border-style:outset;">+</button> <span id="helpSpan3"><b>Ayuda:</b> las metas detalladas de que desea lograr con el proyecto</span>
		<p id="helpP3" class="helpP3" style="text-align: justify;display:none;cursor:pointer;margin-left:16px;margin-right:14px;" onClick="mostrar('helpBut3','helpSpan3','helpP3')">
			<b>Describir los fines al momentos de realizar el proyecto de manera mas detallada, puede intetar desglosar los objetivos generales en tareas m&aacutes especializadas<br/><br/>
			Ejemplo: <br/>
			&nbsp&nbsp1) Sondear las rocas<br/>
			&nbsp&nbsp2) Sondear el suelo<br/>
			&nbsp&nbsp3) Perforaci&oacuten del suelo<br/>
			&nbsp&nbsp4) Diagramar cableado electrico<br/>
			&nbsp&nbsp5) Montar tablero el&eacutectrico<br/>
			.<br/>
			.<br/>
			.</b>
		</p>                
		<?php echo Message::print_form_error($input) ?>
            </div>
			
			<?php $input = 'proy_cobertura_geo' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">&Aacute;mbito Geogr&aacute;fico:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $PROYECTO->$input ?></textarea>
		<button type="button" id="helpBut4" onClick="mostrar('helpBut4','helpSpan4','helpP4')" style="border-style:none;color:red;background-color:#FFFFFF;cursor: help;border-style:outset;">+</button> <span id="helpSpan4"><b>Ayuda:</b> describir el ambiente donde se desarrolla el proyecto</span>
		<p id="helpP4" class="helpP4" style="text-align: justify;display:none;cursor:pointer;margin-left:16px;margin-right:14px;" onClick="mostrar('helpBut4','helpSpan4','helpP4')">		
		<b>Describir las condiciones f&iacutesico naturales del lugar (humedad, &eacutepoca de lluvias, tipo de suelo)<br/><br/>
			Ejemplo: las precipitaciones en el lugar son frecuentes, un alto nivel de humedad por lo que la cancha debería ser cerrada y con aire acondicionado, el suelo es arcilloso (suelo no muy recomendable para la construcci&oacuten)</b>
		</p>                
		<?php echo Message::print_form_error($input) ?>
            </div>
			
			<?php $input = 'proy_benef' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Beneficiarios:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $PROYECTO->$input ?></textarea>
		<button type="button" id="helpBut5" onClick="mostrar('helpBut5','helpSpan5','helpP5')" style="border-style:none;color:red;background-color:#FFFFFF;cursor: help;border-style:outset;">+</button> <span id="helpSpan5"><b>Ayuda:</b> mencionar quienes ser&aacuten beneficiados</span>
		<p id="helpP5" class="helpP5" style="text-align: justify;display:none;cursor:pointer;margin-left:16px;margin-right:14px;" onClick="mostrar('helpBut5','helpSpan5','helpP5')">		
		<b>Mencionar las personas, entes u organizaciones favorecidas gracias a proyecto propuesto<br/><br/>
			Ejemplo: se beneficiaran a los j&oacutevenes deportista de edades comprendidas entre los 5 y 18 a&ntildeos</b>
		</p>
                <?php echo Message::print_form_error($input) ?>
            </div>

	    <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
		<table>
			<caption>N&uacute;mero de familias beneficiadas directamente</caption>
			<caption>(dentro de la comunidad)</caption>
			<tr>
				<td>Sexo/Edad</td>
				<td style="text-align:center">Hombres</td>
				<td style="text-align:center">Mujeres</td>
			</tr>
			<tr>
				<td>J&oacutevenes</td>
				<td><?php $input = 'proy_hom_jov_benf_direc' ?>
					<input type="text" style="width:70px;height:10px" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->proy_hom_jov_benf_direc ?>" />
                			<?php echo Message::print_form_error($input) ?>
				</td>
				<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
				<td><?php $input = 'proy_muj_jov_benf_direc' ?>
					<input type="text" style="width:70px;height:10px" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->proy_muj_jov_benf_direc ?>" />
					<?php echo Message::print_form_error($input) ?>
				</td>
			</tr>
			<tr>
				<td>Adultos</td>
				<td><?php $input = 'proy_hom_adult_benf_direc' ?>
					<input type="text" style="width:70px;height:10px" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->proy_hom_adult_benf_direc ?>" />
					<?php echo Message::print_form_error($input) ?>
				</td>
				<td></td>
				<td><?php $input = 'proy_muj_adult_benf_direc' ?>
					<input type="text" style="width:70px;height:10px" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->proy_muj_adult_benf_direc ?>" />
					<?php echo Message::print_form_error($input) ?>
				</td>
			</tr>
			<tr>
				<td>3ra edad</td>
				<td><?php $input = 'proy_hom_ter_benf_direc' ?>
					<input type="text" style="width:70px;height:10px" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->proy_hom_ter_benf_direc ?>" />
					<?php echo Message::print_form_error($input) ?>
				</td>
				<td></td>
				<td><?php $input = 'proy_muj_ter_benf_direc' ?>
					<input type="text" style="width:70px;height:10px" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->proy_muj_ter_benf_direc ?>" />
					<?php echo Message::print_form_error($input) ?>
				</td>
			</tr>
		</table>
	    </div>

	    <div style="background:none;border:none;" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
		<table>
			<caption>N&uacute;mero de familias beneficiadas indirectamente</caption>
			<caption>(dentro de la comunidad)</caption>
			<tr>
				<td>Sexo/Edad</td>
				<td style="text-align:center">Hombres</td>
				<td></td>
				<td style="text-align:center">Mujeres</td>
			</tr>
			<tr>
				<td>J&oacutevenes</td>
				<td><?php $input = 'proy_hom_jov_benf_indirec' ?>
					<input type="text" style="width:70px;height:10px" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->proy_hom_jov_benf_indirec ?>" />
					<?php echo Message::print_form_error($input) ?>
				</td>
				<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
				<td><?php $input = 'proy_muj_jov_benf_indirec' ?>
					<input type="text" style="width:70px;height:10px" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->proy_muj_jov_benf_indirec ?>" />
					<?php echo Message::print_form_error($input) ?>
				</td>
			</tr>
			<tr>
				<td>Adultos</td>
				<td><?php $input = 'proy_hom_adult_benf_indirec' ?>
					<input type="text" style="width:70px;height:10px" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->proy_hom_adult_benf_indirec ?>" />
					<?php echo Message::print_form_error($input) ?>
				</td>
				<td></td>
				<td><?php $input = 'proy_muj_adult_benf_indirec' ?>
					<input type="text" style="width:70px;height:10px" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->proy_muj_adult_benf_indirec ?>" />
					<?php echo Message::print_form_error($input) ?>
				</td>
			</tr>
			<tr>
				<td>3ra edad</td>
				<td><?php $input = 'proy_hom_ter_benf_indirec' ?>
					<input type="text" style="width:70px;height:10px" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->proy_hom_ter_benf_indirec ?>" />
					<?php echo Message::print_form_error($input) ?>
				</td>
				<td></td>
				<td><?php $input = 'proy_muj_ter_benf_indirec' ?>
					<input type="text" style="width:70px;height:10px" class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->proy_muj_ter_benf_indirec ?>" />
					<?php echo Message::print_form_error($input) ?>
				</td>
			</tr>
		</table>
	    </div>
			
			<?php $input = 'proy_resultado' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Resultados esperados:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $PROYECTO->$input ?></textarea>
		<button type="button" id="helpBut6" onClick="mostrar('helpBut6','helpSpan6','helpP6')" style="border-style:none;color:red;background-color:#FFFFFF;cursor: help;border-style:outset;">+</button> <span id="helpSpan6"><b>Ayuda:</b> que se espera lograr</span>
		<p id="helpP6" class="helpP6" style="text-align: justify;display:none;cursor:pointer;margin-left:16px;margin-right:14px;" onClick="mostrar('helpBut6','helpSpan6','helpP6')">		
		<b>Tama&ntildeo del proyecto, tiempo de logro, cantidad de personas que lo usaran, complemento social que satisfacer&aacute<br/><br/>
			Ejemplo: la cancha deportiva abarcara 120x300 metros cuadrados, se espera terminar en un tiempo de 90 d&iacuteas para el uso de unas 50 personas por d&iacutea y complementar&aacute el desarrollo integral, social y la salud de la comunidad juvenil del sector X</b>
		</p>
                <?php echo Message::print_form_error($input) ?>
            </div>
			
			<?php $input = 'proy_impacto' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Impacto esperado:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $PROYECTO->$input ?></textarea>
		<button type="button" id="helpBut7" onClick="mostrar('helpBut7','helpSpan7','helpP7')" style="border-style:none;color:red;background-color:#FFFFFF;cursor: help;border-style:outset;">+</button> <span id="helpSpan7"><b>Ayuda:</b> que tanto mejorar&aacute la sociedad con el proyecto</span>
		<p id="helpP7" class="helpP7" style="text-align: justify;display:none;cursor:pointer;margin-left:16px;margin-right:14px;" onClick="mostrar('helpBut7','helpSpan7','helpP7')">
		<b>Cantidad de personas a beneficiar, caracter&iacutesticas que mejoran en la comunidad y en que cantidad mejor&aacuten<br/><br/>
			Ejemplo: aproximadamente 50 personas se benefician de la cancha deportiva la cual esperemos mejore en un 30% la condici&oacute f&iacutesica de los deportistas juveniles de la comunidad</b>
		</p>
                <?php echo Message::print_form_error($input) ?>
            </div>

		<?php $input = 'proy_lugar' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
		<label for="<?php echo $input ?>" class="id">Lugar de ejecuci&oacuten:</label>                
		<div id="map_canvas" style="width:100%; height:300px"></div>
		<button type="button" id="helpBut8" onClick="mostrar('helpBut8','helpSpan8','helpP8')" style="border-style:none;color:red;background-color:#FFFFFF;cursor: help;border-style:outset;">+</button> <span id="helpSpan8"><b>Ayuda:</b> click izquierdo sobre el mapa para escoger ubicaci&oacuten del proyecto</span>
		<p id="helpP8" class="helpP8" style="text-align: justify;display:none;cursor:pointer;margin-left:16px;margin-right:14px;" onClick="mostrar('helpBut8','helpSpan8','helpP8')">
		<b>Presione click izquierdo para seleccionar<br/><br/>
			Ejemplo: presione click izquierdo para seleccionar la zona donde se efectuara el proyecto</b>
		</p>

		<div>
				<?php $input = 'proy_map_zoom' ?>
		<input type="text" style="display:none" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->$input ?>" />
				<?php $input = 'proy_map_lat' ?>
		<input type="text" style="display:none" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->$input ?>" />
				<?php $input = 'proy_map_long' ?>
		<input type="text" style="display:none" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->$input ?>" />
		</div>
                <?php echo Message::print_form_error($input) ?>
            </div>
			
			<?php $input = 'proy_fecha_culm' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="">Fecha de culminaci&oacute;n:</label>
                <input type="text" class="input datepicker" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $PROYECTO->$input ?>" />
                <span class="info">(Formato: YYYY-MM-DD)</span>
                <?php echo Message::print_form_error($input) ?>
			</div>

            <hr />
            <p class="top-info">
                <strong>
                    Recuerde que todos los datos que suminstre para el proyecto
                    pueden (y ser&aacute;n) revelados, sin previo aviso, a las
                    entidades aliadas interesadas en invertir en su proyecto.
                </strong> Sin embargo, esta misma informaci&oacute;n no ser&aacute;
                revelada en detalles a las otras organizaciones registradas en
                su comunidad.
            </p>
			
            <div class="submit">
                <input type="hidden" value="by-ajax" name="submit-proy-datos" />
                <input type="submit" class="" value="Guardar los cambios" name="submit-proy-datos" />
            </div>
        </form>
    </div>

    <script>
	jQuery(function() {
        // Botones
		jQuery( "input:submit").button();
		jQuery('.datepicker').datepicker({
			dateFormat: 'yy-mm-dd'
		});
        jQuery('html,body').animate({scrollTop: jQuery(".error").offset().top}, 'slow');
	});
	</script>

    <script type="text/javascript" src="<?php echo $THEME_FOLDER ?>/js/tiny_mce/tiny_mce.js"></script>

<script type="text/javascript">

tinyMCE.init({
        // General options
        mode : "specific_textareas",
		editor_selector : "tinymce-edit",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        theme_advanced_resize_horizontal: false,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        content_css : "<?php echo $THEME_FOLDER ?>/css/editor.css",

        // Drop lists for link/image/media/template dialogs
        // template_external_list_url : "js/template_list.js",
        // external_link_list_url : "js/link_list.js",
        // external_image_list_url : "js/image_list.js",
        // media_external_list_url : "js/media_list.js",

        // Replace values for the template plugin
//        template_replace_values : {
//                username : "Some User",
//                staffid : "991234"
//        }

    /*
       setup : function(ed) {
        ed.onInit.add(function() {
            var e = tinymce.DOM.get(ed.id + '_tbl'), ifr = tinymce.DOM.get(ed.id + '_ifr'), w = ed.getWin(), dh;
            var h = 15; //new height of edit area
            dh = e.clientHeight - ifr.clientHeight; //get the height of the toolbars
            ed.theme.resizeTo(w.clientWidth, h + dh);
        });
      }
      */
});

</script>

<?php get_footer() ?>
