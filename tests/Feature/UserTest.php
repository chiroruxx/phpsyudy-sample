<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testStore_success(): void
    {
        $param = [
            'name' => 'test name',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/users', $param);

        $response->assertCreated();
    }

    public function testStore_duplicateEntry(): void
    {
        $param = [
            'name' => 'test name',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $this->postJson('/api/users', $param);
        $response = $this->postJson('/api/users', $param);

        $response->assertUnprocessable();
    }
}
