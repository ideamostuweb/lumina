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

namespace Lumina\PDO;

use Lumina\Application;

/**
 * Clase Database
 *
 * Administra la conexión a la base de datos utilizando PDO.
 *
 * @package     Lumina
 * @since       1.0.0
 */
class Database
{
    /**
     * @var \PDO|null Instancia de la conexión a la base de datos.
     */
    private static ?\PDO $pdo = null;

    /**
     * Obtiene la instancia de la conexión a la base de datos utilizando el patrón Singleton.
     *
     * @param array $dbConfig Configuración de la base de datos.
     * @return \PDO Instancia de la conexión a la base de datos.
     */
    public static function getConnection(array $dbConfig = []): \PDO
    {
        $dbDsn = $dbConfig['dsn'] ?? '';
        $username = $dbConfig['user'] ?? '';
        $password = $dbConfig['password'] ?? '';

        if (self::$pdo === null) {
            self::$pdo = new \PDO($dbDsn, $username, $password);
            self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$pdo;
    }

    /**
     * Aplica las migraciones pendientes a la base de datos.
     *
     * @return void
     */
    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $migracionesAplicadas = $this->getMigracionesAplicadas();

        $nuevasMigraciones = [];
        $archivos = scandir(Application::$ROOT_DIR . '/migrations');
        $migracionesPorAplicar = array_diff($archivos, $migracionesAplicadas);
        foreach ($migracionesPorAplicar as $migracion) {
            if ($migracion === '.' || $migracion === '..') {
                continue;
            }

            require_once Application::$ROOT_DIR . '/migrations/' . $migracion;
            $nombreClase = pathinfo($migracion, PATHINFO_FILENAME);
            $instancia = new $nombreClase();
            $this->log("Aplicando migración $migracion");
            $instancia->up();
            $this->log("Migración aplicada $migracion");
            $nuevasMigraciones[] = $migracion;
        }

        if (!empty($nuevasMigraciones)) {
            $this->guardarMigraciones($nuevasMigraciones);
        } else {
            $this->log("No hay migraciones para aplicar");
        }
    }

    /**
     * Crea la tabla de migraciones si no existe.
     *
     * @return void
     */
    protected function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )  ENGINE=INNODB;");
    }

    /**
     * Obtiene las migraciones que ya han sido aplicadas.
     *
     * @return array Lista de migraciones aplicadas.
     */
    protected function getMigracionesAplicadas()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Guarda las migraciones recién aplicadas en la base de datos.
     *
     * @param array $nuevasMigraciones Lista de migraciones recién aplicadas.
     * @return void
     */
    protected function guardarMigraciones(array $nuevasMigraciones)
    {
        $str = implode(',', array_map(fn ($m) => "('$m')", $nuevasMigraciones));
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
            $str
        ");
        $statement->execute();
    }

    /**
     * Prepara una consulta SQL para su ejecución.
     *
     * @param string $sql Consulta SQL.
     * @return \PDOStatement Instancia de \PDOStatement.
     */
    public function prepare($sql): \PDOStatement
    {
        return $this->pdo->prepare($sql);
    }

    /**
     * Registra un mensaje con la fecha y hora actual.
     *
     * @param string $mensaje Mensaje a registrar.
     * @return void
     */
    private function log($mensaje)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $mensaje . PHP_EOL;
    }
}
