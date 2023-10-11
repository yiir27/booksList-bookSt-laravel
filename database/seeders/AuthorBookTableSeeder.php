<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorBookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();
        $authors = Author::all();

        foreach($books as $book) {
            $authorIds = $authors
                ->random(2)
                ->pluck('id')
                ->all();
            
            //書籍にランダムに抜き出した２件の著者のID配列を関連づける
            $book->authors()->attach($authorIds);


        }
    }
}
