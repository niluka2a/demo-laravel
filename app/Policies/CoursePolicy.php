<?php

namespace App\Policies;

use App\Models\User;

class CoursePolicy
{
    /**
     * Determine whether the user can view any models.
     *
     * @param User<User> $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        if ($user->isTeacher()) {
            return true;
        }

        return false;
    }
}
