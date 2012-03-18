<?php get_header() ?>
    <?php Message::print_all_messages() ?>
    <h3 class=""><?php echo $PROYECTO->proy_titulo ?></h3>

    <?php get_sidebar('proyecto_menu') ?>
    
    <table class="list-table" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" class="" ><span>Nombre</span></th>
            <th scope="col" class="" ><span>Rol</span></th>
            <th scope="col" class="" ><span>Tel&eacute;fono</span></th>
            <th scope="col" class="" ><span>Permisos para cambiar...</span></th>
            <th scope="col" class="" ><span>Acciones</span></th>
        </tr>
    </thead>

    <tfoot>
        <tr>
            <th scope="col" class="" colspan="5" ></th>
        </tr>
    </tfoot>

    <tbody id="the-list">
        <?php
        $total = 0;
        $total_cancelado = 0;
        foreach($REPRESENTANTES as $representante) {
            $nombre_completo = $representante->user_nombre .' '.$representante->user_apellido;
        ?>
        <tr id="act-<?php echo $representante->user_id ?>" class="" valign="top">
            <td class="" width=""><?php echo $nombre_completo ?></td>
            <td class="" width=""><?php echo $representante->rol ?></td>
            <td class="" width=""><?php echo $representante->user_telf ?></td>
            <td class="" width="">
                <?php
                    $permisos = array();
                    if( $representante->p_modif_datos ) $permisos[] = 'Datos';
                    if( $representante->p_modif_repre ) $permisos[] = 'Representantes';
                    // if( $representante->p_ver_plan ) $permisos[] = 'Inversi&oacute;n';
                    if( $representante->p_modif_activ ) $permisos[] = 'Actividades';
                    // if( $representante->p_modif_fase ) $permisos[] = 'Fases';
                    if( $representante->p_modif_histo ) $permisos[] = 'Historial';
                    if( $representante->p_modif_inver ) $permisos[] = 'Inversi&oacute;n';
                    if( $representante->p_export ) $permisos[] = 'Exportar';

                    if (user_is_admin($representante) ) {
                        echo 'Administrador - Tienen todos los privilegios';
                    } else {
                        echo implode(' - ', $permisos);
                    }
                ?>
            </td>
            <td class="" width="">
                <a id="a-act-<?php echo $representante->user_id ?>" class="a_editar_representante" title="Editar representaci&oacute;n de <?php echo $nombre_completo ?>" href="<?php echo site_url('proyecto/editar_representante/'.$PROYECTO->proy_id.'/'.$representante->user_id) ?>">Editar</a>
                - <a class="a_eliminar_representante" title="Eliminar representante" href="<?php echo site_url('proyecto/eliminar_representante/'.$PROYECTO->proy_id.'/'.$representante->user_id) ?>">Eliminar</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
    </table>

    <br />
    <br />

     <div class="submit">
         <button id="a_crear_representante"> + Agregar representante</button>
    </div>

    <!-- Formulario de representantees -->
    <?php
        global $current_representante;
        foreach($REPRESENTANTES as $representante) {
            $current_representante = $representante;
        ?>
    <div id="editar_representante-a-act-<?php echo $representante->user_id ?>" style="display:none" class="popup">
        <?php get_sidebar('representante_editar') ?>
    </div>
    <?php } ?>

    <div id="nueva_representante" style="display:none" class="popup">
        <?php get_sidebar('representante_crear') ?>
    </div>

    <div id="eliminar_representante" style="display:none" class="popup">
        <p class="text">
            <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
            &iquest;Seguro que desea sacar a este repressentante del proyecto?
        </p>
    </div>

    <script>
	jQuery(function() {
        // Botones
		jQuery( "input:submit, button").button();
		jQuery('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});

        $('#a_crear_representante').click(function() {
            jQuery('#representante_crear_form').each(function(){
                this.reset();
            });
            jQuery('.error').removeClass('error');
            jQuery('.error-msg').hide();
            return mostrarDialogoModal('#nueva_representante', 'Agregar representante', '#representante_crear_form');
        });

        jQuery('a.a_eliminar_representante').click(function() {
            return mostrarDialogoModal_link('#eliminar_representante', 'Eliminar representante', this);
        });
        jQuery('a.a_editar_representante').click(function() {
            return mostrarDialogoModal('#editar_representante-'+jQuery(this).attr('id'), this.title, '#representante_editar_form-'+jQuery(this).attr('id'));
        });

<?php
if ( validation_errors() ) {
    if ($this->input->post('submit-repre-crear')) {
?>
        mostrarDialogoModal('#nueva_representante', 'Agregar representante', '#representante_crear_form');
<?php
    } elseif ($this->input->post('submit-repre-editar')) {
?>
        mostrarDialogoModal('#editar_representante-a-act-<?php echo $this->input->post('user_id') ?>', 'Editar representante', '#representante_crear_form');
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
                "Eliminar representante": function() {
                    window.location = link.href;
                }
            }
        });
        return false;
    }
	</script>

<?php get_footer() ?>