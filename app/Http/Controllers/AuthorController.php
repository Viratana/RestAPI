<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::all();
        if(!empty($authors)){
            return Response::json(['data' => $authors], 200);
        }
        else{
            return Response::json(['message' => 'No Record Found'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = [
            'author_name'       => $request->author_name,
            'author_contact_no' => $request->author_contact_no,
            'author_country'    => $request->author_country,
            'created_at'        => Carbon::now(),
        ];

        $rules = [
            'author_name'       =>'required',
            'author_contact_no' =>'required',
            'author_country'    =>'required',
        ];
        $validator = FacadesValidator::make($request->all(), $rules);

        if($validator->fails()){
            return $validator->errors();
        } else {
            $author = Author::create($data);
            
            if($author){
                return Response::json([
                    'message' => "New Author has been created successfully!"
                ], 200);
            } else {
                return Response::json([
                    'message' => 'Something When Wrong'
                ], 404);
            }
        }

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $authorr = Author::find($author->id);
        if(!empty($authorr)){
            return Response::json(['data' => $authorr], 200);
        }
        else{
            return Response::json(['message' => 'No Record Found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        // $data = [
        //     'author_name'       => $request->author_name,
        //     'author_contact_no' => $request->author_contact_no,
        //     'author_country'    => $request->author_country,
        //     'updated_at'        => Carbon::now(),
        // ];

        $auth = Author::find($author->id);
        $auth->update($request->all());
        // $auth = Author::where('id', $author->id)->update($data);

        if($auth){
            return Response::json([
                'message' => "New Author has been updated successfully!"
            ], 200);
        } else {
            return Response::json([
                'message' => 'Something When Wrong'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        $auth = Author::where('id', $author->id)->delete();

        if($auth){
            return Response::json([
                'message' => "New Author has been deleted successfully!"
            ], 200);
        } else {
            return Response::json([
                'message' => 'Something When Wrong'
            ], 404);
        }
    }

    public function search($term){
        // $authors = Author::where('author_name',​ $term)->get();       //search by full name
        $authors = Author::where('author_name', "LIKE", "%" .$term. "%")->get();     //search by ចាប់តួអក្សរ       
        if(!empty($authors)){
            return Response::json(['data' => $authors], 200);
        }
        else{
            return Response::json(['message' => 'No Record Found'], 404);
        }
    }
}
