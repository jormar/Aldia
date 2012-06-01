<?php get_header() ?>
<h3 class="">Crear una organizaci&oacute;n</h3>
<p class="top-info">
</p>
<div class="register-form">

        <?php Message::print_all_messages() ?>
        <?php // Message::print_all_form_errors() ?>

<form action="<?php echo site_url('organizacion/nuevo') ?>" method="POST">
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

         <div class="submit">
                <input type="submit" class="" value="Crear Organizaci&oacute;n" name="submit-org-nuevo" />
         </div>
</form>
  </div>
<?php get_footer() ?>


