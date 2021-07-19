<?php

namespace App\Transformers\Users;

use App\User;
use League\Fractal\TransformerAbstract;

class PublicUserTrnsformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'        =>  $user->id,
            'name'        =>  $user->name,
            'username'        =>  $user->username,
            'joined'        =>  $user->created_at->toDateTimeString(),
        ];
    }
}
