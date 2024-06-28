<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueChat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'issue_id',
        'msg',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship with the Issue model
    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }
}
