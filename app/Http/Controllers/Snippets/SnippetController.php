<?php

namespace App\Http\Controllers\Snippets;

use App\Snippet;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\Snippets\SnippetTransformer;

class SnippetController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api'])->only('update','store');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \fractal()
            ->collection(Snippet::take(request()->get('limit', 10))->latest()->public()->get())
            ->transformWith(new SnippetTransformer())
            ->parseIncludes(['author'])
            ->toArray()
            ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $snippet = $request->user()->snippets()->create();

        return fractal()
                ->item($snippet)
                ->transformWith(new SnippetTransformer())
                ->toArray()
                ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Snippet  $snippet
     * @return \Illuminate\Http\Response
     */
    public function show(Snippet $snippet)
    {
        $this->authorize('view', $snippet);

        return fractal()
                ->item($snippet)
                ->transformWith(new SnippetTransformer())
                ->parseIncludes(['steps','author','user'])
                ->toArray()
                ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Snippet  $snippet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Snippet $snippet)
    {
        $this->authorize('update', $snippet);

        $request->validate([
            'title'     =>  ['nullable'],
            'is_public'     =>  ['nullable','boolean'],
        ]);


        $snippet->update($request->only(['title','is_public']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Snippet  $snippet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Snippet $snippet)
    {
        $this->authorize('delete', $snippet);

        $snippet->delete();
    }
}
