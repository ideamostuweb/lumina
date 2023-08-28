<?php

/**
 * Lumina Framework
 *
 * Este archivo es parte del Lumina Framework desarrollado para crear aplicaciones web robustas y escalables.
 *
 * @package     Lumina
 * @version     1.1.0
 * @link        https://github.com/ideamostuweb/lumina
 */

namespace Lumina;

/**
 * Clase Application
 *
 * Clase principal que inicializa y maneja la aplicación Lumina.
 *
 * @package     Lumina
 * @since       1.0.0
 */
class Application
{
    // Constantes para los eventos
    const EVENT_BEFORE_REQUEST = 'beforeRequest';
    const EVENT_AFTER_REQUEST = 'afterRequest';

    // Propiedades estáticas para la aplicación y la ruta base
    public static Application $app;
    public static string $ROOT_DIR;

    // Arreglo de listeners de eventos registrados
    protected array $eventListeners = [];

    // Objetos para solicitud, respuesta, enrutador y vista
    public Request $request;
    public Response $response;
    public Router $router;
    public View $view;

    // Controlador actual
    public ?Controller $controller = null;

    // Layout predeterminado para las vistas
    public string $layout = 'main';

    /**
     * Constructor de la clase Application.
     *
     * @param string $rootDir Directorio raíz de la aplicación.
     * @param array $config Configuración de la aplicación (si es necesario).
     */
    public function __construct($rootDir, $config = [])
    {
        self::$ROOT_DIR = $rootDir;
        self::$app = $this;

        // Creación de objetos iniciales
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->view = new View();
    }

    /**
     * Inicia la ejecución de la aplicación.
     *
     * @return void
     */
    public function run()
    {
        // Dispara el evento 'beforeRequest'
        $this->triggerEvent(self::EVENT_BEFORE_REQUEST);

        try {
            // Intenta resolver la ruta y obtener el contenido
            $content = $this->router->resolve();

            // Envía el contenido al navegador
            echo $content;
        } catch (\Exception $e) {
            // En caso de error, renderiza la vista de error
            $errorContent = $this->router->renderView('_error', [
                'exception' => $e,
            ]);

            // Envía el contenido de error al navegador
            echo $errorContent;
        }

        // Dispara el evento 'afterRequest'
        $this->triggerEvent(self::EVENT_AFTER_REQUEST);
    }

    /**
     * Obtiene el manejador de enrutamiento.
     *
     * @return Router Instancia del manejador de enrutamiento.
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * Registra un callback para un evento.
     *
     * @param string $eventName Nombre del evento.
     * @param callable $callback Callback a ejecutar cuando se active el evento.
     * @return void
     */
    public function on($eventName, callable $callback)
    {
        $this->eventListeners[$eventName][] = $callback;
    }

    /**
     * Activa un evento y ejecuta los callbacks registrados.
     *
     * @param string $eventName Nombre del evento a activar.
     * @return void
     */
    public function triggerEvent($eventName)
    {
        $callbacks = $this->eventListeners[$eventName] ?? [];
        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }
    }
}
