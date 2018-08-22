<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $currentUser  当前用户
     * @param User $user     访问的用户
     * @return bool
     */
    public function update(User $currentUser,User $user)
    {
            return $currentUser->id === $user->id;
    }

    public function destroy(User $currentUser , User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }
}
