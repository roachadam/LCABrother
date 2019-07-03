<?php

namespace App\Commons;

use App\Involvement;
use App\Organization;

class InvolvementHelperFunctions
{
    public static function getExistingLogs()
    {
        $involvements = auth()->user()->organization->involvement;
        return $involvements->filter(function ($involvement) {
            return $involvement['organization_id'] === auth()->user()->organization->id;
        });
    }

    public static function checkIfInvolvementEventExists($attributes)
    {
        $organization = auth()->user()->organization;
        $involvements = $organization->involvement;
        $organizationId = $organization->id;

        return $involvements->filter(function ($involvement) use ($attributes, $organizationId) {
            return $involvement['name'] === $attributes['name'] && $involvement['organization_id'] === $organizationId;
        });
    }
}
