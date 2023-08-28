<?php

/**
 * Lumina Framework
 *
 * Este archivo es parte del Lumina Framework desarrollado para crear aplicaciones web robustas y escalables.
 *
 * @package     Lumina
 * @subpackage  PDO
 * @version     1.0.0
 * @author      IDEAMOS TU WEB <hola@ideamostuweb.com>
 * @link        https://github.com/ideamostuweb/lumina
 */

namespace Lumina\PDO;

/**
 * Clase Database
 *
 * Administra la conexión a la base de datos utilizando PDO.
 *
 * @package     Lumina
 * @subpackage  PDO
 * @since       1.0.0
 */
class Database
{
    /**
     * @var \PDO|null Instancia de la conexión a la base de datos.
     */
    private static ?\PDO $connection = null;

    /**
     * Obtiene la instancia de la conexión a la base de datos utilizando el patrón Singleton.
     *
     * @param array $dbConfig Configuración de la base de datos (opcional).
     * @return \PDO Instancia de la conexión a la base de datos.
     */
    public static function getInstance(array $dbConfig = []): \PDO
    {
        // Obtén la configuración de la base de datos de $dbConfig
        $dbDsn = $dbConfig['dsn'] ?? '';
        $username = $dbConfig['user'] ?? '';
        $password = $dbConfig['password'] ?? '';

        if (self::$connection === null) {
            self::$connection = new \PDO($dbDsn, $username, $password);
            self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
}
