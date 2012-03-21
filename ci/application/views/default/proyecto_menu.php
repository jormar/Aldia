<div class="menu m2">
    <ul>
        <?php if ( currentuser_can('proy_modif_histo', $PROYECTO) ) { ?>
        <li><a href="<?php echo base_url('proyecto/historial/'. $PROYECTO->proy_id) ?>" class="<?php if(preg_match('/historial/', current_url())) echo 'active' ?>" ><span>Historial</span></a></li>
        <?php } ?>

        <?php if ( currentuser_can('proy_ver_plan', $PROYECTO) ) { ?>
        <li><a href="services.html"><span>Planificación y estrategia</span></a></li>
        <?php } ?>

        <?php if ( currentuser_can('proy_modif_datos', $PROYECTO) ) { ?>
        <li><a href="<?php echo base_url('proyecto/datos/'. $PROYECTO->proy_id) ?>" class="<?php if(preg_match('/datos/', current_url())) echo 'active' ?>" ><span>Datos del proyecto</span></a></li>
        <?php } ?>

        <?php if ( currentuser_can('proy_modif_repre', $PROYECTO) ) { ?>
        <li><a href="<?php echo base_url('proyecto/representantes/'. $PROYECTO->proy_id) ?>" class="<?php if(preg_match('/representantes/', current_url())) echo 'active' ?>" ><span>Representantes</span></a></li>
        <?php } ?>

        <?php if ( currentuser_can('proy_modif_inver', $PROYECTO) ) { ?>
        <li><a href="<?php echo base_url('proyecto/inversion/'. $PROYECTO->proy_id) ?>" class="<?php if(preg_match('/inversion/', current_url())) echo 'active' ?>" ><span>Plan de Inversi&oacute;n</span></a></li>
        <?php } ?>
        
        <?php if ( currentuser_can('proy_modif_activ', $PROYECTO) ) { ?>
        <li><a href="<?php echo base_url('proyecto/actividades/'. $PROYECTO->proy_id) ?>" class="<?php if(preg_match('/actividades/', current_url())) echo 'active' ?>" ><span>Cronograma de actividades</span></a></li>
        <?php } ?>
    </ul>
</div>
<div class="clr"></div>