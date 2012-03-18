<?php get_header() ?>

    <h3 class="">Se registro con &eacute;xito en el sistema</h3>

    <p class="top-info">
        Estimado(a) <?php echo $USER->user_nombre . ' ' . $USER->user_apellido ?>, sus datos fueron registrados de forma satisfactoria.
    </p>
    <p class="top-info">
        Para poder empezar a usar el sistema debe esperar a que un administrador
        verifique sus datos, y le autorice el acceso. Cuando esto ocurra, le llegara
        un correo con la confirmación de sus credenciales de acceso.
    </p>

    <script>
	jQuery(function() {
        // Botones
		jQuery( "input:submit").button();
	});
	</script>

<?php get_footer() ?>