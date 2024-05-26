<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param User<User> $user
     * @return UserResource
     */
    public function show(Request $request, User $user): UserResource
    {
        if ($request->user()->cannot('view', $user)) {
            abort(403);
        }

        // User personal info.
        return new UserResource($user);
    }
}
