<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'contents',
        'public_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'exercises_favorite', 'exercise_id', 'user_id')
                    ->withTimestamps();
    }

    public function scopePublic($query)
    {
        return $query->where('public_status', 1);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'exercises_favorite', 'exercises_id', 'user_id');
    }

    public function isFavoritedByUser()
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }
}

