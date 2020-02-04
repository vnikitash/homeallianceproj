<?php

namespace App\DTO\User;

use App\DTO\BaseDTO;

/**
 * Class LoginDTO
 * @package App\Http\DTO
 *
 */
class UserLoginDTO extends BaseDTO
{

    public const RULES = [
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string']
    ];

    private $email;
    private $password;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}
