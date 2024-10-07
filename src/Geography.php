<?php

namespace DazzaDev\Geography;

use DazzaDev\Geography\Exceptions\InvalidCodeException;
use DazzaDev\Geography\Models\City;
use DazzaDev\Geography\Models\Continent;
use DazzaDev\Geography\Models\Country;
use DazzaDev\Geography\Models\Division;

class Geography
{
    public static function continents()
    {
        return Continent::orderBy('name', 'asc')->get();
    }

    public static function countries()
    {
        return Country::orderBy('name', 'asc')->get();
    }

    public static function getContinentByCode(string $code)
    {
        return Continent::getByCode($code);
    }

    public static function getCountryByCode(string $code)
    {
        return Country::getByCode($code);
    }

    public static function getByCode(string $code)
    {
        $code = strtolower($code);
        $countryCode = null;

        // Check if code has a separator
        if (strpos($code, '-')) {
            [$countryCode, $code] = explode('-', $code);
        } else {
            return self::getCountryByCode($code);
        }

        // Get country by code
        $country = self::getCountryByCode($countryCode);
        $model = $country->has_division ? Division::class : City::class;

        // Search division or city
        $result = $model::where([
            ['country_id', $country->id],
            ['code', $code],
        ])->first();

        if (is_null($result)) {
            throw new InvalidCodeException('Code is invalid');
        }

        return $result;
    }
}
