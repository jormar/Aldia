<?php get_header() ?>

    <div class="login">
        <?php Message::print_all_messages() ?>
        <?php Message::print_all_form_errors() ?>

        <form action="<?php echo site_url('accounts/recovery_form/'.$USER_ID.'/'.$HASH) ?>" method="POST">
            <p>
                <label for="pass">Nueva Contrase&ntilde;a:</label><br />
                <input type="text" class="input" name="pass" id="pass" value="<?php echo $this->input->post('u') ?>" />
            </p>
            <p>
                <label for="pass2">Confirmar Contrase&ntilde;a:</label><br />
                <input type="text" class="input" name="pass2" id="pass2" value="<?php echo $this->input->post('u') ?>" />
            </p>
            <p class="submit">
                <input type="submit" class="" value="Cambiar contrase&ntilde;a" name="submit-recovery-pass" />
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