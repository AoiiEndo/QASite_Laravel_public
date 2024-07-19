<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'content', 'tags', 'user_id'];

    protected $casts = [
        'tags' => 'json'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function bestAnswer()
    {
        return $this->belongsTo(Answer::class, 'best_answer_id');
    }
}
