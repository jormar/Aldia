<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comunidad extends ALDIA_Controller {

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
        $this->comunidad_db->com_id = SYSTEM_DEFAULT_COM;
        $comunidad = $this->comunidad_db->get();

        if( !($comunidad && currentuser_can('cambiar_perfil_comunidad', $comunidad) ) ){
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos adecuados para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_perfil_proccess($comunidad);
        
        $this->view_data['HEADER_TITLE'] = 'La Comunidad';
        $this->view_data['COMUNIDAD'] = $comunidad;
        $this->load->view('comunidad_perfil', $this->view_data);
    }
    
    private function _perfil_proccess($comunidad) {

        if( $this->input->post('submit-perfil-com') ){
            // Procesamos el formulario
            $this->form_validation->set_rules('com_nombre', 'Nombre', 'required|trim|max_length[45]');
            $this->form_validation->set_rules('com_habitantes', 'Habitantes', 'required|trim|integer');
            $this->form_validation->set_rules('com_familias', 'Familias', 'required|trim|integer');
            $this->form_validation->set_rules('com_estado', 'Estado', 'required|trim|max_length[45]');
            $this->form_validation->set_rules('com_municipio', 'Estado', 'required|trim|max_length[45]');
            $this->form_validation->set_rules('com_parroquia', 'Parroquia', 'required|trim|max_length[45]');
            $this->form_validation->set_rules('com_area_geo', '&Aacute;rea geogr&aacute;fica', 'trim');

            if ($this->form_validation->run() == TRUE) {
                $comunidad->com_nombre = set_value('com_nombre');
                $comunidad->com_habitantes = set_value('com_habitantes');
                $comunidad->com_familias = set_value('com_familias');
                $comunidad->com_estado = set_value('com_estado');
                $comunidad->com_municipio = set_value('com_municipio');
                $comunidad->com_parroquia = set_value('com_parroquia');
                $comunidad->com_area_geo = set_value('com_area_geo');

                if ( $comunidad->save() ) {
                    $this->session->set_flashdata('SUCCESS_MSG', 'Se actualizaron los datos con &eacute;xito.');
                    redirect( current_url() );
                    exit();
                } else {
                    // Error
                    if( $this->db->_error_message() ) {
                        Message::add_error( 'No fue posible procesar su solicitud. Por favor, Int&eacute;ntelo m&aacute;s tarde.' );
                    } else {
                        Message::add_warning( 'No se realizaron cambios.' );
                    }
                }

            } else {

            }
        }
    }
}
