<?php get_header() ?>
<h3 class="">Manejo de Invitaciones</h3>
<p class="top-info">
    Desde esta p&aacute;gina puede invitar a miembros de la comunidad a la organizaci&oacute;n o modificar los permisos de los miembros de la organizaci&oacute;n.
</p>





<div class="list-table-wrapper">

    <?php Message::print_all_messages() ?>
    <?php // Message::print_all_form_errors()  ?>

    <table class="list-table" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" class="" ><a href="">Nombre</a></th>

                <th scope="col" class="" ><span>Privilegios</span></th>
                <th scope="col" class="" ><span>Estado Invitaci&oacute;n</span></th>
                <th scope="col" class="" ><span>Acciones</span></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th scope="col" class="" colspan="4" ></th>
            </tr>
        </tfoot>
        <tbody id="the-list">

            <?php
            foreach ($DATA->result() as $test) {
                ?>
                <tr id="post-18" class="alternate author-self status-draft format-default iedit" valign="top">
                    <td class="">
                        <?php echo $test->user_nombre . ' ' . $test->user_apellido; ?></td>


                    <td class="">
                        <?php if (($test->privilegio) == 0) { ?> Ninguno <?php } else { ?>
                            <?php if (($test->privilegio) > 0) { ?> Ver<?php } ?>
                            <?php if (($test->privilegio) > 1) { ?>, Subir Archivo<?php } ?>
                            <?php if (($test->privilegio) > 2) { ?>, Editar<?php } ?>
                            <?php if (($test->privilegio) > 3) { ?>, Invitar<?php } ?>
                            <?php if (($test->privilegio) > 4) { ?>, Eliminar<?php } ?>


                        <?php } ?>
                    </td>
                    <td class="">

                        <?php if (($test->e_invitacion) == 0) { ?> Cancelada<?php } ?>
                        <?php if (($test->e_invitacion) == 1) { ?> Por Aceptar<?php } ?>
                        <?php if (($test->e_invitacion) == 2) { ?> Aceptada<?php } ?>
                    </td>    
                    <td class="">



                        <a id="a-edit-<?php echo $test->user_id ?>" 
                           class="a_modificar_privilegio" 
                           title="Editar privilegios de  <?php echo $test->user_nombre . ' ' . $test->user_apellido; ?>" 
                           href="<?php echo site_url('organizacion/modificar_privilegio/' . $test->org_id . '/' . $test->user_id) ?>">Modificar privilegios</a>


                        <?php if (($test->e_invitacion) == 0) { ?>
                            <a  class="" href="<?php echo base_url('organizacion/reinvitar/' . $test->org_id . '/' . $test->user_id) ?>">Reenviar Invitaci&oacute;n</a>
                        <?php } ?>
                        <?php if (($test->e_invitacion) == 1) { ?>
                            <a  class="" href="<?php echo base_url('organizacion/cancelar_invitacion/' . $test->org_id . '/' . $test->user_id) ?>">Cancelar Invitaci&oacute;n</a>
                        <?php } ?>

                    </td>

                    <?php
                }
                ?>

        </tbody>
    </table>
</div>
<button  id="a-invitar"  class="a_invitar_usuario" title="Invitar a un nuevo usuario" onclick="location.href=<?php echo site_url('organizacion/invitar_miembro/'.$ORG) ?>" >Invitar a un usuario</button>


<!-- Formularios -->
<?php
global $g_miembro;
foreach ($DATA->result() as $miembro) {
    $g_miembro = $miembro;
    ?>
    <div id="modificar_privilegio-a-edit-<?php echo $miembro->user_id ?>" style="display:none" class="popup">
        <?php get_sidebar('miembro_modificar_permiso') ?>
    </div>
<?php } ?>

<div id="invitar_miembro" style="display:none" class="popup">
        <?php get_sidebar('miembro_invitar_organizacion') ?>
<script>
    jQuery(function() {
        jQuery( "input:submit, button").button();
        
        jQuery('a.a_modificar_privilegio').click(function() {
            return mostrarDialogoModal(this, '#modificar_privilegio-'+jQuery(this).attr('id'), this.title);
            
        });
        jQuery('button.a_invitar_usuario').click(function() {
            return mostrarDialogoModal(this, '#invitar_miembro', this.title);
            
        });

    });
    
    function mostrarDialogoModal( link, box, title ) {
        $( box ).dialog({
            resizable: false,
            modal: true,
            draggable: false,
            position: ['center', 100],
            title: title,
            width: 400,
            buttons: {
                Cancelar: function() {
                    $( this ).dialog( "close" );
                }
                
            }
        });
        return false;
    }</script>

<?php get_footer() ?>
