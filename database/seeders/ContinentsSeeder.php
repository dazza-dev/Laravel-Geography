<?php

namespace Database\Seeders;

use DazzaDev\Geography\Models\Continent;
use DazzaDev\Geography\Models\ContinentLocale;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContinentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $continents = jsonFileToArray('database/data/continents.json');
        $locales = getLocalesFromDirectory('database/data/locale/continents');

        // Truncate Tables
        $this->truncateTables();
        Continent::insert($continents);

        // Map Continents Locales
        $continentsMap = Continent::pluck('id', 'code')->toArray();
        $localesWithIds = array_map(function ($locale) use ($continentsMap) {
            return [
                'continent_id' => $continentsMap[$locale['parent_code']],
                'name' => $locale['name'],
                'alias' => $locale['alias'],
                'abbr' => $locale['abbr'],
                'full_name' => $locale['full_name'],
                'locale' => $locale['locale'],
            ];
        }, $locales);

        // Insert locales
        ContinentLocale::insert($localesWithIds);

        $this->command->info('Continents data seeded successfully.');
    }

    private function truncateTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('continents_locale')->truncate();
        DB::table('continents')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
