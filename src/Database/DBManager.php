<?php

declare(strict_types=1);

namespace App\Database;

use App\Attribute\EntityAttribute;
use App\Attribute\ManyMany;
use App\Attribute\NullableAttribute;
use App\Attribute\PrimaryKey;
use Cli\CliColor;
use React\MySQL\ConnectionInterface;
use React\MySQL\Exception;
use React\MySQL\QueryResult;
use React\Promise\PromiseInterface;
use function React\Promise\all;

class DBManager
{
    private ConnectionInterface $db;

    public function __construct()
    {
        $this->db = (new DBConnection())->getDb();
    }

    public function getDb(): ConnectionInterface
    {
        return $this->db;
    }

    // Get classname and attributeReflection from class
    public function getSchema(string $class): array
    {
        $reflectionClass = new \ReflectionClass($class);
        $properties = $reflectionClass->getProperties();
        $propertyAttributes = [];

        foreach ($properties as $property) {
            $attributes = $property->getAttributes(EntityAttribute::class, \ReflectionAttribute::IS_INSTANCEOF);
            foreach ($attributes as $attribute) {
                $attributeInstance = $attribute->newInstance();
                $attributeName = $attribute->getName();
                $propertyAttributes[$property->getName()] = [
                    "type" => $attributeName,
                    "instance" => $attributeInstance
                ];
                break;
            }
        }

        $attributes = $propertyAttributes;
        $className = $reflectionClass->getShortName();
        $schema = [
            'className' => $className,
            'attributes' => $attributes
        ];
        return $schema;
    }

    public function createTables(array $classes): PromiseInterface
    {
        $promises = [];
        $count = count($classes);
        echo "Handling $count classes\n";
        foreach ($classes as $class) {
            $promises[] = $this->createTable($class)->then(
                function (QueryResult $result) use ($class, $count) {
                    return $result->warningCount > 0 ?
                        CliColor::colorize("Table already exists for $class \n", CliColor::YELLOW) :
                        CliColor::colorize("Successfully created table for $class \n", CliColor::GREEN);
                },
                function (Exception $e) use ($class, $count) {
                    return CliColor::colorize($e->getMessage(), CliColor::RED) . "\n" . $e->getTraceAsString() . "\n";
                }
            );
        }

        return all($promises);
    }

    public function createRelationTables(array $classes): PromiseInterface
    {
        $promises = [];
        $count = count($classes);
        echo "Handling $count relational classes\n";
        foreach ($classes as $class) {
            $reflectionClass = new \ReflectionClass($class);
            $properties = $reflectionClass->getProperties();
            foreach ($properties as $property) {
                $attributes = $property->getAttributes(ManyMany::class, \ReflectionAttribute::IS_INSTANCEOF);

                foreach ($attributes as $attributeName => $attribute) {
                    /** @var ManyMany $attributeInstance */
                    $attributeInstance = $attribute->newInstance();
                    $promises[] = $this->db->query($attributeInstance->getCreateTableSchema())->then(
                        function (QueryResult $result) use ($class, $count) {
                            return $result->warningCount > 0 ?
                                CliColor::colorize("Table already exists for $class \n", CliColor::YELLOW) :
                                CliColor::colorize("Successfully created table for $class \n", CliColor::GREEN);
                        },
                        function (Exception $e) use ($class, $count) {
                            return CliColor::colorize($e->getMessage(), CliColor::RED) . "\n" . $e->getTraceAsString() . "\n";
                        }
                    );
                }
            }
        }

        return all($promises);
    }


    public function createTable(string $class): PromiseInterface
    {
        $query = $this->getCreateTableQuery($class);

        return $this->db->query($query);
    }

    public function getCreateTableQuery(string $class): string
    {
        $schema = $this->getSchema($class);
        $tableName = $schema['className'];
        $attributes = $schema['attributes'];

        $primaryId = array_filter($attributes, function ($attribute) {
            return $attribute['type'] === PrimaryKey::class;
        });
        if (count($primaryId) === 0) {
            throw new \Exception('No primary key found');
        }

        $primaryIdTarget = array_keys($primaryId)[0];
        $primaryIdAttribute = $primaryId[$primaryIdTarget]['instance'];


        $query = 'CREATE TABLE IF NOT EXISTS `' . $tableName . '` (';

        $length = count($attributes);
        $i = 0;
        foreach ($attributes as $attributeName => $attribute) {
            /** @var EntityAttribute $attribute */
            $attribute = $attribute['instance'];

            $nullQuery = '';
            if ($attribute instanceof NullableAttribute) {
                $nullQuery = $attribute->isNullable() ? ' NULL' : ' NOT NULL';
            }

            $query .= '`' . $attributeName . '` ' . $attribute->getType() . $nullQuery . ', ';

            $i++;
        }

        $query .= 'PRIMARY KEY (' . $primaryIdTarget . '))';

        return $query;
    }
}