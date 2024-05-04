<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::orderBy('created_at', 'DESC');

        if (!empty($request->keyword)) {
            $books->where('title', 'like', '%' .$request->keyword. '%');
        }

        $books = $books->paginate(10);

        return view('books.list', [
            'books' => $books
        ]);
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'author' => 'required',
            'status' => 'required', 
        ];

        if (!empty($request->image)) {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('books.create')->withInput()->withErrors($validator);
        }

        // Save book information
        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->discription = $request->discription;
        $book->status = $request->status;
        $book->save();

        // Save book image
        if (!empty($request->image)) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $bookImage = time().'.'.$ext;
            $image->move(public_path('uploads/books'),$bookImage);
            $book->image = $bookImage;
            $book->save();

            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/books/'.$bookImage));

            $img->resize(750);
            $img->save(public_path('uploads/books/thumbnail/'.$bookImage));
        }

        return redirect()->route('books.index')->with('success', 'Book added successfully');
    }

    public function edit($id)
    {
        $book = Book::find($id);
        return view('books.edit', [
           'book' => $book,
        ]);
    }

    public function update($id, Request $request)
    {
        $book = Book::findOrFail($id);

        $rules = [
            'title' => 'required',
            'author' => 'required|min:3',
            'status' => 'required', 
        ];

        if (!empty($request->image)) {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('books.edit', $book->id)->withInput()->withErrors($validator);
        }

        // Update book information
        $book->title = $request->title;
        $book->author = $request->author;
        $book->discription = $request->discription;
        $book->status = $request->status;
        $book->save();

        // Update book image
        if (!empty($request->image)) {
            // This will delate old book image from folder books
            File::delete(public_path('upoads/books/' .$book->image));
            File::delete(public_path('upoads/books/thumbnail/' .$book->image));

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $bookImage = time().'.'.$ext;
            $image->move(public_path('uploads/books'),$bookImage);
            $book->image = $bookImage;
            $book->save();

            // Gennerate image thumbnail here
            $manager = new ImageManager(Driver::class);
            $img = $manager->read(public_path('uploads/books/'.$bookImage));
            $img->resize(750);
            $img->save(public_path('uploads/books/thumbnail/'.$bookImage));
        }

        return redirect()->route('books.index')->with('success', 'Book added successfully');
    }

    public function destroy(Request $request)
    {
        $book = Book::find($request->id);

        if ($book == null) {
            session()->flash('error', 'Book not found');

            return response()->json([
                'status' => false,
                'message' => 'Book not found',
            ]);
        } else {
            // This will delate old book image from folder books
            File::delete(public_path('upoads/books/' .$book->image));
            File::delete(public_path('upoads/books/thumbnail/' .$book->image));
            $book->delete();

            session()->flash('success', 'Book deleted successfully');

            return response()->json([
                'status' => true,
                'message' => 'Book deleted successfully',
            ]);
        }
        
    }
}
