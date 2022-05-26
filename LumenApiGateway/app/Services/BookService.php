<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class BookService {
    
    use ConsumesExternalService;


    /**
     * THe base uri to be used to consume the books service
     * @var string
     */
    public $baseUri;

        /**
     * THe secret to be used to consume the authors service
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.books.base_uri');
        $this->secret = config('services.books.secret');
    }

     /**
     * Get the full list of books from book servirce
     * @return string
     */
    public function obtainBooks(){
        return $this->performRequest('GET', '/books');
    }

    /**
     * Create the book from book service
     * @return string
     */
    public function createBook($data){
        return $this->performRequest('POST', '/books', $data);
    }

     /**
     * Get an book from book servirce
     * @return string
     */
    public function obtainBook($book){
        return $this->performRequest('GET', "/books/{$book}");
    }

    /**
     * Edit an book from book service
     * @return string
     */
    public function editBook($data, $book){
        return $this->performRequest('PUT', "/books/{$book}", $data);
    }

    /**
     * Delete an book from book service
     * @return string
     */
    public function deleteBook($book){
        return $this->performRequest('DELETE', "/books/{$book}");
    }

}