<?php global $g_miembro; ?>
<div class="register-form">
    <form id="modificar_privilegio_form-a-edit-<?php echo $g_miembro->user_id ?>" action="<?php echo site_url('organizacion/modificar_privilegio/' . $g_miembro->org_id.'/'.$g_miembro->user_id) ?>" method="POST">

        <?php $input = 'privilegio' ?>
        <div class="field field-box-white <?php if (form_error($input)) echo 'error'; else echo 'no-error'; ?>">
            <input type="radio"  class="" name="<?php echo $input ?>" id="<?php echo $input ?>" value="0" <?php if(($g_miembro->$input) == 0) echo 'checked' ?>/> Ninguno <br />
            <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" value="1" <?php if(($g_miembro->$input) == 1) echo 'checked' ?>/> Ver Organizacion <br />
            <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" value="2" <?php if(($g_miembro->$input) == 2) echo 'checked' ?>/> Ver Organizacion, Subir Archivo <br />
            <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" value="3" <?php if(($g_miembro->$input) == 3) echo 'checked' ?>/> Ver Organizacion, Subir Archivo, Editar Organizacion <br />
            <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" value="4" <?php if(($g_miembro->$input) == 4) echo 'checked' ?>/> Ver Organizacion, Subir Archivo, Editar Organizacion, Enviar Invitaciones <br />
            <input type="radio" class="" name="<?php echo $input ?>"  id="<?php echo $input ?>" value="5" <?php if(($g_miembro->$input) == 5) echo 'checked' ?>/> Ver Organizacion, Subir Archivo, Editar Organizacion, Enviar Invitaciones, Eliminar Organizacion <br />
            
            <?php echo Message::print_form_error($input) ?>
        </div>

           <input type="hidden" name="user_id" value="<?php echo $g_miembro->user_id ?>" />
        <input style="float:right" type="submit" name="submit-editar-privilegios" value="Guardar Cambios" />
    </form>
</div>
