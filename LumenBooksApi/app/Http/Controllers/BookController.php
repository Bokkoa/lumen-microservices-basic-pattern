<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Models\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

     /**
     * Return books list
     * @return Illuminate\Http\Response
     */
    public function index(){
        $books = Book::all();
        return $this->successResponse($books);
    }

    /**
     * create an intance of book
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $author = Book::create($request->all());

        return $this->successResponse($author, Response::HTTP_CREATED);
    }

    /**
     * return an book by id
     * @return Illuminate\Http\Response
     */
    public function show($book){
        $book = Book::findOrFail($book);
        return $this->successResponse($book);
    }

    /**
     * update an book by id
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $book){
       
        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'price' => 'required|min:1',
            'author_id' => 'required|min:1',
        ];

        $this->validate($request, $rules);

        $book = Book::findOrFail($book);

        $book->fill($request->all());

        if($book->isCLean()){
            return $this->errorResponse('at least one value must be changed', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $book->save();

        return $this->successResponse($book);
    }

    /**
     * delete an book by id
     * @return Illuminate\Http\Response
     */
    public function destroy($book){
        $book = Book::findOrFail($book);

        $book->delete();

        return $this->successResponse($book);

    }
}
