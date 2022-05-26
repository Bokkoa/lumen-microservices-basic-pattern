<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class AuthorService {
    
    use ConsumesExternalService;

    /**
     * THe base uri to be used to consume the authors service
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
        $this->baseUri = config('services.authors.base_uri');
        $this->secret = config('services.authors.secret');
    }

    /**
     * Get the full list of authors from author servirce
     * @return string
     */
    public function obtainAuthors(){
        return $this->performRequest('GET', '/authors');
    }

    /**
     * Create the author from author service
     * @return string
     */
    public function createAuthor($data){
        return $this->performRequest('POST', '/authors', $data);
    }

     /**
     * Get an author from author servirce
     * @return string
     */
    public function obtainAuthor($author){
        return $this->performRequest('GET', "/authors/{$author}");
    }

    /**
     * Edit an author from author service
     * @return string
     */
    public function editAuthor($data, $author){
        return $this->performRequest('PUT', "/authors/{$author}", $data);
    }

    /**
     * Delete an author from author service
     * @return string
     */
    public function deleteAuthor($author){
        return $this->performRequest('DELETE', "/authors/{$author}");
    }

}
