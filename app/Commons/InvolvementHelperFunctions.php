<?php

namespace App\Commons;


class InvolvementHelperFunctions
{
    public static function getExistingLogs()
    {
        $involvements = auth()->user()->organization->involvement;
        return $involvements->filter(function ($involvement) {
            return $involvement['organization_id'] === auth()->user()->organization->id;
        });
    }
}
