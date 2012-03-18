<?php get_header() ?>
    <?php Message::print_all_messages() ?>
    <h3 class=""><?php echo $PROYECTO->proy_titulo ?></h3>

    <?php get_sidebar('proyecto_menu') ?>
    
    <table class="list-table" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" class="" ><span>Concepto / Actividad / Rubro</span></th>
            <th scope="col" class="" ><span>Unidad</span></th>
            <th scope="col" class="" ><span>Precio unitario</span></th>
            <th scope="col" class="" ><span>Cantidad</span></th>
            <th scope="col" class="" ><span>Totales</span></th>
            <th scope="col" class="" ><span>Status</span></th>
            <th scope="col" class="" ><span></span></th>
        </tr>
    </thead>

    <tfoot>
        <tr>
            <th scope="col" class="" colspan="7" ></th>
        </tr>
    </tfoot>

    <tbody id="the-list">
        <?php
        $total = 0;
        $total_cancelado = 0;
        foreach($INVERSIONES as $inversion) {
        ?>
        <tr id="act-<?php echo $inversion->inv_id ?>" class="" valign="top">
            <td class=""><?php echo $inversion->inv_rubro ?></td>
            <td class="" width=""><?php echo $inversion->inv_unidad ?></td>
            <td class="" width=""><?php echo $inversion->inv_precio ?> Bs.</td>
            <td class="" width=""><?php echo $inversion->inv_cantidad ?></td>
            <td class="" width=""><?php echo $inversion->inv_cantidad * $inversion->inv_precio ?> Bs.</td>
            <td class="" width=""><?php
                if ($inversion->inv_status == 'cancelado') {
                    echo 'Cancelado';
                    if($inversion->inv_inversionista){
                        echo ' por '.$inversion->inv_inversionista;
                    }
                    $total_cancelado += $inversion->inv_cantidad * $inversion->inv_precio;
                } else {
                    echo 'Por cancelar';
                }
            ?></td>
            <td class="" width="">
                <a id="a-act-<?php echo $inversion->inv_id ?>" class="a_editar_inversion" title="Editar inversion" href="<?php echo site_url('proyecto/editar_inversion/'.$PROYECTO->proy_id.'/'.$inversion->inv_id) ?>">Editar</a>
                - <a class="a_eliminar_inversion" title="Eliminar inversion" href="<?php echo site_url('proyecto/eliminar_inversion/'.$PROYECTO->proy_id.'/'.$inversion->inv_id) ?>">Eliminar</a>
            </td>
        </tr>
        <?php
        $total += $inversion->inv_cantidad * $inversion->inv_precio;
        } ?>

        <tr id="act-<?php echo $inversion->inv_id ?>" class="" valign="top">
            <td class="" colspan="4" style="font-weight: bold; text-align: right">Costo total del proyecto:</td>
            <td class="" ><?php echo $total ?> Bs.</td>
            <td class="" colspan="2"></td>
        </tr>
        <tr id="act-<?php echo $inversion->inv_id ?>" class="" valign="top">
            <td class="" colspan="4" style="font-weight: bold; text-align: right">Costo total cancelado:</td>
            <td class="" ><?php echo $total_cancelado ?> Bs.</td>
            <td class="" colspan="2"></td>
        </tr>
        <tr id="act-<?php echo $inversion->inv_id ?>" class="" valign="top">
            <td class="" colspan="4" style="font-weight: bold; text-align: right">Inversi&oacute;n faltante:</td>
            <td class="" ><?php echo $total-$total_cancelado ?> Bs.</td>
            <td class="" colspan="2"></td>
        </tr>
    </tbody>
    </table>

    <br />
    <br />

     <div class="submit">
         <button id="a_crear_inversion"> + Agregar inversion</button>
    </div>

    <!-- Formulario de inversiones -->
    <?php
        global $current_inversion;
        foreach($INVERSIONES as $inversion) {
            $current_inversion = $inversion;
        ?>
    <div id="editar_inversion-a-act-<?php echo $inversion->inv_id ?>" style="display:none" class="popup">
        <?php get_sidebar('inversion_editar') ?>
    </div>
    <?php } ?>

    <div id="nueva_inversion" style="display:none" class="popup">
        <?php get_sidebar('inversion_crear') ?>
    </div>

    <div id="eliminar_inversion" style="display:none" class="popup">
        <p class="text">
            <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
            &iquest;Seguro que desea eliminar este rubro?
        </p>
    </div>

    <script>
	jQuery(function() {
        // Botones
		jQuery( "input:submit, button").button();
		jQuery('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});

        $('#a_crear_inversion').click(function() {
            jQuery('#inversion_crear_form').each(function(){
                this.reset();
            });
            jQuery('.error').removeClass('error');
            jQuery('.error-msg').hide();
            return mostrarDialogoModal('#nueva_inversion', 'Agregar Rubro', '#inversion_crear_form');
        });

        jQuery('a.a_eliminar_inversion').click(function() {
            return mostrarDialogoModal_link('#eliminar_inversion', 'Eliminar Rubro', this);
        });
        jQuery('a.a_editar_inversion').click(function() {
            return mostrarDialogoModal('#editar_inversion-'+jQuery(this).attr('id'), 'Editar inversion', '#inversion_editar_form-'+jQuery(this).attr('id'));
        });

<?php
if ( validation_errors() ) {
    if ($this->input->post('submit-inv-crear')) {
?>
        mostrarDialogoModal('#nueva_inversion', 'Agregar rubro', '#inversion_crear_form');
<?php
    } elseif ($this->input->post('submit-inv-editar')) {
?>
        mostrarDialogoModal('#editar_inversion-a-act-<?php echo $this->input->post('inv_id') ?>', 'Editar rubro', '#inversion_crear_form');
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
                "Eliminar rubro": function() {
                    window.location = link.href;
                }
            }
        });
        return false;
    }
	</script>

<?php get_footer() ?>