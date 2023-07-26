<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testStore_success(): void
    {
        $params = [
            'name' => 'test name',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $this->postJson('/api/users', $params)
            ->assertCreated();
    }

    public function testStore_duplicateEntry(): void
    {
        $params = [
            'name' => 'test name',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $this->postJson('/api/users', $params);
        $this->postJson('/api/users', $params)
            ->assertUnprocessable();
    }

    public function testUpdate(): void
    {
        $user = User::factory()->create([
            'name' => 'before name',
            'email' => 'test@example.com',
            'password' => Hash::make('before password'),
        ]);

        $params = [
            'name' => 'after name',
            'email' => $user->email,
            'password' => 'after password',
        ];

        $this->putJson('/api/users', $params)
        ->assertNoContent();

        $this->assertDatabaseMissing((new User())->getTable(), $user->getAttributes());
        $this->assertDatabaseHas((new User())->getTable(), Arr::except($params, 'password'));

        // check password
        $result = User::whereEmail($user->email)->first();
        $this->assertNotNull($result);
        $this->assertTrue(Hash::check($params['password'], $result->password));
    }
}
