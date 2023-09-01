<?php

/**
 * Lumina Framework
 *
 * Este archivo es parte del Lumina Framework desarrollado para crear aplicaciones web robustas y escalables.
 *
 * @package     Lumina\Commands
 * @subpackage  Commands
 * @version     1.1.2
 * @author      IDEAMOS TU WEB Agencia Digital <hola@ideamostuweb.com>
 * @link        https://github.com/ideamostuweb/lumina
 */

namespace Lumina\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Clase MigrateCommand
 *
 * Comando de consola para ejecutar las migraciones de la base de datos.
 *
 * @package     Lumina\Commands
 * @subpackage  Commands
 * @version     1.1.2
 */
class MigrateCommand extends Command
{
    protected static $defaultName = 'create-migration';

    protected function configure()
    {
        // Descripción del comando que se muestra al usar "--help"
        $this->setDescription('Create a new database migration');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Lógica para crear una nueva migración
        $migrationName = 'migration_' . date('YmdHis');
        $migrationFileName = 'migrations/' . $migrationName . '.php';

        // Leer el contenido de la plantilla de migración
        $template = file_get_contents(__DIR__ . '/../Templates/migration_template.php');

        // Reemplazar el marcador {{MigrationName}} con el nombre de la migración
        $template = str_replace('{{MigrationName}}', $migrationName, $template);

        // Intentar guardar el archivo de migración
        if (file_put_contents($migrationFileName, $template)) {
            // Imprimir mensaje de éxito
            $output->writeln("Migration created: $migrationFileName");
            return Command::SUCCESS;
        } else {
            // Imprimir mensaje de error si falla
            $output->writeln('Failed to create migration.');
            return Command::FAILURE;
        }
    }
}
