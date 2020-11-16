<?php

namespace App\Http\Controllers;

use App\Language;
use App\Subtitle;
use Illuminate\Http\Request;

class SubtitleController extends Controller
{
    // all movies
    public function index()
    {
        return Subtitle::with('movie')->orderBy('created_at', 'desc')->paginate(10);
    }

    public function add(Request $request)
    {
        $file = $request->file('file')->store('subtitles');
        $language = new Subtitle([
            'movie_id' => $request->input('movie_id'),
            'name' => $request->input('name'),
            'language' => $request->input('language'),
            'file' => $file
        ]);
        $language->save();
    }

    public function edit($id)
    {
        $subtitle = Subtitle::find($id);
        return response()->json($subtitle);
    }

    public function update($id, Request $request)
    {
        $subtitle = Subtitle::find($id);
        $subtitle->update($request->all());
    }


    public function delete($id)
    {
        $subtitle = Subtitle::find($id);
        $subtitle->delete();
    }
}
