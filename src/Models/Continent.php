<?php

namespace DazzaDev\Geography\Models;

use DazzaDev\Geography\Traits\LocaleTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    use LocaleTrait;

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * append names
     */
    protected $appends = [
        'local_name',
        'local_full_name',
        'local_alias',
        'local_abbr',
    ];

    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    public function children()
    {
        return $this->countries;
    }

    public function parent()
    {
        return null;
    }

    public function locales()
    {
        return $this->hasMany(ContinentLocale::class);
    }

    /**
     * Get Continent by name
     */
    public static function getByName(string $name): Collection
    {
        $localized = ContinentLocale::whereName($name)->first();
        if (is_null($localized)) {
            return $localized;
        }

        return $localized->continent;
    }

    /**
     * Search Continent by name
     */
    public static function searchByName(string $name): Collection
    {
        return ContinentLocale::where('name', 'like', '%'.$name.'%')
            ->get()->map(function ($item) {
                return $item->continent;
            });
    }
}
