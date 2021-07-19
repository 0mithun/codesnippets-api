<?php

namespace App\Http\Controllers\Users;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\Snippets\SnippetTransformer;

class SnippetController extends Controller
{
    public function index(User $user, Request $request){
        return \fractal()
            ->collection($user->snippets()->public()->get())
            ->transformWith(new SnippetTransformer())
            ->toArray()
            ;
    }
}
