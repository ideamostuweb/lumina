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
 * Clase Database
 *
 * Administra la conexión y configuración a la base de datos utilizando Medoo.
 *
 * @package     Lumina
 * @subpackage  Database
 * @since       1.2.0
 */
class Database
{
    /**
     * @var Medoo|null Instancia de la conexión a la base de datos utilizando Medoo.
     */
    private static ?Medoo $connection = null;

    /**
     * Obtiene la instancia de la conexión a la base de datos utilizando el patrón Singleton.
     *
     * @return Medoo Instancia de la conexión a la base de datos.
     */
    public static function getConnection(): Medoo
    {
        if (self::$connection === null) {
            // Configuración de la conexión a la base de datos utilizando variables de entorno
            self::$connection = new Medoo([
                'database_type' => getenv('DB_TYPE'),
                'database_name' => getenv('DB_NAME'),
                'server' => getenv('DB_HOST'),
                'username' => getenv('DB_USER'),
                'password' => getenv('DB_PASSWORD'),
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_general_ci',
                'logging' => true, // Habilita el logging de consultas SQL
            ]);
        }
        return self::$connection;
    }
}
