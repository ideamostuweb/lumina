<?php

/**
 * Lumina Framework
 *
 * Este archivo es parte del Lumina Framework desarrollado para crear aplicaciones web robustas y escalables.
 *
 * @package     Lumina
 * @subpackage  Exception
 * @version     1.0.0
 * @author      IDEAMOS TU WEB <hola@ideamostuwe.com>
 * @link        https://github.com/ideamostuweb/lumina
 */

namespace Lumina;

/**
 * Clase ForbiddenException
 *
 * Excepción personalizada para acceso no autorizado (403).
 *
 * @package     Lumina
 * @since       1.0.0
 */
class ForbiddenException extends \Exception
{
    /**
     * Constructor de la excepción.
     *
     * @param string $message Mensaje de error de la excepción.
     * @param int $code Código de error de la excepción.
     * @param \Throwable|null $previous Excepción anterior en cadena (si es aplicable).
     */
    public function __construct($message = "Acceso no autorizado", $code = 403, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
