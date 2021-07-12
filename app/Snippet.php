<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Snippet extends Model
{
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
