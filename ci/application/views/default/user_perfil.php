<?php get_header() ?>

    <h3 class="">Modificando Perfil</h3>
    

    <div class="register-form">
        <?php Message::print_all_messages() ?>

        <form action="<?php echo site_url('usuario/perfil/'.$USER->user_id) ?>" method="POST">

            <?php $input = 'user_email' ?>
            <div class="field <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Correo Electr&oacute;nico:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $USER->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'user_nombre' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id">Nombre:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $USER->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
            
            <?php $input = 'user_apellido' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id">Apellido:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $USER->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
            
            <?php $input = 'user_sex' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id">Sexo:</label>
                <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>_M" value="m" <?php if ( $USER->$input == 'm') echo 'checked' ?> /> <label for="<?php echo $input ?>_M">Hombre</label>
                <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>_F" value="f" <?php if ( $USER->$input == 'f') echo 'checked' ?> /> <label for="<?php echo $input ?>_F">Mujer</label>
                <?php echo Message::print_form_error($input) ?>
            </div>
            
            <?php $input = 'user_ci' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id">C&eacute;dula:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $USER->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
            
            <?php $input = 'user_telf' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id">Tel&eacute;fono principal:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $USER->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'user_telf_alt' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id">Tel&eacute;fono alternativo:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $USER->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
            
            <?php $input = 'user_dir' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id">Direcci&oacute;n:</label>
                <textarea class="" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $USER->$input ?></textarea>
                <?php echo Message::print_form_error($input) ?>
            </div>

            <div class="submit">
                <input type="submit" class="" value="Guardar" name="submit-perfil" />
            </div>
        </form>

        <hr />
        <h2>Recuperar Contrase&ntilde;a</h2>
        <form action="<?php echo site_url('usuario/perfil/'.$USER->user_id) ?>" method="POST">
            <?php $input = 'user_pass' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id">Nueva Contrase&ntilde;a:</label>
                <input type="password" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php // echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'user_pass2' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id">Confirmar contrase&ntilde;a:</label>
                <input type="password" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php // echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <div class="submit">
                <input type="submit" class="" value="Cambiar contrase&ntilde;a" name="submit-perfil-pass" />
            </div>
        </form>
    </div>

    <script>
	jQuery(function() {
        // Botones
		jQuery( "input:submit").button();
        jQuery('html,body').animate({scrollTop: $(".error").offset().top}, 'slow');
	});
	</script>

<?php get_footer() ?>