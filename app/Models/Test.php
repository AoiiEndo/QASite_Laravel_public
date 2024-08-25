<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Test extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'test_name',
        'test_date',
        'target_score',
        'actual_score',
    ];

    public function category()
    {
        return $this->belongsTo(TestCategory::class, 'category_id');
    }
}