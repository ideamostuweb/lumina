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
 * Clase Router
 *
 * Maneja el enrutamiento de la aplicación, mapeando las URLs a controladores y acciones.
 *
 * @package     Lumina
 * @since       1.0.0
 */
class Router
{
    /**
     * @var Request Objeto Request que representa la solicitud entrante.
     */
    private Request $request;

    /**
     * @var Response Objeto Response para manejar la respuesta de la solicitud.
     */
    private Response $response;

    /**
     * @var array Arreglo de rutas definidas en la aplicación.
     */
    private array $routeMap = [];

    /**
     * Constructor de la clase Router.
     *
     * @param Request $request Objeto Request que representa la solicitud entrante.
     * @param Response $response Objeto Response para manejar la respuesta de la solicitud.
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Registra una ruta para solicitudes GET en el enrutador.
     *
     * @param string $path URL de la ruta.
     * @param string $controller Controlador a ejecutar.
     * @param string $action Acción del controlador.
     * @return void
     */
    public function get($path, $controller, $action)
    {
        $this->registerRoute($path, $controller, $action, 'GET');
    }

    /**
     * Registra una ruta para solicitudes POST en el enrutador.
     *
     * @param string $path URL de la ruta.
     * @param string $controller Controlador a ejecutar.
     * @param string $action Acción del controlador.
     * @return void
     */
    public function post($path, $controller, $action)
    {
        $this->registerRoute($path, $controller, $action, 'POST');
    }

    /**
     * Registra una ruta en el enrutador.
     *
     * @param string $path URL de la ruta.
     * @param string $controller Controlador a ejecutar.
     * @param string $action Acción del controlador.
     * @param string $method Método HTTP de la ruta.
     * @return void
     */
    public function registerRoute($path, $controller, $action, $method)
    {
        $this->routeMap[$method][$path] = [
            'controller' => $controller,
            'action' => $action,
        ];
    }

    /**
     * Resuelve una URL y ejecuta el controlador y la acción correspondiente.
     *
     * @return void
     */
    public function resolve()
    {
        $url = $this->request->getUrl();
        $method = $this->request->getMethod();

        $route = $this->routeMap[$method][$url] ?? null;

        if ($route) {
            $callback = $this->getCallback($route['controller'], $route['action']);

            if ($callback) {
                call_user_func($callback);
            } else {
                // Manejo de controlador o acción no encontrados...
            }
        } else {
            // Manejo de ruta no encontrada...
        }
    }

    /**
     * Obtiene el callback para el controlador y la acción correspondientes.
     *
     * @return callable|null Callback del controlador y la acción, o null si no se encuentra la ruta.
     */
    protected function getCallback()
    {
        $method = $this->request->getMethod();
        $url = $this->request->getUrl();

        // Trim slashes from the URL
        $url = trim($url, '/');

        // Get all routes for the current request method
        $routes = $this->routeMap[$method] ?? [];

        // Start iterating over registered routes
        foreach ($routes as $route => $callback) {
            // Trim slashes from the route
            $route = trim($route, '/');
            $routeNames = [];

            if (!$route) {
                continue;
            }

            // Find all route names from the route and save them in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }

            // Convert route name into regex pattern
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', function ($m) {
                return isset($m[2]) ? "({$m[2]})" : '(\w+)';
            }, $route) . "$@";

            // Test and match the current route against $routeRegex
            if (preg_match_all($routeRegex, $url, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);

                // Set the route parameters in the Request object
                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }

        return null; // No matching route found
    }

    /**
     * Renderiza una vista utilizando el manejador de vistas de la aplicación.
     *
     * @param string $view Nombre de la vista a renderizar.
     * @param array $params Datos para pasar a la vista.
     * @return string Contenido renderizado de la vista.
     */
    public function renderView($view, $params = []): string
    {
        // Utiliza el manejador de vistas de la aplicación para renderizar la vista
        return Application::$app->view->renderView($view, $params);
    }
}
