<?php get_header() ?>
    <h3 class="">Proponer un proyecto nuevo</h3>

    <p class="top-info">
        Esta a punto de crear un proyecto nuevo.
        Mientras m&aacute;s datos aporte sobre el proyecto, tendr&aacute;
        mejores oportunidades de conseguir financiamiento.
    </p>

    <div class="register-form">
        <?php Message::print_all_messages() ?>
        <?php // Message::print_all_form_errors() ?>

        <form action="<?php echo site_url('proyecto/nuevo') ?>" method="POST">

            <?php $input = 'proy_titulo' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> T&iacute;tulo:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'proy_tipo' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class=""><span class="required">*</span> Tipo de proyecto:</label>
                <select name="<?php echo $input ?>" id="<?php echo $input ?>" >
                    <option value="">Seleccione...</option>
					<?php foreach(get_proy_tipos() as $key => $value ) { ?>
                    <option value="<?php echo $key ?>" <?php if($this->input->post($input) == $key) echo 'selected' ?> ><?php echo $value ?></option>
					<?php } ?>
                </select>
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'proy_justificacion' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Naturaleza y Justificaci&oacute;n:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $this->input->post($input) ?></textarea>
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'proy_obj_gen' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Objetivo General:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $this->input->post($input) ?></textarea>
                <?php echo Message::print_form_error($input) ?>
            </div>

			<?php $input = 'proy_obj_esp' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Objetivos espec&iacute;ficos:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $this->input->post($input) ?></textarea>
                <?php echo Message::print_form_error($input) ?>
            </div>
			
			<?php $input = 'proy_cobertura_geo' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">&Aacute;mbito Geogr&aacute;fico:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $this->input->post($input) ?></textarea>
                <?php echo Message::print_form_error($input) ?>
            </div>
			
			<?php $input = 'proy_benef' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Beneficiarios:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $this->input->post($input) ?></textarea>
                <?php echo Message::print_form_error($input) ?>
            </div>
			
			<?php $input = 'proy_fam_benf_direc' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="">N&uacute;mero de familias beneficiadas directamente:</label>
                <input type="text" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'proy_fam_benf_indirec' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
				<label for="<?php echo $input ?>" class="">N&uacute;mero de familias beneficiadas indirectamente:</label>
                <input type="text" class="input small" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
			
			<?php $input = 'proy_resultado' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Resultados esperados:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $this->input->post($input) ?></textarea>
                <?php echo Message::print_form_error($input) ?>
            </div>
			
			<?php $input = 'proy_impacto' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Impacto esperado:</label>
                <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $this->input->post($input) ?></textarea>
                <?php echo Message::print_form_error($input) ?>
            </div>
			
			<?php $input = 'proy_fecha_culm' ?>
            <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="">Fecha de culminaci&oacute;n:</label>
                <input type="text" class="input datepicker" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
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

            <p class="top-info">
                Una vez creado el proyecto, puede volver a cambiar estos datos para
                ajustarlos en la medida que se va desarrollando el mismo.
            </p>
			
            <div class="submit">
                <input type="submit" class="" value="Crear Proyecto" name="submit-proy-nuevo" />
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
        // plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
        plugins: "save",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,bullist,numlist",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_buttons4 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,
        theme_advanced_resize_horizontal: false,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver"

        // Example content CSS (should be your site CSS)
        // content_css : "css/example.css",

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