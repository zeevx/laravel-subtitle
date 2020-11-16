<?php

namespace App\Http\Controllers;

use App\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    // all genres
    public function index()
    {
        $genres = Genre::orderBy('created_at', 'desc')->paginate(10);
        return $genres;
    }

    // add genre
    public function add(Request $request)
    {
        $genre = new Genre([
            'genre_name' => $request->input('genre_name'),
        ]);
        $genre->save();
    }

    // edit genre
    public function edit($id)
    {
        $genre = Genre::find($id);
        return response()->json($genre);
    }

    // update genre
    public function update($id, Request $request)
    {
        $genre = genre::find($id);
        $genre->update($request->all());
    }

    // delete genre
    public function delete($id)
    {
        $genre = Genre::find($id);
        $genre->delete();
    }
}
