<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * View Helper.
 * Funciones para hacer la maquetacion HTML mas amigables.
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Jormar Arellano <jormar.arellano@gmail.com>
 */

// ------------------------------------------------------------------------
/**
 * Muestra el archivo header.php
 */
if ( ! function_exists('get_header'))
{
	function get_header($view = 'header'){
		$CI =& get_instance();
		$CI->load->view($view);
	}
}

/**
 * Muestra el archivo footer.php
 */
if ( ! function_exists('get_footer'))
{
	function get_footer($view = 'footer'){
		$CI =& get_instance();
		$CI->load->view($view);
	}
}

/**
 * Muestra el sidebar. Para esta funcion, es mas comun indicar varios sidebar,
 * basta con pasarlo como parametro.
 * 
 * Por defecto, carga el archivo sidebar.php
 */
if ( ! function_exists('get_sidebar'))
{
	function get_sidebar($view = 'sidebar'){
		$CI =& get_instance();
		$CI->load->view($view);
	}
}

/**
 * Indica si estamos en una seccion en particular
 */
if ( ! function_exists('is_in_uri_segment'))
{
	function is_in_uri_segment($option){
		$CI =& get_instance();

        $segments = $CI->uri->segment_array();
        foreach ( $segments as $value ) { 
            if ( $option == $value ) return TRUE;
        }

        return FALSE;
	}
}


/**
 * Indica si estamos el URL esta en una seccion en particular.
 * 
 * @param String    Seccion que queremos ubicar. Por ejemplo, "user/register"
 */
if ( ! function_exists('is_in_uri'))
{
	function is_in_uri($option, $true = TRUE, $false = FALSE){
		$CI =& get_instance();

        if ( is_array ( $option ) ) {
            $options = $option;
            foreach ( $options as $option ){
                $option = (String)$option;
                if(preg_match('/.*' . str_replace('/', '\/', $option ) . '.*/i', $CI->uri->uri_string() ) ){
                    return $true;
                }
            }
        } else {
            $option = (String)$option;
            if(preg_match('/.*' . str_replace('/', '\/', $option ) . '.*/i', $CI->uri->uri_string() ) ){
                return $true;
            }
        }

        return $false;
	}
}
