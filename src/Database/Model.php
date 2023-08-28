<?php

/**
 * Lumina Framework
 *
 * Este archivo es parte del Lumina Framework desarrollado para crear aplicaciones web robustas y escalables.
 *
 * @package     Lumina
 * @subpackage  Database
 * @version     1.2.0
 * @author      IDEAMOS TU WEB Agencia Digital <hola@ideamostuweb.com>
 * @link        https://github.com/ideamostuweb/lumina
 */

namespace Lumina\Database;

use Catfan\Medoo\Medoo;

/**
 * Clase Model
 *
 * Clase base para todos los modelos en el Lumina Framework.
 *
 * @package     Lumina
 * @subpackage  Database
 * @version     1.2.0
 */
class Model
{
    protected Medoo $db;

    /**
     * Constructor de la clase Model.
     *
     * @return void
     */
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Obtiene todos los registros de una tabla.
     *
     * @param string $table Nombre de la tabla.
     * @param array $columns Columnas a seleccionar (opcional).
     * @param array $where Condiciones de consulta (opcional).
     * @return array Resultados de la consulta.
     */
    public function getAll($table, $columns = ['*'], $where = [])
    {
        return $this->db->select($table, $columns, $where);
    }

    /**
     * Obtiene un solo registro de una tabla por su ID.
     *
     * @param string $table Nombre de la tabla.
     * @param int $id ID del registro a obtener.
     * @return array|null Resultado de la consulta o null si no se encuentra.
     */
    public function getById($table, $id)
    {
        return $this->db->get($table, '*', ['id' => $id]);
    }

    /**
     * Inserta un nuevo registro en la tabla.
     *
     * @param string $table Nombre de la tabla.
     * @param array $data Datos del registro a insertar.
     * @return bool True si la inserción se realiza con éxito, de lo contrario, false.
     */
    public function insert($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    /**
     * Actualiza un registro existente en la tabla por su ID.
     *
     * @param string $table Nombre de la tabla.
     * @param int $id ID del registro a actualizar.
     * @param array $data Nuevos datos del registro.
     * @return bool True si la actualización se realiza con éxito, de lo contrario, false.
     */
    public function updateById($table, $id, $data)
    {
        return $this->db->update($table, $data, ['id' => $id]);
    }

    /**
     * Elimina un registro de la tabla por su ID.
     *
     * @param string $table Nombre de la tabla.
     * @param int $id ID del registro a eliminar.
     * @return bool True si la eliminación se realiza con éxito, de lo contrario, false.
     */
    public function deleteById($table, $id)
    {
        return $this->db->delete($table, ['id' => $id]);
    }

    // Otros métodos comunes relacionados con modelos...
}
