<?php

/**
 * Lumina Framework
 *
 * Este archivo es parte del Lumina Framework desarrollado para crear aplicaciones web robustas y escalables.
 *
 * @package     Lumina
 * @subpackage  Exception
 * @version     1.1.0
 * @author      IDEAMOS TU WEB <hola@ideamostuwe.com>
 * @link        https://github.com/ideamostuweb/lumina
 */

namespace Lumina\Exception;

/**
 * Clase NotFoundException
 *
 * Excepción personalizada para recursos no encontrados (404).
 *
 * @package     Lumina
 * @since       1.0.0
 */
class NotFoundException extends \Exception
{
    /**
     * Constructor de la excepción.
     *
     * @param string $message Mensaje de error de la excepción.
     * @param int $code Código de error de la excepción.
     * @param \Throwable|null $previous Excepción anterior en cadena (si es aplicable).
     */
    public function __construct($message = "Página no encontrada", $code = 404, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
