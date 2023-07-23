<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $userClass = User::class;

        return [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', "unique:{$userClass},email"],
            'password' => ['required', 'string'],
        ];
    }
}
