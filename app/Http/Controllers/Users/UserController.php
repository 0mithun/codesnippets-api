<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Transformers\Users\PublicUserTrnsformer;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'])->only(['update']);
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @return void
     */
    public function show(User $user){
        return \fractal()
            ->item($user)
            ->transformWith(new PublicUserTrnsformer())
            ->toArray()
        ;
    }


    /**
     * Undocumented function
     *
     * @param User $user
     * @param Request $request
     * @return void
     */
    public function update(User $user, Request $request){
        $this->authorize('as', $user);

        $request->validate([
            'email'     =>  ['required','email','unique:users,email,'.$request->user()->id],
            'username'     =>  ['required','alpha_dash','unique:users,username,'.$request->user()->id],
            'name'     =>  ['required','string'],
            'password'     =>  ['nullable','min:6'],

        ]);

        $user->update($request->only(['name','email','username','password']));


    }
}
