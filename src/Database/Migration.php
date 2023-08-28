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

use \Catfan\Medoo\Medoo;

/**
 * Clase abstracta Migration
 *
 * Proporciona una base común para todas las migraciones de base de datos.
 *
 * @package     Lumina
 * @subpackage  Database
 * @since       1.0.0
 */
abstract class Migration
{
    /**
     * @var Medoo Instancia de la conexión a la base de datos utilizando Medoo.
     */
    protected Medoo $db;

    /**
     * Constructor de la clase Migration.
     *
     * Inicializa la conexión a la base de datos utilizando Medoo.
     */
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Método abstracto up().
     *
     * Este método debe ser implementado por las clases hijas para aplicar la migración.
     *
     * @return void
     */
    abstract public function up();

    /**
     * Ejecuta una consulta SQL en la base de datos.
     *
     * @param string $sql Consulta SQL a ejecutar.
     * @return bool True si la consulta se ejecuta con éxito, de lo contrario, false.
     */
    protected function executeSql($sql)
    {
        try {
            $this->db->exec($sql);
            return true;
        } catch (\PDOException $e) {
            // Manejar el error de la consulta
            // Registrar el error en el sistema de logs, etc.
            return false;
        }
    }

    /**
     * Crea una nueva tabla en la base de datos.
     *
     * @param string $tableName Nombre de la tabla a crear.
     * @param array $columns Definición de columnas de la tabla.
     * @return bool True si la tabla se crea con éxito, de lo contrario, false.
     */
    protected function createTable($tableName, $columns)
    {
        // Construir la consulta CREATE TABLE con las columnas
        $columnsDefinition = implode(', ', $columns);
        $sql = "CREATE TABLE IF NOT EXISTS $tableName ($columnsDefinition)";

        return $this->executeSql($sql);
    }

    /**
     * Agrega una columna a una tabla existente.
     *
     * @param string $tableName Nombre de la tabla.
     * @param string $columnName Nombre de la columna a agregar.
     * @param string $columnDefinition Definición de la columna.
     * @return bool True si la columna se agrega con éxito, de lo contrario, false.
     */
    protected function addColumn($tableName, $columnName, $columnDefinition)
    {
        $sql = "ALTER TABLE $tableName ADD COLUMN $columnName $columnDefinition";

        return $this->executeSql($sql);
    }
}
