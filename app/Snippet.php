<?php

namespace App;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Transformers\Snippets\SnippetTransformer;

class Snippet extends Model
{

    use Searchable;

    protected $fillable = [
        'user_id','uuid','title','is_public'
    ];

    public static function boot(){
        parent::boot();

        static::created(function($snippet){
            $snippet->steps()->create([
                'order'     =>  1,
            ]);
        });

        static::creating(function($snippet){
            $snippet->uuid = Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function toSearchableArray()
    {
        return \fractal()
                ->item($this)
                ->transformWith(new SnippetTransformer())
                ->parseIncludes(['steps','author',])
                ->toArray()
            ;
    }


    public function scopePublic(Builder $builder){
        return $builder->where('is_public', true);
    }


    public function isPublic(){
        return $this->is_public;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function steps(){
        return $this->hasMany(Step::class)->orderBy('order','ASC');
    }
}
