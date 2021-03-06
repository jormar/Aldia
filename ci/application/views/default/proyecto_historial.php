<?php
get_header();

function is_image($path) {
    $a = getimagesize($path);
    $image_type = $a[2];

    if (in_array($image_type, array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_BMP))) {
        return true;
    }
    return false;
}
?>


<!--Scripts de uploadify-->
<script type="text/javascript" src="<?php echo site_url('uploadify/jquery.uploadify.v2.1.4.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo site_url('uploadify/swfobject.js'); ?>"></script>
<script type="text/javascript">
    archivos_a_eliminar = new Array();
    
    function yourfunction_editar(event) {
        var nombre_archivo = $(this).siblings('img').attr('name');
        var padre = $(this).parent();
        var current =  padre.attr('current');
        $("#info_msg"+current).text("Archivo marcado para ser eliminado");
        $("#info_msg"+current).fadeIn('fast');
        $("#info_msg"+current).fadeOut('slow');

        padre.fadeOut('slow');
        archivos_a_eliminar.push(nombre_archivo);
    }
        
    $(document).ready(function(){

        /*este remove es para evitar un bug del uploadify que hace 
         *cargar el flash 2 veces si hubo una violacion de alguna regla de
         *los formularios body.removeChild('uploader');*/
        

        /*BEGIN configuracion del fancybox*/
        $("a#single_image").fancybox();
        /*END configuracion del fancybox*/
	
    });
   

</script> 


<h3 class=""><?php echo $PROYECTO->proy_titulo ?></h3>

<?php get_sidebar('proyecto_menu') ?>

<?php Message::print_all_messages() ?>

<p class="top-info">
    Este es el historial del proyecto.<br>
    Aqu&iacute; observar&aacute; todas las correcciones, observaciones, noticias  notas que ocurran durante la vida del proyecto.
</p>

<div class="submit">
    <button id="a_crear_historial"> + Agregar nueva nota</button>
</div>

<table class="list-table" cellspacing="0">
    <thead>
        <tr>
            <th scope="col" class="" ><span>Autor/Rol</span></th>
            <th scope="col" class="" ><span>Texto</span></th>
            <th scope="col" class="" ><span>Tipo</span></th>
            <th scope="col" class="" ><span>Fecha de creaci&oacute;n</span></th>
            <th scope="col" class="" ><span>Archivos</span></th>
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
        foreach ($HISTORIALES as $historial) {
            /* se obtienen los datos del creador del historial */
            $user = new Usuario_db();
            $user->user_id = $historial->aldia_usuarios_user_id;
            $usuario = $user->get();
            /* se obtiene su rol */
            $user_p = new usuario_participa_db();
            $user_p->user_id = $usuario->user_id;
            $user_p->proy_id = $PROYECTO->proy_id;
            $participa = $user_p->get();

            echo '<td class="" width="">' . $usuario->user_nombre . ' ' . $usuario->user_apellido . '/' . $participa->rol . '</td>';
            echo '<td class="" width="">' . $historial->hist_texto . '</td>';
            echo '<td class="" width="">' . $historial->hist_type . '</td>';
            echo '<td class="" width="">' . $historial->hist_created . '</td>';
            ?>
        <td>
            <div id ="imagenes">
                <?php
                $archivos = glob($this->_directoriosubidaarchivos . "archivos_historial/" . $historial->hist_id . "_*");
                foreach ($archivos as $archivo) {
                    $nombre_archivo = basename($archivo);
                    /* se obtiene la extension para saber como mostrarlo */
//                $path_info = pathinfo($rutaCarpetaSubidas . 'archivos_historial/' . $nombre_archivo);
//                $extension = $path_info['extension'];

                    $file = 'http://' . $_SERVER['SERVER_NAME'] . $rutaCarpetaSubidas . 'archivos_historial/' . $nombre_archivo;
                    if (is_image($file)) {
                        echo '<a id="single_image" href="' . $file . '">';
                        echo '<img src="' . $file . '" height="50" width="50"> ';
                        echo '</a>';
                    } else {
                        echo '<a href="' . $file . '"><img src="' . $THEME_FOLDER . '/images/unknown_file.jpg" height="50" width="50"></a>';
                    }
                }
                ?>
            </div>
        </td>
        <td class="" width=""><a id = "a-his-<?php echo $historial->hist_id ?>" class = "a_editar_historial" title = "Editar historial" href = "<?php echo site_url('proyecto/editar_historial/' . $PROYECTO->proy_id . '/' . $historial->hist_id) ?>">Editar</a>
            - <a class = "a_eliminar_historial" title = "Eliminar historal" href = "<?php echo site_url('proyecto/eliminar_historial/' . $PROYECTO->proy_id . '/' . $historial->hist_id) ?>">Eliminar</a ></td>

    </tr>
<?php } ?>     

</tbody>
</table>

<!-- Formulario de historiales -->

<?php
global $current_historial;
foreach ($HISTORIALES as $historial) {
    $current_historial = $historial;
    ?>
    <div id="editar_historial-a-his-<?php echo $historial->hist_id ?>" style="display:none" class="popup">
        <?php get_sidebar('historial_editar') ?>
    </div>
<?php } ?>

<div id="nuevo_historial" style="display:none" class="popup">
    <?php get_sidebar('historial_crear') ?>
</div>



<div id="eliminar_historial" style="display:none" class="popup">
    <p class="text">
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        &iquest;Seguro que desea eliminar este registro?
    </p>
</div>

<script>

    jQuery(function() {
        // Botones
        jQuery( "input:submit, button").button();
        jQuery('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});

        $('#a_crear_historial').click(function() {
            jQuery('#historial_crear_form').each(function(){
                this.reset();
            });
            jQuery('.error').removeClass('error');
            return mostrarDialogoModal('#nuevo_historial', 'Agregar historial', '#historial_crear_form');
        });

        jQuery('a.a_eliminar_historial').click(function() {
            return mostrarDialogoModal_link('#eliminar_historial', 'Eliminar Registro', this);
        });
        jQuery('a.a_editar_historial').click(function() {
            return mostrarDialogoModal('#editar_historial-'+jQuery(this).attr('id'), 'Editar historial', '#historial_editar_form-'+jQuery(this).attr('id'));
        });

<?php
if (validation_errors()) {
    if ($this->input->post('submit-his-crear')) {
        ?>
                        mostrarDialogoModal('#nuevo_historial', 'Agregar historial', '#historial_crear_form');
        <?php
    } elseif ($this->input->post('submit-his-editar')) {
        ?>
                        mostrarDialogoModal('#editar_historial-a-his-<?php echo $this->input->post('hist_id') ?>', 'Editar historial', '#historial_editar_form-a-his-'+<?php echo $this->input->post('hist_id'); ?>);
        <?php
    }
}
?>

    });
    function mostrarDialogoModal( box, title, form ) {
        $( box ).dialog({
            resizable: false,
            closeOnEscape: false,
            modal: true,
            draggable: false,
            position: ['center', 100],
            title: title,
            width: 400,
            beforeClose: function() { 
                location.reload();
            },
            buttons: {
                Cancel: function() {
                    $( this ).dialog( "close" );
                },
                "Guardar historial": function() {
                    var nombre = jQuery(form).attr("id").substring(0, 16);
                    if (nombre =="historial_editar")
                    {
                        var data = {};
                        data.archivos = archivos_a_eliminar;
                        $.post("<?php echo site_url(); ?>proyecto/eliminar_archivo/a/b", data ,function(data_s) {
                        });
                    }//fin del if
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
                "Eliminar historial": function() {
                    window.location = link.href;
                }
            }
        });
        return false;
    }

    
</script>
<?php get_footer() ?>
