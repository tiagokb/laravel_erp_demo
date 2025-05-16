<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class DateHelper
{
    /*
     * Se a primeira data for maior que a segunda a função vai retornar true caso contrario ira retornar false
     * */
    public static function compareDateString(string $firstDate, string $secondDate, string $dateFormat = 'Y-m-d'): bool
    {
        $first = Carbon::createFromFormat($dateFormat, $firstDate);
        $second = Carbon::createFromFormat($dateFormat, $secondDate);

        return $first->greaterThan($second);
    }
}
