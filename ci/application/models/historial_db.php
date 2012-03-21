<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Modelo para usuarios
 *
 * @author Jormar Arellano <jormar.arellano@gmail.com>
 */

class Historial_db extends ALDIA_Model {

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
        return 'historico';
    }

    public static function ids(){
        return array('hist_id');
    }
    
    /*
    public function get ( $orderby=FALSE, $order='desc', $row_count=0, $offset=0 ) {
        
        // Por defecto, nos interesa hacer busquedas sobre usuarios activos
        // if ( !isset($this->user_status) ) $this->user_status = 'active';
        
        return parent::get ( $orderby, $order, $row_count, $offset);
    }
    */
}
