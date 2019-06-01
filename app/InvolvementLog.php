<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvolvementLog extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($InvolvementLog)
        {
            session()->put('success', 'Successfully added involvement logs!');
            return back();
        });
    }

    public function involvement(){
        return $this->belongsTo(Involvement::class);
    }
}
