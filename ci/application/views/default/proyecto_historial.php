<?php get_header() ?>
    <?php Message::print_all_messages() ?>
    <h3 class=""><?php echo $PROYECTO->proy_titulo ?></h3>

    <?php get_sidebar('proyecto_menu') ?>
    
    <table class="list-table" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" class="" ><span>Actividad</span></th>
            <th scope="col" class="" ><span>Responsables</span></th>
            <th scope="col" class="" ><span>Fecha de inicio</span></th>
            <th scope="col" class="" ><span>Fecha de finalizaci&oacute;n</span></th>
            <th scope="col" class="" ><span>Acciones</span></th>
        </tr>
    </thead>

    <tfoot>
        <tr>
            <th scope="col" class="" colspan="5" ></th>
        </tr>
    </tfoot>

    <tbody id="the-list">
        <?php foreach($ACTIVIDADES as $actividad) { ?>
        <tr id="act-<?php echo $actividad->act_id ?>" class="" valign="top">
            <td class="act_desc"><?php echo $actividad->act_desc ?></td>
            <td class="act_responsables" width="120"><?php echo $actividad->act_responsables ?></td>
            <td class="act_inicio" width="100"><?php if($actividad->act_inicio) echo date('d M, Y', strtotime($actividad->act_inicio) ); else echo '-'; ?></td>
            <td class="act_fin" width="100"><?php if($actividad->act_fin) echo date('d M, Y', strtotime($actividad->act_fin) ); else echo '-'; ?></td>
            <td class="" width="150">
                <a id="a-act-<?php echo $actividad->act_id ?>" class="a_editar_actividad" title="Editar Actividad" href="<?php echo site_url('proyecto/editar_actividad/'.$PROYECTO->proy_id.'/'.$actividad->act_id) ?>">Editar</a>
                - <a class="a_eliminar_actividad" title="Eliminar Actividad" href="<?php echo site_url('proyecto/eliminar_actividad/'.$PROYECTO->proy_id.'/'.$actividad->act_id) ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
    </table>

    <br />
    <br />

     <div class="submit">
         <button id="a_crear_actividad"> + Agregar Actividad</button>
    </div>

    <!-- Formulario de actividades -->
    <?php
        global $current_actividad;
        foreach($ACTIVIDADES as $actividad) {
            $current_actividad = $actividad;
        ?>
    <div id="editar_actividad-a-act-<?php echo $actividad->act_id ?>" style="display:none" class="popup">
        <?php get_sidebar('actividad_editar') ?>
    </div>
    <?php } ?>

    <div id="nueva_actividad" style="display:none" class="popup">
        <?php get_sidebar('actividad_crear') ?>
    </div>

    <div id="eliminar_actividad" style="display:none" class="popup">
        <p class="text">
            <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
            &iquest;Seguro que desea eliminar esta actividad?
        </p>
    </div>

    <script>
	jQuery(function() {
        // Botones
		jQuery( "input:submit, button").button();
		jQuery('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});

        $('#a_crear_actividad').click(function() {
            jQuery('#actividad_crear_form').each(function(){
                this.reset();
            });
            jQuery('.error').removeClass('error');
            return mostrarDialogoModal('#nueva_actividad', 'Agregar Actividad', '#actividad_crear_form');
        });

        jQuery('a.a_eliminar_actividad').click(function() {
            return mostrarDialogoModal_link('#eliminar_actividad', 'Eliminar Actividad', this);
        });
        jQuery('a.a_editar_actividad').click(function() {
            return mostrarDialogoModal('#editar_actividad-'+jQuery(this).attr('id'), 'Editar Actividad', '#actividad_editar_form-'+jQuery(this).attr('id'));
        });

<?php
if ( validation_errors() ) {
    if ($this->input->post('submit-act-crear')) {
?>
        mostrarDialogoModal('#nueva_actividad', 'Agregar Actividad', '#actividad_crear_form');
<?php
    } elseif ($this->input->post('submit-act-editar')) {
?>
        mostrarDialogoModal('#editar_actividad-a-act-<?php echo $this->input->post('act_id') ?>', 'Agregar Actividad', '#actividad_crear_form');
<?php        
    }
}
?>

	});
    function mostrarDialogoModal( box, title, form ) {
        $( box ).dialog({
            resizable: false,
            modal: true,
            draggable: false,
            position: ['center', 100],
            title: title,
            width: 400,
            buttons: {
                Cancel: function() {
                    $( this ).dialog( "close" );
                },
                "Guardar Actividad": function() {
                    jQuery(form).submit();
                }
            }
        });
        return false;
    }

    function mostrarDialogoModal_link( box, title, link ) {
        $( box ).dialog({
            resizable: false,
            modal: true,
            draggable: false,
            position: ['center', 100],
            title: title,
            width: 400,
            buttons: {
                Cancel: function() {
                    $( this ).dialog( "close" );
                },
                "Eliminar Actividad": function() {
                    window.location = link.href;
                }
            }
        });
        return false;
    }
	</script>

<?php get_footer() ?>