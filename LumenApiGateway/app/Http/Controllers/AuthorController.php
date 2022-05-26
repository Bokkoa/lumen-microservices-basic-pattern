<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the author service
     * @var AuthorService
     */
    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     * Return authors list
     * @return Illuminate\Http\Response
     */
    public function index(){
        return $this->successResponse($this->authorService->obtainAuthors());
    }

    /**
     * create an intance of author
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){
        return $this->successResponse(
               $this->authorService->createAuthor($request->all()),
               Response::HTTP_CREATED);
    }

    /**
     * return an author by id
     * @return Illuminate\Http\Response
     */
    public function show($author){
        return $this->successResponse($this->authorService->obtainAuthor($author));
    }

    /**
     * update an author by id
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $author){
        return $this->successResponse($this->authorService->editAuthor($request->all(), $author));

    }

    /**
     * delete an author by id
     * @return Illuminate\Http\Response
     */
    public function destroy($author){
        return $this->successResponse($this->authorService->deleteAuthor($author));
    }
}
