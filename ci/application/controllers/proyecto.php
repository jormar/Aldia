<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proyecto extends ALDIA_Controller {

	/**
	 * Controlador de sesiones.
	 * Gestiona lo que es el login, logout, y recuperaciones de contrasenas.
	 *
	 * Es el controlador por defecto.
	 */
	public function index() {
		$this->perfil();
	}

    public function nuevo($id = 0) {
        // $this->output->enable_profiler(TRUE);

        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        if ( !currentuser_can('crear_proy') ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_nuevo_proccess();

        $this->view_data['HEADER_TITLE'] = ' + Nuevo Proyecto';
        $this->load->view('proyecto_nuevo', $this->view_data);
    }

    private function _nuevo_proccess() {

        if( $this->input->post('submit-proy-nuevo') ){
            // Procesamos el formulario
            $this->form_validation->set_rules('proy_titulo', 'T&iacute;tulo', 'required|trim|max_length[126]');
            $this->form_validation->set_rules('proy_tipo', 'Tipo', 'required|callback__valid_proytipo');
			$this->form_validation->set_rules('proy_justificacion', 'Justificaci&oacute;n', 'required|min_length[40]');
			$this->form_validation->set_rules('proy_obj_gen', 'Objetivo General', 'required|min_length[40]');
			$this->form_validation->set_rules('proy_obj_esp', 'Objetivo Espec&iacute;fico', '');
			$this->form_validation->set_rules('proy_cobertura_geo', 'Cobertura Geogr&aacute;fica', '');
			$this->form_validation->set_rules('proy_benef', 'Beneficiarios', '');
			$this->form_validation->set_rules('proy_fam_benf_direc', 'Beneficiarios', 'numeric');
			$this->form_validation->set_rules('proy_fam_benf_indirec', 'Beneficiarios', 'numeric');
			$this->form_validation->set_rules('proy_resultado', 'Resultados esperados', '');
			$this->form_validation->set_rules('proy_impacto', 'Impacto esperado', '');
            $this->form_validation->set_rules('proy_fecha_culm', 'Impacto esperado', 'callback__valid_dateformat');

            if ($this->form_validation->run() == TRUE) {
                $current_user = user_get_data ();

                $this->proyecto_db->proy_titulo = set_value('proy_titulo');
                $this->proyecto_db->proy_tipo = set_value('proy_tipo');
                $this->proyecto_db->proy_justificacion = set_value('proy_justificacion');
                $this->proyecto_db->proy_obj_gen = set_value('proy_obj_gen');
                $this->proyecto_db->proy_obj_esp = set_value('proy_obj_esp');
                $this->proyecto_db->proy_cobertura_geo = set_value('proy_cobertura_geo');
                $this->proyecto_db->proy_benef = set_value('proy_benef');
                $this->proyecto_db->proy_fam_benf_direc = set_value('proy_fam_benf_direc');
                $this->proyecto_db->proy_fam_benf_indirec = set_value('proy_fam_benf_indirec');
                $this->proyecto_db->proy_resultado = set_value('proy_resultado');
                $this->proyecto_db->proy_impacto = set_value('proy_impacto');
                $this->proyecto_db->proy_fecha_culm = set_value('proy_fecha_culm');

                $this->proyecto_db->proy_fecha_mod = date('Y-m-d H:i:s');
                $this->proyecto_db->proy_com_id = $current_user->user_com_id;
                $this->proyecto_db->proy_fecha_creacion = date('Y-m-d');
                $this->proyecto_db->proy_status = 'disabled';
                $this->proyecto_db->proy_costo = 0;
                $this->proyecto_db->proy_fase_id = 1;
                $this->proyecto_db->proy_org_id = $current_user->user_org_id;

                if ( ($proyecto_id = $this->proyecto_db->save()) ) {
                    // Privilegios del usuario sobre el proyecto
                    $this->usuario_participa_db->proy_id = $proyecto_id;
                    $this->usuario_participa_db->user_id = $current_user->user_id;
                    $this->usuario_participa_db->rol = 'Creador';
                    $this->usuario_participa_db->grant_all();
                    // var_dump($this->usuario_participa_db); die;
                    $this->usuario_participa_db->insert();

                    $this->session->set_flashdata('SUCCESS_MSG', 'El proyecto fue creado con &eacute;xito.');
                    redirect( 'proyecto/datos/'.$proyecto_id );
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

    public function _valid_dateformat($str) {
        if ( empty($str) || preg_match ("/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/", $str)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('_valid_dateformat', 'El formato de la fecha no es el esperado!');
            return FALSE;
        }
    }
    
    public function _valid_proytipo($str) {
        if (in_array($str, array_keys( get_proy_tipos() ))) {
            return TRUE;
        } else {
            $this->form_validation->set_message('_valid_proytipo', 'El tipo de proyecto no es de los esperados!');
            return FALSE;
        }
    }

    public function datos($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);

        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();

        if ( !$proyecto || !currentuser_can('proy_modif_datos', $proyecto) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_datos_proccess($proyecto);

        $this->view_data['HEADER_TITLE'] = $proyecto->proy_titulo . ' - Datos';
        $this->view_data['PROYECTO'] = $proyecto;
        $this->load->view('proyecto_datos', $this->view_data);
    }

    private function _datos_proccess($proyecto) {
        if( $this->input->post('submit-proy-datos') ){
            // Procesamos el formulario
            $this->form_validation->set_rules('proy_titulo', 'T&iacute;tulo', 'required|trim|max_length[126]');
            $this->form_validation->set_rules('proy_tipo', 'Tipo', 'required|callback__valid_proytipo');
			$this->form_validation->set_rules('proy_justificacion', 'Justificaci&oacute;n', 'required|min_length[40]');
			$this->form_validation->set_rules('proy_obj_gen', 'Objetivo General', 'required|min_length[40]');
			$this->form_validation->set_rules('proy_obj_esp', 'Objetivo Espec&iacute;fico', '');
			$this->form_validation->set_rules('proy_cobertura_geo', 'Cobertura Geogr&aacute;fica', '');
			$this->form_validation->set_rules('proy_benef', 'Beneficiarios', '');
			$this->form_validation->set_rules('proy_fam_benf_direc', 'Beneficiarios', 'numeric');
			$this->form_validation->set_rules('proy_fam_benf_indirec', 'Beneficiarios', 'numeric');
			$this->form_validation->set_rules('proy_resultado', 'Resultados esperados', '');
			$this->form_validation->set_rules('proy_impacto', 'Impacto esperado', '');
            $this->form_validation->set_rules('proy_fecha_culm', 'Impacto esperado', 'callback__valid_dateformat');

            if ($this->form_validation->run() == TRUE) {
                $this->proyecto_db->clear();
                $this->proyecto_db->proy_id = $proyecto->proy_id;
                $this->proyecto_db->proy_titulo = set_value('proy_titulo');
                $this->proyecto_db->proy_tipo = set_value('proy_tipo');
                $this->proyecto_db->proy_justificacion = set_value('proy_justificacion');
                $this->proyecto_db->proy_obj_gen = set_value('proy_obj_gen');
                $this->proyecto_db->proy_obj_esp = set_value('proy_obj_esp');
                $this->proyecto_db->proy_cobertura_geo = set_value('proy_cobertura_geo');
                $this->proyecto_db->proy_benef = set_value('proy_benef');
                $this->proyecto_db->proy_fam_benf_direc = set_value('proy_fam_benf_direc');
                $this->proyecto_db->proy_fam_benf_indirec = set_value('proy_fam_benf_indirec');
                $this->proyecto_db->proy_resultado = set_value('proy_resultado');
                $this->proyecto_db->proy_impacto = set_value('proy_impacto');
                $this->proyecto_db->proy_fecha_culm = set_value('proy_fecha_culm');

                // $this->proyecto_db->proy_fecha_mod = date('Y-m-d H:i:s');

                if ( $this->proyecto_db->save() ) {
                    $this->session->set_flashdata('SUCCESS_MSG', 'Los datos fueron actualizados.');
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

    public function ver($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);

        $this->_must_authenticate_first();

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();

        if ( !$proyecto || !currentuser_can('proy_ver_datos', $proyecto) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->usuario_participa_db->clear();
        $this->usuario_participa_db->proy_id = $proyecto->proy_id;
        $this->db->join(Usuario_db::tableName(),
                Usuario_participa_db::tableName().'.user_id='.Usuario_db::tableName().'.user_id', 'left');
        $this->view_data['USUARIOS'] = $this->usuario_participa_db->get_array();

        $this->view_data['HEADER_TITLE'] = $proyecto->proy_titulo . ' - Datos';
        $this->view_data['PROYECTO'] = $proyecto;
        $this->load->view('proyecto_ver_datos', $this->view_data);
    }

    public function activar($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( $proyecto && currentuser_can('proy_modif_datos', $proyecto) ) {
            $this->proyecto_db->clear();
            $this->proyecto_db->proy_id = $proyecto_id;
            $this->proyecto_db->proy_status = 'active';

            if ( $this->proyecto_db->save() ) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'Los cambios fueron realizados.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect( 'usuario' );
    }

    public function desactivar($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( $proyecto && currentuser_can('proy_modif_datos', $proyecto) ) {
            $this->proyecto_db->clear();
            $this->proyecto_db->proy_id = $proyecto_id;
            $this->proyecto_db->proy_status = 'disabled';

            if ( $this->proyecto_db->save() ) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'Los cambios fueron realizados.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect( 'usuario' );
    }

    public function borrar($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( $proyecto && currentuser_can('borrar_proy', $proyecto) ) {
            $this->proyecto_db->clear();
            $this->proyecto_db->proy_id = $proyecto_id;
            $this->proyecto_db->proy_status = 'deleted';

            if ( $this->proyecto_db->save() ) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'El proyecto fue eliminado del sistema.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect( 'usuario' );
    }

    /* * * * * * * * * * * * ACTIVIDADES * * * * * * * * * * * */
    public function actividades($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->clear();
        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !($proyecto && currentuser_can('proy_modif_activ', $proyecto)) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }
        
        $this->actividad_db->act_proy_id = $proyecto->proy_id;
        $actividades = $this->actividad_db->get_array();
        
        $this->view_data['HEADER_TITLE'] = $proyecto->proy_titulo . ' - Actividades';
        $this->view_data['PROYECTO'] = $proyecto;
        $this->view_data['ACTIVIDADES'] = $actividades;
        $this->load->view('proyecto_actividades', $this->view_data);
    }

    public function crear_actividad($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !currentuser_can('proy_modif_activ', $proyecto) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_crear_actividad_proccess($proyecto);

        // No tiene vista en particular...
        $this->actividades($proyecto_id);
    }

    private function _crear_actividad_proccess($proyecto) {

        if( $this->input->post('submit-act-crear') ){
            // Procesamos el formulario
            $this->form_validation->set_rules('act_desc', 'Descripci&oacute;n', 'required|trim');
            $this->form_validation->set_rules('act_responsables', 'Responsables', 'required|trim');
			$this->form_validation->set_rules('act_inicio', 'Fecha de Inicio', 'callback__valid_dateformat');
			$this->form_validation->set_rules('act_fin', 'Fecha de finalizaci&oacute;n', 'callback__valid_dateformat');

            if ($this->form_validation->run() == TRUE) {
                $this->actividad_db->act_proy_id = $proyecto->proy_id;
                $this->actividad_db->act_desc = set_value('act_desc');
                $this->actividad_db->act_responsables = set_value('act_responsables');
                if (set_value('act_inicio')) $this->actividad_db->act_inicio = set_value('act_inicio');
                if (set_value('act_fin')) $this->actividad_db->act_fin = set_value('act_fin');
                $this->actividad_db->act_status = 'none';

                if ( ($actividad_id = $this->actividad_db->save()) ) {
                    $this->session->set_flashdata('SUCCESS_MSG', 'La actividad fue creada con &eacute;xito.');
                    redirect( 'proyecto/actividades/'.$proyecto->proy_id );
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

    public function editar_actividad($proyecto_id=0, $actividad_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !currentuser_can('proy_modif_activ', $proyecto) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_editar_actividad_proccess($proyecto, $actividad_id);

        // No tiene vista en particular...
        $this->actividades($proyecto_id);
    }
    
    private function _editar_actividad_proccess($proyecto, $actividad_id) {

        if( $this->input->post('submit-act-editar') ){
            // Procesamos el formulario
            $this->form_validation->set_rules('act_desc', 'Descripci&oacute;n', 'required|trim');
            $this->form_validation->set_rules('act_responsables', 'Responsables', 'required|trim');
			$this->form_validation->set_rules('act_inicio', 'Fecha de Inicio', 'callback__valid_dateformat');
			$this->form_validation->set_rules('act_fin', 'Fecha de finalizaci&oacute;n', 'callback__valid_dateformat');

            if ($this->form_validation->run() == TRUE) {
                $this->actividad_db->clear();
                $this->actividad_db->act_id = $actividad_id;
                // $this->actividad_db->act_proy_id = $proyecto->proy_id;
                $this->actividad_db->act_desc = set_value('act_desc');
                $this->actividad_db->act_responsables = set_value('act_responsables');
                if (set_value('act_inicio')) $this->actividad_db->act_inicio = set_value('act_inicio');
                if (set_value('act_fin')) $this->actividad_db->act_fin = set_value('act_fin');
                // $this->actividad_db->act_status = 'none';

                if ( ($actividad_id = $this->actividad_db->save()) ) {
                    $this->session->set_flashdata('SUCCESS_MSG', 'La actividad fue Actualizada con &eacute;xito.');
                    redirect( 'proyecto/actividades/'.$proyecto->proy_id );
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

    public function eliminar_actividad($proyecto_id=0, $actividad_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !currentuser_can('proy_modif_activ', $proyecto) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->actividad_db->clear();
        $this->actividad_db->act_id = $actividad_id;
        if ( $this->actividad_db->delete() ) {
            // actualizado
            $this->session->set_flashdata('SUCCESS_MSG', 'Se elimino la actividad.');
        } else {
            $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
        }
        redirect('proyecto/actividades/'.$proyecto_id);
    }

    /* * * * * * * * * * * * INVERSION * * * * * * * * * * * */
    public function inversion($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->clear();
        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !($proyecto && currentuser_can('proy_modif_inver', $proyecto)) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }
        
        $this->inversion_db->inv_proy_id = $proyecto->proy_id;
        $inversiones = $this->inversion_db->get_array();
        
        $this->view_data['HEADER_TITLE'] = $proyecto->proy_titulo . ' - Inversi&oacute;n';
        $this->view_data['PROYECTO'] = $proyecto;
        $this->view_data['INVERSIONES'] = $inversiones;
        $this->load->view('proyecto_inversiones', $this->view_data);
    }

    public function crear_inversion($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !currentuser_can('proy_modif_inver', $proyecto) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_crear_inversion_proccess($proyecto);

        // No tiene vista en particular...
        $this->inversion($proyecto_id);
    }

    private function _crear_inversion_proccess($proyecto) {

        if( $this->input->post('submit-inv-crear') ){
            // Procesamos el formulario
            $this->form_validation->set_rules('inv_rubro', 'Rubro', 'required|trim');
            $this->form_validation->set_rules('inv_unidad', 'Unidad', 'required|trim');
			$this->form_validation->set_rules('inv_precio', 'Precio', 'required|trim|numeric');
			$this->form_validation->set_rules('inv_cantidad', 'Cantidad', 'required|trim|numeric');
            $this->form_validation->set_rules('inv_status', 'Status', '');
            $this->form_validation->set_rules('inv_inversionista', 'Inversionista', 'trim|max_length[126]');

            if ($this->form_validation->run() == TRUE) {
                $this->inversion_db->clear();
                $this->inversion_db->inv_proy_id = $proyecto->proy_id;
                $this->inversion_db->inv_rubro = set_value('inv_rubro');
                $this->inversion_db->inv_unidad = set_value('inv_unidad');
                $this->inversion_db->inv_precio = set_value('inv_precio');
                $this->inversion_db->inv_cantidad = set_value('inv_cantidad');
                $this->inversion_db->inv_inversionista = set_value('inv_inversionista');
                
                if ( set_value('inv_status') ){
                    $this->inversion_db->inv_status = 'cancelado';
                    $this->inversion_db->inv_fecha_aprob = date('Y-m-d');
                } else {
                    $this->inversion_db->inv_status = 'pendiente';
                }

                if ( ($inversion_id = $this->inversion_db->save()) ) {
                    $this->session->set_flashdata('SUCCESS_MSG', 'El rubro fue creado con &eacute;xito.');
                    redirect( 'proyecto/inversion/'.$proyecto->proy_id );
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

    public function editar_inversion($proyecto_id = 0, $inversion_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !currentuser_can('proy_modif_inver', $proyecto) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_editar_inversion_proccess($proyecto, $inversion_id);

        // No tiene vista en particular...
        $this->inversion($proyecto_id);
    }

    private function _editar_inversion_proccess($proyecto, $inversion_id) {

        if( $this->input->post('submit-inv-editar') ){
            // Procesamos el formulario
            $this->form_validation->set_rules('inv_rubro', 'Rubro', 'required|trim');
            $this->form_validation->set_rules('inv_unidad', 'Unidad', 'required|trim');
			$this->form_validation->set_rules('inv_precio', 'Precio', 'required|trim|numeric');
			$this->form_validation->set_rules('inv_cantidad', 'Cantidad', 'required|trim|numeric');
            $this->form_validation->set_rules('inv_status', 'Status', '');
            $this->form_validation->set_rules('inv_inversionista', 'Inversionista', 'trim|max_length[126]');

            if ($this->form_validation->run() == TRUE) {
                $this->inversion_db->clear();
                $this->inversion_db->inv_id = $inversion_id;
                // $this->inversion_db->inv_proy_id = $proyecto->proy_id;
                $this->inversion_db->inv_rubro = set_value('inv_rubro');
                $this->inversion_db->inv_unidad = set_value('inv_unidad');
                $this->inversion_db->inv_precio = set_value('inv_precio');
                $this->inversion_db->inv_cantidad = set_value('inv_cantidad');
                $this->inversion_db->inv_inversionista = set_value('inv_inversionista');
                
                if ( set_value('inv_status') ){
                    $this->inversion_db->inv_status = 'cancelado';
                    $this->inversion_db->inv_fecha_aprob = date('Y-m-d');
                } else {
                    $this->inversion_db->inv_status = 'pendiente';
                }

                if ( ($inversion_id = $this->inversion_db->save()) ) {
                    $this->session->set_flashdata('SUCCESS_MSG', 'El rubro fue actualizado con &eacute;xito.');
                    redirect( 'proyecto/inversion/'.$proyecto->proy_id );
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
    
    public function eliminar_inversion($proyecto_id=0, $inversion_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !currentuser_can('proy_modif_inver', $proyecto) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->inversion_db->clear();
        $this->inversion_db->inv_id = $inversion_id;
        if ( $this->inversion_db->delete() ) {
            // actualizado
            $this->session->set_flashdata('SUCCESS_MSG', 'Se elimino el rubro.');
        } else {
            $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
        }
        redirect('proyecto/inversion/'.$proyecto_id);
    }

    /* * * * * * * * * * * * REPRESENTANTES * * * * * * * * * * * */
    public function representantes($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->clear();
        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !($proyecto && currentuser_can('proy_modif_repre', $proyecto)) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }
        
        $this->usuario_participa_db->clear();
        $this->usuario_participa_db->proy_id = $proyecto_id;
        $this->db->join(Usuario_db::tableName(),
                Usuario_participa_db::tableName().'.user_id='.Usuario_db::tableName().'.user_id', 'left');
        $representantes = $this->usuario_participa_db->get_array();

        $representantes_ids = array();
        foreach($representantes as $value){
            $representantes_ids[] = $value->user_id;
        }

        // Representantes validos para agregar
        $current_user = user_get_data ();
        $this->usuario_db->clear();
        $this->usuario_db->user_org_id = $current_user->user_org_id;
        $_para_representar = $this->usuario_db->get_array();

        $para_representar = array();
        foreach($_para_representar as $value){
            if( !in_array($value->user_id, $representantes_ids) ){
                $para_representar[] = $value;
            }
        }

        $this->view_data['HEADER_TITLE'] = $proyecto->proy_titulo . ' - Representantes';
        $this->view_data['PROYECTO'] = $proyecto;
        $this->view_data['REPRESENTANTES'] = $representantes;
        $this->view_data['PARA_REPRESENTANTES'] = $para_representar;
        $this->load->view('proyecto_representantes', $this->view_data);
    }
    
    public function crear_representante($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !currentuser_can('proy_modif_repre', $proyecto) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_crear_representante_proccess($proyecto);

        // No tiene vista en particular...
        $this->representantes($proyecto_id);
    }

    private function _crear_representante_proccess($proyecto) {

        if( $this->input->post('submit-repre-crear') ){
            // Procesamos el formulario
            $this->form_validation->set_rules('user_id', 'Usuario', 'required');
            $this->form_validation->set_rules('rol', 'Rol', 'required');
			$this->form_validation->set_rules('p_modif_datos', 'Datos', '');
			$this->form_validation->set_rules('p_modif_repre', 'Representante', '');
            $this->form_validation->set_rules('p_modif_activ', 'Actividades', '');
            $this->form_validation->set_rules('p_modif_histo', 'Historial', '');
            $this->form_validation->set_rules('p_modif_inver', 'Inversi&oacute;n', '');
            $this->form_validation->set_rules('p_export', 'Exportar', '');

            if ($this->form_validation->run() == TRUE) {
                $this->usuario_participa_db->clear();
                $this->usuario_participa_db->proy_id = $proyecto->proy_id;
                $this->usuario_participa_db->user_id = set_value('user_id');
                $this->usuario_participa_db->rol = set_value('rol');

                $this->usuario_participa_db->p_modif_datos = (set_value('p_modif_datos'))?1:0;
                $this->usuario_participa_db->p_modif_repre = (set_value('p_modif_repre'))?1:0;
                $this->usuario_participa_db->p_modif_activ = (set_value('p_modif_activ'))?1:0;
                $this->usuario_participa_db->p_modif_histo = (set_value('p_modif_histo'))?1:0;
                $this->usuario_participa_db->p_modif_inver = (set_value('p_modif_inver'))?1:0;
                $this->usuario_participa_db->p_export = (set_value('p_export'))?1:0;

                $inversion_id = $this->usuario_participa_db->insert();
                if( $this->db->_error_message() ) {
                    Message::add_error( 'No fue posible procesar su solicitud. Por favor, Int&eacute;ntelo m&aacute;s tarde.' );
                } else {
                    $this->session->set_flashdata('SUCCESS_MSG', 'El usuario fue agregado al proyecto con &eacute;xito.');
                    redirect( 'proyecto/representantes/'.$proyecto->proy_id );
                    exit();
                }

            } else {

            }
        }
    }

    public function editar_representante($proyecto_id = 0, $representante_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !currentuser_can('proy_modif_repre', $proyecto) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_editar_representante_proccess($proyecto, $representante_id);

        // No tiene vista en particular...
        $this->representantes($proyecto_id);
    }

    private function _editar_representante_proccess($proyecto, $representante_id) {

        if( $this->input->post('submit-repre-editar') ){
            // Procesamos el formulario
            $this->form_validation->set_rules('user_id', 'Usuario', 'required');
            $this->form_validation->set_rules('rol', 'Rol', 'required');
			$this->form_validation->set_rules('p_modif_datos', 'Datos', '');
			$this->form_validation->set_rules('p_modif_repre', 'Representante', '');
            $this->form_validation->set_rules('p_modif_activ', 'Actividades', '');
            $this->form_validation->set_rules('p_modif_histo', 'Historial', '');
            $this->form_validation->set_rules('p_modif_inver', 'Inversi&oacute;n', '');
            $this->form_validation->set_rules('p_export', 'Exportar', '');

            if ($this->form_validation->run() == TRUE) {
                $this->usuario_participa_db->clear();
                $this->usuario_participa_db->proy_id = $proyecto->proy_id;
                $this->usuario_participa_db->user_id = $representante_id;
                $this->usuario_participa_db->rol = set_value('rol');

                $this->usuario_participa_db->p_modif_datos = (set_value('p_modif_datos'))?1:0;
                $this->usuario_participa_db->p_modif_repre = (set_value('p_modif_repre'))?1:0;
                $this->usuario_participa_db->p_modif_activ = (set_value('p_modif_activ'))?1:0;
                $this->usuario_participa_db->p_modif_histo = (set_value('p_modif_histo'))?1:0;
                $this->usuario_participa_db->p_modif_inver = (set_value('p_modif_inver'))?1:0;
                $this->usuario_participa_db->p_export = (set_value('p_export'))?1:0;

                $this->usuario_participa_db->update();
                if( $this->db->_error_message() ) {
                    Message::add_error( 'No fue posible procesar su solicitud. Por favor, Int&eacute;ntelo m&aacute;s tarde.' );
                } else {
                    $this->session->set_flashdata('SUCCESS_MSG', 'El usuario fue actualizado con &eacute;xito.');
                    redirect( 'proyecto/representantes/'.$proyecto->proy_id );
                    exit();
                }

            } else {

            }
        }
    }

    public function eliminar_representante ($proyecto_id=0, $representante_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !currentuser_can('proy_modif_inver', $proyecto) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        if ( $this->_valid_del_repre( $representante_id ) ) {
            $this->usuario_participa_db->clear();
            $this->usuario_participa_db->user_id = $representante_id;
            $this->usuario_participa_db->proy_id = $proyecto_id;
            if ( $this->usuario_participa_db->delete() ) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'Se saco al representante del proyecto.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        } else {
            $this->session->set_flashdata('ERROR_MSG', 'Usted no puede sacar a este usuario');
        }

        redirect('proyecto/representantes/'.$proyecto_id);
    }

    public function _valid_del_repre($user_id) {
        $current_user = user_get_data ();
        $org_levels = get_org_rol_levels();

        $this->usuario_db->clear();
        $this->usuario_db->user_id = $user_id;
        $user = $this->usuario_db->get();

        $org_levels[$current_user->user_org_rol] <= $org_levels[$user->user_org_rol];
        
        if ($current_user->user_id == $user->user_id ) {
            // No te puedes sacar a ti mismo
            return FALSE;

        } elseif ( $user && $org_levels[$current_user->user_org_rol] <= $org_levels[$user->user_org_rol] ) {
            // Necesitas tener tantos, o mas, privilegios en la organizacion para sacarlo
            return TRUE;

        } else {
            return FALSE;
        }
    }

    public function export_to_pdf ($proyecto_id=0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ( !currentuser_can('proy_export_pdf', $proyecto) ) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }
        // $this->load->helper(array('dompdf', 'file'));
        $this->load->helper(array('tcpdf', 'file'));

        $mes_espanol = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $USER_NAME = $user['user_firstname'].' '.$user['user_lastname'];
        $CI = $user['user_ci'];
        $m = $mes_espanol[(int)date ( 'm', strtotime( $user['user_registered'] ) )-1];
        $FECHA_AFILICACION = $m.' '.date ( 'Y', strtotime( $user['user_registered'] ) );
        $CONTRATO = sprintf('%012d', $user['novared_id']);

        /**
         * Pienso usar estas variables para trasladar facilmente todos los objetos
         * que se incluyen en el PDF
         */
        $_x_offset = 12;
        $_y_offset = -40;

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator('Arquidib');
        $pdf->SetAuthor('Arquidib');
        $pdf->SetTitle('Tarjeta fidelidad');
        $pdf->SetSubject('Tarjeta fidelidad');
        // $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // set font
        $pdf->SetFont('helvetica', '', 12);

        $pdf->AddPage();

        $pdf->Image(APPPATH.'views/'.SYSTEM_DEFAULT_THEME.'/tarjetas/tarjeta_plus2.jpg', 15+$_x_offset, 140+$_y_offset, 150, 0, 'JPG', '', false, 300);

        $fontsize = $pdf->getFontSize();
        $pdf->SetFontSize(9);

        //                  w,  h,  x,  y
        $pdf->writeHTMLCell(32, 10, $_x_offset+18.5, $_y_offset+162, $USER_NAME /*, 1 */ );
        $pdf->writeHTMLCell(32, 10, $_x_offset+18.5, $_y_offset+175, $CI /* , 1 */ );
        $pdf->writeHTMLCell(32, 10, $_x_offset+51  , $_y_offset+162, $FECHA_AFILICACION /* , 1 */ );

        // $pdf->Text(51, 161, "Mi texto\nfsdf", $fstroke=false, $fclip=false, $ffill=true, $border=1, $ln=0, $align='', $fill=false, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M', $rtloff=false);
        // $pdf->Ln();

        // EAN 13
        // define barcode style
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => false,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 7,
            'stretchtext' => 4
        );
        $pdf->write1DBarcode($CONTRATO, 'EAN13', $_x_offset+48, $_y_offset+168, 40, 13, 0.4, $style, 'N');

        $pdf->SetFontSize($fontsize);
        
        if( !$file ){
            $fp = fopen( SYSTEM_CACHE_TARJETAS_FIDELIDAD . $user['novared_id'] . '.pdf', 'w');
        } else {
            $fp = fopen( $file, 'w');
        }
        fwrite($fp, $pdf->Output('', 'S') );
        fclose($fp);
    }
}
