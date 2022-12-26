<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use PhpParser\Node\Stmt\TryCatch;
use Exception;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $book = Book::with(['writter', 'categories'])->get();

        return response($book);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'page' => 'required'
            ]);

            $writter = auth()->user();

            $title = $request->title;
            $page = $request->page;
            $writter_id = $writter->id;

            $book = $writter->books()->create([
                'title' => $title,
                'page' => $page,
                'writter_id' => $writter_id
            ]);

            $book->categories()->attach([1, 2, 3]);

            return response($book);

        } catch (Exception $e) {

            return response([
                'message' => 'Duplicate entry'
            ], 400);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::with(['writter', 'categories'])->find($id);

        return response($book);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $field = $request->validate(([
            'title' => 'string|required',
            'page' => 'numeric|required'
        ]));

        $user = auth()->user();

        $book = $user->books->find($id);

        if( !$book ) {
            return response([
                'message' => 'Requested book not belongs to the user'
            ]);
        }

        $book->title = $field['title'];
        $book->page = $field['page'];

        $book->save();

        return response([
            'messsage' => 'The book is updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();

        $book = $user->books()->find($id);

        if( !$book ) {
            return response([
                'message' => 'the book not belongs to the user'
            ]);
        }

        $book->delete();

        return response([
            'message' => 'the book has been deleted'
        ]);
    }
}
