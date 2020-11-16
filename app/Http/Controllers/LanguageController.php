<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    // all genres
    public function index()
    {
        $languages = Language::orderBy('created_at', 'desc')->paginate(10);
        return $languages;
    }

    // add genre
    public function add(Request $request)
    {
        $language = new Language([
            'language_name' => $request->input('language_name'),
        ]);
        $language->save();
    }

    // edit genre
    public function edit($id)
    {
        $language = Language::find($id);
        return response()->json($language);
    }

    // update genre
    public function update($id, Request $request)
    {
        $language = Language::find($id);
        $language->update($request->all());
    }

    // delete genre
    public function delete($id)
    {
        $language = Language::find($id);
        $language->delete();
    }
}
