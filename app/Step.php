<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $fillable = [
        'snippet_id','uuid','title','order','body',
    ];


    public static function boot(){
        parent::boot();

        static::creating(function($step){
            $step->uuid = Str::uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function afterOrder(){
        $adjacent = self::where('order','>', $this->order)
            ->orderBy('order','asc')
            ->first()
        ;

        if(!$adjacent){
            return self::orderBy('order','desc')->first()->order + 1;
        }

        return ($this->order + $adjacent->order) / 2;
    }

    public function beforeOrder(){
        $adjacent = self::where('order','<', $this->order)
            ->orderBy('order','desc')
            ->first()
        ;
        if(!$adjacent){
           return self::orderBy('order','asc')->first()->order -  1;
        }

        return ($this->order + $adjacent->order) / 2;
    }


    public function snippet(){
        return $this->belongsTo(Snippet::class);
    }

}
