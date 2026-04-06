<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny()
    {
        return true;
    }

    public function view(User $user, Application $app){
        return true;
    }

    public function create(User $user){
        return $user->isAdmin();
    }

    public function update(User $user, Application $app){
        return $user->isAdmin() || ($user->isProgrammer() && $app->programmer_id === $user->id);
    }

    public function delete(User $user, Application $app){
        return $user->isAdmin();
    }
}
