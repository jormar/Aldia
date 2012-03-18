<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario extends ALDIA_Controller {

	/**
	 * Controlador de sesiones.
	 * Gestiona lo que es el login, logout, y recuperaciones de contrasenas.
	 *
	 * Es el controlador por defecto.
	 */
	public function index() {
		$this->escritorio();
	}

    public function registro() {
        // $this->output->enable_profiler(TRUE);
        $this->load->library('form_validation');
        
        $this->_registro_proccess();

        $this->view_data['HEADER_TITLE'] = 'Registrarse';
        $this->load->view('user_registro', $this->view_data);
    }

    private function _registro_proccess() {
        if( $this->input->post('submit-registro') ){
            // Procesamos el formulario
            $this->form_validation->set_rules('user_email', 'Correo electr&oacute;nico', 'required|trim|valid_email|callback__validation_unique_email');
            $this->form_validation->set_rules('user_pass', 'Contrase&ntilde;a', 'required|xss_clean|min_length[5]|matches[user_pass2]');
            $this->form_validation->set_rules('user_pass2', 'Confirmar Contrase&ntilde;a', 'required');
            $this->form_validation->set_rules('user_nombre', 'Nombre', 'required|trim|max_length[45]');
            $this->form_validation->set_rules('user_apellido', 'Apellido', 'required|trim|max_length[45]');
            $this->form_validation->set_rules('user_sex', 'Sexo', 'required|max_length[1]');
            $this->form_validation->set_rules('user_ci', 'C&eacute;dula', 'required|trim|numeric|max_length[10]');
            $this->form_validation->set_rules('user_telf', 'Tel&eacute;fono', 'required|trim|numeric|max_length[14]');
            $this->form_validation->set_rules('user_telf_alt', 'Tel&eacute;fono alternativo', 'numeric|trim|max_length[14]');
            $this->form_validation->set_rules('user_dir', 'Direcci&oacute;n', 'required|trim');
            $this->form_validation->set_rules('_check', 'Condici&oacute;', 'required');

            if ($this->form_validation->run() == TRUE) {
                $this->load->library('PasswordHash');
                $wp_hasher = new PasswordHash();
                $password_wp = $wp_hasher->HashPassword(set_value('user_pass'));

                $this->usuario_db->clear();
                $this->usuario_db->user_email = set_value('user_email');
                $this->usuario_db->user_pass = $password_wp;
                $this->usuario_db->user_nombre = set_value('user_nombre');
                $this->usuario_db->user_apellido = set_value('user_apellido');
                $this->usuario_db->user_sex = set_value('user_sex');
                $this->usuario_db->user_ci = set_value('user_ci');
                $this->usuario_db->user_telf = set_value('user_telf');
                $this->usuario_db->user_telf_alt = set_value('user_telf_alt');
                $this->usuario_db->user_dir = set_value('user_dir');

                $this->usuario_db->user_registrado = date('Y-m-d');
                $this->usuario_db->user_com_id = SYSTEM_DEFAULT_COM;
                $this->usuario_db->user_org_id = SYSTEM_DEFAULT_ORG;

                if ( $this->usuario_db->save() ) {
                    // Enviar correo de bienvenida

                    $this->view_data['HEADER_TITLE'] = 'Registrarse';
                    $this->view_data['USER'] = $this->usuario_db;
                    echo $this->load->view('user_registro_success', $this->view_data, TRUE);
                    exit();
                } else {
                    // Error
                    Message::add_error( 'No fue posible procesar su registro. Por favor, Int&eacute;ntelo m&aacute;s tarde.' );
                }

            } else {

            }
        }
    }

    public function _validation_unique_email($email) {
        $user = new Usuario_db();
        $user->user_email = $email;
        if( $user->get() ) {
            $this->form_validation->set_message('_validation_unique_email', 'Este correo elect&oacute;nico ya fue registrado en el sistema.');
            return FALSE;
        }
        return TRUE;
    }

    public function perfil($id = 0) {
        // $this->output->enable_profiler(TRUE);

        $this->_must_authenticate_first();
        $this->load->library('form_validation');
        
        $perfil_user = $current_user = user_get_data ();

        if ($id==0 || $id == $current_user->user_id) {
            // Esta modificando su perfil
            $this->_perfil_proccess($current_user);

        } else {
            // intenta modificar el de alguien mas...
            $this->usuario_db->user_id = $id;
            $user = $this->usuario_db->get();

            // if ( currentuser_can_change_user($user) ) {
            if ( currentuser_can('cambiar_perfil', $user) ) {
                $this->_perfil_proccess($user);
                $perfil_user = $user;
            } else {
                $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos adecuados para realizar esta acci&oacute;n.');
                redirect(  );
                exit();
            }
        }

        $this->view_data['HEADER_TITLE'] = 'Modificar perfil';
        $this->view_data['USER'] = $perfil_user;
        $this->load->view('user_perfil', $this->view_data);
    }
    
    private function _perfil_proccess($user) {
        $this->_perfil_pass_proccess($user);

        if( $this->input->post('submit-perfil') ){
            // Procesamos el formulario
            if ( $user->user_email == $this->input->post('user_email') ) {
                $this->form_validation->set_rules('user_email', 'Correo electr&oacute;nico', 'required|valid_email');
            } else {
                $this->form_validation->set_rules('user_email', 'Correo electr&oacute;nico', 'required|valid_email|callback__validation_unique_email');
            }
            $this->form_validation->set_rules('user_nombre', 'Nombre', 'required|trim|max_length[45]');
            $this->form_validation->set_rules('user_apellido', 'Apellido', 'required|trim|max_length[45]');
            $this->form_validation->set_rules('user_sex', 'Sexo', 'required|max_length[1]');
            $this->form_validation->set_rules('user_ci', 'C&eacute;dula', 'required|trim|numeric|max_length[10]');
            $this->form_validation->set_rules('user_telf', 'Tel&eacute;fono', 'required|trim|numeric|max_length[14]');
            $this->form_validation->set_rules('user_telf_alt', 'Tel&eacute;fono alternativo', 'numeric|trim|max_length[14]');
            $this->form_validation->set_rules('user_dir', 'Direcci&oacute;n', 'required|trim');

            if ($this->form_validation->run() == TRUE) {
                $user->user_email = set_value('user_email');
                $user->user_nombre = set_value('user_nombre');
                $user->user_apellido = set_value('user_apellido');
                $user->user_sex = set_value('user_sex');
                $user->user_ci = set_value('user_ci');
                $user->user_telf = set_value('user_telf');
                $user->user_telf_alt = set_value('user_telf_alt');
                $user->user_dir = set_value('user_dir');

                // var_dump($user); die;

                if ( $user->save() ) {
                    // Actualizamos los datos de la sesion actual
                    $current_user = user_get_data();
                    if ( $current_user->user_id == $user->user_id ) {
                        $this->session->set_userdata('user', get_object_vars( $user ) );
                    }

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

    private function _perfil_pass_proccess($user) {
        if( $this->input->post('submit-perfil-pass') ){
            // Procesamos el formulario
            $this->form_validation->set_rules('user_pass', 'Contrase&ntilde;a', 'required|xss_clean|min_length[5]|matches[user_pass2]');
            $this->form_validation->set_rules('user_pass2', 'Confirmar Contrase&ntilde;a', 'required');

            if ($this->form_validation->run() == TRUE) {
                $this->load->library('PasswordHash');
                $wp_hasher = new PasswordHash();
                $password_wp = $wp_hasher->HashPassword(set_value('user_pass'));

                $user->user_pass = $password_wp;

                if ( $user->save() ) {
                    // Actualizamos los datos de la sesion actual
                    $current_user = user_get_data();
                    if ( $current_user->user_id == $user->user_id ) {
                        $this->session->set_userdata('user', get_object_vars( $user ) );
                    }

                    $this->session->set_flashdata('SUCCESS_MSG', 'Contrase&ntilde;a actualizada.');
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

    public function lista() {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $current_user = user_get_data ();

        $org_levels = get_org_rol_levels();
        if ( $org_levels[$current_user->user_org_rol] > ADMIN_LEVEL ) {
            redirect ('usuario');
            exit();
        }

        // Usuarios activos
        $this->usuario_db->user_status = 'active';
        $this->usuario_db->user_org_id = $current_user->user_org_id;
        $this->view_data['ACTIVE_USERS'] = $this->usuario_db->get_array();

        $this->usuario_db->clear();
        $this->usuario_db->user_status = 'disabled';
        $this->usuario_db->user_org_id = $current_user->user_org_id;
        $this->view_data['DISABLED_USERS'] = $this->usuario_db->get_array();

        $this->view_data['HEADER_TITLE'] = 'Usuarios';
        $this->load->view('user_list', $this->view_data);
    }

    public function suspender($user_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();

        $this->usuario_db->user_id = $user_id;
        $user = $this->usuario_db->get();
        if ( $user && currentuser_can('cambiar_user_status', $user) ) {
            $this->usuario_db->clear();
            $this->usuario_db->user_id = $user_id;
            $this->usuario_db->user_status = 'disabled';
            if ( $this->usuario_db->save() ) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'El usuario fue desactivado.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect( 'usuario/lista' );
    }

    public function activar($user_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();

        $this->usuario_db->user_id = $user_id;
        $user = $this->usuario_db->get();
        if ( $user && currentuser_can('cambiar_user_status', $user) ) {
            $this->usuario_db->clear();
            $this->usuario_db->user_id = $user_id;
            $this->usuario_db->user_status = 'active';
            if ( $this->usuario_db->save() ) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'El usuario fue activado.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect( 'usuario/lista' );
    }

    public function eliminar($user_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();

        $this->usuario_db->user_id = $user_id;
        $user = $this->usuario_db->get();
        if ( $user && currentuser_can('borrar_usuario', $user) ) {
            $this->usuario_db->clear();
            $this->usuario_db->user_id = $user_id;
            $this->usuario_db->user_status = 'deleted';
            $this->usuario_db->user_email = '';

            if ( $this->usuario_db->save() ) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'El usuario fue eliminado. Debera volver a registrarse si desea participar en el sistema.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect( 'usuario/lista' );
    }

    public function toadmin($user_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();

        $this->usuario_db->user_id = $user_id;
        $user = $this->usuario_db->get();
        if ( $user && currentuser_can('cambiar_org_rol', $user) ) {
            $this->usuario_db->clear();
            $this->usuario_db->user_id = $user_id;
            $this->usuario_db->user_org_rol = 'admin';

            if ( $this->usuario_db->save() ) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'Los cambios fueron realizados.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect( 'usuario/lista' );
    }

    public function tomiembro($user_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();

        $this->usuario_db->user_id = $user_id;
        $user = $this->usuario_db->get();
        if ( $user && currentuser_can('cambiar_org_rol', $user) ) {
            $this->usuario_db->clear();
            $this->usuario_db->user_id = $user_id;
            $this->usuario_db->user_org_rol = 'miembro';

            if ( $this->usuario_db->save() ) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'Los cambios fueron realizados.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect( 'usuario/lista' );
    }

    public function escritorio() {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $current_user = user_get_data ();

        $this->usuario_participa_db->user_id = $current_user->user_id;
        $this->view_data['USUARIO_PARTICIPA'] = $usuario_participa = $this->usuario_participa_db->get_array();

        $usuario_participa_ids = array();
        foreach( $usuario_participa as $proy ) {
            $usuario_participa_ids[] = $proy->proy_id;
        }
        $this->view_data['USUARIO_PARTICIPA_IDS'] = $usuario_participa_ids;

        $this->proyecto_db->clear();
        $this->proyecto_db->proy_org_id = $current_user->user_org_id;
        $this->proyecto_db->proy_status = 'active';
        $this->db->join(Organizacion_db::tableName(), 'org_id = proy_org_id', 'left');
        $this->view_data['ORG_PROYECTOS'] = $this->proyecto_db->get_array();

        $this->proyecto_db->clear();
        $this->proyecto_db->proy_org_id = $current_user->user_org_id;
        $this->proyecto_db->proy_status = 'disabled';
        $this->db->join(Organizacion_db::tableName(), 'org_id = proy_org_id', 'left');
        $this->view_data['DISABLED_ORG_PROYECTOS'] = $this->proyecto_db->get_array();

        $this->proyecto_db->clear();
        $this->proyecto_db->proy_com_id = $current_user->user_com_id;
        $this->proyecto_db->proy_status = 'active';
        $this->db->join(Organizacion_db::tableName(), 'org_id = proy_org_id', 'left');
        $this->view_data['COM_PROYECTOS'] = $this->proyecto_db->get_array();

        $this->view_data['HEADER_TITLE'] = 'Escritorio';
        $this->load->view('user_home', $this->view_data);
    }
}
