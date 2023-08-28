<?php

/**
 * Lumina Framework
 *
 * Este archivo es parte del Lumina Framework desarrollado para crear aplicaciones web robustas y escalables.
 *
 * @package     Lumina
 * @version     1.0.0
 * @link        https://github.com/ideamostuweb/lumina
 */

namespace Lumina;

/**
 * Clase Controller
 *
 * Clase base para todos los controladores en el Lumina Framework.
 *
 * @package     Lumina
 * @since       1.0.0
 */
class Controller
{
    /**
     * @var string Layout predeterminado para las vistas de este controlador.
     */
    public string $layout = 'main'; // Puedes personalizar el layout predeterminado aquí

    /**
     * @var string Acción actual del controlador.
     */
    public string $action = ''; // Puedes establecer la acción en tus controladores derivados

    /**
     * Establece el layout a utilizar para las vistas de este controlador.
     *
     * @param string $layout Nombre del layout a establecer.
     * @return void
     */
    public function setLayout($layout): void
    {
        $this->layout = $layout;
    }

    /**
     * Renderiza una vista utilizando el manejador de vistas del controlador.
     *
     * @param string $view Nombre de la vista a renderizar.
     * @param array $params Datos para pasar a la vista.
     * @return string Contenido renderizado de la vista.
     */
    public function render($view, $params = []): string
    {
        // Utiliza el manejador de vistas del controlador para renderizar la vista
        return Application::$app->view->renderView($view, $params);
    }
}
