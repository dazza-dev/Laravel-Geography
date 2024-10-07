<?php

namespace DazzaDev\Geography\Models;

use DateTime;
use DateTimeZone;
use DazzaDev\Geography\Traits\LocaleTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use LocaleTrait;

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * append names.
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

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function children()
    {
        return null;
    }

    public function parent()
    {
        if ($this->division_id === null) {
            return $this->country;
        }

        return $this->division;
    }

    public function locales()
    {
        return $this->hasMany(CityLocale::class);
    }

    /**
     * Get timezone abbreviation.
     */
    public static function timezoneAbbrev(string $ianaTimezone): string
    {
        if (empty($ianaTimezone)) {
            return '';
        }
        if (! in_array($ianaTimezone, timezone_identifiers_list(), true)) {
            return '';
        }

        $dateTime = new DateTime;
        $dateTime->setTimeZone(new DateTimeZone($ianaTimezone));

        return $dateTime->format('T');
    }

    /**
     * Get GMT timezone offset.
     */
    public static function timezoneOffset(string $ianaTimezone): string
    {
        if (empty($ianaTimezone)) {
            return '';
        }
        if (! in_array($ianaTimezone, timezone_identifiers_list(), true)) {
            return '';
        }

        $dateTimeZone = new DateTimeZone($ianaTimezone);
        $timeInCity = new DateTime('now', $dateTimeZone);
        $offset = $dateTimeZone->getOffset($timeInCity) / 3600;

        return 'GMT'.($offset < 0 ? $offset : '+'.$offset);
    }

    /**
     * Get City by name.
     */
    public static function getByName(string $name): Collection
    {
        $locale = CityLocale::whereName($name)->first();
        if (is_null($locale)) {
            return $locale;
        }

        return $locale->city;
    }

    /**
     * Search City by name.
     */
    public static function searchByName(string $name): Collection
    {
        return CityLocale::where('name', 'like', '%'.$name.'%')
            ->get()->map(function ($item) {
                return $item->city;
            });
    }
}
