<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Issue;
use App\Models\AnonIssue;


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
                $query->where('country_id', $sampleUser->country_id)
                      ->where('region_id', $sampleUser->region_id)
		              ->where('district_id', $sampleUser->district_id)
                      ->where('ward_id', $sampleUser->ward_id)
                      ->where('street_id', $sampleUser->street_id);
                break;
            case 2:
                $query->where('country_id', $sampleUser->country_id)
                      ->where('region_id', $sampleUser->region_id)
                      ->where('district_id', $sampleUser->district_id)
                      ->where('ward', $sampleUser->ward_id);
                break;
	    
            case 3:
            case 4:
            case 5:
                $query->where('country_id', $sampleUser->country_id)
                      ->where('region_id', $sampleUser->region_id)
                      ->where('district_id', $sampleUser->district_id);
                break; 
            case 6:
                $query->where('country_id', $sampleUser->country_id)
                      ->where('region_id', $sampleUser->region_id);
                break;
            case 7:
                $query->where('category_id', $category_id);
                break;
	        case 8:
            case 9:
                $query->where('country_id', $sampleUser->country_id);
                break;
        }

        $matchingUser = $query->first();

        return $matchingUser ? $matchingUser->id : null;
    }

    public static function findMatchingByUserLocation($country_id, $region_id, $district_id, $ward_id, $street_id, $role, $position, $category_id)
    {
        
        $query = User::where('role', $role)
                     ->where('leader_id', $position);

        switch ($position) {
            case 1:
                $query->where('country_id', $country_id)
                      ->where('region_id', $region_id)
		              ->where('district_id', $district_id)
                      ->where('ward_id', $ward_id)
                      ->where('street_id', $street_id);
                break;
            case 2:
                $query->where('country_id', $country_id)
                      ->where('region_id', $region_id)
                      ->where('district_id', $district_id)
                      ->where('ward', $ward_id);
                break;
	    
            case 3:
            case 4:
            case 5:
                $query->where('country_id', $country_id)
                      ->where('region_id', $region_id)
                      ->where('district_id', $district_id);
                break; 
            case 6:
                $query->where('country_id', $country_id)
                      ->where('region_id', $region_id);
                break;
            case 7:
                $query->where('category_id', $category_id);
                break;
	        case 8:
            case 9:
                $query->where('country_id', $country_id);
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

    public static function findMatchingAnonIssuesForLeader($leaderId)
    {
        $matchingAnonIssueIds = [];
        $leaderRole = 'leader';
        $leaderPosition = self::getLeaderPosition($leaderId);
        $anonIssues = AnonIssue::all();

        foreach ($anonIssues as $anonIssue) {
            $matchingUserId = self::findMatchingByUserLocation(
                $anonIssue->country_id,
                $anonIssue->region_id,
                $anonIssue->district_id,
                $anonIssue->ward_id,
                $anonIssue->street_id,
                $leaderRole,
                $leaderPosition,
                $anonIssue->category_id
            );

            if ($matchingUserId == $leaderId) {
                $matchingAnonIssueIds[] = $anonIssue->id;
            }
        }

        return $matchingAnonIssueIds;
    }

}
