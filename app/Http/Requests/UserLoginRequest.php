<?php

namespace App\Http\Requests;

use App\DTO\User\UserLoginDTO;

class UserLoginRequest extends BaseRequest
{
    const DTO_CLASS = UserLoginDTO::class;
}
