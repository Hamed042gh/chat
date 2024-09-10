<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->id === Auth::id()
            ? Response::allow()
            : Response::deny('You do not own this post.');
    }
}
