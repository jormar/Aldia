<?php get_header() ?>

    <h3 class=""><?php echo $COMUNIDAD->com_nombre ?></h3>
    

    <div class="register-form">
        <?php Message::print_all_messages() ?>

        <form action="<?php echo site_url('comunidad/perfil/'.$COMUNIDAD->com_id) ?>" method="POST">

            <?php $input = 'com_nombre' ?>
            <div class="field <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Nombre:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $COMUNIDAD->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'com_habitantes' ?>
            <div class="field <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Nro. de Habitantes:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $COMUNIDAD->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'com_familias' ?>
            <div class="field <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Nro. de familias:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $COMUNIDAD->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'com_estado' ?>
            <div class="field <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Estado:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $COMUNIDAD->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'com_municipio' ?>
            <div class="field <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Municipio:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $COMUNIDAD->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'com_parroquia' ?>
            <div class="field <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Parroquia:</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $COMUNIDAD->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <?php $input = 'com_area_geo' ?>
            <div class="field <?php if( form_error($input) ) echo 'error' ?>">
                <label for="<?php echo $input ?>" class="id">&Aacute;rea geogr&aacute;fica:</label>
                <textarea class="" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $COMUNIDAD->$input ?></textarea>
                <?php echo Message::print_form_error($input) ?>
            </div>

            <div class="submit">
                <input type="submit" class="" value="Guardar" name="submit-perfil-com" />
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