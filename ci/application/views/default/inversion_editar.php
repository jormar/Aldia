<?php global $current_inversion; ?>
<div class="register-form">
    <form id="inversion_editar_form-a-act-<?php echo $current_inversion->inv_id ?>" action="<?php echo site_url('proyecto/editar_inversion/'.$PROYECTO->proy_id.'/'.$current_inversion->inv_id) ?>" method="POST">
        <?php $input = 'inv_rubro' ?>
        <div class="field field-box-white <?php if( form_error($input) && $this->input->post('inv_id') == $current_inversion->inv_id ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Concepto / Rubro:</label>
            <input type="text" class="input" name="<?php echo $input ?>" value="<?php echo $current_inversion->$input ?>" />
            <?php if($this->input->post('inv_id') == $current_inversion->inv_id) echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'inv_unidad' ?>
        <div class="field field-box-white <?php if( form_error($input) && $this->input->post('inv_id') == $current_inversion->inv_id ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Unidad:</label>
            <input type="text" class="input" name="<?php echo $input ?>" value="<?php echo $current_inversion->$input ?>" />
            <?php if($this->input->post('inv_id') == $current_inversion->inv_id) echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'inv_precio' ?>
        <div class="field field-box-white <?php if( form_error($input) && $this->input->post('inv_id') == $current_inversion->inv_id ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Precio unitario:</label>
            <input type="text" class="input" name="<?php echo $input ?>" value="<?php echo $current_inversion->$input ?>" />
            <span class="info">(Solo n&uacute;meros)</span>
            <?php if($this->input->post('inv_id') == $current_inversion->inv_id) echo Message::print_form_error($input) ?>
        </div>
        
        <?php $input = 'inv_cantidad' ?>
        <div class="field field-box-white <?php if( form_error($input) && $this->input->post('inv_id') == $current_inversion->inv_id ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Cantidad:</label>
            <input type="text" class="input" name="<?php echo $input ?>" value="<?php echo $current_inversion->$input ?>" />
            <span class="info">(Solo n&uacute;meros)</span>
            <?php if($this->input->post('inv_id') == $current_inversion->inv_id) echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'inv_status' ?>
        <div class="field field-box-white <?php if( form_error($input) && $this->input->post('inv_id') == $current_inversion->inv_id ) echo 'error'; else echo 'no-error'; ?>">
            <input type="checkbox" class="" name="<?php echo $input ?>" <?php if($current_inversion->$input == 'cancelado') echo 'checked' ?> />
            <label for="<?php echo $input ?>" class="">Cancelado</label>
            <?php if($this->input->post('inv_id') == $current_inversion->inv_id) echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'inv_inversionista' ?>
        <div class="field field-box-white <?php if( form_error($input) && $this->input->post('inv_id') == $current_inversion->inv_id ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id">Cancelado por:</label>
            <input type="text" class="input" name="<?php echo $input ?>" value="<?php echo $current_inversion->$input ?>" />
            <span class="info">(Texto)</span>
            <?php if($this->input->post('inv_id') == $current_inversion->inv_id) echo Message::print_form_error($input) ?>
        </div>

        <input type="hidden" name="inv_id" value="<?php echo $current_inversion->inv_id ?>" />
        <input style="float:right" type="submit" name="submit-inv-editar" value="Guardar Rubro" />
    </form>
</div>