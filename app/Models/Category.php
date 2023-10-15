<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    //タイトルの列の登録を許可する
    protected $fillable = ['title'];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
