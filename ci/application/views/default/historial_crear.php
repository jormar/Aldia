<script type="text/javascript">
    $(window).load( function() {

        $("#fileUpload").uploadify({
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
                $("#showimage").append('<div class="imagen"><img name= "' + fileObj.name + '" src="http://<?php echo $_SERVER['SERVER_NAME'] . $rutaCarpetaSubidas . $n_random;
?>' + fileObj.name + '" height="50" width="50" /><a href="#" id="enlaceajax">eliminar</a></div>');
            }                  
        });//fin funcion oncomplete
        
       
        function yourfunction(event) {
            var nombre_archivo = $(this).siblings('img').attr('name');
            var padre = $(this).parent();
                
            $.post("<?php echo site_url(); ?>proyecto/eliminar_archivo/<?php echo $n_random; ?>"+nombre_archivo+"/tmp", function(data_s) {
                $("#info_msg").text(data_s);
                $("#info_msg").fadeIn('slow');
                $("#info_msg").fadeOut('slow');
            });// fin post
            padre.fadeOut('slow');
        }//fin yourfunction
        $('#enlaceajax').live("click",yourfunction);
       
    });//finon
</script>

<div class="register-form">
    <form id="historial_crear_form" action="<?php echo site_url('proyecto/crear_historial/' . $PROYECTO->proy_id . '/' . $n_random) ?>" method="POST">
        <?php $input = 'hist_texto' ?>
        <div class="field field-box-white <?php if (form_error($input)) echo 'error'; else echo 'no-error'; ?>">
            <label for="<?php echo $input ?>" class="id"><span class="required">*</span> Texto:</label>
            <textarea class="tinymce-edit" name="<?php echo $input ?>" id="<?php echo $input ?>" rows="3"><?php echo $this->input->post($input) ?></textarea>
            <?php echo Message::print_form_error($input) ?>
        </div>

        <?php $input = 'hist_type' ?>
        <!--  Visualmente aplicar la clase de error a los radio buttons no es atractivo
        por lo que se sacaron de la clase-->
        <div class="field <?php if (form_error($input)) echo 'error' ?>">
            <label for="<?php echo $input ?>" class="id">Tipo:</label>
        </div>
        <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>_correccion" value="correccion" <?php if ($this->input->post($input) == "correccion") echo "checked"; ?> /> <label for="<?php echo $input ?>_correccion">Correcci&oacute;n</label>
        <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>_observacion" value="observacion"  <?php if ($this->input->post($input) == "observacion") echo "checked"; ?> /> <label for="<?php echo $input ?>_observacion">Observaci&oacute;n</label>
        <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>_nota" value="nota"  <?php if ($this->input->post($input) == "nota") echo "checked"; ?> /> <label for="<?php echo $input ?>_nota">Nota</label>
        <input type="radio" class="" name="<?php echo $input ?>" id="<?php echo $input ?>_noticia" value="noticia"  <?php if ($this->input->post($input) == "noticia") echo "checked"; ?> /> <label for="<?php echo $input ?>_noticia">Noticia</label>
        <div class="field <?php if (form_error($input)) echo 'error' ?>">
            <?php echo Message::print_form_error($input) ?>
        </div>
        <input type="hidden" name="submit-his-crear" value="submit-his-crear"/>
    </form>
</div>

<div id="uploader">
    <div id="fileUpload">You have a problem with your javascript</div>
    <a href="javascript:$('#fileUpload').uploadifyUpload();">subir archivos</a>
    <div id="showimage"></div>
    <br>
    <div id="info_msg"></div>
</div>

