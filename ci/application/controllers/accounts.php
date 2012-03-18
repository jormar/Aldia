<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accounts extends ALDIA_Controller {

	/**
	 * Controlador de sesiones.
	 * Gestiona lo que es el login, logout, y recuperaciones de contrasenas.
	 *
	 * Es el controlador por defecto.
	 */
	public function index() {
		if($this->_is_login()) {
			redirect();
		} else $this->login();
	}

	/** Inicio de sesion. Permite que un usuario inicie sesion. */
	public function login() {
		$this->_load_data();
		// $this->load->library('form_validation');

        $this->_proccess_login();

        /*
		$this->load->library('PasswordHash');
		$wp_hasher = new PasswordHash();
		$password_wp = $wp_hasher->HashPassword('admin');
		$this->view_data['__PASSWORD__'] = $password_wp;
        echo $password_wp;
        die;
        */

		$this->view_data['REDIRECT_TO'] = $this->input->get_post('redirectTo');
		$this->view_data['HEADER_TITLE'] = 'Inicio de sesi&oacute;n';
		$this->load->view('login', $this->view_data);
	}
	/// Procesa el formulario de inicio de sesion
	public function _proccess_login() {
        if( $this->input->post('submit-sesion') ) {
            $this->load->library('PasswordHash');

            $this->usuario_db->user_email = $this->input->post('u');
            $user = $this->usuario_db->get();

            $pass = $this->input->post('p');

            $wp_hasher = new PasswordHash();
            if( $user && $wp_hasher->CheckPassword($pass, $user->user_pass)){
                
                if ( $user && $user->user_status == 'active'){
                    $this->_create_session( get_object_vars( $user ) );

                    $redirect = $this->input->post('redirectTo');
                    if($redirect) {
                        redirect($redirect);
                    }
                    redirect();
                } else {
                    Message::add_error ( 'Debe esperar aprobaci&oacute;n de un administrador para poder usar el sistema.' );
                }
            } else {
                Message::add_error ( 'Usuario / Contrase&ntilde;a incorrectos.' );
            }
        } else {
        }
	}

	/** Cierre de sesion */
	public function logout(){
		$this->_destroy_session();
		redirect();
	}

	/** Recuperacion de contrasena */
	public function password_recovery(){
        $this->_load_data();

        $email = $this->input->get_post('recovery_email');

        if ( $this->input->get_post('submit-recovery') && valid_email($email) ) {
            $this->usuario_db->user_email = $email;
            $user = $this->usuario_db->get();

            if( $user ) {
                // generar hash
                $user->clear();
                $user->user_id = $this->usuario_db->user_id;
                $this->usuario_db->user_hash = $user->user_hash = md5( $user->user_id . time() );
                $user->user_expire_hash = date('Y-m-d H:i:s', time() + 3600*24);

                // Salvar en DB
                if( $user->save() ) {
                    // enviar correo
                    $this->load->library('email');

                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);

                    $this->email->from('no-reply@aldia.loc', 'Aldia');
                    $this->email->to( $this->usuario_db->user_email );
                    $this->email->subject('Recuperar Contraseña - Aldia');

                    $this->view_data['USER'] = $this->usuario_db;
                    // echo $this->load->view('emails/recovery-pass', $this->view_data, TRUE ); die;
                    $this->email->message( $this->load->view('emails/recovery-pass', $this->view_data, TRUE ) );

                    $this->email->send();
                }
            }

            Message::add_success('Se ha enviado un correo con las instrucciones para cambiar su contrase&ntilde;a');
            $this->login();
        } else {
            $this->view_data['HEADER_TITLE'] = 'Recuperar Contrase&ntilde;a';
            $this->load->view('recovery_password', $this->view_data);
        }
	}

	/// Procesa el formulario de recuperacion de contrasena
	public function recovery_form ( $user_id = 0, $hash = '' ){
        $this->load->library('form_validation');

        $this->view_data['HEADER_TITLE'] = 'Recuperar Contrase&ntilde;a';
		$this->view_data['REDIRECT_TO'] = $this->input->get_post('redirectTo');
		$this->view_data['USER_ID'] = $user_id;
		$this->view_data['HASH'] = $hash;

        //Verificar hash
        $this->usuario_db->user_id = $user_id;
        $this->usuario_db->user_hash = $hash;
        $user_expired_hash = 'user_expire_hash >';
        $this->usuario_db->$user_expired_hash = date('Y-m-d H:i:s');

		if ( ($user = $this->usuario_db->get()) ) {
            if ( $this->input->post('submit-recovery-pass') ) {
                // Procesamos el formulario de contrasenas

                $this->form_validation->set_rules('pass', 'Contrase&ntilde;a', 'required|xss_clean|min_length[5]|matches[pass2]');
                $this->form_validation->set_rules('pass2', 'Confirmar Contrase&ntilde;a', 'required');

                if ($this->form_validation->run() == TRUE) {
                    // Cambiamos la contrasena
                    $this->load->library('PasswordHash');
                    $wp_hasher = new PasswordHash();
                    $password_wp = $wp_hasher->HashPassword(set_value('pass'));

                    $user->clear();
                    $user->user_id = $this->usuario_db->user_id;
                    $user->user_pass = $password_wp;
                    $user->user_hash = '';
                    $user->user_expire_hash = date('Y-m-d H:i:s');
                    $user->save();

                    Message::add_success( 'Su contrase&ntilde;a fue actualizada.' );
                    echo $this->load->view('login', $this->view_data, TRUE);
                    return;
                }
            } else {
                Message::add_warning( 'Introduzca su nueva contrase&ntilde;a...' );
            }
		} else {
			// El hash ha expirado
			Message::add_error ('Este link ha expirado.');
            Message::add_warning( 'Introduzca sus datos de ingreso...' );
            $this->login();
			// echo $this->load->view('login', $this->view_data, TRUE);
            return;
		}

        echo $this->load->view('recovery_form', $this->view_data, TRUE);
	}

	/** Crea la sesion del usuario. */
	public function _create_session($user){
		$this->session->set_userdata('islogin', TRUE);
		$this->session->set_userdata('user', $user);
	}

	/** Elimina la sesion de un usuario */
	public function _destroy_session(){
		// $this->session->sess_destroy();
		$this->session->unset_userdata('islogin');
		$this->session->unset_userdata('user');
	}
}
