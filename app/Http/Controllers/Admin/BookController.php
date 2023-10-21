<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookPostRequest;
use App\Http\Requests\BookPutRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():Response
    {
        //書籍一覧を取得
        // $books = Book::all();
        $books = Book::with('category')
                    ->orderBy('category_id')
                    ->orderBy('title')
                    ->get();

        //書籍一覧をレスポンスとして返す
        // return $books;
        return response()
            ->view('admin/book/index', ['books' => $books])
            ->header('Content-Type', 'text/html')
            ->header('Content-Encoding', 'UTF-8');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        //viewにカテゴリ一覧を表示するために全件取得
        $categories = Category::all();

        //著者一覧を表示するために全件取得
        $authors = Author::all();

        //viewオブジェクトを返す
        // return view('admin/book/create', [
        //     'categories' => $categories
        // ]);
        return view('admin/book/create', 
            compact('categories','authors'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookPostRequest $request): RedirectResponse
    {
        //書籍データ登録用のオブジェクトを作成する
        $book = new Book();

        //リクエストオブジェクトからパラメーターを取得
        $book->category_id = $request->category_id;
        $book->title = $request->title;
        $book->price = $request->price;

        DB::transaction(function() use($book, $request){
    
        //保存
        $book->save();

        //著者書籍テーブルを登録
        $book->authors()->attach($request->author_ids);

        });

        //保存した書籍情報をレスポンスとして返す
        // return $book;
        //登録完了後book.indexにリダイレクトする
        return redirect(route('book.index'))
            ->with('message', $book->title . 'を追加しました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book):View
    {
        //書籍一件を取得
        // $book = Book::findOrFail($id);

        //取得した書籍をレスポンスとして返す
        return view('admin/book/show',compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book): View
    {
        //カテゴリ一覧を表示するために全件取得
        $categories = Category::all();

        //著者一覧を表示するために全件取得
        $authors = Author::all();

        //書籍に紐づく著者IDの一覧を取得
        $authorIds = $book->authors()->pluck('id')->all();

        return view('admin/book/edit', compact('book', 'categories', 'authors', 'authorIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookPutRequest $request, Book $book): RedirectResponse
    {
        //リクエストオブジェクトからパラメータを取得する
        $book->category_id = $request->category_id;
        $book->title = $request->title;
        $book->price = $request->price;

        DB::transaction(function() use($book,$request){
            //更新
            $book->update();

            //書籍と著者の関連付けを更新する
            $book->authors()->sync($request->author_ids);
        });

        return redirect(route('book.index'))->with('message',$book->title . 'を変更しました。'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book): RedirectResponse
    {
        // DB::transaction(function() use($book) {
        //     //削除
        //     $book->authors()->detach();
        //     $book->delete();
        // });

        //削除
        $book->delete();
        
        return redirect(route('book.index'))->with('message', $book->title . 'を削除しました。');
    }
}
