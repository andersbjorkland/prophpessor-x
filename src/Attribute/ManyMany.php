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
        $sourceKeyString =  '`' . $sourceKey .'`';

        $targetKey = $this->targetClass .'ID';
        $targetKeyString = '`' . $targetKey .'`';

        $tableName =  $this->sourceClass . '-' . $this->targetClass;
        $tableNameString =  '`' . $tableName . '`';

        $constraintName1 = '`fk_' . $tableName . '_' . $sourceKey . '`';
        $constraintName2 = '`fk_' . $tableName . '_' . $targetKey . '`';

        $query = 'CREATE TABLE ' . $tableNameString . '('
            . $sourceKeyString .' int UNSIGNED not null,'
            . $targetKeyString .' int UNSIGNED not null,'
            . ' PRIMARY KEY('. $sourceKeyString .', ' . $targetKeyString . '),'
            . ' CONSTRAINT ' . $constraintName1 . ' FOREIGN KEY (' . $sourceKeyString . ') references `' . $this->sourceClass . '` (id),'
            . ' CONSTRAINT ' . $constraintName2 . ' FOREIGN KEY (' . $targetKeyString . ') references `' . $this->targetClass . '` (id)'
            . ')';

        return $query;
    }
}