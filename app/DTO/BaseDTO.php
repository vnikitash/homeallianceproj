<?php

namespace App\DTO;

use App\User;
use App\Contracts\Validatable;

/**
 * Class BaseDTO
 * @package App\Http\DTO
 */
class BaseDTO
{
    public const RULES = [];

    /**
     * @var array
     */
    protected $arguments;

    /** @var User */
    protected $user;

    /**
     * @var array
     */
    protected $fieldsInRequest = [];

    /**
     * BaseDTO constructor.
     * @param Validatable $validatable
     * @param User $user
     */
    public function __construct(Validatable $validatable, User $user = null)
    {
        $this->user = $user;
        $this->arguments = $validatable->validated();
    }

    /**
     * @return User|null
     */
    public function user(): ?User
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getValidatableData(): array
    {
        return $this->arguments;
    }

    /**
     * @return array
     */
    public static function compiledRules(): array
    {
        return static::RULES;
    }
}
