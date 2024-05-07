<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::orderBy('created_at', 'DESC');

        if (!empty($request->keyword)) {
            $query->where('title', 'like', '%' . $request->keyword . '%');
        }

        $books = $query->where('status', 0)->paginate(20);

        return view('home', compact('books'));
    }

    public function detail($id)
    {
        $book = Book::findOrFail($id);

        if ($book->status == 1) {
            abort(404);
        }

        $relatedBooks = Book::where('status', 0)->take(3)->where('id', '!=', $id)->inRandomOrder()->get();
        return view('detail', [
            'book' => $book,
            'relatedBooks' => $relatedBooks,
        ]);
    }
}
