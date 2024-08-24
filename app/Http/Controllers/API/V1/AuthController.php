<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\UserLoginRequest;
use App\Http\Requests\API\V1\UserRegistrationRequest;
use App\Http\Resources\API\V1\UserResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * @tags User Authentication
 */
class AuthController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * User Registration
     *
     * Registers a new user in the system.
     *
     * @unauthenticated
     */
    public function register(UserRegistrationRequest $request)
    {
        $validated = $request->validated();

        // Check if the user with the given email already exists
        if ($this->userRepository->getUserByEmail($validated['email'])) {
            return response()->json(['message' => 'User already exists'], 400);
        }

        DB::beginTransaction();
        try {
            // Create a new user
            $userDetails = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ];
            $user = $this->userRepository->createUser($userDetails);

            // Generate a new authentication token for the user
            $token = $user->createToken("{$user->name}AuthToken")->plainTextToken;

            DB::commit();

            return (new UserResource($user))
                ->additional([
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'message' => 'Account created successfully',
                ]);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('User registration failed: '.$e->getMessage());

            return response()->json([
                'message' => 'Account creation failed, please try again later',
            ], 500);
        }
    }

    /**
     * User Login
     *
     * Authenticates a user and provides an access token.
     *
     * @unauthenticated
     */
    public function login(UserLoginRequest $request)
    {
        $validated = $request->validated();

        $user = $this->userRepository->getUserByEmail($validated['email']);

        if ($user && Hash::check($validated['password'], $user->password)) {
            $token = $user->createToken("{$user->name}AuthToken")->plainTextToken;

            return (new UserResource($user))
                ->additional([
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'message' => 'Login successful',
                ]);
        }

        return response()->json(['message' => 'Invalid email or password'], 401);
    }

    /**
     * User Logout
     *
     * Logs out the user by invalidating the current authentication token.
     *
     * @authenticated
     */
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();

            return response()->json(['status' => 'true', 'message' => 'Logged out successfully'], 200);
        }

        return response()->json(['status' => 'failed', 'message' => 'No user found to logout'], 404);
    }
}
