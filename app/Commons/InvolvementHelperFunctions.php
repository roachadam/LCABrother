<?php

namespace App\Commons;

use App\Involvement;
use Illuminate\Database\Eloquent\Collection;

class InvolvementHelperFunctions
{
    public static function getExistingLogs($test): Collection
    {
        return $test ? (Involvement::where('organization_id', auth()->user()->organization_id)->get()) : auth()->user()->organization->involvement;
    }

    public static function checkIfInvolvementEventExists($attributes): Collection
    {
        return auth()->user()->organization->involvement->filter(function ($involvement) use ($attributes) {
            return $involvement['name'] === $attributes['name'];
        });
    }
}
