<?php global $current_representante; ?>
<div class="register-form">
    <form id="representante_editar_form-a-act-<?php echo $current_representante->user_id ?>" action="<?php echo site_url('proyecto/editar_representante/'.$PROYECTO->proy_id.'/'.$current_representante->user_id) ?>" method="POST">

        <?php $input = 'rol' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" class="id"><span class="required">*</span> Rol:</label>
            <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" value="<?php echo $current_representante->$input ?>" />
            <?php echo Message::print_form_error($input) ?>
        </div>

        <h2>Permisos:</h2>
        <?php $input = 'p_modif_datos' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" <?php if($current_representante->$input) echo 'checked' ?> />
            <label for="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" class="">Modificar datos del proyecto</label>
            <?php echo Message::print_form_error($input) ?>
        </div>
        
        <?php $input = 'p_modif_repre' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" <?php if($current_representante->$input) echo 'checked' ?> />
            <label for="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" class="">Modificar Representantes del proyecto</label>
            <?php echo Message::print_form_error($input) ?>
        </div>
        
        <?php $input = 'p_modif_activ' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" <?php if($current_representante->$input) echo 'checked' ?> />
            <label for="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" class="">Modificar el cronograma de actividades del proyecto</label>
            <?php echo Message::print_form_error($input) ?>
        </div>
        
        <?php $input = 'p_modif_histo' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" <?php if($current_representante->$input) echo 'checked' ?> />
            <label for="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" class="">Modificar el historial del proyecto</label>
            <?php echo Message::print_form_error($input) ?>
        </div>
        
        <?php $input = 'p_modif_inver' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" <?php if($current_representante->$input) echo 'checked' ?> />
            <label for="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" class="">Modificar el plan de inversi&oacute;n del proyecto</label>
            <?php echo Message::print_form_error($input) ?>
        </div>
        
        <?php $input = 'p_export' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" <?php if($current_representante->$input) echo 'checked' ?> />
            <label for="<?php echo $input ?>-<?php echo $current_representante->user_id ?>" class="">Exportar los datos del proyecto en PDF</label>
            <?php echo Message::print_form_error($input) ?>
        </div>

        <input type="hidden" name="user_id" value="<?php echo $current_representante->user_id ?>" />
        <input style="float:right" type="submit" name="submit-repre-editar" value="Actualizar representante" />
    </form>
</div>