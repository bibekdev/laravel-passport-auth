<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;

class BookController extends Controller
{
    public function create(Request $request)
    {
        // validation
        $request->validate([
            "title" => "required",
            "book_cost" => "required"
        ]);

        // create book data
        $book = new Book();

        $book->author_id = auth()->user()->id;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->book_cost = $request->book_cost;

        // save
        $book->save();

        // send response
        return response()->json([
            "status" => 1,
            "message" => "Book created successfully"
        ]);
    }

    // LIST METHOD - GET
    public function index()
    {
        $books = Book::get();

        return response()->json([
            "status" => 1,
            "message" => "All Books",
            "data" => $books
        ]);
    }

    // Author Book METHOD - GET
    public function authorBook()
    {
        $author_id = auth()->user()->id;
        $books = Author::find($author_id)->books;

        return response()->json([
            "status" => 1,
            "message" => "Author Books",
            "data" => $books
        ]);
    }

    // SINGLE BOOK METHOD - GET
    public function single($book_id)
    {
        $author_id = auth()->user()->id;

        if (Book::where([
            "author_id" => $author_id,
            "id" => $book_id
        ])->exists()) {

            $book = Book::find($book_id);

            return response()->json([
                "status" => true,
                "message" => "Book data found",
                "data" => $book
            ]);
        } else {

            return response()->json([
                "status" => false,
                "message" => "Author Book doesn't exists"
            ]);
        }
    }

    // UPDATE METHOD - POST
    public function update(Request $request, $book_id)
    {
        $author_id = auth()->user()->id;

        if (Book::where([
            "author_id" => $author_id,
            "id" => $book_id
        ])->exists()) {

            $book = Book::find($book_id);

            //print_r($request->all());die;

            $book->title = isset($request->title) ? $request->title : $book->title;
            $book->description = isset($request->description) ? $request->description : $book->description;
            $book->book_cost = isset($request->book_cost) ? $request->book_cost : $book->book_cost;

            $book->save();

            return response()->json([
                "status" => 1,
                "message" => "Book data has been updated"
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Author Book doesn't exists"
            ]);
        }
    }

    // DELETE METHOD - GET
    public function destroy($book_id)
    {
        $author_id = auth()->user()->id;

        if (Book::where([
            "author_id" => $author_id,
            "id" => $book_id
        ])->exists()) {

            $book = Book::find($book_id);

            $book->delete();

            return response()->json([
                "status" => true,
                "message" => "Book has been deleted"
            ]);
        } else {

            return response()->json([
                "status" => false,
                "message" => "Author Book doesn't exists"
            ]);
        }
    }
}
