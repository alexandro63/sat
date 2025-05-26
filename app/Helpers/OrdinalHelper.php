<?php

namespace App\Helpers;

class OrdinalHelper
{
    public static function str_ordinal($value, $superscript = false)
    {
        $number = abs((int)$value);
        $suffixes = [
            1 => 'ro',
            2 => 'do',
            3 => 'ro',
            4 => 'to',
            5 => 'to',
            6 => 'to',
            7 => 'mo',
            8 => 'vo',
            9 => 'no',
            0 => 'mo',
        ];

        $lastDigit = $number % 10;
        $suffix = $suffixes[$lastDigit] ?? 'mo';

        // Excepciones del 11 al 13
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            $suffix = 'avo';
        }

        // Aplicar como superíndice si se desea
        $suffix = $superscript ? '<sup>' . $suffix . '</sup>' : $suffix;

        return $number . $suffix;
    }
}
