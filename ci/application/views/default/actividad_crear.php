


<div  class="register-form">
    <form id="actividad_crear_form" action="<?php echo site_url('proyecto/crear_actividad/'.$PROYECTO->proy_id) ?>" method="POST">
        <?php $input = 'act_desc' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Actividad:</label>
            <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $this->input->post($input) ?></textarea>
            <?php echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'act_responsables' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Responsables:</label>
            <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $this->input->post($input) ?></textarea>
            <?php echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'act_inicio' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="">Fecha de culminaci&oacute;n:</label>
            <input type="text" class="input datepicker" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
            <span class="info">(Formato: YYYY-MM-DD)</span>
            <?php echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'act_fin' ?>
        <div class="field field-box-white <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="">Fecha de culminaci&oacute;n:</label>
            <input type="text" class="input datepicker" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $this->input->post($input) ?>" />
            <span class="info">(Formato: YYYY-MM-DD)</span>
            <?php echo Message::print_form_error($input) ?>
        </div>
		<div id="map_canvas" style="width:100%; height:200px"></div>
        	<input type="hidden" name="submit-act-crear" value="submit-act-crear" />
	</form>
</div>
