<?php

namespace App\Http\Controllers;

use App\Movies;
use App\GenreMovies;
use Illuminate\Http\Request;

class MoviesController extends Controller
{

    // all movies
    public function index()
    {
        $movies = Movies::with('genres')->orderBy('created_at', 'desc')->paginate(10);
        return $movies;
    }

    // add movie
    public function add(Request $request)
    {
//        dd($request->all());
        $file = $request->file('image')->store('thumbnails');
        $movie = new Movies([
            'movie_name' => $request->input('movie_name'),
            'IMDB_rating' => $request->input('IMDB_rating'),
            'description' => $request->input('description'),
            'youtube' => $request->input('youtube'),
            'image' => $file
        ]);
        $movie->save();

        $genreAssigns = [];

        foreach( $request->genre_id as $genre_id ){
            $genreAssigns[] = [
                'genre_id' => $genre_id,
                'movie_id' => $movie->id
            ];
        }
        GenreMovies::insert($genreAssigns);
    }

    // edit movie
    public function edit($id)
    {
        $movie = Movies::find($id);
        return response()->json($movie);
    }

    // update movie
    public function update($id, Request $request)
    {
        $movie = Movies::find($id);
        $movie->update($request->all());
    }

    //movie genre
    // public function genre_movies($id)
    // {
    //     $movie[] = GenreMovies::all()->where('movie_id', '=' ,$id);
    //     return array_reverse($movie);
    // }

    // delete movie
    public function delete($id)
    {
        $movie = Movies::find($id);
        $movie->delete();
    }
}

