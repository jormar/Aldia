<?php get_header() ?>
    <h3 class=""><?php echo $ORGANIZACION ->org_nombre ?></h3>
<div class="register-form">
<?php Message::print_all_messages() ?>
<form action="<?php echo site_url('organizacion/editar/'.$ORGANIZACION->org_id) ?>" method="POST">

        <?php $input = 'org_nombre' ?>
            <div class="field <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Nombre de la Organizaci&oacute;n</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $ORGANIZACION->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
        <?php $input = 'org_sectores' ?>
            <div class="field <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Sector de la Organizaci&oacute;n</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $ORGANIZACION->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>
        <?php $input = 'org_desc' ?>
            <div class="field <?php if( form_error($input) ) echo 'error'; else echo 'no-error'; ?>">
                <label for="<?php echo $input ?>" class="id">Descripci&oacute; de la Organizaci&oacute;n</label>
                <input type="text" class="input" name="<?php echo $input ?>" id="<?php echo $input ?>" value="<?php echo $ORGANIZACION->$input ?>" />
                <?php echo Message::print_form_error($input) ?>
            </div>

            <div class="submit">
                <input type="submit" class="" value="Guardar" name="submit-editar-organizacion" />
            </div>
        </form>

<?php get_footer() ?>

