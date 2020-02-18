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
        $userDTO = new \App\DTO\User\UserRegisterDTO();
        $userDTO->setFirstName("Admin");
        $userDTO->setLastName("Adminovich");
        $userDTO->setPassword("Qweqwe");
        $userDTO->setEmail("admin@srtyber.com");

        /** @var \App\Http\Services\AuthService $authService */
        $authService = app(\App\Http\Services\AuthService::class);
        $authService->register($userDTO);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \App\User::query()->where('email', 'admin@srtyber.com')->delete();
    }
}
