<?php

namespace App\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Status;
use App\Models\User;

class StatusPolicy
{
    use HandlesAuthorization;

    public function destroy(User $user,Status $status)
    {
    		return  true;
            //return $user->id === $status->user_id;
    }
}
