<?php

class Message {
    static public $ERROR_MSG = array();
    static public $SUCCESS_MSG = array();
    static public $WARNING_MSG = array();

    static public function add_error($message) {
        Message::$ERROR_MSG[] = $message;
    }
    
    static public function add_success($message) {
        Message::$SUCCESS_MSG[] = $message;
    }

    static public function add_warning($message) {
        Message::$WARNING_MSG[] = $message;
    }

    /**
     * Imprime en HTML los mensajes contenidos en un Array de mensajes
     *
     * @param type $messages
     * @param String $class     Clase del contenedor del mensaje
     */
    static public function show_messages($messages, $class = 'message-box'){
        foreach ( $messages as $error ) {
        ?>
<div class="<?php echo $class ?>"><?php echo $error ?></div>
        <?php
        }
	}

    /**
     * Imprime los mensajes de error
     */
    static public function show_errors(){
        Message::show_messages(Message::$ERROR_MSG, 'error-box');
    }

    /**
     * Imprime los mensajes de exito
     */
    static public function show_success(){
        Message::show_messages(Message::$SUCCESS_MSG);
    }

    /**
     * Imprime las advertencias
     */
    static public function show_warnings(){
        Message::show_messages(Message::$WARNING_MSG);
    }

    /**
     * Imprime todos los mensajes almacenados
     */
    static public function print_all_messages() {
        Message::show_errors();
        Message::show_success();
        Message::show_warnings();
        
        $CI =& get_instance();
        if ( $CI->session->flashdata('ERROR_MSG') )
            Message::show_messages( array( $CI->session->flashdata('ERROR_MSG') ), 'error-box');

        if ( $CI->session->flashdata('SUCCESS_MSG') )
            Message::show_messages( array( $CI->session->flashdata('SUCCESS_MSG') ) );
        
        if ( $CI->session->flashdata('WARNING_MSG') )
            Message::show_messages( array( $CI->session->flashdata('WARNING_MSG') ) );
    }

    /**
     * Esta funcion centraliza el formato de las impresiones de los mensajes de
     * error en los formularios. Necesita la libreria de formularios.
     */
    static public function print_all_form_errors() {
        $CI =& get_instance();
        echo validation_errors('<div class="error-box">', '</div>');
        $CI->form_validation->set_error_delimiters('', '');
    }

    /**
     * Esta funcion centraliza el formato de las impresiones de los mensajes de
     * error en los formularios. Imprime el error de un solo campo.
     * Necesita la libreria de formularios.
     *
     * @param String $input Campo del que se quiere imprimir el error.
     */
    static public function print_form_error($input) {
        $CI =& get_instance();
        echo form_error($input, '<div class="error-msg">', '</div>');
    }
}