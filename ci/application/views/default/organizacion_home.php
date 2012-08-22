<?php get_header() ?>



<h3>Organizaciones</h3>
<p class="top-info">
    Esta es la p&aacute;gina principal de las organizaciones. Desde esta
    p&aacute;gina puede administrar las organizaciones a las cuales pertenece,
    crear nuevas organizaciones o eliminarla en caso de tener los permisos. 
</p>
<?php
$i = 0;
foreach (array($ORGANIZACIONES_REG) as $organizacion) {
    if ($organizacion) {
        ?>

        <div class="list-table-wrapper">
            <?php Message::print_all_messages() ?>
            <?php // Message::print_all_form_errors() ?>

            <table class="list-table" cellspacing="0">
                <thead>
                    <tr>
                        <th scope="col" class="" ><a href="">Nombre</a></th>
                        <th scope="col" class="" ><span>Sector</span></th>
                        <th scope="col" class="" ><span>Descripci&oacute;n</span></th>
                        <th scope="col" class="" ><span>Acciones</span></th>
                    </tr>

                </thead>

                <tfoot>
                    <tr>
                        <th scope="col" class="" colspan="4" ></th>
                    </tr>
                </tfoot>
                <tbody id="the-list">
                    <?php foreach ($organizacion as $org) { ?>
                        <tr id="post-18" class="alternate author-self status-draft format-default iedit" valign="top">
                            <td class="">
                                <a href="<?php echo base_url('organizacion/ver/' . $org->org_id) ?>"><?php echo $org->org_nombre ?></a>
                            </td>
                            <td class=""><?php echo $org->org_sectores ?></td>
                            <td class=""><?php echo $org->org_desc ?></td>
                            <td class="">
                                <a href="<?php echo base_url('organizacion/editar/' . $org->org_id) ?>">Editar</a>
                                <a title="<?php echo $org->org_nombre ?>" class="o_eliminar" href="<?php echo base_url('organizacion/eliminar/' . $org->org_id) ?>">Eliminar</a>
                                <a href="<?php echo base_url('organizacion/invitaciones/' . $org->org_id) ?>">Manejar Invitaciones</a>
                            </td>


                        <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } $i++;
} ?>


<li><a href="<?php echo base_url('organizacion/nuevo') ?>" class=""><span>Crear Organizaci&oacute;n</span></a></li>

<!-- Ventanas de dialogo -->
<div id="eliminar-dialog-confirm" title="" style="display: none">
    <p class="text">
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        Si elimina esta organizaci&oacute;n, se perder&aacute; toda la informaci&oacute;n relacionada a la misma.
    </p>
    <p class="text">
        &iquest;Quiere eliminar a esta organizaci&oacute;n del sistema?
    </p>
</div>
<script>
    jQuery(function() {
        $('a.o_eliminar').click(function() {
            var orgname = jQuery( this ).attr('title');
            jQuery('.var-org_name').html( orgname );
            return mostrarDialogoModal(this, '#eliminar-dialog-confirm', 'Eliminar ' + orgname);
        });	});
    function mostrarDialogoModal( link, box, title ) {
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
                Aceptar: function() {
                    // $( this ).dialog( "close" );
                    window.location = link.href;
                }
            }
        });
        return false;
            }</script>

<?php get_footer() ?>
