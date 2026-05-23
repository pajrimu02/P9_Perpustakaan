<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookshelfController extends Controller
{
    public function index()
    {
        $bookshelf = DB::table('bookshelf')->get();
        return view('bookshelf.index', compact('bookshelf'));
    }

    public function create()
    {
        return view('bookshelf.create');
    }

    public function store(Request $request)
    {
        DB::table('bookshelf')->insert([
            'code' => $request->code,
            'name' => $request->name,
        ]);

        return redirect()->route('bookshelf.index');
    }

    public function edit($id)
    {
        $bookshelf = DB::table('bookshelf')->where('id', $id)->first();
        return view('bookshelf.edit', compact('bookshelf'));
    }

    public function update(Request $request, $id)
    {
        DB::table('bookshelf')
            ->where('id', $id)
            ->update([
                'code' => $request->code,
                'name' => $request->name,
            ]);

        return redirect()->route('bookshelf.index');
    }

    public function destroy($id)
    {
        DB::table('bookshelf')->where('id', $id)->delete();

        return redirect()->route('bookshelf.index');
    }
}