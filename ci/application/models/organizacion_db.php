<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Modelo para usuarios
 *
 * @author Jormar Arellano <jormar.arellano@gmail.com>
 */

class Organizacion_db extends ALDIA_Model {

    /**
	 * Constructor
	 *
	 * @access public
	 */
    function __construct()
	{
        parent::__construct();
	}

    public static function tableName(){
        return 'organizacion';
    }

    public static function ids(){
        return array('org_id');
    }
}
