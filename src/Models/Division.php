<?php

namespace DazzaDev\Geography\Models;

use DazzaDev\Geography\Traits\LocaleTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use LocaleTrait;

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * append names
     *
     * @var array
     */
    protected $appends = [
        'local_name',
        'local_full_name',
        'local_alias',
        'local_abbr',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function children()
    {
        return $this->cities;
    }

    public function parent()
    {
        return $this->country;
    }

    public function locales()
    {
        return $this->hasMany(DivisionLocale::class);
    }

    /**
     * Get Division by name
     */
    public static function getByName(string $name)
    {
        $localized = DivisionLocale::whereName($name)->first();
        if (is_null($localized)) {
            return $localized;
        }

        return $localized->region;
    }

    /**
     * Search Division by name
     */
    public static function searchByName(string $name): Collection
    {
        return DivisionLocale::where('name', 'like', '%'.$name.'%')
            ->get()->map(function ($item) {
                return $item->division;
            });
    }
}
