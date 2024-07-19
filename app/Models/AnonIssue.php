<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AnonIssue
 *
 * @property $id
 * @property $title
 * @property $description
 * @property $status
 * @property $country_id
 * @property $region_id
 * @property $district_id
 * @property $ward_id
 * @property $street_id
 * @property $category_id
 * @property $file_path
 * @property $code
 * @property $citizen_satisfied
 * @property $sealed_by
 * @property $to_user_id
 * @property $read
 * @property $visibility
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class AnonIssue extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'description', 'status', 'country_id', 'region_id', 'district_id', 'ward_id', 'street_id', 'category_id', 'file_path', 'code', 'citizen_satisfied', 'sealed_by', 'to_user_id', 'read', 'visibility'];


}
