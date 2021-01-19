<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/auth/register",
     * summary="Register",
     * security={},
     * description="Register with name, nemail, password",
     * operationId="register",
     * summary="Register a new user",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     * ),
     * @OA\Response(
     *    response="201", 
     *    description="User Created Successfully", 
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="User Created Successfully")
     *        )
     *     ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Sorry, wrong email address or password. Please try again",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json($user, Response::HTTP_CREATED);
    }
    
    /**
     * @OA\Post(
     * path="/auth/login",
     * summary="Login a system user",
     * security={},
     * description="Login a user using email, password",
     * operationId="authLogin",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     * ),
     * @OA\Response(
     *    response="200", 
     *    description="User loggedin successfully", 
     *    @OA\JsonContent(),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
     *        )
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        // $credentials = request(['email', 'password']);
        $credentials = [
                        'email'     => $request->input('email'), 
                        'password'  => $request->input('password')
                    ];

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post(
     * path="/me",
     * summary="Get details of the authenticated user",
     * description="Get details of the authenticated user",
     * operationId="me",
     * tags={"User"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success"
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated"),
     *    )
     * )
     * )
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     * path="/logout",
     * summary="Logout a user",
     * description="Logout a user and invalidate token",
     * operationId="authLogout",
     * tags={"Auth"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success"
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthorized"),
     *    )
     * )
     * )
     *
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     * path="/refresh",
     * summary="Refresh a token",
     * description="Invalidate the old token and get a new token",
     * operationId="refresh",
     * tags={"Auth"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(
     *    response=200,
     *    description="A New Token",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="A New Token")
     *        )
     *     )
     * ),
     * @OA\Response(
     *    response=401,
     *    description="Returns when user is not authenticated",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Unauthenticated"),
     *    )
     * )
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
