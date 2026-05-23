<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Models\Book;
use App\Models\Bookshelf;
use Illuminate\Http\Request;
use App\Http\Controllers\Storage;
use App\Imports\BooksImport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //controler harus mengirimkan data buku ke view index
        // Model
        $data['books'] = Book::with('bookshelf')->get();
        return view('books.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['bookshelves'] = Bookshelf::pluck('name', 'id');
        return view('books.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:150',
            'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y')),
            'publisher' => 'required|max:100',
            'city' => 'required|max:75',
            'bookshelf_id' => 'required',
            'cover' => 'nullable|image',
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->storeAs(
                'cover_buku',
                'coverbuku' . time() . '.' . $request->file('cover')->extension(),
                'public'
            );
            $validated['cover'] = basename($path);
        }

        Book::create($validated);

        $notification = array(
            'message' => 'Data buku berhasil ditambahkan',
            'alert-type' => 'success'
        );

        if ($request->save == true) {
            return redirect()->route('book')->with($notification);
        } else {
            return redirect()->route('book.create')->with($notification);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['book'] = Book::findOrFail($id);
        $data['bookshelves'] = Bookshelf::pluck('name', 'id');
        return view('books.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $validated = $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:150',
            'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y')),
            'publisher' => 'required|max:100',
            'city' => 'required|max:75',
            'bookshelf_id' => 'required',
            'cover' => 'nullable|image',
        ]);

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->storeAs(
                'cover_buku',
                'coverbuku' . time() . '.' . $request->file('cover')->extension(),
                'public'
            );
            $validated['cover'] = basename($path);
        }

        Book::where('id', $id)->update($validated);

        $notification = array(
            'message' => 'Data buku berhasil ditambahkan',
            'alert-type' => 'success'
        );

        if ($request->save == true) {
            return redirect()->route('book')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        
        $notification = array(
            'message' => 'Data buku berhasil dihapus',
            'alert-type' => 'success'
        );
        
        return redirect()->route('book')->with($notification);
    }


    public function print(){
        $books = Book::all();
        $pdf = Pdf::loadView('books.print', ['books' => $books]);
        return $pdf->download(('dataBuku.pdf'));
    }


    public function export(){
        return Excel::download(new BooksExport, 'report_book_well.xlsx');
    }
         
    public function import(Request $request){
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);
        Excel::import(new BooksImport, $request->file('file'));
        return redirect()->route('book');
    }
}
