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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function issue()
    {
        return $this->belongsTo(Issue::class, 'issue_id');
    }
}
