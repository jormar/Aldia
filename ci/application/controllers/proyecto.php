<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Proyecto extends ALDIA_Controller {

    /**
     * Controlador de sesiones.
     * Gestiona lo que es el login, logout, y recuperaciones de contrasenas.
     *
     * Es el controlador por defecto.
     */
    private $_nombreControlador;

    public function __construct() {
        parent::__construct();

        //crear el nombre del controlador
        //es algo genérico para usarlo en cualquier momento
        $this->_nombreControlador = __CLASS__;
        $this->_nombreControlador = strtolower($this->_nombreControlador);

        //cargar el helper url
        $this->load->helper('url');
        $this->_directorioprincipal = "/ci/";
        $this->_directoriosubidaarchivos = "{$_SERVER['DOCUMENT_ROOT']}{$this->_directorioprincipal}uploads/";
    }

    public function index() {
        $this->perfil();
    }

    public function nuevo($id = 0) {
        // $this->output->enable_profiler(TRUE);

        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        if (!currentuser_can('crear_proy')) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_nuevo_proccess();

        $this->view_data['HEADER_TITLE'] = ' + Nuevo Proyecto';
        $this->load->view('proyecto_nuevo', $this->view_data);
    }

    private function _nuevo_proccess() {

        if ($this->input->post('submit-proy-nuevo')) {
            // Procesamos el formulario
            $this->form_validation->set_rules('proy_titulo', 'T&iacute;tulo', 'required|trim|max_length[126]');
            $this->form_validation->set_rules('proy_tipo', 'Tipo', 'required|callback__valid_proytipo');
            $this->form_validation->set_rules('proy_justificacion', 'Justificaci&oacute;n', 'required|min_length[40]');
            $this->form_validation->set_rules('proy_obj_gen', 'Objetivo General', 'required|min_length[40]');
            $this->form_validation->set_rules('proy_obj_esp', 'Objetivo Espec&iacute;fico', '');
            $this->form_validation->set_rules('proy_cobertura_geo', 'Cobertura Geogr&aacute;fica', '');
            $this->form_validation->set_rules('proy_benef', 'Beneficiarios', '');
            $this->form_validation->set_rules('proy_hom_jov_benf_direc', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_hom_adult_benf_direc', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_hom_ter_benf_direc', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_muj_jov_benf_direc', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_muj_adult_benf_direc', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_muj_ter_benf_direc', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_hom_jov_benf_indirec', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_hom_adult_benf_indirec', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_hom_ter_benf_indirec', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_muj_jov_benf_indirec', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_muj_adult_benf_indirec', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_muj_ter_benf_indirec', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_map_zoom', 'Mapa', 'numeric|required');
            $this->form_validation->set_rules('proy_map_lat', 'en el mapa', 'numeric|required');
            $this->form_validation->set_rules('proy_map_long', 'en el mapa', 'numeric|required');

            $this->form_validation->set_rules('proy_resultado', 'Resultados esperados', '');
            $this->form_validation->set_rules('proy_impacto', 'Impacto esperado', '');
            $this->form_validation->set_rules('proy_fecha_culm', 'Impacto esperado', 'callback__valid_dateformat');

            if ($this->form_validation->run() == TRUE) {
                $current_user = user_get_data();

                $this->proyecto_db->proy_titulo = set_value('proy_titulo');
                $this->proyecto_db->proy_tipo = set_value('proy_tipo');
                $this->proyecto_db->proy_justificacion = set_value('proy_justificacion');
                $this->proyecto_db->proy_obj_gen = set_value('proy_obj_gen');
                $this->proyecto_db->proy_obj_esp = set_value('proy_obj_esp');
                $this->proyecto_db->proy_cobertura_geo = set_value('proy_cobertura_geo');
                $this->proyecto_db->proy_benef = set_value('proy_benef');
                $this->proyecto_db->proy_hom_jov_benf_direc = set_value('proy_hom_jov_benf_direc');
                $this->proyecto_db->proy_hom_adult_benf_direc = set_value('proy_hom_adult_benf_direc');
                $this->proyecto_db->proy_hom_ter_benf_direc = set_value('proy_hom_ter_benf_direc');
                $this->proyecto_db->proy_muj_jov_benf_direc = set_value('proy_muj_jov_benf_direc');
                $this->proyecto_db->proy_muj_adult_benf_direc = set_value('proy_muj_adult_benf_direc');
                $this->proyecto_db->proy_muj_ter_benf_direc = set_value('proy_muj_ter_benf_direc');
                $this->proyecto_db->proy_hom_jov_benf_indirec = set_value('proy_hom_jov_benf_indirec');
                $this->proyecto_db->proy_hom_adult_benf_indirec = set_value('proy_hom_adult_benf_indirec');
                $this->proyecto_db->proy_hom_ter_benf_indirec = set_value('proy_hom_ter_benf_indirec');
                $this->proyecto_db->proy_muj_jov_benf_indirec = set_value('proy_muj_jov_benf_indirec');
                $this->proyecto_db->proy_muj_adult_benf_indirec = set_value('proy_muj_adult_benf_indirec');
                $this->proyecto_db->proy_muj_ter_benf_indirec = set_value('proy_muj_ter_benf_indirec');
                $this->proyecto_db->proy_resultado = set_value('proy_resultado');
                $this->proyecto_db->proy_impacto = set_value('proy_impacto');
                $this->proyecto_db->proy_fecha_culm = set_value('proy_fecha_culm');
                $this->proyecto_db->proy_map_zoom = set_value('proy_map_zoom');
                $this->proyecto_db->proy_map_lat = set_value('proy_map_lat');
                $this->proyecto_db->proy_map_long = set_value('proy_map_long');

                $this->proyecto_db->proy_fecha_mod = date('Y-m-d H:i:s');
                $this->proyecto_db->proy_com_id = $current_user->user_com_id;
                $this->proyecto_db->proy_fecha_creacion = date('Y-m-d');
                $this->proyecto_db->proy_status = 'disabled';
                $this->proyecto_db->proy_costo = 0;
                $this->proyecto_db->proy_fase_id = 1;
                $this->proyecto_db->proy_org_id = $current_user->user_org_id;

                if (($proyecto_id = $this->proyecto_db->save())) {
                    // Privilegios del usuario sobre el proyecto
                    $this->usuario_participa_db->proy_id = $proyecto_id;
                    $this->usuario_participa_db->user_id = $current_user->user_id;
                    $this->usuario_participa_db->rol = 'Creador';
                    $this->usuario_participa_db->grant_all();
                    // var_dump($this->usuario_participa_db); die;
                    $this->usuario_participa_db->insert();

                    $this->session->set_flashdata('SUCCESS_MSG', 'El proyecto fue creado con &eacute;xito.');
                    redirect('proyecto/datos/' . $proyecto_id);
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
    }

    public function _valid_dateformat($str) {
        if (empty($str) || preg_match("/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})$/", $str)) {
            return TRUE;
        } else {
            $this->form_validation->set_message('_valid_dateformat', 'El formato de la fecha no es el esperado!');
            return FALSE;
        }
    }

    public function _valid_proytipo($str) {
        if (in_array($str, array_keys(get_proy_tipos()))) {
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

        if (!$proyecto || !currentuser_can('proy_modif_datos', $proyecto)) {
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
        if ($this->input->post('submit-proy-datos')) {
            // Procesamos el formulario
            $this->form_validation->set_rules('proy_titulo', 'T&iacute;tulo', 'required|trim|max_length[126]');
            $this->form_validation->set_rules('proy_tipo', 'Tipo', 'required|callback__valid_proytipo');
            $this->form_validation->set_rules('proy_justificacion', 'Justificaci&oacute;n', 'required|min_length[40]');
            $this->form_validation->set_rules('proy_obj_gen', 'Objetivo General', 'required|min_length[40]');
            $this->form_validation->set_rules('proy_obj_esp', 'Objetivo Espec&iacute;fico', '');
            $this->form_validation->set_rules('proy_cobertura_geo', 'Cobertura Geogr&aacute;fica', '');
            $this->form_validation->set_rules('proy_benef', 'Beneficiarios', '');
            $this->form_validation->set_rules('proy_hom_jov_benf_direc', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_hom_adult_benf_direc', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_hom_ter_benf_direc', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_muj_jov_benf_direc', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_muj_adult_benf_direc', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_muj_ter_benf_direc', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_hom_jov_benf_indirec', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_hom_adult_benf_indirec', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_hom_ter_benf_indirec', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_muj_jov_benf_indirec', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_muj_adult_benf_indirec', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_muj_ter_benf_indirec', 'Beneficiarios', 'numeric');
            $this->form_validation->set_rules('proy_resultado', 'Resultados esperados', '');
            $this->form_validation->set_rules('proy_impacto', 'Impacto esperado', '');
            $this->form_validation->set_rules('proy_fecha_culm', 'Impacto esperado', 'callback__valid_dateformat');
            $this->form_validation->set_rules('proy_map_zoom', 'Mapa', 'numeric|required');
            $this->form_validation->set_rules('proy_map_lat', 'en el mapa', 'numeric|required');
            $this->form_validation->set_rules('proy_map_long', 'en el mapa', 'numeric|required');

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
                $this->proyecto_db->proy_hom_jov_benf_direc = set_value('proy_hom_jov_benf_direc');
                $this->proyecto_db->proy_hom_adult_benf_direc = set_value('proy_hom_adult_benf_direc');
                $this->proyecto_db->proy_hom_ter_benf_direc = set_value('proy_hom_ter_benf_direc');
                $this->proyecto_db->proy_muj_jov_benf_direc = set_value('proy_muj_jov_benf_direc');
                $this->proyecto_db->proy_muj_adult_benf_direc = set_value('proy_muj_adult_benf_direc');
                $this->proyecto_db->proy_muj_ter_benf_direc = set_value('proy_muj_ter_benf_direc');
                $this->proyecto_db->proy_hom_jov_benf_indirec = set_value('proy_hom_jov_benf_indirec');
                $this->proyecto_db->proy_hom_adult_benf_indirec = set_value('proy_hom_adult_benf_indirec');
                $this->proyecto_db->proy_hom_ter_benf_indirec = set_value('proy_hom_ter_benf_indirec');
                $this->proyecto_db->proy_muj_jov_benf_indirec = set_value('proy_muj_jov_benf_indirec');
                $this->proyecto_db->proy_muj_adult_benf_indirec = set_value('proy_muj_adult_benf_indirec');
                $this->proyecto_db->proy_muj_ter_benf_indirec = set_value('proy_muj_ter_benf_indirec');
                $this->proyecto_db->proy_resultado = set_value('proy_resultado');
                $this->proyecto_db->proy_impacto = set_value('proy_impacto');
                $this->proyecto_db->proy_fecha_culm = set_value('proy_fecha_culm');
                $this->proyecto_db->proy_map_zoom = set_value('proy_map_zoom');
                $this->proyecto_db->proy_map_lat = set_value('proy_map_lat');
                $this->proyecto_db->proy_map_long = set_value('proy_map_long');


                // $this->proyecto_db->proy_fecha_mod = date('Y-m-d H:i:s');

                if ($this->proyecto_db->save()) {
                    $this->session->set_flashdata('SUCCESS_MSG', 'Los datos fueron actualizados.');
                    redirect(current_url());
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
    }

    public function ver($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);

        $this->_must_authenticate_first();

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();

        if (!$proyecto || !currentuser_can('proy_ver_datos', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->usuario_participa_db->clear();
        $this->usuario_participa_db->proy_id = $proyecto->proy_id;
        $this->db->join(Usuario_db::tableName(), Usuario_participa_db::tableName() . '.user_id=' . Usuario_db::tableName() . '.user_id', 'left');
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
        if ($proyecto && currentuser_can('proy_modif_datos', $proyecto)) {
            $this->proyecto_db->clear();
            $this->proyecto_db->proy_id = $proyecto_id;
            $this->proyecto_db->proy_status = 'active';

            if ($this->proyecto_db->save()) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'Los cambios fueron realizados.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect('usuario');
    }

    public function desactivar($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ($proyecto && currentuser_can('proy_modif_datos', $proyecto)) {
            $this->proyecto_db->clear();
            $this->proyecto_db->proy_id = $proyecto_id;
            $this->proyecto_db->proy_status = 'disabled';

            if ($this->proyecto_db->save()) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'Los cambios fueron realizados.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect('usuario');
    }

    public function borrar($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if ($proyecto && currentuser_can('borrar_proy', $proyecto)) {
            $this->proyecto_db->clear();
            $this->proyecto_db->proy_id = $proyecto_id;
            $this->proyecto_db->proy_status = 'deleted';

            if ($this->proyecto_db->save()) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'El proyecto fue eliminado del sistema.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        }
        redirect('usuario');
    }

	 /*     * * * * * * * * * * * MAPAS * * * * * * * * * * * */
	public function mapas($actividad_id =0){
		
		 $this->_must_authenticate_first();
		 $this->load->model('map_db');
		 $this->load->library('form_validation');
		 $this->map_db->clear();
		 $this->map_db->map_act_id = $actividad_id;
		 $mapa = $this->map_db->get();
		 $this->actividad_db->clear();
		 $this->actividad_db->act_id = $actividad_id;
		 $actividad = $this->actividad_db->get();
		 $this->view_data['actividad'] = $actividad;
		 $this->view_data['mapa']      = $mapa;
		 $this->load->view('proyecto_mapas',$this->view_data);
		}

	public function editar_mapa($actividad_id = 0){
		
		$this->_must_authenticate_first();
		$this->load->library('form_validation');
		$this->load->model('map_db');
        if ($this->input->post('submit-map-editar')) {
            // Procesamos el formulario

            $this->form_validation->set_rules('map_lat', 'Latitud', 'required|trim');
            $this->form_validation->set_rules('map_lang', 'Longitud', 'required|trim');
            $this->form_validation->set_rules('map_desc', 'Descripción', 'required|trim');
		
			 if ($this->form_validation->run() == TRUE) {
				$this->map_db->clear();
                $this->map_db->map_act_id = $actividad_id;
				$this->map_db->map_lat  = set_value('map_lat');
				$this->map_db->map_lang = set_value('map_lang');
                if (set_value('map_desc'))
                     $this->map_db->map_desc = set_value('map_desc');
               
                if (($map_id = $this->map_db->save())) {
                    $this->session->set_flashdata('SUCCESS_MSG', 'El mapa fue editado con éxito.');
					$this->map_db->clear();
					$this->map_db->map_act_id = $actividad_id;
					$this->map_db->get();
                    redirect('proyecto/actividades/'.$this->map_db->map_proy_id);
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
	}	

    /*     * * * * * * * * * * * ACTIVIDADES * * * * * * * * * * * */

    public function actividades($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
	//	$this->load->helper('json');
        $this->_must_authenticate_first();
        $this->load->library('form_validation');
		$this->load->model('map_db');
        $this->proyecto_db->clear();
        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
		if (!($proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'Esta mal la cosa'.$proyecto_id);
            redirect();
            exit();
        }


        if (!($proyecto && currentuser_can('proy_modif_activ', $proyecto))) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n'.$proyecto->proy_tipo);
            redirect();
            exit();
        }

        $this->actividad_db->act_proy_id = $proyecto->proy_id;
        $actividades = $this->actividad_db->get_array();
		$this->map_db->map_proy_id       = $proyecto->proy_id;
		$mapas       = $this->map_db->get_array();
        $this->view_data['HEADER_TITLE'] = $proyecto->proy_titulo . ' - Actividades';
        $this->view_data['PROYECTO'] = $proyecto;
        $this->view_data['ACTIVIDADES'] = $actividades;
		$this->view_data['MAPAS'] = $mapas;
		//$json_data = {'hola':"hola"};
		$this->view_data['JSON']  = json_encode($mapas);
        $this->load->view('proyecto_actividades', $this->view_data);
    }

    public function crear_actividad($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');
        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if (!currentuser_can('proy_modif_activ', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_crear_actividad_proccess($proyecto);

        // No tiene vista en particular...
        $this->actividades($proyecto_id);
    }

    private function _crear_actividad_proccess($proyecto) {

        if ($this->input->post('submit-act-crear')) {
			$this->load->model('map_db');
            // Procesamos el formulario
            $this->form_validation->set_rules('act_desc', 'Descripci&oacute;n', 'required|trim');
            $this->form_validation->set_rules('act_responsables', 'Responsables', 'required|trim');
            $this->form_validation->set_rules('act_inicio', 'Fecha de Inicio', 'callback__valid_dateformat');
            $this->form_validation->set_rules('act_fin', 'Fecha de finalizaci&oacute;n', 'callback__valid_dateformat');

            if ($this->form_validation->run() == TRUE) {

                $this->actividad_db->act_proy_id = $proyecto->proy_id;
                $this->actividad_db->act_desc = set_value('act_desc');
                $this->actividad_db->act_responsables = set_value('act_responsables');
                if (set_value('act_inicio'))
                    $this->actividad_db->act_inicio = set_value('act_inicio');
                if (set_value('act_fin'))
                    $this->actividad_db->act_fin = set_value('act_fin');
                $this->actividad_db->act_status = 'none';
                if (($actividad_id = $this->actividad_db->save())) {
				
					$this->map_db->map_act_id = $actividad_id;
					$this->map_db->map_lang   = -66.4293642578125;
					$this->map_db->map_lat	  = 10.440202583805885;
					$this->map_db->map_desc	  = "actividad";
					$this->map_db->map_proy_id= $proyecto->proy_id;
					$this->map_db->insert();
                    $this->session->set_flashdata('SUCCESS_MSG', 'La actividad fue creada con &eacute;xito.');
                    redirect('proyecto/actividades/' . $proyecto->proy_id);
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
    }

    public function editar_actividad($proyecto_id = 0, $actividad_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if (!currentuser_can('proy_modif_activ', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_editar_actividad_proccess($proyecto, $actividad_id);

        // No tiene vista en particular...
        $this->actividades($proyecto_id);
    }

    private function _editar_actividad_proccess($proyecto, $actividad_id) {

        if ($this->input->post('submit-act-editar')) {
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
                if (set_value('act_inicio'))
                    $this->actividad_db->act_inicio = set_value('act_inicio');
                if (set_value('act_fin'))
                    $this->actividad_db->act_fin = set_value('act_fin');
                // $this->actividad_db->act_status = 'none';

                if (($actividad_id = $this->actividad_db->save())) {
                    $this->session->set_flashdata('SUCCESS_MSG', 'La actividad fue Actualizada con &eacute;xito.');
                    redirect('proyecto/actividades/' . $proyecto->proy_id);
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
    }

    public function eliminar_actividad($proyecto_id = 0, $actividad_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');
		$this->load->model('map_db');
        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if (!currentuser_can('proy_modif_activ', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->actividad_db->clear();
        $this->actividad_db->act_id = $actividad_id;
		$this->map_db->clear();
		$this->map_db->map_act_id = $actividad_id;
        if ($this->actividad_db->delete() && $this->map_db->delete()) {
            // actualizado
            $this->session->set_flashdata('SUCCESS_MSG', 'Se elimino la actividad.');
        } else {
            $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
        }
        redirect('proyecto/actividades/' . $proyecto_id);
    }

    /*     * * * * * * * * * * * INVERSION * * * * * * * * * * * */

    public function inversion($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->clear();
        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if (!($proyecto && currentuser_can('proy_modif_inver', $proyecto))) {
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
        if (!currentuser_can('proy_modif_inver', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_crear_inversion_proccess($proyecto);

        // No tiene vista en particular...
        $this->inversion($proyecto_id);
    }

    private function _crear_inversion_proccess($proyecto) {

        if ($this->input->post('submit-inv-crear')) {
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

                if (set_value('inv_status')) {
                    $this->inversion_db->inv_status = 'cancelado';
                    $this->inversion_db->inv_fecha_aprob = date('Y-m-d');
                } else {
                    $this->inversion_db->inv_status = 'pendiente';
                }

                if (($inversion_id = $this->inversion_db->save())) {
                    $this->session->set_flashdata('SUCCESS_MSG', 'El rubro fue creado con &eacute;xito.');
                    redirect('proyecto/inversion/' . $proyecto->proy_id);
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
    }

    public function editar_inversion($proyecto_id = 0, $inversion_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if (!currentuser_can('proy_modif_inver', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_editar_inversion_proccess($proyecto, $inversion_id);

        // No tiene vista en particular...
        $this->inversion($proyecto_id);
    }

    private function _editar_inversion_proccess($proyecto, $inversion_id) {

        if ($this->input->post('submit-inv-editar')) {
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

                if (set_value('inv_status')) {
                    $this->inversion_db->inv_status = 'cancelado';
                    $this->inversion_db->inv_fecha_aprob = date('Y-m-d');
                } else {
                    $this->inversion_db->inv_status = 'pendiente';
                }

                if (($inversion_id = $this->inversion_db->save())) {
                    $this->session->set_flashdata('SUCCESS_MSG', 'El rubro fue actualizado con &eacute;xito.');
                    redirect('proyecto/inversion/' . $proyecto->proy_id);
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
    }

    public function eliminar_inversion($proyecto_id = 0, $inversion_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if (!currentuser_can('proy_modif_inver', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->inversion_db->clear();
        $this->inversion_db->inv_id = $inversion_id;
        if ($this->inversion_db->delete()) {
            // actualizado
            $this->session->set_flashdata('SUCCESS_MSG', 'Se elimino el rubro.');
        } else {
            $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
        }
        redirect('proyecto/inversion/' . $proyecto_id);
    }

    /*     * * * * * * * * * * * REPRESENTANTES * * * * * * * * * * * */

    public function representantes($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->clear();
        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if (!($proyecto && currentuser_can('proy_modif_repre', $proyecto))) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->usuario_participa_db->clear();
        $this->usuario_participa_db->proy_id = $proyecto_id;
        $this->db->join(Usuario_db::tableName(), Usuario_participa_db::tableName() . '.user_id=' . Usuario_db::tableName() . '.user_id', 'left');
        $representantes = $this->usuario_participa_db->get_array();

        $representantes_ids = array();
        foreach ($representantes as $value) {
            $representantes_ids[] = $value->user_id;
        }

        // Representantes validos para agregar
        $current_user = user_get_data();
        $this->usuario_db->clear();
        $this->usuario_db->user_org_id = $current_user->user_org_id;
        $_para_representar = $this->usuario_db->get_array();

        $para_representar = array();
        foreach ($_para_representar as $value) {
            if (!in_array($value->user_id, $representantes_ids)) {
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
        if (!currentuser_can('proy_modif_repre', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_crear_representante_proccess($proyecto);

        // No tiene vista en particular...
        $this->representantes($proyecto_id);
    }

    private function _crear_representante_proccess($proyecto) {

        if ($this->input->post('submit-repre-crear')) {
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

                $this->usuario_participa_db->p_modif_datos = (set_value('p_modif_datos')) ? 1 : 0;
                $this->usuario_participa_db->p_modif_repre = (set_value('p_modif_repre')) ? 1 : 0;
                $this->usuario_participa_db->p_modif_activ = (set_value('p_modif_activ')) ? 1 : 0;
                $this->usuario_participa_db->p_modif_histo = (set_value('p_modif_histo')) ? 1 : 0;
                $this->usuario_participa_db->p_modif_inver = (set_value('p_modif_inver')) ? 1 : 0;
                $this->usuario_participa_db->p_export = (set_value('p_export')) ? 1 : 0;

                $inversion_id = $this->usuario_participa_db->insert();
                if ($this->db->_error_message()) {
                    Message::add_error('No fue posible procesar su solicitud. Por favor, Int&eacute;ntelo m&aacute;s tarde.');
                } else {
                    $this->session->set_flashdata('SUCCESS_MSG', 'El usuario fue agregado al proyecto con &eacute;xito.');
                    redirect('proyecto/representantes/' . $proyecto->proy_id);
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
        if (!currentuser_can('proy_modif_repre', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_editar_representante_proccess($proyecto, $representante_id);

        // No tiene vista en particular...
        $this->representantes($proyecto_id);
    }

    private function _editar_representante_proccess($proyecto, $representante_id) {

        if ($this->input->post('submit-repre-editar')) {
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

                $this->usuario_participa_db->p_modif_datos = (set_value('p_modif_datos')) ? 1 : 0;
                $this->usuario_participa_db->p_modif_repre = (set_value('p_modif_repre')) ? 1 : 0;
                $this->usuario_participa_db->p_modif_activ = (set_value('p_modif_activ')) ? 1 : 0;
                $this->usuario_participa_db->p_modif_histo = (set_value('p_modif_histo')) ? 1 : 0;
                $this->usuario_participa_db->p_modif_inver = (set_value('p_modif_inver')) ? 1 : 0;
                $this->usuario_participa_db->p_export = (set_value('p_export')) ? 1 : 0;

                $this->usuario_participa_db->update();
                if ($this->db->_error_message()) {
                    Message::add_error('No fue posible procesar su solicitud. Por favor, Int&eacute;ntelo m&aacute;s tarde.');
                } else {
                    $this->session->set_flashdata('SUCCESS_MSG', 'El usuario fue actualizado con &eacute;xito.');
                    redirect('proyecto/representantes/' . $proyecto->proy_id);
                    exit();
                }
            } else {
                
            }
        }
    }

    public function eliminar_representante($proyecto_id = 0, $representante_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if (!currentuser_can('proy_modif_inver', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        if ($this->_valid_del_repre($representante_id)) {
            $this->usuario_participa_db->clear();
            $this->usuario_participa_db->user_id = $representante_id;
            $this->usuario_participa_db->proy_id = $proyecto_id;
            if ($this->usuario_participa_db->delete()) {
                // actualizado
                $this->session->set_flashdata('SUCCESS_MSG', 'Se saco al representante del proyecto.');
            } else {
                $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
            }
        } else {
            $this->session->set_flashdata('ERROR_MSG', 'Usted no puede sacar a este usuario');
        }

        redirect('proyecto/representantes/' . $proyecto_id);
    }

    public function _valid_del_repre($user_id) {
        $current_user = user_get_data();
        $org_levels = get_org_rol_levels();

        $this->usuario_db->clear();
        $this->usuario_db->user_id = $user_id;
        $user = $this->usuario_db->get();

        $org_levels[$current_user->user_org_rol] <= $org_levels[$user->user_org_rol];

        if ($current_user->user_id == $user->user_id) {
            // No te puedes sacar a ti mismo
            return FALSE;
        } elseif ($user && $org_levels[$current_user->user_org_rol] <= $org_levels[$user->user_org_rol]) {
            // Necesitas tener tantos, o mas, privilegios en la organizacion para sacarlo
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function export_to_pdf($proyecto_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if (!currentuser_can('proy_export_pdf', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }
        // $this->load->helper(array('dompdf', 'file'));
        $this->load->helper(array('tcpdf', 'file'));

        $mes_espanol = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

        $USER_NAME = $user['user_firstname'] . ' ' . $user['user_lastname'];
        $CI = $user['user_ci'];
        $m = $mes_espanol[(int) date('m', strtotime($user['user_registered'])) - 1];
        $FECHA_AFILICACION = $m . ' ' . date('Y', strtotime($user['user_registered']));
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

        $pdf->Image(APPPATH . 'views/' . SYSTEM_DEFAULT_THEME . '/tarjetas/tarjeta_plus2.jpg', 15 + $_x_offset, 140 + $_y_offset, 150, 0, 'JPG', '', false, 300);

        $fontsize = $pdf->getFontSize();
        $pdf->SetFontSize(9);

        //                  w,  h,  x,  y
        $pdf->writeHTMLCell(32, 10, $_x_offset + 18.5, $_y_offset + 162, $USER_NAME /* , 1 */);
        $pdf->writeHTMLCell(32, 10, $_x_offset + 18.5, $_y_offset + 175, $CI /* , 1 */);
        $pdf->writeHTMLCell(32, 10, $_x_offset + 51, $_y_offset + 162, $FECHA_AFILICACION /* , 1 */);

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
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 7,
            'stretchtext' => 4
        );
        $pdf->write1DBarcode($CONTRATO, 'EAN13', $_x_offset + 48, $_y_offset + 168, 40, 13, 0.4, $style, 'N');

        $pdf->SetFontSize($fontsize);

        if (!$file) {
            $fp = fopen(SYSTEM_CACHE_TARJETAS_FIDELIDAD . $user['novared_id'] . '.pdf', 'w');
        } else {
            $fp = fopen($file, 'w');
        }
        fwrite($fp, $pdf->Output('', 'S'));
        fclose($fp);
    }

    /*     * * * * * * * * * * * HISTORIAL* * * * * * * * * * * */

    public function historial($proyecto_id = 0) {
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();

        if (!currentuser_can('proy_modif_histo', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }
        $this->historial_db->aldia_proyecto_proy_id = $proyecto->proy_id;
        $historiales = $this->historial_db->get_array();
        $this->view_data['HISTORIALES'] = $historiales;
        $this->view_data['HEADER_TITLE'] = $proyecto->proy_titulo . ' - Historial';
        $this->view_data['PROYECTO'] = $proyecto;
        /*
         * para la subida de archivos, se coloca un numero random como prefijo del archivo para poder identificarlo
         */
        $n_random = mt_rand();
        $this->view_data['rutaAbsolutaMetodoSubir'] = "{$this->_directorioprincipal}{$this->_nombreControlador}/subir_archivo/";
        $this->view_data['rutaCarpetaSubidas'] = "{$this->_directorioprincipal}/uploads/";
        $this->view_data['n_random'] = $n_random;
        $this->load->view('proyecto_historial', $this->view_data);
    }

    public function subir_archivo($n_random) {
        if (!empty($_FILES)) {
            $nombreArchivo = $_FILES['Filedata']['name'];
            $tempFile = $_FILES['Filedata']['tmp_name'];
            $targetFile = $this->_directoriosubidaarchivos . $n_random . $nombreArchivo;
            if (move_uploaded_file($tempFile, $targetFile)) {
                
            }
        }
        echo 1;
    }

    public function eliminar_archivo($nombre_archivo, $carpeta) {
        $archivos = $this->input->post('archivos');
        if ($archivos != null) {
            /* eliminacion de archivos mediante editar */
            foreach ($archivos as $valor) {
                unlink($this->_directoriosubidaarchivos . 'archivos_historial/' . $valor);
            }
        } else {

            if ($carpeta == "tmp") {
                if (file_exists($this->_directoriosubidaarchivos . $nombre_archivo)) {
                    unlink($this->_directoriosubidaarchivos . $nombre_archivo);
                    echo "Archivo borrado.";
                } else {
                    echo "Error al borrar el archivo del servidor 1.";
                }
            } else if ($carpeta == "historial") {
                if (file_exists($this->_directoriosubidaarchivos . 'archivos_historial/' . $nombre_archivo)) {
                    unlink($this->_directoriosubidaarchivos . 'archivos_historial/' . $nombre_archivo);
                    echo "Archivo borrado.";
                } else {
                    echo "Error al borrar el archivo del servidor.";
                }
            }
        }
    }

    public function crear_historial($proyecto_id, $n_random) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if (!currentuser_can('proy_modif_histo', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }
        $this->_crear_historial_proccess($proyecto, $n_random);

        // No tiene vista en particular...
        $this->historial($proyecto_id);
    }

    private function _crear_historial_proccess($proyecto, $n_random) {
        if ($this->input->post('submit-his-crear')) {
            // Procesamos el formulario
            $this->form_validation->set_rules('hist_texto', 'Texto', 'required|trim|max_length[126]');
            $this->form_validation->set_rules('hist_type', 'Type', 'required');

            if ($this->form_validation->run() == TRUE) {
                $current_user = user_get_data();

                $this->historial_db->clear();
                $this->historial_db->hist_texto = set_value('hist_texto');
                $this->historial_db->hist_type = set_value('hist_type');
                $this->historial_db->hist_created = date('Y-m-d H:i:s');
                $this->historial_db->aldia_proyecto_proy_id = $proyecto->proy_id;
                $this->historial_db->aldia_usuarios_user_id = $current_user->user_id;

                if ($this->historial_db->save()) {
                    /* se procesan los archivos de la carpeta y se coloca un nombre
                     * predefinido para asociarlo al historial que se
                     * esta salvando
                     */
                    $historial = $this->historial_db->get();
                    $archivos = glob($this->_directoriosubidaarchivos . $n_random . "*");
                    foreach ($archivos as $archivo) {
                        $n_random = mt_rand();
                        /* se obtiene la extension */
                        $path_info = pathinfo($archivo);
                        $extension = $path_info['extension'];
                        rename($archivo, $this->_directoriosubidaarchivos . "archivos_historial/" . $historial->hist_id . "_" . $n_random . '.' . $extension);
                    }
                    $this->session->set_flashdata('SUCCESS_MSG', 'Registro creado.');
                    redirect(current_url());
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
    }

    public function editar_historial($proyecto_id = 0, $historial_id = 0, $n_random) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->preditaroyecto_db->get();
        if (!currentuser_can('proy_modif_histo', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->_editar_historial_proccess($proyecto, $historial_id, $n_random);

        // No tiene vista en particular...
        $this->historial($proyecto_id);
    }

    private function _editar_historial_proccess($proyecto, $historial_id, $n_random) {

        if ($this->input->post('submit-his-editar')) {
            // Procesamos el formulario

            $this->form_validation->set_rules('hist_texto', 'Texto', 'required|trim|max_length[126]');
            $this->form_validation->set_rules('hist_type', 'Type', 'required');

            if ($this->form_validation->run() == TRUE) {
                $current_user = user_get_data();

                $this->historial_db->clear();
                $this->historial_db->hist_id = $historial_id;
                $this->historial_db->hist_texto = set_value('hist_texto');
                $this->historial_db->hist_type = set_value('hist_type');
                $this->historial_db->hist_created = date('Y-m-d H:i:s');
                $this->historial_db->aldia_usuarios_user_id = $current_user->user_id;

                if ($this->historial_db->save()) {
                    /* se procesan los archivos de la carpeta y se coloca un nombre
                     * predefinido para asociarlo al historial que se
                     * esta salvando
                     */
                    $archivos = glob($this->_directoriosubidaarchivos . $n_random . "*");
                    foreach ($archivos as $archivo) {
                        $n_random = mt_rand();
                        /* se obtiene la extension */
                        $path_info = pathinfo($archivo);
                        $extension = $path_info['extension'];
                        rename($archivo, $this->_directoriosubidaarchivos . "archivos_historial/" . $historial_id . "_" . $n_random . '.' . $extension);
                    }


                    $this->session->set_flashdata('SUCCESS_MSG', 'Historial actualizado con &eacute;xito.');
                    redirect('proyecto/historial/' . $proyecto->proy_id);
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
    }

    public function eliminar_historial($proyecto_id = 0, $historial_id = 0) {
        // $this->output->enable_profiler(TRUE);
        $this->_must_authenticate_first();
        $this->load->library('form_validation');

        $this->proyecto_db->proy_id = $proyecto_id;
        $proyecto = $this->proyecto_db->get();
        if (!currentuser_can('proy_modif_histo', $proyecto)) {
            $this->session->set_flashdata('ERROR_MSG', 'No tiene los permisos necesarios para realizar esta acci&oacute;n.');
            redirect();
            exit();
        }

        $this->historial_db->clear();
        $this->historial_db->hist_id = $historial_id;
        if ($this->historial_db->delete()) {
            // actualizado
            /* se eliminan los archivos asociados a este historial */
            $archivos = glob($this->_directoriosubidaarchivos . "archivos_historial/" . $historial_id . "_*");
            foreach ($archivos as $archivo) {
                if (file_exists($archivo)) {
                    unlink($archivo);
                } else {
                    Message::add_warning('Hubo un error al borrar uno de los archivos.');
                }
            }
            $this->session->set_flashdata('SUCCESS_MSG', 'Se elimino el registro.');
        } else {
            $this->session->set_flashdata('WARNING_MSG', 'No se realizaron cambios');
        }
        redirect('proyecto/historial/' . $proyecto_id);
    }

}
