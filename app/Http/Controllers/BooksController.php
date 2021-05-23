<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BooksController extends Controller
{
    function addBook(Request $req)
    {
        $book = new Book;
        $book->title = $req->input('title');
        $book->author = $req->input('author');
        $book->genre_id = $req->input('genre_id');
        $book->description = $req->input('description');
        $book->numberInStock = $req->input('numberInStock');
        if ($req->file('image') == null) {
            $book->image = '';
        } else {
            $book->image = $req->file('image')->store('book_pictures');
        }
        $book->save();
        return response()->json($book, 200);
    }

    function list()
    {
        return Book::all();
    }

    function getBook($id)
    {
        $result = Book::find($id);
        if ($result) {
            return $result;
        } else {
            return ['result' => 'Book not found'];
        }
    }

    function saveBook($id, Request $req)
    {
        $book = Book::find($id);
        if ($req->title)
            $book->title = $req->title;
        if ($req->author)
            $book->author = $req->author;
        if ($req->genre_id)
            $book->genre_id = $req->genre_id;
        if ($req->description)
            $book->description = $req->description;
        if ($req->numberInStock)
            $book->numberInStock = $req->numberInStock;
        if ($req->file('image')) {
            $book->image = $req->file('image')->store('book_pictures');
        }
        $book->save();
        return response()->json($book, 200);
    }

    function delete($id)
    {
        $result = Book::where('id', $id)->delete();
        if ($result) {
            return response()->json('Book has been deleted', 200);
        } else {
            return response()->json('Operation failed!', 400);
        }
    }
}
