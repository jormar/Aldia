<?php
global $proyectos;

if ( !empty($proyectos) ) { ?>
<table class="list-table" cellspacing="0">
<thead>
    <tr>
        <th scope="col" class="" ><span>Title</span></th>
        <th scope="col" class="" ><span>Organizaci&oacute;n</span></th>
        <th scope="col" class="" ><span>Costo</span></th>
        <th scope="col" class="" ><span>Ultima Actualizaci&oacute;n</span></th>
        <th scope="col" class="" ><span>Acciones</span></th>
    </tr>
</thead>

<tfoot>
    <tr>
        <th scope="col" class="" ><span>Title</span></th>
        <th scope="col" class="" ><span>Organizaci&oacute;n</span></th>
        <th scope="col" class="" ><span>Costo</span></th>
        <th scope="col" class="" ><span>Ultima Actualizaci&oacute;n</span></th>
        <th scope="col" class="" ><span>Acciones</span></th>
    </tr>
</tfoot>

<tbody id="the-list">
    <?php foreach($proyectos as $proyecto) { ?>
    <tr id="post-18" class="alternate author-self status-draft format-default iedit" valign="top">
        <td class="">
            <?php if(currentuser_can('proy_modif_histo', $proyecto) ) { ?>
            <a href="<?php echo base_url('proyecto/datos/'.$proyecto->proy_id) ?>"><?php echo $proyecto->proy_titulo ?></a>
            <?php } else { ?>
            <?php echo $proyecto->proy_titulo ?>
            <?php } ?>
        </td>
        <td class=""><?php echo $proyecto->org_nombre ?></td>
        <td class=""><?php echo $proyecto->proy_costo ?></td>
        <td class=""><?php echo date('d M, Y g:ia', strtotime($proyecto->proy_fecha_mod) ) ?></td>
        <td class="" width="250" style="line-height:1.6;">
            <a href="<?php echo base_url('proyecto/ver/'.$proyecto->proy_id) ?>">Ver</a>

            <?php if ( currentuser_can('proy_modif_datos', $proyecto) ) { ?>
            - <a href="<?php echo base_url('proyecto/datos/'. $proyecto->proy_id) ?>">Datos</a>
            <?php } ?>

            <?php if ( currentuser_can('proy_modif_repre', $proyecto) ) { ?>
            - <a href="<?php echo base_url('proyecto/representantes/'. $proyecto->proy_id) ?>">Representantes</a>
            <?php } ?>

            <?php if ( currentuser_can('proy_modif_inver', $proyecto) ) { ?>
            - <a href="<?php echo base_url('proyecto/inversion/'. $proyecto->proy_id) ?>">Inversi&oacute;n</a>
            <?php } ?>

            <?php if ( currentuser_can('proy_modif_activ', $proyecto) ) { ?>
            - <a href="<?php echo base_url('proyecto/actividades/'. $proyecto->proy_id) ?>">Actividades</a>
            <?php } ?>

            <?php if ( $proyecto->proy_status=='active' ) { ?>
                <?php if(currentuser_can('proy_modif_datos', $proyecto) && user_is_admin() ) { ?>
                - <a href="<?php echo base_url('proyecto/desactivar/'.$proyecto->proy_id) ?>">Desactivar</a>
                <?php } ?>

            <?php } else { ?>
                <?php if(currentuser_can('proy_modif_datos', $proyecto) && user_is_admin() ) { ?>
                - <a href="<?php echo base_url('proyecto/activar/'.$proyecto->proy_id) ?>">Activar</a>
                <?php } ?>

            <?php } ?>

            <?php if(currentuser_can('borrar_proy', $proyecto) ) { ?>
            - <a href="<?php echo base_url('proyecto/borrar/'.$proyecto->proy_id) ?>">Eliminar</a>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</tbody>
</table>
<?php } else { ?>
<p class="top-info">Actualmente, no hay proyectos disponibles</p>
<?php } ?>
