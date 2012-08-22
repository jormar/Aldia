<?php get_header() ?>
<h3 class="">Ver Organizaci&oacute;n</h3>

     <p class="top-info">
         Desde esta p&aacute;gina puede ver la informaci&oacute;n disponible sobre esta organizaci&oacute;n. 
    </p>


        <?php Message::print_all_messages() ?>
        <?php // Message::print_all_form_errors() ?>


	<?php $input = 'nombre_org' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
			<label for="<?php echo $input ?>" class="id"><span class="required">*</span> Nombre de la organizaci&oacute;n:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
        <?php $input = 'sector_org' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                        <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Sector de la organizaci&oacute;n:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
        <?php $input = 'desc_org' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
				<label for="<?php echo $input ?>" class="id"><span class="required">*</span> Descripci&oacute;n de la organizaci&oacute;n:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
        <hr />
        <h2>Documentos</h2>



<?php get_footer() ?>


