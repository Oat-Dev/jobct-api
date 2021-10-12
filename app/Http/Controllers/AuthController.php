<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\AuthStoreRegisterRequest;
use App\Http\Resources\User as ResourcesUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Register Applicant user API
     * @param Request $request
     * @return Response
     */
    public function register(AuthStoreRegisterRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);
            if ($request->cv_path) {
                $uploadFolder = 'users/cv_files';
                $image = $request->file('cv_path');
                $path = Storage::put($uploadFolder, $image, 'public');
                $validated['cv_path'] = $path;
            }
            $user = User::create($validated);
            $user->assignRole($request->input('type'));
        } catch (Exception $e) {
            return response()->json([
                'type' => 'error',
                'title' => 'Failed',
                'message' => $e->getMessage(),
            ], 400);
        }

        return response()->json([
            'users' => new ResourcesUser($user),
        ]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile()
    {
        return response()->json(['user' => auth()->user()]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        // auth::guard('api')->logout();

        return response()->json([
            'status' => 'success',
            'title' => 'Logout',
            'message' => 'Successfully logged out'
        ], 200);
    }

    /**
     * Delete user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        // $user = User::find(Auth::user()->$id);
        // Auth::logout();

        // if ($user->delete()) {
        //     return Redirect::route('/')->with('global', 'Your account has been deleted!');
        // }
        User::destroy($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully User delete'
        ], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
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
            // 'access_token' => $token,
            // 'token_type' => 'bearer',
            // 'expires_in' => auth('api')->factory()->getTTL() * 60,
            'success' => True,
            'user' => [
                'access_token' => $token,
            ]
        ]);
    }
}
