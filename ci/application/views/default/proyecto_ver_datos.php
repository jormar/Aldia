<?php get_header() ?>
    <h3 class=""><?php echo $PROYECTO->proy_titulo ?></h3>

    <?php // get_sidebar('proyecto_menu') ?>

    <div class="register-form">
        <div class="field field-box-white">
        <?php foreach( $USUARIOS as $usuario ) { ?>
            <br />
            <br />
            <strong><?php echo $usuario->rol ?>:</strong>
            <?php echo $usuario->user_nombre ?>
            <?php echo $usuario->user_apellido ?>.
            Telf.: <?php echo $usuario->user_telf ?>
        <?php } ?>
        </div>

        <?php $input = 'proy_tipo' ?>
        <div class="field field-box-white">
            <strong>Tipo de proyecto:</strong> <?php echo ucwords($PROYECTO->$input) ?>
        </div>

        <?php $input = 'proy_costo' ?>
        <div class="field field-box-white">
            <strong>Costo estimado:</strong> <?php echo $PROYECTO->$input ?>
        </div>

        <?php $input = 'proy_obj_gen' ?>
        <div class="field field-box-white">
            <strong>Objetivo general:</strong>
            <br />
            <div class="preview"><?php echo html_entity_decode($PROYECTO->$input) ?></div>
        </div>

        <?php
            $current_user = user_get_data ();
            if ( $current_user->user_org_id == $PROYECTO->proy_org_id ) {
        ?>

        <?php $input = 'proy_justificacion' ?>
        <div class="field field-box-white">
            <strong>Justificaci&oacute;n:</strong>
            <br />
            <div class="preview"><?php echo html_entity_decode($PROYECTO->$input) ?></div>
        </div>

        <?php $input = 'proy_obj_esp' ?>
        <div class="field field-box-white">
            <strong>Objetivos espec&iacute;ficos:</strong>
            <br />
            <div class="preview"><?php echo html_entity_decode($PROYECTO->$input) ?></div>
        </div>

        <?php $input = 'proy_cobertura_geo' ?>
        <div class="field field-box-white">
            <strong>&Aacute;mbito Geogr&aacute;fico:</strong>
            <br />
            <div class="preview"><?php echo html_entity_decode($PROYECTO->$input) ?></div>
        </div>

        <?php $input = 'proy_benef' ?>
        <div class="field field-box-white">
            <strong>Beneficiarios:</strong>
            <br />
            <div class="preview"><?php echo html_entity_decode($PROYECTO->$input) ?></div>
        </div>
        <?php } ?>
    </div>

<?php get_footer() ?>