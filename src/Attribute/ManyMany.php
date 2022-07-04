<?php

namespace App\Attribute;

#[\Attribute]
class ManyMany implements CreatesDatabase
{
    public string $sourceClass;
    public string $targetClass;

    /**
     * @param string $sourceClass
     * @param string $targetClass
     */
    public function __construct(string $sourceClass, string $targetClass)
    {
        $this->sourceClass = $sourceClass;
        $this->targetClass = $targetClass;
    }

    public function getCreateTableSchema(): string
    {
        $sourceKey =  $this->sourceClass .'ID';
        $targetKey = $this->targetClass .'ID';
        $tableName =  $this->sourceClass . '-' . $this->targetClass;
        $constraintName1 = 'fk_' . $tableName . '_' . $sourceKey;
        $constraintName2 = 'fk_' . $tableName . '_' . $targetKey;

        $query = 'CREATE TABLE `' . $tableName . '`(
            ' . $sourceKey .' int not null,
            ' . $targetKey .' int not null,
            PRIMARY KEY('. $sourceKey .', ' . $targetKey . '),
            CONSTRAINT ' . $constraintName1 . ' FOREIGN KEY (' . $sourceKey . ') references ' . $this->sourceClass . ' (id),
            CONSTRAINT ' . $constraintName2 . ' FOREIGN KEY (' . $targetKey . ') references ' . $this->targetClass . ' (id)
        )';

        return $query;
    }
}