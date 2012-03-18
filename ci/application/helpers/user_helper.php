<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * View Helper. Funciones para hacer las vistas anidadas mas amigables.
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/array_helper.html
 */

// ------------------------------------------------------------------------
if ( ! function_exists('user_get_data'))
{
	function user_get_data () {
		$CI =& get_instance();

        if ( $CI->session->userdata('islogin') ) {
            $data = $CI->session->userdata('user');

            $result = new Usuario_db();
            foreach ($data as $key => $value) {
                $result->$key = $value;
            }
            // var_dump($result); die;
            return $result;
        }

        return NULL;
	}
}

/**
 * Verifica que un usuario este logueado
 */
if ( ! function_exists('user_is_login'))
{
	function user_is_login () {
        static $return = FALSE;

        if ( !$return ){
            $CI =& get_instance();

            if ( ($user = user_get_data() ) ) {
                // hay que verificar que el usuario sigue teniendo una cuenta valida en la DB
                $user_db = new Usuario_db();
                $user_db->user_id = $user->user_id;
                if ( $user_db->get() && $user_db->user_status == 'active' ) {
                    
                    // Actualizamos los datos del usuario
                    $CI->session->set_userdata('user', $user_db);
                    $return = TRUE;
                    return TRUE;
                }
            }
            // Aseguramos de que la sesion este realmente cerrada
            $CI->session->unset_userdata('islogin');
            $CI->session->unset_userdata('user');
        }

        return $return;
	}
}

/**
 * Obtiene un array que permite comparar algebraicamente los privilegios de
 * un usuario.
 * Mientras menor sea el numero, mayor son los privilegios del usuario.
 */
function get_org_rol_levels() {
    return array(
        'super' => 1,
        'admin' => 5,
        'miembro' => 10
    );
}

function user_is_admin($user=NULL){
    if ($user===NULL) $user = user_get_data ();

    $org_levels = get_org_rol_levels();
    if ( $org_levels[$user->user_org_rol] <= ADMIN_LEVEL ) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 *
 * @param String $action Indica la accion que se quiere realizar
 * @param type $object De tipo Usuario_db, o segun sea el caso
 * @return Bool Si el usuario tiene los permisos adecuados
 */
function currentuser_can($action, $object = NULL) {
    $current_user = user_get_data();
    $org_levels = get_org_rol_levels();
    $CI =& get_instance();

    switch ($action) {
        case 'cambiar_perfil':
            $user = $object;
            if ( $user ) {
                // El usuario existe

                if( $current_user->user_type == 'admin') {
                    // Administrador general del sistema... puede cambiar cualquier perfil
                    return TRUE;

                } else if (
                        $current_user->user_org_id == $user->user_org_id
                        && element ($current_user->user_org_rol, $org_levels, 100) <= element ($user->user_org_rol, $org_levels, 0)
                        ) {
                    // Tiene tantos, o mas, privilegios
                    return TRUE;
                }
            }
            break;
        case 'cambiar_user_status':
        case 'borrar_usuario':
        case 'cambiar_org_rol':
            $user = $object;
            if (
                    $current_user->user_id != $user->user_id
                    && $current_user->user_org_id == $user->user_org_id
                    && $org_levels[$current_user->user_org_rol] <= $org_levels[$user->user_org_rol] ) {
                return TRUE;
            }
            break;
        case 'cambiar_perfil_comunidad':
            $comunidad = $object;
            if (
                    $current_user->user_com_id == $comunidad->com_id
                    && $org_levels[$current_user->user_org_rol] <= ADMIN_LEVEL ) {
                return TRUE;
            }
            break;
        case 'crear_proy':
        case 'borrar_proy':
            if ( $org_levels[$current_user->user_org_rol] <= ADMIN_LEVEL ) {
                return TRUE;
            }
            break;
        case 'proy_ver_datos':
            $proyecto = $object;
            if ( $proyecto->proy_com_id == $current_user->user_com_id
                    && (
                        $proyecto->proy_status == 'active'
                        ||
                        ( user_is_admin($current_user) && $proyecto->proy_org_id == $current_user->user_org_id )
                    )
                ) {
                return TRUE;
            }
            break;
        case 'proy_modif_datos':
            $proyecto = $object;
            // $cache_var = 'proy_modif_datos-'.$current_user->user_id.'-'.$proyecto->proy_id;
            /*
            if ( ($return=$CI->cache->get($cache_var)) !== FALSE ){
                return $return;
            }
            */

            $usuario_participa_db = new Usuario_participa_db();
            $usuario_participa_db->proy_id = $proyecto->proy_id;
            $usuario_participa_db->user_id = $current_user->user_id;
            $usuario_participa_db = $usuario_participa_db->get();

            if (
                    $proyecto->proy_org_id == $current_user->user_org_id
                    && (
                            $org_levels[$current_user->user_org_rol] <= ADMIN_LEVEL
                            ||
                            ($usuario_participa_db && $usuario_participa_db->p_modif_datos )
                    )
                ) {
                // $CI->cache->save($cache_var, 1);
                return TRUE;
            }
            // $CI->cache->save($cache_var, 0);
            break;
        case 'proy_modif_histo':
            $proyecto = $object;

            $usuario_participa_db = new Usuario_participa_db();
            $usuario_participa_db->proy_id = $proyecto->proy_id;
            $usuario_participa_db->user_id = $current_user->user_id;
            $usuario_participa_db = $usuario_participa_db->get();

            if (
                    $proyecto->proy_org_id == $current_user->user_org_id
                    && (
                            $org_levels[$current_user->user_org_rol] <= ADMIN_LEVEL
                            ||
                            ($usuario_participa_db && $usuario_participa_db->p_modif_histo )
                    )
                ) {
                return TRUE;
            }
            break;
        case 'proy_modif_activ':
            $proyecto = $object;

            $usuario_participa_db = new Usuario_participa_db();
            $usuario_participa_db->proy_id = $proyecto->proy_id;
            $usuario_participa_db->user_id = $current_user->user_id;
            $usuario_participa_db = $usuario_participa_db->get();

            if (
                    $proyecto->proy_org_id == $current_user->user_org_id
                    && (
                            $org_levels[$current_user->user_org_rol] <= ADMIN_LEVEL
                            ||
                            ($usuario_participa_db && $usuario_participa_db->p_modif_activ )
                    )
                ) {
                return TRUE;
            }
            break;
        case 'proy_modif_inver':
            $proyecto = $object;

            $usuario_participa_db = new Usuario_participa_db();
            $usuario_participa_db->proy_id = $proyecto->proy_id;
            $usuario_participa_db->user_id = $current_user->user_id;
            $usuario_participa_db = $usuario_participa_db->get();

            if (
                    $proyecto->proy_org_id == $current_user->user_org_id
                    && (
                            $org_levels[$current_user->user_org_rol] <= ADMIN_LEVEL
                            ||
                            ($usuario_participa_db && $usuario_participa_db->p_modif_inver )
                    )
                ) {
                return TRUE;
            }
            break;
        case 'proy_modif_repre':
            $proyecto = $object;

            $usuario_participa_db = new Usuario_participa_db();
            $usuario_participa_db->proy_id = $proyecto->proy_id;
            $usuario_participa_db->user_id = $current_user->user_id;
            $usuario_participa_db = $usuario_participa_db->get();

            if (
                    $proyecto->proy_org_id == $current_user->user_org_id
                    && (
                            $org_levels[$current_user->user_org_rol] <= ADMIN_LEVEL
                            ||
                            ($usuario_participa_db && $usuario_participa_db->p_modif_repre )
                    )
                ) {
                return TRUE;
            }
            break;
        case 'proy_export_pdf':
            $proyecto = $object;

            $usuario_participa_db = new Usuario_participa_db();
            $usuario_participa_db->proy_id = $proyecto->proy_id;
            $usuario_participa_db->user_id = $current_user->user_id;
            $usuario_participa_db = $usuario_participa_db->get();

            if (
                    $proyecto->proy_org_id == $current_user->user_org_id
                    && (
                            $org_levels[$current_user->user_org_rol] <= ADMIN_LEVEL
                            ||
                            ($usuario_participa_db && $usuario_participa_db->p_export)
                    )
                ) {
                return TRUE;
            }
            break;
    }

    return FALSE;
}