<?php global $current_historial;
?>
<script type="text/javascript">

    $(window).load( function() {

        /*editar*/
        $("#fileUpload<?php echo $current_historial->hist_id ?>").uploadify({
            'uploader'    : '<?php echo site_url('uploadify/uploadify.swf'); ?>',
            'cancelImg'   : '<?php echo site_url('uploadify/cancel.png'); ?>',
            'script'      : '<?php echo $rutaAbsolutaMetodoSubir . $n_random; ?>',
            'folder'      : '',
            'multi'       : true,
            'buttonText'  : 'Buscar',
            'displayData' : 'speed',
            'sizeLimit' : 10485760,
            'simUploadLimit': 1,
            'onComplete': function (event, queueID, fileObj, response, data) {
                function inArray(array, value) {
                    for (var i = 0; i < array.length; i++) {
                        if (array[i] == value) return true;
                    }
                    return false;
                }; 
                var a_extension = ["jpg", "png", "bmp"];
                var extension = fileObj.filePath.slice(fileObj.filePath.length-3,fileObj.filePath.length);
                var t_nuevo;
                if (inArray(a_extension,extension))
                {
                    $("#showimage<?php echo $current_historial->hist_id ?>").append('<div class="imagen"><img name= "' + fileObj.name + '" src="http://<?php echo $_SERVER['SERVER_NAME'] . $rutaCarpetaSubidas . $n_random;
?>' + fileObj.name + '" height="50" width="50" /><a href="#" id="enlaceajax">eliminar</a></div>');
                } else
                {
                    $("#showimage<?php echo $current_historial->hist_id ?>").append('<div class="imagen"><img name= "' + fileObj.name + '" src="<?php echo $THEME_FOLDER ?>/images/unknown_file.jpg" height="50" width="50"/><a href="#" id="enlaceajax">eliminar</a></div>');
                }
            }                  
        });
       
        $(document).ready(function() {

            $('#enlaceajax_editar<?php echo $current_historial->hist_id ?>').live("click",yourfunction_editar);
        

        });
       

    });
</script>

<div class="register-form">
    <form id="historial_editar_form-a-his-<?php echo $current_historial->hist_id ?>" action="<?php echo site_url('proyecto/editar_historial/' . $PROYECTO->proy_id . '/' . $current_historial->hist_id . '/' . $n_random) ?>" method="POST">
        <?php $input = 'hist_texto' ?>
        <div class="field field-box-white <?php if (form_error($input) && $this->input->post('hist_id') == $current_historial->hist_id) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Texto:</label>
            <textarea class="tinymce-edit <?php echo $input ?>" name="<?php echo $input ?>" rows="3"><?php echo $current_historial->$input ?></textarea>
            <?php if ($this->input->post('hist_id') == $current_historial->hist_id) echo Message::print_form_error($input) ?>
        </div>
        <?php $input = 'hist_type' ?>
        <div class="field <?php if (form_error($input)) echo 'error' ?>">
            <label for="<?php echo $input ?>" class="id">Tipo:</label>
            <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>_correccion" value="correcci&oacute;n" <?php if ($current_historial->$input == "corrección") echo "checked"; ?> /> <label for="<?php echo $input ?>_correccion">Correcci&oacute;n</label>
            <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>_observacion" value="observaci&oacute;n"  <?php if ($current_historial->$input == "observación") echo "checked"; ?> /> <label for="<?php echo $input ?>_observacion">Observaci&oacute;n</label>
            <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>_nota" value="nota"  <?php if ($current_historial->$input == "nota") echo "checked"; ?> /> <label for="<?php echo $input ?>_nota">Nota</label>
            <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>_noticia" value="noticia"  <?php if ($current_historial->$input == "noticia") echo "checked"; ?> /> <label for="<?php echo $input ?>_noticia">Noticia</label>
            <?php echo Message::print_form_error($input) ?>
        </div>
        <input type="hidden" name="submit-his-editar" value="submit-his-editar" />
        <input type="hidden" name="hist_id" value="<?php echo $current_historial->hist_id ?>" />
    </form>
</div>


<div id="fileUpload<?php echo $current_historial->hist_id ?>">You have a problem with your javascript</div><br>
<a href="javascript:$('#fileUpload<?php echo $current_historial->hist_id ?>').uploadifyUpload();">subir archivos</a>
<br><br>
<div><b>Archivos subidos actualmente:</b></div>
<br>
<div id="showimage<?php echo $current_historial->hist_id ?>"></div>
<div>
    <?php
    $archivos = glob($this->_directoriosubidaarchivos . "archivos_historial/" . $current_historial->hist_id . "_*");
    foreach ($archivos as $archivo) {
        $nombre_archivo = basename($archivo);
        $file = 'http://' . $_SERVER['SERVER_NAME'] . $rutaCarpetaSubidas . 'archivos_historial/' . $nombre_archivo;

        if (is_image($file)) {
            echo '<div current = "' . $current_historial->hist_id . '" class="imagen">';
            echo '<img name= "' . $nombre_archivo . '" src="' . $file . '" height="50" width="50">';
            echo '<a href="#" id="enlaceajax_editar' . $current_historial->hist_id . '">eliminar</a></div>';
        } else {
            echo '<div current = "' . $current_historial->hist_id . '" class="imagen">';
            echo '<img name= "' . $nombre_archivo . '" src="' . $THEME_FOLDER . '/images/unknown_file.jpg" height="50" width="50">';
            echo '<a href="#" id="enlaceajax_editar' . $current_historial->hist_id . '">eliminar</a></div>';
        }
    }
    ?>
</div>
<br>
<div id="info_msg<?php echo $current_historial->hist_id ?>"></div>


