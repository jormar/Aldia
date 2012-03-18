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
 * Necesitamos que nuestro cargador soporte de forma transparene para el
 * programador multiples temas visuales (HTMLs).
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Libraries
 * @author      Jormar Arellano
 * @link
 */
class ALDIA_Loader extends CI_Loader {
	function __construct() {
        parent::__construct();

		/// Sobreescribimos la ruta donde se encuentra la carpeta de vistas
		/// IMPORTANTE: aun NO se establace coneccion con mysql!
        // NOTA: no recuerdo porque no lo hago de esta forma...
        // ...asi que dejar esto comentado =D
		// $this->_ci_view_path .= SYSTEM_DEFAULT_THEME.'/';
    }

	/*
	 * Sobre escribimos la carga de las vistas para dar soporte a multiples
	 * temas cargados dinamicamente (mysql por ejemplo)
	 */
	function view ( $view, $vars = array(), $return = FALSE ) {
		/// Seleccionamos el tema que deseamos usar a usar...
		$theme = SYSTEM_DEFAULT_THEME;

		/// Adicionalmente, podriamos incluir en $vars el archivo css a usar :D
		$vars['TEMPLATE_PATH'] = APPPATH.'views/'.$theme.'/';
        $vars['TEMPLATE_URL'] = site_url() . $vars['TEMPLATE_PATH'];

        $vars['THEME_FOLDER'] = site_url() . '../themes/' . $theme;

		/// Cargamos la vista en el tema adecuado
		return parent::view($theme.'/'.$view, $vars, $return);
	}

}