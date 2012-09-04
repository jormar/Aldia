<div class="register-form">
    <form id="miembro_invitar_form" action="<?php echo site_url('organizacion/invitar_usuario/' . $ORG) ?>" method="POST">

        <?php $input = 'user_id' ?>
        <div class="field field-box-white <?php if (form_error($input)) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Usuario:</label>
            <select name="<?php echo $input ?>" id="<?php echo $input ?>" >
                <option value="">Seleccione...</option>
                <?php foreach ($USERS->result() as $user) { ?>
                    <option value="<?php echo $user->user_id ?>"  ><?php echo $user->user_nombre . ' ' . $user->user_apellido ?></option>
                <?php } ?>
            </select>
            <?php echo Message::print_form_error($input) ?>
        </div>

        Permisos del usuario:
        <?php $input = 'privilegio' ?>
        <div class="field field-box-white <?php if (form_error($input)) echo 'error'; else echo 'no-error'; ?>">
            <input type="radio"  class="" name="<?php echo $input ?>" id="<?php echo $input ?>" value="0"/> Ninguno <br />
            <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" value="1" checked /> Ver Organizacion <br />
            <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" value="2" /> Ver Organizacion, Subir Archivo <br />
            <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" value="3" /> Ver Organizacion, Subir Archivo, Editar Organizacion <br />
            <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" value="4" /> Ver Organizacion, Subir Archivo, Editar Organizacion, Enviar Invitaciones <br />
            <input type="radio" class="" name="<?php echo $input ?>"  id="<?php echo $input ?>" value="5" /> Ver Organizacion, Subir Archivo, Editar Organizacion, Enviar Invitaciones, Eliminar Organizacion <br />

            <?php echo Message::print_form_error($input) ?>
        </div>
 
        <input style="float:right" type="submit" name="submit-miembro-invitar" value="Invitar usuario" />
    </form>
</div>