<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Collection
    {
        //書籍一覧を取得
        $books = Book::all();

        //書籍一覧をレスポンスとして返す
        return $books;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        //viewにカテゴリ一覧を表示するために全件取得
        $categories = Category::all();

        //viewオブジェクトを返す
        return view('admin/book/create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //書籍データ登録用のオブジェクトを作成する
        $book = new Book();

        //リクエストオブジェクトからパラメーターを取得
        $book->category_id = $request->category_id;
        $book->title = $request->title;
        $book->price = $request->price;

        //保存
        $book->save();

        //保存した書籍情報をレスポンスとして返す
        return $book;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):Book
    {
        //書籍一件を取得
        $book = Book::findOrFail($id);

        //取得した書籍をレスポンスとして返す
        return $book;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        //
    }
}