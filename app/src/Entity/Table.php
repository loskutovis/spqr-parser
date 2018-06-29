<?php

namespace App\Entity;

use App\Parser\CsvParser;

/**
 * Class Table
 *
 * @package App\Entity
 */
class Table
{
    /**
     * @return array|null
     */
    public static function get() : ?array
    {
        $tables = [];

        $content = CsvParser::parse('tables');

        foreach ($content as $table) {
            $tables[strtolower($table['Table'])] = explode(PHP_EOL, $table['Value']);
        }

        return $tables;
    }
}
