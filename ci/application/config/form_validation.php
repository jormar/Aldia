<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * En este archivo van todas las reglas que se usan para validar los
 * formularios.
 * 
 * Tener mucho cuidado con lo que modifica aqui
 */

$config = array(
    /* Formulario de registro de usuario */
    'usuario_registro' => array(
        array(
            'field' => 'user_email',
            'label' => 'Correo electr&oacute;nico',
            'rules' => 'required|valid_email|callback__validation_unique_email'
        ),
        array(
            'field' => 'user_pass',
            'label' => 'Contrase&ntilde;a',
            'rules' => 'required|xss_clean|min_length[5]|matches[user_pass2]'
        ),
        array(
            'field' => 'user_pass2',
            'label' => 'Confirmar contrase&ntilde;a',
            'rules' => 'required'
        ),
        array(
            'field' => 'user_nombre',
            'label' => 'Nombre',
            'rules' => 'required|max_length[45]'
        ),
        array(
            'field' => 'user_apellido',
            'label' => 'Apellido',
            'rules' => 'required|max_length[45]'
        ),
        array(
            'field' => 'user_sex',
            'label' => 'Sexo',
            'rules' => 'required|max_length[1]'
        ),
        array(
            'field' => 'user_ci',
            'label' => 'C&eacute;dula',
            'rules' => 'required|numeric|max_length[10]'
        ),
        array(
            'field' => 'user_telf',
            'label' => 'Tel&eacute;fono',
            'rules' => 'required|numeric|max_length[14]'
        ),
        array(
            'field' => 'user_dir',
            'label' => 'Direcci&oacute;n',
            'rules' => 'required'
        ),
        array(
            'field' => '_check',
            'label' => 'Condici&oacute;',
            'rules' => 'required'
        ),
    ),

    /* Edicion de perfil de un usuario */
    // Se encuentra directamente en el controlador... esto es porque
    // se realizan varias verificaciones que no se puede hacer desde aqui
    
    /* Cambio de contrasena de un usuario - perfil */
    'usuario_perfil_pass' => array(
        array(
            'field' => 'user_pass',
            'label' => 'Contrase&ntilde;a',
            'rules' => 'required|xss_clean|min_length[5]|matches[user_pass2]'
        ),
        array(
            'field' => 'user_pass2',
            'label' => 'Confirmar contrase&ntilde;a',
            'rules' => 'required'
        ),
    ),
);