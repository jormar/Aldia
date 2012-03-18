<?php global $current_actividad; ?>
<div class="register-form">
    <form id="actividad_editar_form-a-act-<?php echo $current_actividad->act_id ?>" action="<?php echo site_url('proyecto/editar_actividad/'.$PROYECTO->proy_id.'/'.$current_actividad->act_id) ?>" method="POST">
        <?php $input = 'act_desc' ?>
        <div class="field field-box-white <?php if( form_error($input) && $this->input->post('act_id') == $current_actividad->act_id ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Actividad:</label>
            <textarea class="tinymce-edit <?php echo $input ?>" name="<?php echo $input ?>" rows="3"><?php echo $current_actividad->$input ?></textarea>
            <?php if($this->input->post('act_id') == $current_actividad->act_id) echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'act_responsables' ?>
        <div class="field field-box-white <?php if( form_error($input) && $this->input->post('act_id') == $current_actividad->act_id ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Responsables:</label>
            <textarea class="tinymce-edit <?php echo $input ?>" name="<?php echo $input ?>" rows="3"><?php echo $current_actividad->$input ?></textarea>
            <?php if($this->input->post('act_id') == $current_actividad->act_id) echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'act_inicio' ?>
        <div class="field field-box-white <?php if( form_error($input) && $this->input->post('act_id') == $current_actividad->act_id ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="">Fecha de culminaci&oacute;n:</label>
            <input type="text" class="input datepicker <?php echo $input ?>" name="<?php echo $input ?>" value="<?php echo $current_actividad->$input ?>" />
            <span class="info">(Formato: YYYY-MM-DD)</span>
            <?php if($this->input->post('act_id') == $current_actividad->act_id) echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'act_fin' ?>
        <div class="field field-box-white <?php if( form_error($input) && $this->input->post('act_id') == $current_actividad->act_id ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="">Fecha de culminaci&oacute;n:</label>
            <input type="text" class="input datepicker <?php echo $input ?>" name="<?php echo $input ?>" value="<?php echo $current_actividad->$input ?>" />
            <span class="info">(Formato: YYYY-MM-DD)</span>
            <?php if($this->input->post('act_id') == $current_actividad->act_id) echo Message::print_form_error($input) ?>
        </div>

        <input type="hidden" name="submit-act-editar" value="submit-act-crear" />
        <input type="hidden" name="act_id" value="<?php echo $current_actividad->act_id ?>" />
    </form>
</div>