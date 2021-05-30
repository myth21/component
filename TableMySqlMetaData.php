<?php

namespace component;

class TableMySqlMetaData
{
    protected string $tableName;

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
    }

    public function getStatusSqlRaw(): string
    {
        return 'SHOW TABLE STATUS WHERE name = "'.$this->tableName.'";';
    }

    public function getColumnSqlRaw(string $columnName): string
    {
        return 'SHOW FULL COLUMNS FROM '.$this->tableName.' WHERE Field = "'.$columnName.'";';
    }


}