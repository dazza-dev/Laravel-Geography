<?php

namespace Database\Seeders;

use App\Models\Continent;
use DazzaDev\Geography\Models\Country;
use DazzaDev\Geography\Models\CountryLocale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = jsonFileToArray('database/data/countries.json');
        $locales = getLocalesFromDirectory('database/data/locale/countries');

        // Map Countries
        $continentsMap = Continent::pluck('id', 'code')->toArray();
        $countriesWithIds = array_map(function ($country) use ($continentsMap) {
            return [
                'continent_id' => $continentsMap[$country['continent_code']],
                'name' => $country['name'],
                'full_name' => $country['full_name'],
                'capital' => $country['capital'],
                'code' => $country['code'],
                'code_alpha3' => $country['code_alpha3'],
                'code_numeric' => $country['code_numeric'],
                'emoji' => $country['emoji'],
                'has_division' => $country['has_division'],
                'currency_code' => $country['currency_code'],
                'currency_name' => $country['currency_name'],
                'tld' => $country['tld'],
                'calling_code' => $country['calling_code'],
            ];
        }, $countries);

        // Map Countries Locales
        $countriesMap = Country::pluck('id', 'code')->toArray();
        $localesWithIds = array_map(function ($locale) use ($countriesMap) {
            return [
                'country_id' => $countriesMap[$locale['country_code']],
                'name' => $locale['name'],
                'alias' => $locale['alias'],
                'abbr' => $locale['abbr'],
                'full_name' => $locale['full_name'],
                'currency_name' => $locale['currency_name'],
                'locale' => $locale['locale'],
            ];
        }, $locales);

        // Truncate Tables
        $this->truncateTables();

        // Insert Countries
        Country::insert($countriesWithIds);
        CountryLocale::insert($localesWithIds);

        $this->command->info('Countries data seeded successfully.');
    }

    private function truncateTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('countries_locale')->truncate();
        DB::table('countries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
