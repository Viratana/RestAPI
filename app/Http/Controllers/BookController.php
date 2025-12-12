<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('author')->get();
        if(!empty($books)){
            return Response::json(['data' => $books], 200);
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
            'book_title'            => $request->book_title,
            'book_isbn'             => $request->book_isbn,
            'book_price'            => $request->book_price,
            'book_publish_year'     => $request->book_publish_year,
            'author_id'             => $request->author_id,
            'created_at'            => Carbon::now(),
        ];

        $rules = [
            'book_title'            =>'required',
            'book_isbn'             =>'required',
            'book_price'            =>'required',
            'book_publish_year'     =>'required',
            'author_id'             =>'required',
        ];
        $validator = FacadesValidator::make($request->all(), $rules);

        if($validator->fails()){
            return $validator->errors();
        } else {
            $book = Book::create($data);
            
            if($book){
                return Response::json([
                    'message' => "New Book has been created successfully!"
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
    public function show(Book $book)
    {
        $bok = Book::find($book->id);
        if(!empty($bok)){
            return Response::json(['data' => $bok], 200);
        }
        else{
            return Response::json(['message' => 'No Record Found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        // $data = [
        //     'author_name'       => $request->author_name,
        //     'author_contact_no' => $request->author_contact_no,
        //     'author_country'    => $request->author_country,
        //     'updated_at'        => Carbon::now(),
        // ];

        $bok = Book::find($book->id);
        $bok->update($request->all());
        // $auth = Author::where('id', $author->id)->update($data);

        if($bok){
            return Response::json([
                'message' => "New Book has been updated successfully!"
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
    public function destroy(Book $book)
    {
        $bok = Book::where('id', $book->id)->delete();

        if($bok){
            return Response::json([
                'message' => "New Book has been deleted successfully!"
            ], 200);
        } else {
            return Response::json([
                'message' => 'Something When Wrong'
            ], 404);
        }
    }
}
