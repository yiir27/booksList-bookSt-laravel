<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Book::factory(3)->create();

        $categories = [
            //ファクトリで生成されるタイトルを上書き
            Category::factory()->create(['title' => 'programming']),
            Category::factory()->create(['title' => 'design']),
            Category::factory()->create(['title' => 'management']),
        ];
        foreach($categories as $category) {
            //カテゴリ１件につき、２件の書籍を登録する
            //ファクトリで生成されるカテゴリIDを上書きする
            Book::factory(2)->create(['category_id' => $category->id]);
        }
    }
}
