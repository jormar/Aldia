<?php get_header() ?>
    <?php Message::print_all_messages() ?>

    <p class="top-info"></p>
    <p class="top-info">
        Este es su pantalla principal. Aqu&iacute; encontrar&aacute; la lista
        de todos los proyectos de la comunidad. Puede revisar el estado de los
        proyectos en los que esta participando, o consultar otros proyectos
        en la comunidad.
    </p>

    <?php
    global $proyectos;

    // Hacemos un filtro para dejar solo los proyectos en los que participo
    $proyectos = array();
    foreach ( $ORG_PROYECTOS as $proyecto ){
        if (in_array($proyecto->proy_id, $USUARIO_PARTICIPA_IDS)){
            $proyectos[] = $proyecto;
        }
    }
    ?>
    <div class="list-table-wrapper">
        <?php ?>
        <h2>Proyectos en los que estoy participando:</h2>
        <?php get_sidebar('user_home_table') ?>
    </div>
    
    <?php
    // Hacemos un filtro para dejar solo los proyectos en los que NO participo
    $proyectos = array();
    foreach ( $COM_PROYECTOS as $proyecto ){
        if ( !in_array($proyecto->proy_id, $USUARIO_PARTICIPA_IDS) ){
            $proyectos[] = $proyecto;
        }
    }
    // var_dump($ORG_PROYECTOS);
    
    // ...y los mezclamos con el resto de proyectos de la comunidad...
    // $proyectos = array_merge($proyectos, $COM_PROYECTOS);
    ?>
    <div class="list-table-wrapper">
        <?php ?>
        <h2>Otros proyectos en la comunidad:</h2>
        <?php get_sidebar('user_home_table') ?>
    </div>

    <?php
    // Mostramos los proyectos de la organizacion que faltan por aprobar
    $proyectos = $DISABLED_ORG_PROYECTOS;
    if ( user_is_admin() ) {
    ?>
    <div class="list-table-wrapper">
        <?php ?>
        <h2>Proyectos que esperan aprobaci&oacute;n:</h2>
        <?php get_sidebar('user_home_table') ?>
    </div>
    <?php } ?>

<?php get_footer() ?>