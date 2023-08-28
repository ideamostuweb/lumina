<?php

/**
 * Lumina Framework
 *
 * Este archivo es parte del Lumina Framework desarrollado para crear aplicaciones web robustas y escalables.
 *
 * @package     Lumina
 * @version     1.1.0
 * @author      IDEAMOS TU WEB
 */

namespace Lumina;

/**
 * Clase View
 *
 * Maneja la representación de las vistas en la aplicación.
 *
 * @package     Lumina
 * @since       1.0.0
 */
class View
{
    /**
     * Renderiza una vista y la incrusta en un layout.
     *
     * @param string $view Nombre de la vista a renderizar.
     * @param array $params Datos para pasar a la vista.
     * @return string Contenido renderizado.
     */
    public function renderView($view, array $params = []): string
    {
        $layoutName = Application::$app->controller ? Application::$app->controller->layout : Application::$app->layout;
        $viewContent = $this->renderViewOnly($view, $params);

        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layoutName.php";
        $layoutContent = ob_get_clean();

        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Renderiza solo la vista.
     *
     * @param string $view Nombre de la vista a renderizar.
     * @param array $params Datos para pasar a la vista.
     * @return string Contenido renderizado de la vista.
     */
    public function renderViewOnly($view, array $params = []): string
    {
        extract($params);

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}
