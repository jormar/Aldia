<?php get_header() ?>
<h3 class="">Manejo de Invitaciones</h3>
     <p class="top-info">
	Desde esta p&aacute;gina puede invitar a miembros de la comunidad a la organizaci&oacute;n.
    </p>
<div class="register-form">

        <?php Message::print_all_messages() ?>
        <?php // Message::print_all_form_errors() ?>
    
    <?php
        $i = 0;
        foreach( array ($ACTIVE_USERS, $DISABLED_USERS) as $usuarios ) {
            if ( $usuarios ) {
    ?>
    <div class="list-table-wrapper">
        <?php if ($i % 2 == 1) { ?>
        <h2>Invitar usuarios a esta organizac&oacute;n</h2>
        <?php } ?>
        <table class="list-table" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" class="" ><a href="">Nombre</a></th>
                <th scope="col" class="" ><span>Tipo</span></th>
                <th scope="col" class="" ><span>Estado</span></th>
                <th scope="col" class="" ><span>Acciones</span></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th scope="col" class="" colspan="3" ></th>
            </tr>
        </tfoot>
        <tbody id="the-list">
            <?php foreach($usuarios as $user) { ?>
            <tr id="post-18" class="alternate author-self status-draft format-default iedit" valign="top">
                <td class=""><a href="<?php echo base_url('usuario/perfil/' . $user->user_id) ?>"><?php echo $user->user_nombre . ' ' . $user->user_apellido ?></a></td>
                <td class=""><?php echo $user->user_org_rol ?></td>
                <td class="">En desarrollo</td>
                <td class="">

                    <a href="<?php echo base_url('organizacion/invitar/' . $user->user_id) ?>">Invitar</a>

                </td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>
    <?php } $i++; } ?>

    <!-- Ventanas de dialogo -->
    <div id="invitar-dialog-confirm" title="" style="display: none">
        <p class="text">
            <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
            Si invita a este usuario, este podr&aacute; ver toda la informaci&oacute; 
            de la organizaci&oacute; y podr&aacute; subir documentos a la misma. 
        </p>
        <p class="text">
            &iquest;Quiere invitar a <strong><span class="var-user_name"></span></strong> a la organizaci&oacute;n?
        </p>
    </div>
        <script>
	jQuery(function() {
        $('a.a_suspender').click(function() {
            var username = jQuery( this ).attr('title');
            jQuery('.var-user_name').html( username );
            return mostrarDialogoModal(this, '#suspender-dialog-confirm', 'Suspender a ' + username);
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
