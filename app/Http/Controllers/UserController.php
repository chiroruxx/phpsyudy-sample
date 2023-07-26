<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(UserStoreRequest $request): UserResource
    {
        $user = User::create([...$request->validated(), 'password' => Hash::make($request->validated('password'))]);

        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request): Response
    {
        $user = User::whereEmail($request->validated('email'))->firstOrFail();
        $user->fill([...$request->all(), 'password' => Hash::make($request->input('password'))]);
        $user->save();

        return response()->noContent();
    }
}
