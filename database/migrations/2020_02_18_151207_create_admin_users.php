<?php

use Illuminate\Database\Migrations\Migration;

class CreateAdminUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('APP_ENV') !== 'production') {
            $userDTO = new \App\DTO\User\UserRegisterDTO();
            $userDTO->setFirstName("Admin");
            $userDTO->setLastName("Adminovich");
            $userDTO->setPassword("Qweqwe");
            $userDTO->setEmail("admin@stryber.com");

            /** @var \App\Http\Services\AuthService $authService */
            $authService = app(\App\Http\Services\AuthService::class);
            $authService->register($userDTO);
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (env('APP_ENV') !== 'production') {
            \App\User::query()->where('email', 'admin@stryber.com')->delete();
        }
    }
}
