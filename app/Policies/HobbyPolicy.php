<?php

namespace App\Policies;

use App\Models\Hobby;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HobbyPolicy
{
    use HandlesAuthorization;

    public function befor($user, $ability) {
        if ($user->rolle === 'admin') {
            return true;
        }
    }


    /**
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Hobby $hobby)
    {
        //
    }

    /**
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Hobby $hobby)
    {
      return $user->id === $hobby->user_id || $user->rolle === 'admin';
    }

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Hobby $hobby)
    {
        return $user->id === $hobby->user_id || $user->rolle === 'admin';
    }

    /**
     * @param  \App\Models\User  $user
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Hobby $hobby)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Hobby  $hobby
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Hobby $hobby)
    {
        //
    }
}
