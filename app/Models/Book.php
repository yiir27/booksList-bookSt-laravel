<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    public function authors(): BelongsToMany
    {
        //著者１件に複数の書籍が紐付くことを定義する
        return $this->belongsToMany(Author::class)->withTimestamps();
    }
}

