<?php get_header() ?>

    <div class="login">
        <?php Message::add_warning( 'Por favor, introduzca su correo electr&oacute;nico. Usted recibir&aacute; un enlace para crear una nueva contrase&ntilde;a v&iacute;a email.' ); ?>
        <?php Message::print_all_messages() ?>

        <form action="<?php echo site_url('accounts/password_recovery') ?>" method="POST">
            <p>
                <label for="recovery_email">Correo Electr&oacute;nico:</label><br />
                <input type="text" class="input" name="recovery_email" id="recovery_email" value="<?php echo $this->input->post('u') ?>" />
            </p>
            <p class="submit">
                <input type="submit" class="" value="Enviar" name="submit-recovery" />
                <input type="hidden" name="redirectTo" value="<?php echo $REDIRECT_TO ?>" />
            </p>
        </form>
        <p class="nav">
            <a href="<?php echo base_url('accounts/login') ?>">Iniciar sesi&oacute;n</a>
            |
            <a href="<?php echo base_url('usuario/registro') ?>">Registrarse</a>
        </p>
    </div>

    <script>
	jQuery(function() {
        // Botones
		jQuery( "input:submit").button();
        jQuery( ".error" ).error();
	});
	</script>

<?php get_footer() ?>