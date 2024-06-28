<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category_id',
        'status',
        'citizen_satisfied',
        'sealed_by',
        'to_user_id',
        'visibility',
        'file_path',
    ];

    // Define the category relationship
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Define the chats relationship
    public function chats()
    {
        return $this->hasMany(IssueChat::class, 'issue_id');
    }
}
