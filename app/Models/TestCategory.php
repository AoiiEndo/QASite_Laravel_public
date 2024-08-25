<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'category_name'];

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    /**
     * カテゴリを削除する際に関連するテストが存在するかチェック
     */
    public function delete()
    {
        if ($this->tests()->exists()) {
            throw new \Exception('このカテゴリには関連するテストが存在するため、削除できません。');
        }

        return parent::delete();
    }
}
