<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnonIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'country',
        'region',
        'ward',
        'street',
        'file_path',
        'code',
        'visibility',
    ];
}
