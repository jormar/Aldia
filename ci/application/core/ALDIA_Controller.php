<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package     CodeIgniter
 * @author      Jormar Arellano
 * @copyright   Copyright (c) 2011, Jormar Arellano.
 * @license     http://codeigniter.com/user_guide/license.html
 * @link        
 * @since       Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CPS Application Controller Class
 *
 * Necesitamos que nuestro controlador realice algunas operaciones adicionales.
 * Vamos a dotarlo de algunas funciones utiles...
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Libraries
 * @author      Jormar Arellano
 * @link        
 */
class ALDIA_Controller extends CI_Controller {
	protected $view_data;

	function __construct()
    {
        parent::__construct();
        // $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'file'));

        $this->view_data = array();
        /*
        $this->view_data['ERROR_MSG'] = array();
        $this->view_data['SUCCESS_MSG'] = array();
        $this->view_data['WARNING_MSG'] = array();
        */

        $this->_load_data();

		// Carga de configuracion de la DB
    }

	/**
	 * Indica si el usuario inicio sesion
	 */
	function _is_login() {
        return user_is_login();
	}

	/**
	 * Verifica si el usuario inicio sesion. En caso de que no, sera redirigido
	 * a otro modulo del sistema (por defecto, la pantalla de login)
	 */
	function _must_authenticate_first($redirectTo = 'accounts/login') {
		if ( !$this->_is_login() ) {
			if ( $this->uri->total_segments() ) {
				$redirectTo .= '?redirectTo='.  urlencode(current_url());
			}
			redirect($redirectTo);
		}
	}

	/**
	 * Si un usuario no ha iniciado sesion, envia un string vacio como
	 * respuesta, en el formtato indicado (defecto: JSON)
	 */
	function _say_nothing_if_not_authenticated($format = 'json') {
		if(!$this->_is_login()) {
			switch ($format){
				default:
					return '';
			}
		}
	}

	/**
	 * Carga los datos por defecto que necesita el layout completo del sistema.
	 */
	function _load_data() {
		$this->view_data['HEADER_TITLE'] = 'DEFAULT TITLE';
        $this->view_data['REDIRECT_TO'] = '';
	}
}

