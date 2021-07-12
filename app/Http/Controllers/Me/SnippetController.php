<?php

namespace App\Http\Controllers\Me;

use App\Snippet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\Snippets\SnippetTransformer;

class SnippetController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function index(){
        return \fractal()
            ->collection(request()->user()->snippets)
            ->transformWith(new SnippetTransformer())
            ->toArray()
            ;
    }
}
