<?php

namespace Core\Transformers;

use Core\Models\User;

class UserTransformer implements TransformerInterface
{
    public function item(User $user)
    {
        return [
            'id' => $user->ID,
            'slug' => $user->slug,
            'name' => $user->nickname,
            'first-name' => $user->first_name,
            'last-name' => $user->last_name,
            'avatar' => $user->getAvatarAttribute()
        ];
    }

}