<?php

namespace DazzaDev\Geography\Models;

use Illuminate\Database\Eloquent\Model;

class CityLocale extends Model
{
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     */
    protected $table = 'cities_locale';

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
