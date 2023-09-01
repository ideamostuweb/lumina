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
    private string $layout = 'main';
    private string $viewPath = '';
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
        include_once Application::$ROOT_DIR . $viewPath . $layoutName . ".php";
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
        include_once Application::$ROOT_DIR . "/Views/$view.php";
        return ob_get_clean();
    }

    /**
     * Establece el nombre del layout para las vistas.
     *
     * @param string $layout Nombre del layout.
     * @return void
     */
    public function setLayout(string $layout): void
    {
        $this->layout = $layout;
    }

    /**
     * Establece la ruta base para las vistas.
     *
     * @param string $path Ruta base para las vistas.
     * @return void
     */
    public function setViewPath(string $path): void
    {
        $this->viewPath = rtrim($path, '/');
    }
}
