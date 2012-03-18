<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Modelo para usuarios
 *
 * @author Jormar Arellano <jormar.arellano@gmail.com>
 */

class Usuario_participa_db extends ALDIA_Model {

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
        return 'usuario_participa';
    }

    public static function ids(){
        return array('proy_id', 'user_id');
    }
    
    /**
     * Establece los privilegios
     */
    public function grant($priv, $value=1) {
        $this->$priv = $value;
    }

    /**
     * Establece todos los privilegios al mismo valor
     *
     * @param string $value Valor
     */
    public function grant_all($value=1) {
        $all = array(
            'p_modif_datos',
            'p_modif_repre',
            'p_ver_plan',
            'p_modif_activ',
            'p_modif_fase',
            'p_modif_histo',
            'p_export',
            'p_modif_inver');

        foreach($all as $priv){
            $this->grant($priv, $value);
        }
    }
}
