<?php

namespace App\DTO\User;

use App\DTO\BaseDTO;

/**
 * Class SignUpDTO
 * @package App\Http\DTO
 */
class UserRegisterDTO extends BaseDTO
{

    public const RULES = [
        'first_name' => ['required', 'string'],
        'last_name' => ['required', 'string'],
        'email' => ['required', 'string', 'email', 'unique:users'],
        'password' => ['required', 'string', 'confirmed'],
    ];

    protected $firstName;
    protected $lastName;
    protected $email;
    protected $password;

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

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

    public function setPassword(string $password, bool $encrypt = true): self
    {
        $this->password = $encrypt ? bcrypt($password) : $password;

        return $this;
    }
}
