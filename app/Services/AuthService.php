<?php
declare(strict_types = 1);

namespace App\Http\Services;

use App\DTO\User\UserLoginDTO;
use App\DTO\User\UserRegisterDTO;
use App\Exceptions\AuthorizationErrorException;
use App\Exceptions\UserAlreadyRegisteredException;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\PersonalAccessTokenResult;

/**
 * Class AuthService
 * @package App\Http\Services
 */
class AuthService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserLoginDTO $loginDTO
     * @return PersonalAccessTokenResult
     * @throws AuthorizationErrorException
     */
    public function login(UserLoginDTO $loginDTO): array
    {
        $user = $this->userRepository->findUserByEmail($loginDTO->getEmail());

        if (!$user || !Hash::check($loginDTO->getPassword(), $user->password)) {
            throw new AuthorizationErrorException();
        }

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        return [
            'token' => $tokenResult->accessToken,
            'type' => 'Bearer',
            "revoked" => $token->revoked,
            "created_at" => $token->created_at,
            "updated_at" => $token->updated_at,
            "expires_at" => $token->expires_at,
        ];
    }

    /**
     * @param UserRegisterDTO $loginDTO
     * @return bool
     * @throws UserAlreadyRegisteredException
     */
    public function register(UserRegisterDTO $loginDTO): bool
    {
        $user = $this->userRepository->findUserByEmail($loginDTO->getEmail());

        if ($user) {
            throw new UserAlreadyRegisteredException();
        }

        try {
            $this->userRepository->createUser(
                $loginDTO->getFirstName(),
                $loginDTO->getLastName(),
                $loginDTO->getPassword(),
                $loginDTO->getEmail()
            );
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
