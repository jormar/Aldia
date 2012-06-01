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
        $this->_must_authenticate_first();
        $this->load->library('form_validation');
	$this->view_data['ORGANIZACIONES_REG'] = $this->organizacion_db->get_array();
	$this->view_data['HEADER_TITLE'] = 'Organizaciones';        
        $this->load->view('organizacion_home', $this->view_data);
    }
    
    public function nuevo($id = 0) {

        $this->_must_authenticate_first();
        $this->load->library('form_validation');
	$this->_nuevo_proccess();
        $this->view_data['HEADER_TITLE'] = 'Crear Organizaci&oacute;n';
        $this->load->view('organizacion_crear', $this->view_data);
    }
    private function _nuevo_proccess() {
	if ($this->input->post('submit-org-nuevo')) {
         	$this->form_validation->set_rules('nombre_org','Nombre','required');
	        $this->form_validation->set_rules('sector_org','Sector','required');
        	$this->form_validation->set_rules('desc_org','Descripci&oacute;n','required');
	}
	if ($this->form_validation->run() == TRUE) {
		$this->organizacion_db->org_nombre = set_value('nombre_org');
		$this->organizacion_db->org_sectores = set_value('sector_org');
		$this->organizacion_db->org_desc = set_value('desc_org');
		if (($org_id = $this->organizacion_db->save())){
			$this->session->set_flashdata('SUCCESS_MSG', 'La organizaci&oacute;n fue creada con &eacute;xito.');
	                 redirect('organizacion');
                         exit();                
		} else {
                    // Error
                    if ($this->db->_error_message()) {
                        Message::add_error('No fue posible procesar su solicitud. Por favor, Int&eacute;ntelo m&aacute;s tarde.');
                    } else {
                        Message::add_warning('No se realizaron cambios.');
                      }
	            }
		}else{}
	}
    public function editar($id = 0) {
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

	$this->view_data['HEADER_TITLE'] = 'Editar Organizaci&oacute;n';
//        $this->view_data['ORGANIZACION'] = $perfil_user;
        $this->load->view('organizacion_editar', $this->view_data);
    
    }

}
?>
