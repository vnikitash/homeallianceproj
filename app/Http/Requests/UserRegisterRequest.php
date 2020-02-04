<?php

namespace App\Http\Requests;

use App\DTO\User\UserRegisterDTO;

class UserRegisterRequest extends BaseRequest
{
    const DTO_CLASS = UserRegisterDTO::class;
}
