<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request): UserResource
    {
        $user = User::create([...$request->all(), 'password' => Hash::make($request->input('password'))]);

        return new UserResource($user);
    }
}
