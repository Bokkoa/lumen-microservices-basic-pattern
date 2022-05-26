<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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
     * Return users list
     * @return Illuminate\Http\Response
     */
    public function index(){
        $users = User::all();
        return $this->validResponse($users);
    }

    /**
     * create an intance of user
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];

        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);

        $author = User::create($fields);

        return $this->validResponse($author, Response::HTTP_CREATED);
    }

    /**
     * return an user by id
     * @return Illuminate\Http\Response
     */
    public function show($user){
        $user = User::findOrFail($user);
        return $this->validResponse($user);
    }

    /**
     * update an user by id
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $user){
       
        $rules = [
            'name' => 'max:255',
            'email' => 'email|unique:users,email,'.$user,  // Unique except for the same user
            'password' => 'min:8|confirmed',
        ];

        $this->validate($request, $rules);

        $user = User::findOrFail($user);

        $user->fill($request->all());

        if($request->has('password')){
            $user->password = Hash::make($request->password);
        }

        if($user->isCLean()){
            return $this->errorResponse('at least one value must be changed', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();

        return $this->validResponse($user);
    }

    /**
     * delete an user by id
     * @return Illuminate\Http\Response
     */
    public function destroy($user){
        $user = User::findOrFail($user);

        $user->delete();

        return $this->validResponse($user);

    }


    /**
     * identifies the current user
     * @return Illuminate\Http\Response
     */
    public function me(Request $request){
        return $this->validResponse($request->user());
    }
}
