<?php

namespace DazzaDev\Geography\Models;

use Illuminate\Database\Eloquent\Model;

class CountryLocale extends Model
{
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     */
    protected $table = 'countries_locale';

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
