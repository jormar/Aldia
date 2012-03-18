<?php get_header() ?>
    <?php Message::print_all_messages() ?>

    <h3>Usuarios</h3>

    <?php
        $i = 0;
        foreach( array ($ACTIVE_USERS, $DISABLED_USERS) as $usuarios ) {
            if ( $usuarios ) {
    ?>
    <div class="list-table-wrapper">
        <?php if ($i % 2 == 1) { ?>
            <h2>Usuarios que esperan su aprobaci&oacute;n para usar el sistema:</h2>
        <?php } ?>
        <table class="list-table" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" class="" ><a href="">Nombre</a></th>
                <th scope="col" class="" ><span>Telf.</span></th>
                <th scope="col" class="" ><span>Tipo</span></th>
                <th scope="col" class="" ><span>Acciones</span></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th scope="col" class="" colspan="4" ></th>
            </tr>
        </tfoot>
        <tbody id="the-list">
            <?php foreach($usuarios as $user) { ?>
            <tr id="post-18" class="alternate author-self status-draft format-default iedit" valign="top">
                <td class=""><a href="<?php echo base_url('usuario/perfil/' . $user->user_id) ?>"><?php echo $user->user_nombre . ' ' . $user->user_apellido ?></a></td>
                <td class=""><?php echo $user->user_telf ?></td>
                <td class=""><?php echo $user->user_org_rol ?></td>
                <td class="">
                <?php if ( currentuser_can('cambiar_perfil', $user ) ) { ?>
                    <a href="<?php echo base_url('usuario/perfil/' . $user->user_id) ?>">Editar</a>
                <?php } ?>

                <?php if ( currentuser_can('cambiar_user_status', $user ) ) { ?>
                    <?php if( $user->user_status == 'active') { ?>
                    - <a title="<?php echo $user->user_nombre . ' ' . $user->user_apellido ?>" class="a_suspender" href="<?php echo base_url('usuario/suspender/'.$user->user_id) ?>">Suspender</a>
                    <?php } else {?>
                    - <a title="<?php echo $user->user_nombre . ' ' . $user->user_apellido ?>" class="a_activar" href="<?php echo base_url('usuario/activar/'.$user->user_id) ?>">Activar</a>
                    <?php } ?>
                <?php } ?>

                <?php if ( currentuser_can('cambiar_org_rol', $user ) ) { ?>
                    <?php if( $user->user_org_rol == 'admin') { ?>
                    - <a title="<?php echo $user->user_nombre . ' ' . $user->user_apellido ?>" class="a_tomiembro" href="<?php echo base_url('usuario/tomiembro/'.$user->user_id) ?>">Convertir a usuario regular</a>
                    <?php } else { ?>
                    - <a title="<?php echo $user->user_nombre . ' ' . $user->user_apellido ?>" class="a_toadmin" href="<?php echo base_url('usuario/toadmin/'.$user->user_id) ?>">Convertir en Administrador</a>
                    <?php } ?>
                <?php } ?>

                <?php if ( currentuser_can('borrar_usuario', $user ) ) { ?>
                    <a style="float:right" title="<?php echo $user->user_nombre . ' ' . $user->user_apellido ?>" class="a_eliminar" href="<?php echo base_url('usuario/eliminar/'.$user->user_id) ?>">Eliminar</a>
                <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>
    <?php } $i++; } ?>

    <!-- Ventanas de dialogo -->
    <div id="suspender-dialog-confirm" title="" style="display: none">
        <p class="text">
            <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
            Si suspende a este usuario, no podr&aacute; acceder al sistema, ni
            interactuar en los proyectos. Esta acci&oacute;n se puede deshacer
            en cualquier momento.
        </p>
        <p class="text">
            &iquest;Realmente quiere suspender a <strong><span class="var-user_name"></span></strong>?
        </p>
    </div>
    <div id="activar-dialog-confirm" title="" style="display: none">
        <p class="text">
            <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
            Una vez activo, este usuario podr&aacute; participar en los proyectos
            en los que sea agregado.
        </p>
        <p class="text">
            &iquest;Confirma que desea activar a <strong><span class="var-user_name"></span></strong>?
        </p>
    </div>
    <div id="eliminar-dialog-confirm" title="" style="display: none">
        <p class="text">
            <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
            Esta a punto de eliminar a <strong><span class="var-user_name"></span></strong> del sistema!
        </p>
        <p class="text">
            <strong>Esta acci&oacute; no se puede deshacer</strong>. Si hizo click
            por error en esta opci&oacute;n, presione Cancelar, o la tecla ESC.
        </p>
        <p class="text">
            Todos los aportes realizados por el usuario dentro del sistema NO
            ser&aacute;n borrados.
        </p>
        <p class="text">
            Si lo que desea es que este usuario
            <strong>no tenga acceso al sistema de forma temporal</strong>,
            suspendalo en lugar de eliminarlo.
        </p>
    </div>

    <script>
	jQuery(function() {
        $('a.a_suspender').click(function() {
            var username = jQuery( this ).attr('title');
            jQuery('.var-user_name').html( username );
            return mostrarDialogoModal(this, '#suspender-dialog-confirm', 'Suspender a ' + username);
        });

        $('a.a_eliminar').click(function() {
            var username = jQuery( this ).attr('title');
            jQuery('.var-user_name').html( username );
            return mostrarDialogoModal(this, '#eliminar-dialog-confirm', 'Eliminar a ' + username);
        });
        $('a.a_activar').click(function() {
            var username = jQuery( this ).attr('title');
            jQuery('.var-user_name').html( username );
            return mostrarDialogoModal(this, '#activar-dialog-confirm', 'Eliminar a ' + username);
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
    }
	</script>
<?php get_footer() ?>