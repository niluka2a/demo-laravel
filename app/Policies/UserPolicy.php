<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view the model.
     *
     * @param User<User> $user
     * @param User<User> $model
     * @return bool
     */
    public function view(User $user, User $model): bool
    {
        if ($user->id === $model->id) {
            return true;
        }

        // Teacher able to see the students list of each class they teach.
        if ($user->isTeacher()) {
            return $user->with(['courses', 'courses.users' => function($query) use ($model) {
                return $query->find($model->id);
            }])->exists();
        }

        return false;
    }
}
