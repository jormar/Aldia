<?php
/*
 * USER_NAME: el nombre del usuario al que se le envia el correo.
 * USER: el nombre del usuario al que se le envia el correo.
 */
?>
<p>
    Estimado(a) <?php echo $USER->user_nombre . ' ' . $USER->user_apellido ?>
</p>
<p>
	Se ha solicitado recuperar la contrase&ntilde;a de su cuenta.
	Para finalizar el proceso haga click en el siguiente link: <a href="<?php echo site_url('accounts/recovery_form/'.$USER->user_id.'/'.$USER->user_hash) ?>">recuperar contrase&ntilde;a</a>
</p>
<p>Si no puede hacer click en el link, copie y pegue el siguiente enlace en su navegador: <?php echo site_url('accounts/recovery_form/'.$USER->user_id.'/'.$USER->user_hash) ?></p>
<?php get_footer('emails/footer') ?>