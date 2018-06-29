<?php

namespace App\Parser;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Serializer\Encoder\CsvEncoder;

/**
 * Class CsvParser
 *
 * @package App\Parser
 */
class CsvParser
{
    /**
     * @param string $filename
     * @return array
     */
    public static function parse(string $filename) : array {
        $content = [];

        $finder = new Finder();
        $finder->in(getenv('FILES_PATH'))->name($filename . '.csv');

        foreach ($finder as $file) {
            $encoder = new CsvEncoder(';');
            $content = $encoder->decode($file->getContents(), 'csv');
        }

        return $content;
    }
}
