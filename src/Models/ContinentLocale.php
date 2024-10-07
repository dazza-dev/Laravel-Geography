<?php

namespace DazzaDev\Geography\Models;

use Illuminate\Database\Eloquent\Model;

class ContinentLocale extends Model
{
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     */
    protected $table = 'continents_locale';

    public function continent()
    {
        return $this->belongsTo(Continent::class);
    }
}
