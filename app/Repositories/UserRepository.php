<?php
namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function findUserByEmail(string $email): ?User
    {
        /** @var User $user */
        $user = User::query()->where('email', $email)->first();

        return $user;
    }

    public function createUser(string $firstName, string $lastName, string $password, string $email): User
    {
        $user = new User();
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->password = $password;
        $user->email = $email;
        $user->save();

        return $user;
    }
}