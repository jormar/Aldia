<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Modelo para usuario_miembro_organizacion
 *
 */
class Usuario_miembro_organizacion_db extends ALDIA_Model {

    /**
     * Constructor
     *
     * @access public
     */
    function __construct() {
        parent::__construct();
    }

    public static function tableName() {
        return 'usuario_miembro_organizacion';
    }

    public static function ids() {
        return array('org_id', 'user_id');
    }

    public static function get_permiso_miembro() {
        return array('privilegio');
        
    }

    public function set_permiso_miembro($org, $user) {
        
    }

    public static function get_invitacion_miembro() {
        return array('e_invitacion');
        
    }

    public function set_invitacion_miembro($org, $user, $value) {
        
    }

}
