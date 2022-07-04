<?php

namespace Cli;

use App\Database\DBManager;
use App\Service\ClassLookup;
use Exception;

class CliDB implements CliCommand
{
    public static function init()
    {
        $entities = self::getEntityClasses();
        $manager = new DBManager();

        try {
            $manager->createTables($entities)
                ->then(function (array $result) {
                    echo "Tables processed:\n";
                    foreach ($result as $message) {
                        echo $message . "\n";
                    }
                });

            $manager->createRelationTables($entities)
                ->then(function () {
                    echo "Relational table created.\n";
                });
        } catch (Exception $e) {
            echo CliColor::colorize($e->getMessage(), CliColor::RED);
            exit(1);
        }

    }

    // Find all classes in the entity folder
    protected static function getEntityClasses(): array
    {
        $entities = ClassLookup::findClassesInFolder(__DIR__ . '/../src/Entity');
        $noAbstractEntities = array_filter($entities, function ($entity) {
            return !preg_match('/Abstract/', $entity);
        });

        return $noAbstractEntities;
    }

    public static function getDescription(): string
    {
        return self::class . ' is used to do basic interactions with the database. Supports "init".';
    }

    public static function getCommandDescription(string $commandName): string
    {
        return match($commandName) {
            'init' => 'Initializes database with basic database structure',
            default => 'Unknown command'
        };
    }
}