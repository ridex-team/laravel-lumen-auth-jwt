<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller {

    // use auth middleware
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function showAllAuthors()
    : JsonResponse {
        
        // return response
        return response()->json(Author::all());
    }

    public function showOneAuthor($id)
    : JsonResponse {

        return response()->json(Author::find($id));
    }

    public function create(Request $request)
    : JsonResponse {
        // validation of data
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:authors',
            'location' => 'required|alpha'
        ]);
        
        $author = Author::create($request->all());
        return response()->json($author, Response::HTTP_CREATED);
    }

    public function update($id, Request $request)
    : JsonResponse {

        $author = Author::findOrFail($id);
        $author->update($request->all());

        return response()->json($author, Response::HTTP_OK);
    }

    public function delete($id) {

        Author::findOrFail($id)->delete();

        return response('Deleted Successfully', Response::HTTP_OK);
    }
}