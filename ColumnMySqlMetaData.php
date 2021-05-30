<?php

namespace component;

class ColumnMySqlMetaData
{
    /**
     * Try to parse mysql enum string like this: enum('first', 'second')
     * @param string $enumString
     * @return array ['first' => 'first', 'second' => 'second']
     */
    public static function parseEnums(string $enumString): array
    {
        preg_match("/^enum\(\'(.*)\'\)$/", $enumString, $matches);

        if (!$matches) {
            return [];
        }

        $enums = explode("','", $matches[1]);

        return array_combine($enums, $enums);
    }

    /**
     * Try to parse mysql type id string like this: varchar(255)
     * @param string $typeIdString
     * @return null|int, for example 255
     */
    public static function parseTypeNumberValue(string $typeIdString): ?int
    {
        preg_match("/([0-9]+)/", $typeIdString, $matches);
        if (!$matches || !is_numeric($matches[1])) {
            return null;
        }

        return (int)$matches[1];
    }

}