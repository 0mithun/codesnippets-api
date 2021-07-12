<?php

namespace App\Http\Controllers\Snippets;

use App\Http\Controllers\Controller;
use App\Snippet;
use App\Step;
use App\Transformers\Snippets\StepTransformer;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'])->only('store','update','destroy');
    }

    /**
     * Store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Snippet  $snippet
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Snippet $snippet)
    {
        $this->authorize('storeStep', $snippet);
        // return $this->getOrder($request);

        $step = $snippet->steps()->create($request->only('title','body') + ['order'=>$this->getOrder($request)]);

        return \fractal()
            ->item($step)
            ->transformWith(new StepTransformer())
            ->toArray()
            ;
    }

    /**
     *
     */

    protected function getOrder(Request $request){
        return Step::where('uuid', $request->before)
            ->orWhere('uuid', $request->after)
            ->first()
            ->{($request->before  ? 'before': 'after') .'Order'}();
            ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Snippet $snippet, Step $step)
    {
        $this->authorize('update', $step);

        $step->update($request->only(['title','body']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Step  $step
     * @return \Illuminate\Http\Response
     */
    public function destroy(Snippet $snippet, Step $step)
    {
        $this->authorize('destroy', $step);

        if($snippet->steps->count() == 1){
            return response(null, 400);
        }

        $step->delete();
    }
}
