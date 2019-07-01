<?php

namespace App\Commons;


class InvolvementHelperFunctions
{
    public static function checkIfInvolvementEventExists($attributes)
    {
        $involvements = auth()->user()->organization->involvement;
        return $involvements->filter(function ($involvement) use ($attributes) {
            return $involvement['name'] === $attributes['name'] && $involvement['organization_id'] === auth()->user()->organization->id;
        });
    }
}
