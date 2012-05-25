<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Organizacion extends ALDIA_Controller {
	/**
	 * Controlador de sesiones.
	 * Gestiona lo que es el login, logout, y recuperaciones de contrasenas.
	 *
	 * Es el controlador por defecto.
	 */
	public function index() {
		$this->perfil();
	}

    public function perfil($id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        // Por ahora, solo traemos los datos de la misma comunidad
	$this->view_data['HEADER_TITLE'] = 'Organizaciones';        
        $this->load->view('organizacion_home', $this->view_data);
    }
    
}
