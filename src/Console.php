<?php

/**
 * Lumina Framework
 *
 * Este archivo es parte del Lumina Framework desarrollado para crear aplicaciones web robustas y escalables.
 *
 * @package     Lumina
 * @subpackage  Commands
 * @version     1.2.0
 * @author      IDEAMOS TU WEB Agencia Digital <hola@ideamostuweb.com>
 * @link        https://github.com/ideamostuweb/lumina
 */

namespace Lumina;

use Symfony\Component\Console\Application as App;
use Lumina\Commands\MigrateCommand;

/**
 * Clase Console
 *
 * Clase para definir y ejecutar comandos de consola en el Lumina Framework.
 *
 * @package     Lumina
 * @since       1.0.0
 */
class Console extends App
{
    /**
     * Constructor de la clase Console.
     */
    public function __construct()
    {
        parent::__construct('Lumina Framework', '1.0.2');

        // Agrega tus comandos personalizados aquí
        $this->add(new MigrateCommand());
        // Puedes agregar más comandos aquí
    }
}
