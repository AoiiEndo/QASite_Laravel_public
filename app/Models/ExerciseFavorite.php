<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users;
use App\Models\Exercise;

class ExerciseFavorite extends Model
{
    use HasFactory;

    protected $table = 'exercises_favorite';

    protected $fillable = [
        'user_id',
        'exercises_id'
    ];

    public function getExercisesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function exercises()
    {
        return $this->hasMany(Exercise::class, 'id', 'exercises_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}