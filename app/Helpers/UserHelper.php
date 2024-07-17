<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Issue;

class UserHelper
{
    public static function getLeaderPosition($leaderId)
    {
        $leader = User::find($leaderId);

        if (!$leader) {
            return null; 
        }

        return $leader->leader_id;
    }

    public static function findMatchingUserId($userId, $role, $position, $category_id)
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
                $query->where('category_id', $category_id);
                break;
            case 9:
                $query->where('country', $sampleUser->country);
                break;
        }

        $matchingUser = $query->first();

        return $matchingUser ? $matchingUser->id : null;
    }

    public static function findMatchingByUserLocation($country, $region, $ward, $street, $role, $position, $category_id)
    {
        
        $query = User::where('role', $role)
                     ->where('leader_id', $position);

        switch ($position) {
            case 1:
                $query->where('country', $country)
                      ->where('region', $region)
                      ->where('ward', $ward)
                      ->where('street', $street);
                break;
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
                $query->where('country', $country)
                      ->where('region', $region)
                      ->where('ward', $ward);
                break;
            case 7:
                $query->where('category_id', $category_id);
                break;
            case 9:
                $query->where('country', $country);
                break;
        }

        $matchingUser = $query->first();

        return $matchingUser ? $matchingUser->id : null;
    }

    public static function findMatchingIssuesForLeader($leaderId)
    {
        
        $matchingIssueIds = [];
        $leaderRole = 'leader';
        $leaderPosition = self::getLeaderPosition($leaderId);
        $issues = Issue::all();
        foreach ($issues as $issue) {
            $matchingUserId = self::findMatchingUserId($issue->user_id, $leaderRole, $leaderPosition, $issue->category_id);

            if ($matchingUserId == $leaderId) {
                $matchingIssueIds[] = $issue->id;
            }
        }

        return $matchingIssueIds;
    }

}
