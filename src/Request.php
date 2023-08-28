<?php

/**
 * Lumina Framework
 *
 * Este archivo es parte del Lumina Framework desarrollado para crear aplicaciones web robustas y escalables.
 *
 * @package     Lumina
 * @version     1.0.0
 * @author      IDEAMOS TU WEB
 */

namespace Lumina;

/**
 * Clase Request
 *
 * Representa una solicitud entrante del cliente.
 *
 * @package     Lumina
 * @since       1.0.0
 */
class Request
{
    /**
     * @var array Almacena los parámetros de la ruta.
     */
    private array $routeParams = [];

    /**
     * Obtiene el método HTTP de la solicitud (GET, POST, etc.).
     *
     * @return string Método HTTP de la solicitud.
     */
    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Obtiene la URL solicitada.
     *
     * @return string URL solicitada.
     */
    public function getUrl()
    {
        $path = $_SERVER['REQUEST_URI'];
        $pos = strpos($path, '?');
        if ($pos !== false) {
            $path = substr($path, 0, $pos);
        }
        return $path;
    }

    /**
     * Establece los parámetros de la ruta.
     *
     * @param array $name Parámetros de la ruta.
     * @return Request Instancia de la clase Request.
     */
    public function setRouteParams($name)
    {
        $this->routeParams = $name;
        return $this;
    }

    /**
     * Obtiene los parámetros de la ruta.
     *
     * @return array Parámetros de la ruta.
     */
    public function getRouteParams()
    {
        return $this->routeParams;
    }

    /**
     * Obtiene un parámetro específico de la ruta.
     *
     * @param string $name Nombre del parámetro.
     * @param mixed $default Valor predeterminado si el parámetro no está presente.
     * @return mixed Valor del parámetro o el valor predeterminado.
     */
    public function getRouteParam($name, $default = null)
    {
        return $this->routeParams[$name] ?? $default;
    }

    /**
     * Verifica si la solicitud es de tipo POST.
     *
     * @return bool True si la solicitud es POST, false en caso contrario.
     */
    public function isPost()
    {
        return $this->getMethod() === 'POST';
    }

    /**
     * Verifica si la solicitud es de tipo GET.
     *
     * @return bool True si la solicitud es GET, false en caso contrario.
     */
    public function isGet()
    {
        return $this->getMethod() === 'GET';
    }

    /**
     * Obtiene los datos de la solicitud (GET o POST) filtrados y sanitizados.
     *
     * @return array Datos de la solicitud filtrados.
     */
    public function getBody()
    {
        $data = [];
        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->isPost()) {
            foreach ($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }
}
