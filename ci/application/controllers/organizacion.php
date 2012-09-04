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
        $this->home();
    }

    //Pagina inicial de las organizaciones
    public function home($id = 0) {
        $this->_must_authenticate_first();
        $this->load->library('form_validation');
        $this->view_data['ORGANIZACIONES_REG'] = $this->organizacion_db->get_array();
        $this->view_data['HEADER_TITLE'] = 'Organizaciones';
        $this->load->view('organizacion_home', $this->view_data);
    }

    //funcion publica para crear organizaciones
    public function nuevo($id = 0) {

        $this->_must_authenticate_first();
        $this->load->library('form_validation');
        $this->_nuevo_proccess();
        $this->view_data['HEADER_TITLE'] = 'Crear Organizaci&oacute;n';
        $this->load->view('organizacion_crear', $this->view_data);
    }

    //funcion privada que crea las organizaciones
    private function _nuevo_proccess() {
        if ($this->input->post('submit-org-nuevo')) {
            $this->form_validation->set_rules('nombre_org', 'Nombre', 'required');
            $this->form_validation->set_rules('sector_org', 'Sector', 'required');
            $this->form_validation->set_rules('desc_org', 'Descripci&oacute;n', 'required');
        }
        if ($this->form_validation->run() == TRUE) {
            $current_user = user_get_data();
            $this->organizacion_db->org_nombre = set_value('nombre_org');
            $this->organizacion_db->org_sectores = set_value('sector_org');
            $this->organizacion_db->org_desc = set_value('desc_org');
            $this->organizacion_db->org_status = '1';
            if (($org_id = $this->organizacion_db->save())) {
                // Privilegios del usuario sobre la organizacion
                $this->usuario_miembro_organizacion_db->org_id = $org_id;
                $this->usuario_miembro_organizacion_db->user_id = $current_user->user_id;
                $this->usuario_miembro_organizacion_db->privilegio = '5';
                $this->usuario_miembro_organizacion_db->e_invitacion = '2';
                // var_dump($this->usuario_participa_db); die;
                $this->usuario_miembro_organizacion_db->insert();
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

    //funcion publica para editar organizaciones
    public function editar($org_id = 0) {
        $this->_must_authenticate_first();
        $this->organizacion_db->org_id = $org_id;
        $org = $this->organizacion_db->get();
        if ($org && currentuser_can('org_editar', $org)) {
            $this->load->library('form_validation');
            $this->_editar_proccess($org);
            $this->view_data['HEADER_TITLE'] = 'Editar Organizaci&oacute;n';
            $this->view_data['ORGANIZACION'] = $org;
            $this->load->view('organizacion_editar', $this->view_data);
        }
    }

    //funcion privada para editar organizaciones
    private function _editar_proccess() {
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

    //funcion publica para eliminar (deshabilitar) organizaciones
    public function eliminar($org_id = 0) {


        $this->_must_authenticate_first();

        $this->organizacion_db->org_id = $org_id;
        $org = $this->organizacion_db->get();
        if ($org && currentuser_can('org_eliminar', $org)) {
            $this->organizacion_db->clear();
            $this->organizacion_db->org_id = $org_id;
            $this->organizacion_db->org_status = '0';

            if ($this->organizacion_db->save()) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'Los cambios fueron realizados.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }

        redirect('organizacion');
    }

    //pagina principal de modulo de invitaciones
    public function invitaciones($org_id = 0) {

        $this->_must_authenticate_first();

        $this->organizacion_db->org_id = $org_id;
        $org = $this->organizacion_db->get();
        if ($org && currentuser_can('org_invitaciones', $org)) {

            $this->db->select('*');
            $this->db->from('aldia_usuarios AS A');
            $this->db->join('aldia_usuario_miembro_organizacion AS B', 'A.user_id = B.user_id', 'INNER');
            $this->db->where('org_id', $org_id);
            
            $this->view_data['DATA'] = $this->db->get();
            $this->view_data['ORG'] = $org_id;

            
            $this->view_data['USERS'] = $this->db->query("SELECT `aldia_usuarios`.* FROM `aldia_usuarios` 
                LEFT OUTER JOIN `aldia_usuario_miembro_organizacion` 
                ON `aldia_usuarios`.`user_id` = `aldia_usuario_miembro_organizacion`.`user_id`
                AND `aldia_usuario_miembro_organizacion`.`org_id` = ".$this->db->escape($org_id)."
                WHERE `aldia_usuario_miembro_organizacion`.`user_id` IS NULL");

            $this->load->library('form_validation');

            $this->view_data['HEADER_TITLE'] = 'Manejo de Invitaciones';
            $this->view_data['ORGANIZACION'] = $org;

            $this->load->view('organizacion_invitaciones', $this->view_data);
        }
    }

    public function ver($org_id = 0) {
        $this->_must_authenticate_first();

        $this->organizacion_db->org_id = $org_id;
        $org = $this->organizacion_db->get();
        if ($org && currentuser_can('org_ver', $org)) {
            $this->load->library('form_validation');
            $this->view_data['HEADER_TITLE'] = 'Ver Organizacion';
            $this->view_data['ORGANIZACION'] = $org;
            $this->load->view('organizacion_ver', $this->view_data);
        }
    }

    public function reinvitar($org_id = 0, $_user_id = 0) {
        $this->_must_authenticate_first();

        $this->organizacion_db->org_id = $org_id;
        $org = $this->organizacion_db->get();
        if ($org && currentuser_can('org_invitaciones', $org)) {
            $this->usuario_miembro_organizacion_db->clear();
            $this->usuario_miembro_organizacion_db->user_id = $_user_id;
            $this->usuario_miembro_organizacion_db->org_id = $org_id;
            $this->usuario_miembro_organizacion_db->e_invitacion = '1';
            if ($this->usuario_miembro_organizacion_db->save()) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'Invitacion reenviada.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect('organizacion/invitaciones/' . $org_id);
    }

    public function cancelar_invitacion($org_id = 0, $_user_id = 0) {
        $this->_must_authenticate_first();

        $this->organizacion_db->org_id = $org_id;
        $org = $this->organizacion_db->get();
        if ($org && currentuser_can('org_invitaciones', $org)) {
            $this->usuario_miembro_organizacion_db->clear();
            $this->usuario_miembro_organizacion_db->user_id = $_user_id;
            $this->usuario_miembro_organizacion_db->org_id = $org_id;
            $this->usuario_miembro_organizacion_db->e_invitacion = '0';
            if ($this->usuario_miembro_organizacion_db->save()) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'Invitacion cancelada.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect('organizacion/invitaciones/' . $org_id);
    }

    public function aceptar_invitacion($org_id = 0, $_user_id = 0) {
        $this->_must_authenticate_first();

        $this->organizacion_db->org_id = $org_id;
        $org = $this->organizacion_db->get();
        if ($org && currentuser_can('org_aceptar', $org)) {
            $this->usuario_miembro_organizacion_db->clear();
            $this->usuario_miembro_organizacion_db->user_id = $_user_id;
            $this->usuario_miembro_organizacion_db->org_id = $org_id;
            $this->usuario_miembro_organizacion_db->e_invitacion = '2';
            if ($this->usuario_miembro_organizacion_db->save()) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'Invitacion aceptada.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect('usuario/perfil/');
    }

    public function modificar_privilegio($org_id = 0, $_user_id = 0) {
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->organizacion_db->org_id = $org_id;
        $org = $this->organizacion_db->get();
        if ($org && currentuser_can('org_invitaciones', $org)) {
            $this->_modificar_privilegio($org_id, $_user_id);
        }
    }

    private function _modificar_privilegio($org_id, $user_id) {

        if ($this->input->post('submit-editar-privilegios')) {
            // Procesamos el formulario
            $this->form_validation->set_rules('privilegio', 'privilegio', '');

            if ($this->form_validation->run() == TRUE) {
                $this->usuario_miembro_organizacion_db->clear();
                $this->usuario_miembro_organizacion_db->org_id = $org_id;
                $this->usuario_miembro_organizacion_db->user_id = $user_id;
                $this->usuario_miembro_organizacion_db->privilegio = set_value('privilegio');

                $this->usuario_miembro_organizacion_db->update();
                if ($this->db->_error_message()) {
                    Message::add_error('No fue posible procesar su solicitud. Por favor, Int&eacute;ntelo m&aacute;s tarde.');
                } else {
                    $this->session->set_flashdata('SUCCESS_MSG', 'El usuario fue actualizado con &eacute;xito.');
                    redirect('organizacion/invitaciones/' . $org_id);
                    exit();
                }
            } else {
                
            }
        }
    }

    public function invitar_usuario($org_id = 0) {

        $this->load->library('table');
        $this->load->helper('html');
          $this->load->library('form_validation');
        $this->organizacion_db->org_id = $org_id;
        $org = $this->organizacion_db->get();

        if ($org && currentuser_can('org_invitaciones', $org)) {
            $this->_invitar_usuario($org_id);
        }
    }

    private function _invitar_usuario($org_id) {

        if ($this->input->post('submit-miembro-invitar')) {
            // Procesamos el formulario
            $this->form_validation->set_rules('user_id', 'user_id', '');
            $this->form_validation->set_rules('privilegio', 'privilegio', '');

            if ($this->form_validation->run() == TRUE) {
                $this->usuario_miembro_organizacion_db->clear();
                $this->usuario_miembro_organizacion_db->org_id = $org_id;
                $this->usuario_miembro_organizacion_db->user_id = set_value('user_id');
                $this->usuario_miembro_organizacion_db->privilegio = set_value('privilegio');
                $this->usuario_miembro_organizacion_db->e_invitacion = '0';

                $this->usuario_miembro_organizacion_db->insert();
                
                if ($this->db->_error_message()) {
                    Message::add_error('No fue posible procesar su solicitud. Por favor, Int&eacute;ntelo m&aacute;s tarde.');
                } else {
                    $this->session->set_flashdata('SUCCESS_MSG', 'El usuario fue invitado con &eacute;xito.');
                    redirect('organizacion/invitaciones/' . $org_id);
                    exit();
                }
            } else {
                
                
            }
        }
    }


}

?>
