<div class="register-form">
    <form id="inversion_crear_form" action="<?php echo site_url('proyecto/crear_inversion/'.$PROYECTO->proy_id) ?>" method="POST">
        <?php $input = 'inv_rubro' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Concepto / Rubro:</label>
            <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
            <?php echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'inv_unidad' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Unidad:</label>
            <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
            <?php echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'inv_precio' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Precio unitario:</label>
            <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
            <span class="info">(Solo n&uacute;meros)</span>
            <?php echo Message::print_form_error($input) ?>
        </div>
        
        <?php $input = 'inv_cantidad' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Cantidad:</label>
            <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
            <span class="info">(Solo n&uacute;meros)</span>
            <?php echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'inv_status' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" id="<?php echo $input ?>" <?php if($this->input->post($input)) echo 'checked' ?> />
            <label for="<?php echo $input ?>" class="">Cancelado</label>
            <?php echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'inv_inversionista' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id">Cancelado por:</label>
            <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>-input" value="<?php echo $this->input->post($input) ?>" />
            <span class="info">(Texto)</span>
            <?php echo Message::print_form_error($input) ?>
        </div>

        <input style="float:right" type="submit" name="submit-inv-crear" value="Guardar Rubro" />
    </form>
</div>