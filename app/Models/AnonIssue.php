<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AnonIssue
 *
 * @property $id
 * @property $title
 * @property $description
 * @property $country
 * @property $region
 * @property $ward
 * @property $street
 * @property $file_path
 * @property $code
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
    protected $fillable = ['title', 'description', 'country', 'region', 'ward', 'street', 'file_path', 'code', 'visibility'];


}
