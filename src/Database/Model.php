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
     */
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Crea un nuevo registro en la base de datos.
     *
     * @param string $table Nombre de la tabla.
     * @param array $data Datos del registro a crear.
     * @return bool|int Id del registro creado o false en caso de error.
     */
    public function create($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    /**
     * Obtiene un registro por su ID.
     *
     * @param string $table Nombre de la tabla.
     * @param int $id ID del registro a buscar.
     * @return array|bool Registro encontrado o false si no se encuentra.
     */
    public function findById($table, $id)
    {
        return $this->db->get($table, '*', ['id' => $id]);
    }

    /**
     * Actualiza un registro en la base de datos.
     *
     * @param string $table Nombre de la tabla.
     * @param array $data Datos a actualizar.
     * @param int $id ID del registro a actualizar.
     * @return bool Resultado de la operación.
     */
    public function update($table, $data, $id)
    {
        return $this->db->update($table, $data, ['id' => $id]);
    }

    /**
     * Elimina un registro de la base de datos.
     *
     * @param string $table Nombre de la tabla.
     * @param int $id ID del registro a eliminar.
     * @return bool Resultado de la operación.
     */
    public function delete($table, $id)
    {
        return $this->db->delete($table, ['id' => $id]);
    }

    /**
     * Obtiene todos los registros de una tabla.
     *
     * @param string $table Nombre de la tabla.
     * @return array Registros encontrados.
     */
    public function findAll($table)
    {
        return $this->db->select($table, '*');
    }

    /**
     * Busca registros en una tabla según condiciones dadas.
     *
     * @param string $table Nombre de la tabla.
     * @param array $conditions Condiciones de búsqueda.
     * @return array Registros encontrados.
     */
    public function findByCondition($table, $conditions)
    {
        return $this->db->select($table, '*', $conditions);
    }
}
