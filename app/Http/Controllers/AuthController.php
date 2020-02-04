<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param UserLoginRequest $request
     * @return JsonResponse
     * @throws \App\Exceptions\AuthorizationErrorException
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        return response()->json($this->authService->login($request->toBag()));
    }

    /**
     * @param UserRegisterRequest $request
     * @return JsonResponse
     * @throws \App\Exceptions\UserAlreadyRegisteredException
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $status = $this->authService->register($request->toBag());

        return response()->json(['status' => $status], ($status) ? Response::HTTP_CREATED : Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}