<?php

/**
 * Lumina Framework
 *
 * Este archivo es parte del Lumina Framework desarrollado para crear aplicaciones web robustas y escalables.
 *
 * @package     Lumina
 * @version     1.0.0
 */

namespace Lumina;

/**
 * Clase Response
 *
 * Representa la respuesta que se enviará al cliente.
 *
 * @package     Lumina
 * @since       1.0.0
 */
class Response
{
    /**
     * @var int Código HTTP de la respuesta.
     */
    protected $statusCode = 200;

    /**
     * @var array Cabeceras HTTP de la respuesta.
     */
    protected $headers = [];

    /**
     * @var string Contenido de la respuesta.
     */
    protected $content = '';

    /**
     * Establece el código HTTP de la respuesta.
     *
     * @param int $code Código HTTP.
     * @return Response Instancia del objeto Response.
     */
    public function setStatusCode($code)
    {
        $this->statusCode = $code;
        return $this;
    }

    /**
     * Agrega una cabecera HTTP a la respuesta.
     *
     * @param string $name Nombre de la cabecera.
     * @param string $value Valor de la cabecera.
     * @return Response Instancia del objeto Response.
     */
    public function addHeader($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    /**
     * Establece el contenido de la respuesta.
     *
     * @param string $content Contenido de la respuesta.
     * @return Response Instancia del objeto Response.
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Envia la respuesta al cliente.
     *
     * @return void
     */
    public function send()
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->content;
    }

    /**
     * Redirecciona a una URL dada.
     *
     * @param string $url URL de redirección.
     * @param int $statusCode Código de estado HTTP para la redirección.
     * @return void
     */
    public function redirect($url, $statusCode = 302)
    {
        $this->setStatusCode($statusCode)
            ->addHeader('Location', $url)
            ->send();
        exit;
    }
}
