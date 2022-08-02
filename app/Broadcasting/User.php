<?php

namespace App\Broadcasting;

use App\Models\User as ModelUser;

class User
{
    /**
     * Create a new channel instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \App\Models\User  $user
     * @return array|bool
     */
    public function join(ModelUser $user, $id)
    {
        return $user->id == $id;
    }
}
