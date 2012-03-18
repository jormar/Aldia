<?php get_header() ?>

    <div class="login">
        <?php Message::print_all_messages() ?>

        <form action="<?php echo site_url('accounts/login') ?>" method="POST">
            <p>
                <label for="u">Correo Electr&oacute;nico:</label><br />
                <input type="text" class="input" name="u" id="u" value="<?php echo $this->input->post('u') ?>" />
            </p>
            <p>
                <label for="p">Contrase&ntilde;a:</label><br />
                <input type="password" value="" class="input" name="p" id="p" />
            </p>
            <p class="submit">
                <input type="submit" class="" value="Entrar" name="submit-sesion" />
                <input type="hidden" name="redirectTo" value="<?php echo $REDIRECT_TO ?>" />
            </p>
        </form>
        <p class="nav">
            <a href="<?php echo base_url('usuario/registro') ?>">Registrarse</a>
            |
            <a href="<?php echo base_url('accounts/password_recovery') ?>">Recuperar Contrase&ntilde;a</a>
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