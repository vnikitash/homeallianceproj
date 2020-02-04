<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

/**
 * Class User
 * @package App
 *
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $email
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens;

    protected $hidden = ['password'];
}
