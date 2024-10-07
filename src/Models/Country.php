<?php

namespace DazzaDev\Geography\Models;

use DazzaDev\Geography\Traits\LocaleTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use LocaleTrait;

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = [
        'has_division' => 'boolean',
    ];

    /**
     * @var array
     */
    protected $appends = [
        'local_name',
        'local_full_name',
        'local_alias',
        'local_abbr',
        'local_currency_name',
    ];

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function continent()
    {
        return $this->belongsTo(Continent::class);
    }

    public function children()
    {
        if ($this->has_division == true) {
            return $this->divisions;
        }

        return $this->cities;
    }

    public function parent()
    {
        return $this->continent;
    }

    public function locales()
    {
        return $this->hasMany(CountryLocale::class);
    }

    /**
     * Get alias of locale
     */
    public function getLocalCurrencyNameAttribute(): string
    {
        if ($this->locale == $this->defaultLocale) {
            return $this->currency_name;
        }
        $localized = $this->getLocalized();
        if (! is_null($localized)) {
            return ! is_null($localized->currency_name) ? $localized->currency_name : $this->currency_name;
        }

        return $this->currency_name;
    }

    /**
     * Get country by name
     */
    public static function getByName(string $name)
    {
        $localized = CountryLocale::whereName($name)->first();
        if (is_null($localized)) {
            return $localized;
        }

        return $localized->country;
    }

    /**
     * Search country by name
     */
    public static function searchByName(string $name): Collection
    {
        return CountryLocale::where('name', 'like', '%'.$name.'%')
            ->get()->map(function ($item) {
                return $item->country;
            });
    }
}
