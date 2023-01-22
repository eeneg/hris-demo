<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    public function definition()
    {
        return [];
    }

    public function admin()
    {
        return $this->state([
            'name' => 'admin',
            'email' => 'admin@local.com',
            'landline' => '09XXXXXX',
            'role' => 'Administrator',
            'status' => 'unknown',
            'password' => Hash::make('root'),
        ]);
    }
}
