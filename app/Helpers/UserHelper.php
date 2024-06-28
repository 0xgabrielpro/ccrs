<?php

namespace App\Helpers;

use App\Models\User;

class UserHelper
{
    public static function findMatchingUserId($userId, $role, $position)
    {
        $sampleUser = User::findOrFail($userId);

        $query = User::where('role', $role)
                     ->where('leader_id', $position);

        switch ($position) {
            case 1:
                $query->where('country', $sampleUser->country)
                      ->where('region', $sampleUser->region)
                      ->where('ward', $sampleUser->ward)
                      ->where('street', $sampleUser->street);
                break;
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
                $query->where('country', $sampleUser->country)
                      ->where('region', $sampleUser->region)
                      ->where('ward', $sampleUser->ward);
                break;
            case 7:
                $query->where('country', $sampleUser->country)
                      ->where('region', $sampleUser->region);
                break;
            case 9:
                $query->where('country', $sampleUser->country);
                break;
        }

        $matchingUser = $query->first();

        return $matchingUser ? $matchingUser->id : null;
    }
}
