<div class="register-form">
    <form id="representante_crear_form" action="<?php echo site_url('proyecto/crear_representante/'.$PROYECTO->proy_id) ?>" method="POST">

        <?php $input = 'user_id' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Usuario:</label>
            <select name="<?php echo $input ?>" id="<?php echo $input ?>" >
                <option value="">Seleccione...</option>
                <?php foreach($PARA_REPRESENTANTES as $representante) { ?>
                <option value="<?php echo $representante->user_id ?>" <?php if($representante->user_id == $this->input->post($input) ) echo 'selected' ?> ><?php echo $representante->user_nombre . ' ' . $representante->user_apellido?></option>
                <?php } ?>
            </select>
            <?php echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'rol' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Rol:</label>
            <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
            <?php echo Message::print_form_error($input) ?>
        </div>

        <h2>Permisos:</h2>
        <?php $input = 'p_modif_datos' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" <?php if($this->input->post($input)) echo 'checked' ?> />
            <label for="<?php echo $input ?>" class="">Modificar datos del proyecto</label>
            <?php echo Message::print_form_error($input) ?>
        </div>
        
        <?php $input = 'p_modif_repre' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" <?php if($this->input->post($input)) echo 'checked' ?> />
            <label for="<?php echo $input ?>" class="">Modificar Representantes del proyecto</label>
            <?php echo Message::print_form_error($input) ?>
        </div>
        
        <?php $input = 'p_modif_activ' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" <?php if($this->input->post($input)) echo 'checked' ?> />
            <label for="<?php echo $input ?>" class="">Modificar el cronograma de actividades del proyecto</label>
            <?php echo Message::print_form_error($input) ?>
        </div>
        
        <?php $input = 'p_modif_histo' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" <?php if($this->input->post($input)) echo 'checked' ?> />
            <label for="<?php echo $input ?>" class="">Modificar el historial del proyecto</label>
            <?php echo Message::print_form_error($input) ?>
        </div>
        
        <?php $input = 'p_modif_inver' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" <?php if($this->input->post($input)) echo 'checked' ?> />
            <label for="<?php echo $input ?>" class="">Modificar el plan de inversi&oacute;n del proyecto</label>
            <?php echo Message::print_form_error($input) ?>
        </div>
        
        <?php $input = 'p_export' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" <?php if($this->input->post($input)) echo 'checked' ?> />
            <label for="<?php echo $input ?>" class="">Exportar los datos del proyecto en PDF</label>
            <?php echo Message::print_form_error($input) ?>
        </div>

        <input style="float:right" type="submit" name="submit-repre-crear" value="Guardar representante" />
    </form>
</div>