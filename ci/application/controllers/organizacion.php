<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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
            $this->form_validation->set_rules('nombre_org', 'Nombre', 'required');
            $this->form_validation->set_rules('sector_org', 'Sector', 'required');
            $this->form_validation->set_rules('desc_org', 'Descripci&oacute;n', 'required');
        }
        if ($this->form_validation->run() == TRUE) {
            $this->organizacion_db->org_nombre = set_value('nombre_org');
            $this->organizacion_db->org_sectores = set_value('sector_org');
            $this->organizacion_db->org_desc = set_value('desc_org');
            if (($org_id = $this->organizacion_db->save())) {
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
        } else {
            
        }
    }

    public function editar($id = 0) {
        $this->_must_authenticate_first();
        $this->load->library('form_validation');
        $this->organizacion_db->org_id = $id;
        $org = $this->organizacion_db->get();
        $this->_editar_proccess($org);
        $this->view_data['HEADER_TITLE'] = 'Editar Organizaci&oacute;n';
        $this->view_data['ORGANIZACION'] = $org;
        $this->load->view('organizacion_editar', $this->view_data);
    }

    private function _editar_proccess($org) {
        if ($this->input->post('submit-editar-org')) {
            $this->form_validation->set_rules('org_nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('org_sectores', 'Sector', 'required');
            $this->form_validation->set_rules('org_desc', 'Descripci&oacute;n', 'required');
        }
        if ($this->form_validation->run() == TRUE) {
            $this->organizacion_db->org_nombre = set_value('org_nombre');
            $this->organizacion_db->org_sectores = set_value('org_sectores');
            $this->organizacion_db->org_desc = set_value('org_desc');
            if (($org_id = $this->organizacion_db->save())) {
                $this->session->set_flashdata('SUCCESS_MSG', 'La organizaci&oacute;n fue editada con &eacute;xito.');
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
        }
    }

    public function eliminar($org) {

        $this->load->library('table');
        $this->load->helper('html');
        $this->load->model('organizacion_db');

        $this->view_data['ORGANIZACIONES_REG'] = $this->organizacion_db->get_array();
        $this->view_data['HEADER_TITLE'] = 'Organizaciones';
//        $this->load->view('organizacion_home', $this->view_data);
        $this->_must_authenticate_first();
        $this->organizacion_db->delete($org);
        echo "listo";
        $this->session->set_flashdata('SUCCESS_MSG', 'La organizaci&oacute;n fue eliminada con &eacute;xito.');
        redirect('organizacion');
    }

    public function invitaciones($id = 0) {
        $this->_must_authenticate_first();
        $this->load->library('form_validation');
        $this->organizacion_db->org_id = $id;
        $org = $this->organizacion_db->get();
        $this->view_data['HEADER_TITLE'] = 'Manejo de Invitaciones';
        $this->view_data['ORGANIZACION'] = $org;
        $current_user = user_get_data();
        // Usuarios activos
        $this->usuario_db->user_status = 'active';
        $this->usuario_db->user_org_id = $current_user->user_org_id;
        $this->view_data['ACTIVE_USERS'] = $this->usuario_db->get_array();

        $this->usuario_db->clear();
        $this->usuario_db->user_status = 'disabled';
        $this->usuario_db->user_org_id = $current_user->user_org_id;
        $this->view_data['DISABLED_USERS'] = $this->usuario_db->get_array();

        $this->load->view('organizacion_invitaciones', $this->view_data);
    }

    public function ver($id = 0) {
        $this->_must_authenticate_first();
        $this->load->library('form_validation');
        $this->organizacion_db->org_id = $id;
        $org = $this->organizacion_db->get();
        $this->view_data['HEADER_TITLE'] = 'Manejo de Invitaciones';
        $this->view_data['ORGANIZACION'] = $org;
        $this->load->view('organizacion_ver', $this->view_data);
    }

}

?>
