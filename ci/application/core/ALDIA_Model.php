<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class ALDIA_Model extends CI_Model {

	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
        parent::__construct();
	}

    /**
     * Obtiene el nombre de la tabla asociado al registro.
     *
     * @return String   Nombre de la tabla en DB del tipo de regitro
     */
    public static function tableName(){
        return '__DEFINIR__';
    }

    /**
     * Indica cuales son los campos IDs del registro.
     *
     * @return ARRAY(STRING)    Lista de IDs del registro
     */
    public static function ids(){
        return array();
    }

    /**
     * CDonvierte en String el objeto. Por defecto, se concatenan los ids.
     *
     * @return String String
     */
    public function __toString() {
        return implode(',', (array)$this->ids() );
    }

    /**
     * Elimina los campos del objeto actual, a fin de poder reutilizarlo
     * en otro tipo de operaciones.
     */
    public function clear(){
        foreach ($this as $key => $value ){
            unset( $this->$key );
        }
    }

    /**
     * Obtiene informacion de la base de datos.
     * 
     * De los atributos (parcialmente especificados) en el objeto, se intenta
     * encontrar todos los registros que coincidan con este. El objeto actual
     * es rellenado con el primer resultado del conjunto de resultados obtenido.
     *
     * @param String $orderby       Campo por el cual se desea ordenar los resultados
     * @param String $order         'asc' o 'desc'
     * @param Integer $row_count    Numero de resultados esperados
     * @param Integer $offset       Offset, tal como se usa en LIMITS
     * @return mixed    Un objeto, un array de objetos segun el numero de resultados. FALSE en caso de no obtener resultados.
     */
    public function get ( $orderby=FALSE, $order='desc', $row_count=0, $offset=0, $asarray=FALSE ) {

        // Verificacion de valores simples, o Array
        foreach( $this as $key => $value){
            if (is_array($value)) {
                // Lo tratamos como un Where IN ()
                $this->db->where_in($key, $value);
                unset($this->$key);
            }
        }

        $this->db->from( $this->tableName() )->where( get_object_vars($this) );

        if ( $orderby ) $this->db->order_by($orderby, $order);

        if( $row_count > 0 ) $this->db->limit($row_count, $offset);

        $query = $this->db->get();

        if ($query->num_rows == 1 && !$asarray) {
            $result = $query->row( 0, get_class($this) );
            $datos = $result;

        } elseif ($query->num_rows > 0) {
            $result = $query->result( get_class($this) );
            $datos = $result[0];

        } else {
            if($asarray) {
                $result = array();
            } else {
                $result = FALSE;
            }
            $datos = array();
        }

        // Rellenamos el objeto actual con datos de los resultados
        foreach ($datos as $key => $value ){
            $this->$key = $value;
        }

        return $result;
	}

    /**
     * Exactamente igual que get(), solo que SIEMPRE retorna una array de resultados
     * cuando los consigue.
     */
    public function get_array ( $orderby=FALSE, $order='desc', $row_count=0, $offset=0) {
        return $this->get ($orderby, $order, $row_count, $offset, TRUE);
    }

    /**
     * Inserta un nuevo registro en la DB.
     * 
     * Los datos son obtenidos del propio objeto.
     *
     * @return INTEGER El ID del registro recien insertado en la DB.
     */
    public function insert() {
        $this->db->insert($this->tableName(), get_object_vars($this) );

        return $this->db->insert_id();
    }

    /**
     * Actualiza los registros de la base de datos. Los datos son obtenidos
     * del propio objeto.
     * 
     * @return INTEGER  El numero de registros afectados.
     */
    public function update() {
        $where = array();
        $updates = get_object_vars($this);

        foreach ( $this->ids() as $value ) {
            if ( isset($this->$value) ) {
                $where[$value] = $this->$value;
                unset( $updates[$value] );
            }
        }

        if ( !empty($where) && !empty($updates) ) {
            $this->db->where($where);
            $this->db->update($this->tableName(), $updates );
            return $this->db->affected_rows();
        }

        return 0;
    }

    /**
     * Evalua si los datos del objeto son para insertar en la DB, o para
     * actualizar un registro actual en la db.
     * 
     * El criterio es el siguiente: si se indico un ID como dato dentro del
     * objeto, entonces lo que se quiere es actualizar dicho registro en la
     * DB. Si, por el contrario, no se indica el valor del ID en el objeto,
     * se asume que se trata de un registro nuevo para insertar en la DB.
     * 
     * Si de antemano se sabe que se quiere actualizar o insertar, usar
     * directamente las funciones destinadas para estos objetivos.
     *
     * @return INTEGER  Lo que retorna insert y update, segun el caso.
     */
    public function save () {
        $update = FALSE;
        foreach ( $this->ids() as $value ) {
            if ( isset($this->$value) ) {
                $update = TRUE;
                break;
            }
        }

        if($update) {
            return $this->update();
        } else {
            return $this->insert();
        }
    }

    /**
     * Elimina registros de la DB. Los datos de los registros a eliminar son
     * extraidos directamente del objeto.
     * 
     * @return INTEGER  El numero de registros afectados.
     */
    public function delete () {
        $where = get_object_vars($this);

        if ( !empty($where) ) {
            $this->db->delete($this->tableName(), $where ); 
            return $this->db->affected_rows();
        }

        return 0;
    }
}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */
