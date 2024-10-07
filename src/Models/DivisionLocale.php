<?php

namespace DazzaDev\Geography\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionLocale extends Model
{
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;

    /**
     * The database table used by the model.
     */
    protected $table = 'divisions_locale';

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
