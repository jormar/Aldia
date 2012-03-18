<?php get_header() ?>

    <h3 class="">Registro de usuario</h3>
    

    <div class="register-form">
        <?php Message::print_all_messages() ?>
        <?php // Message::print_all_form_errors() ?>

        <form action="<?php echo site_url('usuario/registro') ?>" method="POST">

            <?php $input = 'user_email' ?>
            <div class="field <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Correo Electr&oacute;nico:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'user_pass' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Contrase&ntilde;a:</label>
                <input type="password" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php // echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'user_pass2' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Confirmar contrase&ntilde;a:</label>
                <input type="password" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php // echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
            
            <?php $input = 'user_nombre' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Nombre:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
            
            <?php $input = 'user_apellido' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Apellido:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
            
            <?php $input = 'user_sex' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Sexo:</label>
                <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>_M" value="m" <?php if ( $this->input->post($input) == 'm') echo 'checked' ?> /> <label for="<?php echo $input ?>_M">Hombre</label>
                <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>_F" value="f" <?php if ( $this->input->post($input) == 'f') echo 'checked' ?> /> <label for="<?php echo $input ?>_F">Mujer</label>
                <?php echo Message::print_form_error($input) ?>
            </div>
            
            <?php $input = 'user_ci' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> C&eacute;dula:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
            
            <?php $input = 'user_telf' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Tel&eacute;fono principal:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'user_telf_alt' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id">Tel&eacute;fono alternativo:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
            
            <?php $input = 'user_dir' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Direcci&oacute;n:</label>
                <textarea class="" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $this->input->post($input) ?></textarea>
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = '_check' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <p class="condiciones">
                    Usted entiende que los datos que suministre al sistema deben ser lo m&aacute;s precisos posibles,
                    y que &uacute;nicamente su <strong>Nombre, Apellido y tel&eacute;fono principal</strong>
                    pueden (y ser&aacute;n) revelados a sus compañeros dentro de la comunidad, y a cualquier
                    entidad interesada en participar en los proyectos que lleve a cabo.
                </p>
                <p class="condiciones">
                    El resto de sus datos (como, por ejemplo, su direcci&oacute;n) NO
                    ser&aacute;n revelados a terceros.
                </p>
                <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" /><label for="<?php echo $input ?>">He le&iacute;do y acepto estas condiciones.</label>

                <?php if( form_error($input) ) { ?>
                <div class="error-msg">Debe marcar la casilla de selecci&oacute;n, indicando que entiende y acepta estas peque&ntilde;as con diciones para usar el sistema.</div>
                <?php } ?>
            </div>

            <div class="submit">
                <input type="submit" class="" value="Registrarse" name="submit-registro" />
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